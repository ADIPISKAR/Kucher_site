<?php

namespace App\Http\Controllers\API;

require_once __DIR__ . '/../../../vendor/autoload.php';

if (!file_exists('madeline.php')) {
    copy('https://phar.madelineproto.xyz/madeline.php', 'madeline.php');
}
include 'madeline.php';

use danog\MadelineProto\API;

class TgApi {
    private $MadelineProto;

    public function __construct() {
        $settings = [
            'app_info' => [
                'api_id' => '23309931', // Замените на ваш API ID
                'api_hash' => 'a1b55a9fa815fa90cf817b0390a430cf' // Замените на ваш API hash
            ]
        ];

        $this->MadelineProto = new \danog\MadelineProto\API('session.madeline', $settings);
        $this->MadelineProto->start();

        $me = $this->MadelineProto->getSelf();
        $this->MadelineProto->logger($me);

        $this->MadelineProto->echo('OK, done!');
    }

    public function authorize() {
        try {
            // $this->MadelineProto->start();
            echo "Авторизация прошла успешно!";
        } catch (Exception $e) {
            echo "Ошибка авторизации: " . $e->getMessage();
        }
    }
}
