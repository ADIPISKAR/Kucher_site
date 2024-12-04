<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\WordsExclusion;
use danog\MadelineProto\API;
use danog\MadelineProto\Settings\AppInfo;
use danog\MadelineProto\Settings;

class TgProcessingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    public $tries = 6;
    public $timeout = 2700;

    protected $excludedWords;
    protected $sessionFile;

    public function __construct()
    {
        $this->excludedWords = WordsExclusion::pluck('word')->filter()->toArray();
        $this->sessionFile = env('TELEGRAM_SESSION_FILE');  // Указываем полный путь
    }

    public function handle()
    {
        try {
            $settings = (new AppInfo)
                ->setApiId('23309931')
                ->setApiHash('a1b55a9fa815fa90cf817b0390a430cf');


            // $settings = new Settings([
            //     'app_info' => [
            //         'api_id' => '23309931',  // Ваш api_id
            //         'api_hash' => 'a1b55a9fa815fa90cf817b0390a430cf',  // Ваш api_hash
            //     ],
            // ]);
            
            $MadelineProto = new API($this->sessionFile, $settings);

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
        } catch (\danog\MadelineProto\Exception $e) {
            echo "MadelineProto Ошибка: " . $e->getMessage() . "\n";
        } catch (\Exception $e) {
            echo "Ошибка: " . $e->getMessage() . "\n";
        }
    }
}
