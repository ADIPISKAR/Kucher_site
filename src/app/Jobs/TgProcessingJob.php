<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Http\Controllers\API\TgClient;

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

    public function handle()
    {
        try {
            $tgClient = new TgClient();
            $tgClient->authorize();


            $tgClient->MadelineProto->messages->sendMessage(['peer' => $this->access_token, 'message' => "Привет!"]);


            echo 'Сообщения отправлены';
        } catch (\Exception $e) {
            echo('Ошибка в обработке сообщения TG: ' . $e->getMessage());
            throw $e;
        }
    }
}