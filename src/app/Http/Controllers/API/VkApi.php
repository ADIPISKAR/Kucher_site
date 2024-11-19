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
        try {
                $client = new Client([
                    'verify' => false,  // Отключить проверку сертификатов
                ]);

                $response = $client->post('https://api.vk.com/method/messages.send', [
                    'form_params' => [
                        'peer_id' => -91050183, // ID получателя
                        'message' => $message,
                        'random_id' => 0, // Генерация уникального ID для сообщения
                        'access_token' => $access_token,
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
        catch (\Exception $e) {
            echo('Ошибка в обработке сообщения VK: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getMessageLast($access_token)
    {
        try {
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
    
            // Проверка на наличие ошибок в ответе
            if (isset($responseData['error'])) {
                throw new \Exception('Ошибка API VK: ' . $responseData['error']['error_msg']);
            }
    
            // Проверяем наличие сообщений и что это массив
            if (isset($responseData['response']['items']) && is_array($responseData['response']['items']) && !empty($responseData['response']['items'])) {
                return $responseData['response']['items'][0]; // Возвращаем последнее сообщение
            }
    
            return null; // Если сообщений нет, возвращаем null
        } 
        catch (\Exception $e) {
            echo('Ошибка в обработке сообщения VK: ' . $e->getMessage());
            throw $e;
        }
    }
    
    
}
