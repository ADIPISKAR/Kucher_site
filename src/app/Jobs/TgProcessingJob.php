<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\WordsExclusion;
use danog\MadelineProto\API;
use danog\MadelineProto\Settings;

class TgProcessingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    public $tries = 6;
    public $timeout = 2700;

    protected $access_token;
    protected $excludedWords;
    protected $messagesArray;
    protected $sessionFile;

    public function __construct()
    {
        $this->excludedWords = WordsExclusion::pluck('word')->filter()->toArray();
        $this->sessionFile = '/var/www/html/Kucher_site/src/session.madeline';  // Указываем полный путь
    }

    public function handle()
    {
        try {
            $settings = new Settings([
                'app_info' => [
                    'api_id' => '23309931',
                    'api_hash' => 'a1b55a9fa815fa90cf817b0390a430cf',
                ],
                'connections' => [
                    'proxy' => null,
                    'use_ipv6' => false,
                ],
            ]);

            $MadelineProto = new API($this->sessionFile, $settings);

            // Проверка существования файла сессии
            if (!file_exists($this->sessionFile)) {
                echo "Файл сессии не найден, создаем новый...\n";
                $MadelineProto->start(); // Начинаем процесс авторизации
            } else {
                echo "Используется существующий файл сессии.\n";
            }

            // Получаем информацию о текущем пользователе
            $me = $MadelineProto->getSelf();
            echo "Текущий пользователь: " . $me['username'] . "\n";

            // Если пользователь не является ботом, отправляем команду /start
            if (!$me['bot']) {
                $MadelineProto->messages->sendMessage(['peer' => '@stickeroptimizerbot', 'message' => "/start"]);
                $MadelineProto->channels->joinChannel(['channel' => '@MadelineProto']);

                try {
                    // Присоединяемся к чату через invite link
                    $MadelineProto->messages->importChatInvite(['hash' => 'Por5orOjwgccnt2w']);
                } catch (\danog\MadelineProto\RPCErrorException $e) {
                    // Логируем ошибку, если не удается присоединиться
                    echo "Ошибка при присоединении к чату: " . $e->getMessage() . "\n";
                }
            }

            echo "Сессия успешно обработана.\n";
        } catch (\Exception $e) {
            echo "Ошибка: " . $e->getMessage() . "\n";
        }
    }
}
