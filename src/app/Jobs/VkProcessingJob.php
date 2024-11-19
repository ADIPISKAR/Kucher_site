<?php

namespace App\Jobs;
use App\Http\Controllers\API\VkApi;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\ButterflyVk;
use Illuminate\Support\Facades\DB;


class VkProcessingJob implements ShouldQueue
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
    }

    public function handle()
    {
        try {
            
            $VK = new VKApi;
            $this->excludedWords = DB::table('words_exclusion')->pluck('word')->toArray();
    
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
                foreach ($this->excludedWords  as $iskl) {
                    if (strpos($last_message, $iskl) !== False) {

                        // Прочие действия
                        $VK->sendMessageWithGuzzle($this->access_token, '/start');
                        sleep(rand(2, 5));
                        $VK->sendMessageWithGuzzle($this->access_token, '1');
                        sleep(rand(2, 5));
                        $VK->sendMessageWithGuzzle($this->access_token, '5');
                        $skipCurrentIteration = true; // Отмечаем, что нужно пропустить текущую итерацию
                        break; // Выходим из цикла поиска ключевых слов
                        continue;
                    }
                }
    
                // Если нужно пропустить итерацию, то переходим к следующей
                if ($skipCurrentIteration) {
                    continue;
                }
    
                // Если условие для сообщения от конкретного ID выполнено
                if ((rand(0, 10) >= 5) && ($drop_message['from_id'] == '-91050183')) {

                    // Проверяем, есть ли уже такое сообщение в таблице
                    $existingMessage = ButterflyVk::where('message', $last_message)->first();

                    if ($existingMessage) {
                        $VK->sendMessageWithGuzzle($this->access_token, '3');
                        continue; // Переходим к следующей итерации
                    }

                    ButterflyVk::create([
                        'message' => $last_message
                    ]);

                    sleep(rand(2, 5));
                    $VK->sendMessageWithGuzzle($this->access_token, '2');
                    sleep(rand(2, 5));
                    $randomMessage = $this->messagesArray['messages'][array_rand($this->messagesArray['messages'])];
                    $VK->sendMessageWithGuzzle($this->access_token, $randomMessage);
                } else {
                    sleep(rand(2, 5));
                    $VK->sendMessageWithGuzzle($this->access_token, '3');
                }
    
                sleep(rand(5, 10));
            }
        } catch (\Exception $e) {
            echo('Ошибка в обработке сообщения VK: ' . $e->getMessage());
            throw $e;
        }
    }

}
