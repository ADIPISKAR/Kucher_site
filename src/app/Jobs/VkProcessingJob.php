<?php

namespace App\Jobs;

use App\Models\Vk;
use App\Models\VkAccount;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Exception;

class VkProcessingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $vk_account_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($vk_account_id)
    {
        $this->vk_account_id = $vk_account_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        echo 'VkProcessingJob started' . PHP_EOL;

        try {
            $vk_account = VkAccount::find($this->vk_account_id);
            echo 'Vk account found: ' . ($vk_account ? 'Yes' : 'No') . PHP_EOL;

            // Проверка на существование учетной записи
            if (!$vk_account) {
                echo 'VkAccount not found. Aborting job.' . PHP_EOL;
                return;
            }

            // Получаем все ВК аккаунты и их сообщения
            $messages = Vk::where('vk_account_id', $this->vk_account_id)->get();
            echo 'Found ' . count($messages) . ' messages to process.' . PHP_EOL;

            foreach ($messages as $message) {
                echo 'Processing message ID: ' . $message->id . PHP_EOL;

                // Ваш код для отправки сообщений
                // Например:
                // if ($this->sendMessage($message)) {
                //     echo 'Message sent successfully: ' . $message->id . PHP_EOL;
                // } else {
                //     echo 'Failed to send message: ' . $message->id . PHP_EOL;
                // }

                // Пример обработки сообщения:
                echo 'Message text: ' . $message->text . PHP_EOL;
                echo 'Message status: ' . ($message->sent ? 'Sent' : 'Not sent') . PHP_EOL;
                
                // Логика обработки сообщений и отправки
            }

            echo 'VkProcessingJob completed' . PHP_EOL;

        } catch (Exception $e) {
            echo 'Error occurred: ' . $e->getMessage() . PHP_EOL;
            echo 'Stack trace: ' . $e->getTraceAsString() . PHP_EOL;
        }
    }

    /**
     * Метод для отправки сообщений
     */
    private function sendMessage($message)
    {
        // Логика отправки сообщения ВКонтакте
        // Реализуйте этот метод, если необходимо
        // В данном примере просто возвращаем true, как если бы сообщение было отправлено
        return true; 
    }
}
