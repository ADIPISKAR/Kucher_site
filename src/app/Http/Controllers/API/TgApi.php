<?php

namespace App\Http\Controllers\API;

require_once __DIR__ . '/../../../vendor/autoload.php';

use danog\MadelineProto\API;

class TgApi {
    private $MadelineProto;

    public function __construct($settings = null) {
        $this->MadelineProto = new API('session.madeline');
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
