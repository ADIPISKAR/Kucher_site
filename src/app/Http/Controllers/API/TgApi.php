<?php

namespace App\Http\Controllers\API;

use GuzzleHttp\Client;

class TgApi {
    
    private $client;
    private $apiUrl;

    public function __construct($botToken) {
        $this->client = new Client();
        $this->apiUrl = "https://api.telegram.org/bot{$botToken}/";
    }

    public function sendMessage($chatId, $message) {
        $response = $this->client->post($this->apiUrl . 'sendMessage', [
            'json' => [
                'chat_id' => $chatId,
                'text' => $message
            ]
        ]);

        return json_decode($response->getBody(), true);
    }
}
