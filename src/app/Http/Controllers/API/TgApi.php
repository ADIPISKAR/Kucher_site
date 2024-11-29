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
                'api_id' => '233023429931',  // Замените на ваш реальный API ID
                'api_hash' => 'a1b5sdfgfsda9fa815fa90cf817b0390a430cf',  // Замените на ваш реальный API Hash
            ],
            'logger' => [
                'logger' => 0, // 0 для отключения логирования, 1 для логирования в файл, 2 для логирования в консоль
            ],
            'serialization' => [
                'serialization_interval' => 300, // Интервал в секундах для автоматической сериализации сессии
            ],
            'updates' => [
                'handle_updates' => false, // Установите true, если хотите обрабатывать обновления вручную
            ],
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
