<?php

require 'vendor/autoload.php';

use danog\MadelineProto\API;

class TgClient {
    private $MadelineProto;

    public function __construct($settings = []) {
        $this->MadelineProto = new API('session.madeline', $settings);
    }

    public function authorize() {
        try {
            $this->MadelineProto->start();
            echo "Авторизация прошла успешно!";
        } catch (Exception $e) {
            echo "Ошибка авторизации: " . $e->getMessage();
        }
    }
}

// Пример использования:
$tgClient = new TgClient();
$tgClient->authorize();