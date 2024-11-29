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
use danog\MadelineProto\Settings\Instance as MadelineSettings;

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

        // Если файл с сессией уже существует, использовать его
        if(file_exists( env('TELEGRAM_SESSION_FILE') ) ) {
            $madeline = new API( env('TELEGRAM_SESSION_FILE') );
        } else {
        // Иначе создать новую сессию
            $madeline = new API([
                'app_info' => [
                    'api_id' => env('TELEGRAM_API_ID'),
                    'api_hash' => env('TELEGRAM_API_HASH'),
                ]
            ]);

            // Задать имя сессии
            $madeline->session = env('TELEGRAM_SESSION_FILE');

            // Принудительно сохранить сессию
            $madeline->serialize();

            // Начать авторизацию по номеру мобильного телефона
            $madeline->phone_login( env('TELEGRAM_PHONE') );
            // Запросить код с помощью консоли
            $code = readline('Enter the code you received: ');
            $madeline->complete_phone_login($code);
        }

        $messages = $madeline->messages->getHistory(['peer' => '@ANY_CHANNEL_ID', 'offset_id' => 0, 'offset_date' => 0, 'add_offset' => 0, 'limit' => 10, 'max_id' => 0, 'min_id' => 0, 'hash' => 0, ]);

        foreach($messages['messages'] as $msg) {
            dump($msg);
        }

    }
}
