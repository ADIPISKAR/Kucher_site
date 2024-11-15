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
    use Dispatchable, InteractsWithQueue, SerializesModels;

    public $tries = 6;
    public $timeout = 2700;

    protected $access_token;
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
    try {
        // Создаем объект VKApi
        $VK = new VKApi;

        while (true) {
            // Получаем последнее сообщение
            $drop_message = $VK->getMessageLast($this->access_token);
            $last_message = $drop_message['text'];

            // Если встретилось сообщение "Слишком много лайков за сегодня", выходим из цикла
            if (strpos($last_message, 'Слишком много лайков за сегодня') !== false) {
                echo 'Превышен лимит лайков. Завершаем процесс.';
                break;
            }

            // Проверка на исключенные сообщения
            $skipCurrentIteration = false;
            foreach ($this->mess_pass as $iskl) {
                if (strpos($last_message, $iskl) !== false) {
                    $VK->sendMessageWithGuzzle($this->access_token, '/start');
                    sleep(rand(2, 5));
                    $VK->sendMessageWithGuzzle($this->access_token, '1');
                    sleep(rand(2, 5));
                    $VK->sendMessageWithGuzzle($this->access_token, '5');
                    $skipCurrentIteration = true; // Отмечаем, что нужно пропустить текущую итерацию
                    break; // Выходим из цикла поиска ключевых слов
                }
            }

            // Если нужно пропустить итерацию, то переходим к следующей
            if ($skipCurrentIteration) {
                continue;
            }

            // Если условие для сообщения от конкретного ID выполнено
            if ((rand(0, 10) >= 5) && ($drop_message['from_id'] == '-91050183')) {
                sleep(rand(2, 5));
                $VK->sendMessageWithGuzzle($this->access_token, '2');
                sleep(rand(2, 5));
                $VK->sendMessageWithGuzzle($this->access_token, 'Привет, чем занимаешься?');
            } else {
                sleep(rand(2, 5));
                $VK->sendMessageWithGuzzle($this->access_token, '3');
            }

            // Делаем паузу между циклами
            sleep(rand(5, 10));
        }
    } catch (\Exception $e) {
        echo('Ошибка в обработке сообщения VK: ' . $e->getMessage());
        throw $e;
    }
}

}
