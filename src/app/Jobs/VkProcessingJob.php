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
use App\Models\WordsExclusion;


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
        $this->excludedWords = WordsExclusion::pluck('word')->filter()->toArray();
    }

    public function handle()
    {
        try {
            
            $VK = new VKApi;
            $VK->sendMessageWithGuzzle($this->access_token, '/start');

            while (true) {
                $drop_message = $VK->getMessageLast($this->access_token);
                $last_message = $drop_message['text'];
    
                if (strpos($last_message, 'Слишком много лайков за сегодня') !== false) {
                    echo 'Превышен лимит лайков. Завершаем процесс.';
                    break;
                }
    
                $skipCurrentIteration = false;
                foreach ($this->excludedWords as $iskl) {
                    if (strpos($last_message, $iskl) !== False) {

                        $VK->sendMessageWithGuzzle($this->access_token, '/start');
                        sleep(rand(3, 7));
                        $VK->sendMessageWithGuzzle($this->access_token, '1');
                        sleep(rand(3, 7));
                        $VK->sendMessageWithGuzzle($this->access_token, '5');
                        $skipCurrentIteration = true;
                        break;
                        continue;
                    }
                }
    
                if ($skipCurrentIteration) {
                    continue;
                }
    
                if ((rand(0, 10) >= 5) && ($drop_message['from_id'] == '-91050183')) {

                    $existingMessage = ButterflyVk::where('message', $last_message)->first();

                    if ($existingMessage) {
                        $VK->sendMessageWithGuzzle($this->access_token, '3');
                        continue; // Переходим к следующей итерации
                    }

                    ButterflyVk::create([
                        'message' => $last_message
                    ]);

                    sleep(rand(3, 7));
                    $VK->sendMessageWithGuzzle($this->access_token, '2');
                    sleep(rand(3, 7));
                    $randomMessage = $this->messagesArray['messages'][array_rand($this->messagesArray['messages'])];
                    $VK->sendMessageWithGuzzle($this->access_token, $randomMessage);
                } else {
                    sleep(rand(3, 7));
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
