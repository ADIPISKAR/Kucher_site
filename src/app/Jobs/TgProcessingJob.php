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

    // Добавим API ID и API Hash как параметры конструктора
    protected $apiId = 23309931;
    protected $apiHash = 'a1b55a9fa815fa90cf817b0390a430cf';

    public function __construct($apiId, $apiHash)
    {
        $this->access_token = $access_token;
        $this->messagesArray = $messagesArray;
        $this->excludedWords = WordsExclusion::pluck('word')->filter()->toArray();
        $this->sessionFile = env('TELEGRAM_SESSION_FILE', 'session.madeline'); // Путь к файлу сессии


        // Инициализация API ID и API Hash
        $this->apiId = $apiId;
        $this->apiHash = $apiHash;
    }

    public function handle()
    {
        try {
            // Конфигурируем настройки для MadelineProto с использованием API ID и API Hash
            $settings = new Settings();
            $settings->setAPIId($this->apiId);  // Устанавливаем API ID
            $settings->setAPIHash($this->apiHash); // Устанавливаем API Hash

            // Создаем или используем существующую сессию
            $MadelineProto = new API($this->sessionFile, $settings);
            $MadelineProto->start();

            // Получаем информацию о текущем пользователе
            $me = $MadelineProto->getSelf();
            $MadelineProto->logger($me);

            if (!$me['bot']) {
                $MadelineProto->messages->sendMessage(peer: '@stickeroptimizerbot', message: "/start");
                $MadelineProto->channels->joinChannel(channel: '@MadelineProto');

                try {
                    $MadelineProto->messages->importChatInvite(hash: 'Por5orOjwgccnt2w');
                } catch (\danog\MadelineProto\RPCErrorException $e) {
                    $MadelineProto->logger($e);
                }
            }

            echo "Сессия успешно обработана.\n";
        } catch (\Exception $e) {
            echo "Ошибка: " . $e->getMessage() . "\n";
        }
    }
}
