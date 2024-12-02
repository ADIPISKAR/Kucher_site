<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Http\Controllers\API\TgApi;
use App\Models\WordsExclusion;
use danog\madeline\Settings\Instance as MadelineSettings;

use danog\MadelineProto\API;
use \danog\madeline\Settings;
use \danog\madeline\Tools;

class TgProcessingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    public $tries = 6;
    public $timeout = 2700;

    protected $access_token;
    protected $excludedWords;
    protected $messagesArray;
    protected $sessionFile; // Добавьте это свойство

    public function __construct($access_token, $messagesArray)
    {
        $this->access_token = $access_token;
        $this->messagesArray = $messagesArray;
        $this->excludedWords = WordsExclusion::pluck('word')->filter()->toArray();
        $this->sessionFile = env('TELEGRAM_SESSION_FILE'); // Теперь будет работать корректно
    }

    public function handle()
    {
        try {
            if (!file_exists('madeline.php')) {
                copy('https://phar.madelineproto.xyz/madeline.php', 'madeline.php');
            }
            include 'madeline.php';
            
            // Используйте $this->sessionFile в логике, если необходимо
            $MadelineProto = new \danog\MadelineProto\API($this->sessionFile ?: 'session.madeline');
            $MadelineProto->start();
            
            $me = $MadelineProto->getSelf();
            
            $MadelineProto->logger($me);
            
            if (!$me['bot']) {
                $MadelineProto->messages->sendMessage(peer: '@stickeroptimizerbot', message: "/start");
            
                $MadelineProto->channels->joinChannel(channel: '@MadelineProto');
            
                try {
                    $MadelineProto->messages->importChatInvite(hash: 'https://t.me/+Por5orOjwgccnt2w');
                } catch (\danog\MadelineProto\RPCErrorException $e) {
                    $MadelineProto->logger($e);
                }
            }
            $MadelineProto->echo('OK, done!');
    
            echo 'Сообщение отправлено!\n';
        } catch (\Exception $e) {
            echo "Ошибка при отправке сообщения: " . $e->getMessage() . "\n";
            echo "Трассировка стека: " . $e->getTraceAsString() . "\n";
        }
    }
}
