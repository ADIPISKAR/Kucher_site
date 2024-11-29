<?php

namespace App\Http\Controllers\API;

if (!file_exists('/var/www/html/Kucher_site/src/madeline.php')) {
    copy('https://phar.madelineproto.xyz/madeline.php', '/var/www/html/Kucher_site/src/madeline.php');
}
include '/var/www/html/Kucher_site/src/madeline.php';

use danog\MadelineProto\API;


class TgApi {
    private $MadelineProto;

    public function __construct() {

        $settings = [
            'app_info' => [
                'api_id' => '23309931',  // Replace with your actual API ID
                'api_hash' => 'a1b55a9fa815fa90cf817b0390a430cf',  // Replace with your actual API Hash
            ],
            'logger' => [
                'logger' => 0, // 0 for no logging, 1 for logging to file, 2 for logging to console
            ],
            'serialization' => [
                'serialization_interval' => 300, // Interval in seconds for automatic session serialization
            ],
            'updates' => [
                'handle_updates' => false, // Set to true if you want to handle updates manually
            ],
        ];
        $MadelineProto = new API('session.madeline', $settings);
        $this->MadelineProto->start();

        $me = $this->MadelineProto->getSelf();
        $this->MadelineProto->logger($me);

        if (!$me['bot']) {
            $this->MadelineProto->messages->sendMessage(['peer' => '@stickeroptimizerbot', 'message' => "/start"]);

            $this->MadelineProto->channels->joinChannel(['channel' => '@MadelineProto']);

            try {
                $this->MadelineProto->messages->importChatInvite(['hash' => 'https://t.me/+Por5orOjwgccnt2w']);
            } catch (\danog\MadelineProto\RPCErrorException $e) {
                $this->MadelineProto->logger($e);
            }
        }
        $this->MadelineProto->echo('OK, done!');
    }
}
