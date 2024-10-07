<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Http\Controllers\Controller;
use App\Models\AccountListing; // Убедитесь, что добавили этот импорт
use App\Models\Message; // Убедитесь, что добавили этот импорт

class VkApi extends Controller
{
    function sendMessageWithGuzzle($access_token, $message) {
        $client = new Client([
            'verify' => false,  // Отключить проверку сертификатов
        ]);

        $response = $client->post('https://api.vk.com/method/messages.send', [
            'form_params' => [
                'peer_id' => -91050183, // ID получателя
                'message' => $message,
                'random_id' => 0, // Генерация уникального ID для сообщения
                'access_token' => 'vk1.a.HCFmrya23ZUBDMoLEUbl4ZVvD5aYTHnUfKrReQLxbBSQ8rvcH8IAYAhgIAq4znRN3Hki1IKA2FrNUZ0pEUHdqWXoXE1n55t5d3WrjtgRphX01w4_PcKqH1DAXfwtw0zKv_ZSR1MYEvpM0zcMoQVbqjN8ApeT0PpIIUQNToYuvQrMFVV8re2nOOyGTzdokmrlhpjFc8QJzILC2-_gdRZFfg',
                'v' => '5.199', // Версия API
            ],
        ]);

        // Декодируем ответ
        $responseData = json_decode($response->getBody(), true);

        // Проверяем на наличие ошибок
        if (isset($responseData['error'])) {
            echo 'Ошибка: ' . $responseData['error']['error_msg'];
        } else {
            echo 'Сообщение отправлено! ID сообщения: ' . $responseData['response'];
        }
    }

    public function getMessageLast($access_token)
    {
        $client = new Client([
            'verify' => false,  // Отключить проверку сертификатов
        ]);

        // Получение списка сообщений из чата
        $response = $client->post('https://api.vk.com/method/messages.getHistory', [
            'form_params' => [
                'peer_id' => -91050183, // ID чата
                'count' => 1, // Получаем только последнее сообщение
                'access_token' => $access_token, // Используем переданный токен
                'v' => '5.131' // Версия API
            ],
        ]);

        // Декодируем ответ
        $responseData = json_decode($response->getBody(), true);

        // Проверяем наличие сообщений
        if (isset($responseData['response']['items']) && !empty($responseData['response']['items'])) {
            return $responseData['response']['items'][0]; // Возвращаем последнее сообщение
        }

        return null; // Если сообщений нет, возвращаем null
    }
}
