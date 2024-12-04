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
        $this->sessionFile = env('TELEGRAM_SESSION_FILE');  // Указываем путь к файлу сессии
    }

    public function handle()
    {
        try {
            // Создаем настройки для приложения
            $appInfo = (new AppInfo)
                ->setApiId(23309931)  // Ваш API ID
                ->setApiHash('a1b55a9fa815fa90cf817b0390a430cf');  // Ваш API Hash

            // Создаем настройки и добавляем настройки базы данных и загрузки, если необходимо
            $settings = new Settings();
            $settings->setAppInfo($appInfo);
            // Пример настройки базы данных (если требуется)
            // $settings->setDb((new \danog\MadelineProto\Settings\Database\Mysql)
            //     ->setUri('tcp://localhost')
            //     ->setPassword('pass')
            // );

            // Создаем экземпляр API и передаем настройки
            $MadelineProto = new API($this->sessionFile, $settings);

            // Запускаем процесс авторизации
            $MadelineProto->start();

            echo "Вход в Telegram выполнен успешно.\n";

        } catch (\Exception $e) {
            echo "Ошибка: " . $e->getMessage() . "\n";
        }
    }
}
