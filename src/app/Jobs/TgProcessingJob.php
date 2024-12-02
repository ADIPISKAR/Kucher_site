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

    public function __construct($access_token, $messagesArray)
    {
        $this->access_token = $access_token;
        $this->messagesArray = $messagesArray;
        $this->excludedWords = WordsExclusion::pluck('word')->filter()->toArray();
        $this->sessionFile = env('TELEGRAM_SESSION_FILE');
    }

    public function handle()
    {
        try {
            // Подключение к API Telegram
            $MadelineProto = new API($this->sessionFile);
            $MadelineProto->start();
    
            // Проверка, если пользователь не авторизован
            if (!$MadelineProto->isLoggedIn()) {
                echo "Необходимо пройти авторизацию...\n";
    
                // Авторизация через телефон (вводите свой номер)
                $MadelineProto->phoneLogin('+79518456649'); // Ваш номер телефона
                echo "Введите код из SMS: ";
                $code = readline();
                $MadelineProto->completePhoneLogin($code);
    
                echo "Авторизация прошла успешно!\n";
            } else {
                echo "Вы уже авторизованы!\n";
            }
    
            // Отправка сообщения
            $MadelineProto->messages->sendMessage([
                'peer' => '1234060895', // Замените на правильный ID чата
                'message' => "Привет!",
            ]);
    
            echo 'Сообщение отправлено!\n';
        } catch (\Exception $e) {
            echo "Ошибка при отправке сообщения: " . $e->getMessage() . "\n";
            echo "Трассировка стека: " . $e->getTraceAsString() . "\n";
        }
    }
    
}