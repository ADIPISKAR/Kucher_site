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

use \danog\madeline\API;
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

    public function __construct($access_token, $messagesArray)
    {
        $this->access_token = $access_token;
        $this->messagesArray = $messagesArray;
        $this->excludedWords = WordsExclusion::pluck('word')->filter()->toArray();
        $this->sessionFile = env('TELEGRAM_SESSION_FILE');
    }

    public function handle() {

        try {
            // Подключение к API Telegram
            $MadelineProto = new API($this->sessionFile);
            $MadelineProto->start();

            // Проверка, если пользователь не авторизован
            if (!$MadelineProto->isLoggedIn()) {
                echo "Необходимо пройти авторизацию...";
                // Авторизация через телефон
                $MadelineProto->phoneLogin('+79518456649');
                $code = readline("Введите код из SMS: ");
                $MadelineProto->completePhoneLogin($code);
            }

            // Отправка сообщения
            $MadelineProto->messages->sendMessage([
                'peer' => '1234060895',
                'message' => "Привет!",
            ]);

            echo "Сообщение отправлено!";
        } catch (\Exception $e) {
            echo "Ошибка при отправке сообщения: " . $e->getMessage();
        }
    }
}