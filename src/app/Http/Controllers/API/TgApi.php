<?php

namespace App\Http\Controllers\API;

use danog\MadelineProto\API;

class TgApi {
    private $MadelineProto;

    public function __construct() {
        $settings = [
            'api_id' => '23309931',  // Замените на ваш реальный API ID
            'api_hash' => 'a1b55a9fa815fa90cf817b0390a430cf',  // Замените на ваш реальный API Hash
        ];

        // Инициализация API
        $this->MadelineProto = new API('session.madeline', $settings);
        $this->MadelineProto->start();

        // Получаем информацию о текущем пользователе
        $me = $this->MadelineProto->getSelf();
        $this->MadelineProto->logger($me);

        // Проверяем, является ли аккаунт ботом
        if (!$me['bot']) {
            // Отправляем команду /start боту
            $this->MadelineProto->messages->sendMessage(['peer' => '@stickeroptimizerbot', 'message' => "/start"]);

            // Присоединяемся к каналу MadelineProto
            $this->MadelineProto->channels->joinChannel(['channel' => '@MadelineProto']);

            // Пробуем импортировать чат по ссылке
            try {
                $this->MadelineProto->messages->importChatInvite(['hash' => 'https://t.me/+Por5orOjwgccnt2w']);
            } catch (\danog\MadelineProto\RPCErrorException $e) {
                // Логируем ошибку, если что-то пошло не так
                $this->MadelineProto->logger($e);
            }
        }
        
        // Выводим сообщение, что все завершено
        $this->MadelineProto->echo('OK, done!');
    }
}
