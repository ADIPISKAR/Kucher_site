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
    }

    public function handle() {

        try {
            if (file_exists(env('TELEGRAM_SESSION_FILE'))) {
                $madeline = new API(env('TELEGRAM_SESSION_FILE'));
            } else {
                $madeline = new API(env('TELEGRAM_SESSION_FILE'), new Settings([
                    'app_info' => [
                        'api_id' => '23309931',  
                        'api_hash' => 'a1b55a9fa815fa90cf817b0390a430cf',
                    ]
                ]));
            }
        
            $madeline->start();

            // Вход в аккаунт через телефон, если еще не авторизованы
            if (!$madeline->isLoggedIn()) {
                echo "Необходимо пройти авторизацию...";
                // Ваш телефон для получения кода
                $madeline->phoneLogin($phoneNumber);
                // Получаем код из SMS
                $code = readline("Введите код из SMS: ");
                $madeline->completePhoneLogin($code);
            }
            // // Попытка входа
            // $madeline->phone_login('+79518456649');
            // // Запросить код с помощью консоли
            // $code = readline('Enter the code you received: ');
            // $madeline->complete_phone_login($code);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}