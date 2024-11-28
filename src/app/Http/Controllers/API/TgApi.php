<?php

namespace App\Http\Controllers\API;

require_once __DIR__ . '/../../../vendor/autoload.php';

if (!file_exists('madeline.php')) {
    copy('https://phar.madelineproto.xyz/madeline.php', 'madeline.php');
}
include 'madeline.php';

use danog\MadelineProto\API;
use danog\MadelineProto\Settings\AppInfo;
use danog\MadelineProto\Settings\API as APISettings;

class TgApi {
    private $MadelineProto;

    public function __construct() {
        $appInfo = new AppInfo([
            'api_id' => '23309931', // Ваш API ID
            'api_hash' => 'a1b55a9fa815fa90cf817b0390a430cf' // Ваш API hash
        ]);

        $settings = new APISettings([
            'app_info' => $appInfo
        ]);

        $this->MadelineProto = new \danog\MadelineProto\API('/var/www/html/Kucher_site/src/session/session.madeline', $settings);
        $this->MadelineProto->start();

        $me = $this->MadelineProto->getSelf();
        $this->MadelineProto->logger($me);

        $this->MadelineProto->echo('OK, done!');
    }
}
