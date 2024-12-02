<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\WordsExclusion;
use danog\MadelineProto\API;

class TgProcessingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    public $tries = 6;
    public $timeout = 2700;

    protected $access_token;
    protected $excludedWords;
    protected $messagesArray;
    protected $sessionFile;

    public function __construct($access_token, $messagesArray)
    {
        $this->access_token = $access_token;
        $this->messagesArray = $messagesArray;
        $this->excludedWords = WordsExclusion::pluck('word')->filter()->toArray();
        $this->sessionFile = env('TELEGRAM_SESSION_FILE', 'session.madeline'); // Путь к файлу сессии
    }

    public function handle()
    {
        try {
            // Создаем или используем существующую сессию
            $MadelineProto = new API($this->sessionFile);
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
