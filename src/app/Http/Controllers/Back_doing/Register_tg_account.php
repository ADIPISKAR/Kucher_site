<?php

namespace App\Http\Controllers\Back_doing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use danog\MadelineProto\API;
use danog\MadelineProto\Settings;
use danog\MadelineProto\Settings\AppInfo;



class Register_tg_account extends Controller
{
    public function register_number(Request $request)
    {
        $phone = $request->input('phone');
        $sessionFile = env('TELEGRAM_SESSION_FILE');

        $appInfo = (new AppInfo)
            ->setApiId(23309931)
            ->setApiHash('a1b55a9fa815fa90cf817b0390a430cf'); 

        $settings = new Settings();
        $settings->setAppInfo($appInfo);

        $MadelineProto = new API($sessionFile, $settings);

        $MadelineProto->phoneLogin($phone);

        session(['telegram_session' => $sessionFile]);

        return redirect()->route('next_step_number');
    }


    public function next_step_number(Request $request)
    {
        $code = $request->input('code');

        // Восстанавливаем MadelineProto из сессии
        $sessionFile = session('telegram_session');

        if (!$sessionFile) {
            return redirect()->route('register')->withErrors('Сессия Telegram не найдена');
        }

        $appInfo = (new AppInfo)
            ->setApiId(23309931)
            ->setApiHash('a1b55a9fa815fa90cf817b0390a430cf'); 

        $settings = new Settings();
        $settings->setAppInfo($appInfo);

        $MadelineProto = new API($sessionFile, $settings);

        // Завершаем авторизацию
        $authorization = $MadelineProto->completePhoneLogin($code);

        $MadelineProto->messages->sendMessage([
            'peer' => '@leomatchbot',     // ID чата или @username
            'message' => "Приветики!", // Сообщение
        ]);

        return redirect()->route('success'); // Перенаправление на страницу успешной авторизации
    }
}