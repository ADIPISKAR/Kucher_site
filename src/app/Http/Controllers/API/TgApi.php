<?php

namespace App\Http\Controllers\API;

require_once __DIR__ . '/../../../vendor/autoload.php';

if (!file_exists('madeline.php')) {
    copy('https://phar.madelineproto.xyz/madeline.php', 'madeline.php');
}
include 'madeline.php';

use danog\MadelineProto\API;

class TgApi {
    // private $MadelineProto;

    // public function __construct() {
    //     $this->MadelineProto = new \danog\MadelineProto\API('session.madeline');
    //     $this->MadelineProto->start();

    //     $me = $this->MadelineProto->getSelf();

    //     $this->MadelineProto->logger($me);

    //     if (!$me['bot']) {
    //         $this->MadelineProto->messages->sendMessage(peer: '@stickeroptimizerbot', message: "/start");

    //         $this->MadelineProto->channels->joinChannel(channel: '@MadelineProto');

    //         try {
    //             $this->MadelineProto->messages->importChatInvite(hash: 'https://t.me/+Por5orOjwgccnt2w');
    //         } catch (\danog\MadelineProto\RPCErrorException $e) {
    //             $this->MadelineProto->logger($e);
    //         }
    //     }
    //     $this->MadelineProto->echo('OK, done!');
    // }

    // public function authorize() {
    //     try {
    //         // $this->MadelineProto->start();
    //         echo "Авторизация прошла успешно!";
    //     } catch (Exception $e) {
    //         echo "Ошибка авторизации: " . $e->getMessage();
    //     }
    // }
}
