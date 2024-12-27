<?php

namespace App\Http\Controllers\Back_doing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use danog\MadelineProto\API;
use danog\MadelineProto\Settings;
use danog\MadelineProto\Settings\AppInfo;



class Register_tg_account extends Controller
{
    public function register_number(Request $request){

        $phone = $request->input('phone');
        $sessionFile = env('TELEGRAM_SESSION_FILE');

        $appInfo = (new AppInfo)
        ->setApiId(23309931)
        ->setApiHash('a1b55a9fa815fa90cf817b0390a430cf'); 

        $settings = new Settings();
        $settings->setAppInfo($appInfo);

        $MadelineProto = new API($sessionFile, $settings);

        $MadelineProto->phoneLogin($phone);
    }
}
