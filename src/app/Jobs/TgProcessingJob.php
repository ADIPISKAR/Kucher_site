<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use danog\MadelineProto\API;
use danog\MadelineProto\Settings;
use danog\MadelineProto\Settings\AppInfo;

class TgProcessingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    public $tries = 6;
    public $timeout = 2700;

    protected $sessionFile;

    public function __construct()
    {
        $this->sessionFile = env('TELEGRAM_SESSION_FILE');
    }

    public function handle()
    {
        try {
            $appInfo = (new AppInfo)
                ->setApiId(23309931)
                ->setApiHash('a1b55a9fa815fa90cf817b0390a430cf'); 

            $settings = new Settings();
            $settings->setAppInfo($appInfo);

            $MadelineProto = new API($this->sessionFile, $settings);

            $MadelineProto->start();

            echo "Вход в Telegram выполнен успешно.\n";

        } catch (\Exception $e) {
            echo "Ошибка: " . $e->getMessage() . "\n";
        }
    }
}
