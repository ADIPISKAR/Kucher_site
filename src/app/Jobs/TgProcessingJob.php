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
use \danog\MadelineProto\API;
use \danog\MadelineProto\Settings;

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
            $madeline = new API(env('TELEGRAM_SESSION_FILE'), new Settings([
                'app_info' => [
                    'api_id' => '23309931',
                    'api_hash' => 'a1b55a9fa815fa90cf817b0390a430cf',
                ]
            ]));

            // Задать имя сессии
            $madeline->session = env('TELEGRAM_SESSION_FILE');

            // Принудительно сохранить сессию
            $madeline->serialize();

            // Начать авторизацию по номеру мобильного телефона
            $madeline->phone_login( env('+79518456649') );
            // Запросить код с помощью консоли
            $code = readline('Enter the code you received: ');
            $madeline->complete_phone_login($code);
        }

        $messages = $madeline->messages->getHistory(['peer' => '@leomatchbot', 'offset_id' => 0, 'offset_date' => 0, 'add_offset' => 0, 'limit' => 10, 'max_id' => 0, 'min_id' => 0, 'hash' => 0, ]);

        foreach($messages['messages'] as $msg) {
            dump($msg);
        }

    }
}
