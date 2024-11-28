<?php

namespace App\Http\Controllers\API;

if (!file_exists('/var/www/html/Kucher_site/src/madeline.php')) {
    copy('https://phar.madelineproto.xyz/madeline.php', '/var/www/html/Kucher_site/src/madeline.php');
}
include '/var/www/html/Kucher_site/src/madeline.php';

use danog\MadelineProto\API;
// use danog\MadelineProto\Settings\Bot;

class TgApi {
    private $MadelineProto;

    public function __construct() {
        $this->MadelineProto = new \danog\MadelineProto\API('/var/www/html/Kucher_site/src/session/session.madeline');
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
