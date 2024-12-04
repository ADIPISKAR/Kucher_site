<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\WordsExclusion;
use danog\MadelineProto\API;
use danog\MadelineProto\Settings\AppInfo;
use danog\MadelineProto\Settings;

class TgProcessingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    public $tries = 6;
    public $timeout = 2700;

    protected $excludedWords;
    protected $sessionFile;

    public function __construct()
    {
        $this->excludedWords = WordsExclusion::pluck('word')->filter()->toArray();
        $this->sessionFile = env('TELEGRAM_SESSION_FILE');  // Указываем полный путь
    }

    public function handle()
    {
        try {
            $settings = (new \danog\MadelineProto\Settings\AppInfo)
                ->setApiId(23309931)
                ->setApiHash('a1b55a9fa815fa90cf817b0390a430cf');
            
            $MadelineProto = new \danog\MadelineProto\API('session.madeline', $settings);

            $MadelineProto->start(); 

        } catch (\Exception $e) {
            echo "Ошибка: " . $e->getMessage() . "\n";
        }
    }
}
