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
            $VK = new VKApi;
    
            while (true) {
                // Получаем новое сообщение
                $drop_message = $VK->getMessageLast($this->access_token);
                $last_message = $drop_message['text'];
                $from_id = $drop_message['from_id'];  // id отправителя для дополнительной логики

                // Логирование последнего сообщения
                \Log::info("Последнее сообщение: $last_message");

                // Если встречаем сообщение о "слишком много лайков", останавливаем выполнение
                if (strpos($last_message, 'Слишком много лайков за сегодня') !== false) {
                    \Log::info("Цикл завершен из-за превышения лайков.");
                    return false;
                }
        
                $restartCycle = false;

                // Если найдено ключевое слово в $this->mess_pass
                foreach ($this->mess_pass as $iskl) {
                    if (strpos($last_message, $iskl) !== false) {
                        // Ответы на основе найденного сообщения
                        \Log::info("Сообщение найдено, начинаем действия.");
                        $VK->sendMessageWithGuzzle($this->access_token, '/start');
                        sleep(rand(2, 5));
                        $VK->sendMessageWithGuzzle($this->access_token, '1');
                        sleep(rand(2, 5));
                        $VK->sendMessageWithGuzzle($this->access_token, '5');
                        $restartCycle = true;
                        break;
                    }
                }

                if ($restartCycle) {
                    // Если цикл перезапускается, продолжаем его
                    continue;
                }
        
                // Логика для других вариантов сообщений
                if ((rand(0, 10) >= 5) && ($from_id == '-91050183')) {
                    sleep(rand(2, 5));
                    $VK->sendMessageWithGuzzle($this->access_token, '2');
                    sleep(rand(2, 5));
                    $VK->sendMessageWithGuzzle($this->access_token, 'Привет, чем занимаешься?');
                    $restartCycle = true;
                } else {
                    sleep(rand(2, 5));
                    $VK->sendMessageWithGuzzle($this->access_token, '3');
                    $restartCycle = true;
                }

                if ($restartCycle) {
                    // Если цикл перезапускается, продолжаем его
                    continue;
                }

                // Небольшая задержка перед следующим запросом
                sleep(3);  // Задержка 3 секунды, чтобы избежать слишком частых запросов
            }

        } catch (\Exception $e) {
            \Log::error('Ошибка в обработке сообщения VK: ' . $e->getMessage());
        }
    }
}
