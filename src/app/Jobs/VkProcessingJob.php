<?php

namespace App\Jobs;

use App\Http\Controllers\API\VkApi;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class VkProcessingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $access_token;   // Делаем свойства доступными
    protected $mess_pass;
    protected $messagesArray;

    public function __construct($access_token, $mess_pass, $messagesArray)
    {
        $this->access_token = $access_token;
        $this->mess_pass = $mess_pass;
        $this->messagesArray = $messagesArray;
    }

    public function handle()
    {

        echo 'Обработка началась';
        // Создаем объект VKApi
        $VK = new VKApi;

        // Используем $this->access_token, которое теперь доступно
        $drop_message = $VK->getMessageLast($this->access_token);
        $last_message = $drop_message['text'];

        if(strpos($last_message, 'Слишком много лайков за сегодня – ставь Мне нравится только тем, кто тебе действительно нравится. Загляни к нам попозже') !== false){
            return false;
        }

        foreach ($this->mess_pass as $iskl) {
            if (strpos($last_message, $iskl) !== false) {
                $VK->sendMessageWithGuzzle($this->access_token, '/start');
                sleep(rand(2, 5));
                $VK->sendMessageWithGuzzle($this->access_token, '1');
                sleep(rand(2, 5));
                $VK->sendMessageWithGuzzle($this->access_token, '5');
                return;
            }
        }

        // Пример работы с сообщениями
        if ((rand(0, 10) >= 5) && ($drop_message['from_id'] == '-91050183')) {
            sleep(rand(2, 5));
            $VK->sendMessageWithGuzzle($this->access_token, '2');
            sleep(rand(2, 5));
            $VK->sendMessageWithGuzzle($this->access_token, 'Привет, чем занимаешься?');
            return;
        } else {
            sleep(rand(2, 5));
            $VK->sendMessageWithGuzzle($this->access_token, '3');
            return;
        }
    }
}