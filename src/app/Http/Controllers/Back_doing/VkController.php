<?php

namespace App\Http\Controllers\Back_doing;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\VkLongPollService;
use App\Jobs\VkProcessingJob;
use Illuminate\Bus\Queueable;

use App\Models\AccountListing; // Убедитесь, что добавили этот импорт
use App\Models\Message; // Убедитесь, что добавили этот импорт

class VkController extends Controller
{

    public function init(Request $request)
{
    // Устанавливаем время выполнения скрипта в бесконечность
    set_time_limit(0);

    // Проверяем, была ли нажата кнопка "Стоп"
    if ($request->input('action') === 'stop') {
        session()->forget('vk_processing'); // Удаляем флаг обработки из сессии
        return redirect()->back()->with('message', 'Процесс остановлен.');
    }

    // Обработка нажатия кнопки "Начать"
    $mess_pass = [
        0 => "Помни, что в интернете люди могут выдавать себя за других",
        1 => "Дайвинчик всегда доступен в Telegram",
        2 => "это совет от Дайвинчика как не стать жертвой мошенников.",
        3 => "предлагаю тебе сделку:",
        4 => "1. Смотреть анкеты.",
        5 => "Нашли кое-кого для тебя ;) Заканчивай с вопросом выше и увидишь кто это",
        6 => "1. Заполнить анкету заново.",
        7 => "Отлично! Надеюсь хорошо проведете время ;) добавляй в друзья",
        8 => "Мы тебя помним! Хочешь снова пообщаться с кем-то новым?",
        9 => "Подождем пока кто-то увидит твою анкету",
        10 => "Есть взаимная симпатия! Добавляй в друзья -",
        11 => "Ты понравился девушке, показать её?",
        12 => "Взять моё основное фото из ВК",
        13 => "Прикрепи к сообщению фото",
        14 => "Нет такого варианта ответа, напиши одну цифру",
        15 => "пришли мне свое местоположение и увидишь кто находится рядом",
        16 => "хочешь больше взаимок? Жми 💌 и спроси что-либо интересное у девушки. Она обязательно ответит ❤",
        17 => "Кому-то понравилась твоя анкета! Заканчивай с вопросом выше и посмотрим кто это",
        18 => "Сообщение слишком короткое. Напишите что-нибудь для этого пользователя или нажмите 1 чтобы продолжать поиски",
        19 => "В твоей анкете совсем нет текста, если ты напишешь немного о себе и кого ищешь, мы сможем лучше подобрать тебе пару.",
        20 => "Так ты не узнаешь, что кому-то нравишься",
        21 => "Расскажи о себе, кого хочешь найти, чем предлагаешь заняться",
        22 => "Напиши о себе что-нибудь поинтереснее",
        23 => "Так ты не узнаешь, что кому-то нравишься... Точно хочешь отключить свою анкету?",
        24 => "Нет такого варианта ответа"
    ];

    $request->validate([
        'User' => 'required|exists:account_listings,id',
        'MessageGroup' => 'required|exists:messages,id'
    ]);

    // Получаем ID пользователя и группы сообщений
    $selectedUserId = $request->input('User');
    $selectedMessageGroupId = $request->input('MessageGroup');

    // Получаем токен доступа и группу сообщений
    $access_token = AccountListing::find($selectedUserId)->Hash;
    $messageGroup = Message::find($selectedMessageGroupId);

    $messagesArray = [
        'name_group' => $messageGroup->name_group,
        'messages' => [
            $messageGroup->message_1,
            $messageGroup->message_2,
            $messageGroup->message_3,
            $messageGroup->message_4,
        ],
    ];

    dispatch(new VkProcessingJob($access_token, $mess_pass, $messagesArray))->onQueue('default');


    // Устанавливаем флаг обработки в сессии
    // session(['vk_processing' => true]);
    // echo 'Сессия создалась';
    // $client = new Client(['verify' => false]);

    // while (session('vk_processing')) {
    //     echo 'Цикл запустился';
    //     VkProcessingJob::dispatch($access_token, $mess_pass, $messagesArray);
    //     echo 'Процесс идёт';
    //     sleep(2);

    //     if (!session('vk_processing')) {
    //         break; // Остановка цикла при выполнении условия
    //     }
    // }

    // // После завершения работы убираем флаг обработки
    // session()->forget('vk_processing');
    // return redirect()->back()->with('message', 'Процесс завершён.');
}













    // public function Proccesing_vk($mess_pass, $access_token, $messagesArray){
    //     $VK = new VKApi;
    //     $drop_message = $VK->getMessageLast($access_token);
    //     $last_message = $drop_message['text'];

    //     if(strpos($last_message, 'Слишком много лайков за сегодня – ставь Мне нравится только тем, кто тебе действительно нравится. Загляни к нам попозже') !== false){
    //         return 'running_stop';
    //     }

    //     foreach($mess_pass as $iskl) {

    //         if (strpos($last_message, $iskl) !== false) {
    //             $VK->sendMessageWithGuzzle($access_token, '/start');
    //             sleep(rand(2,5));;
    //             $VK->sendMessageWithGuzzle($access_token, '1');
    //             sleep(rand(2,5));;
    //             $VK->sendMessageWithGuzzle($access_token, '5');
    //             return 'anketa_const';
    //         }

    //     }

    //     if((rand(0, 10) >= 5) and ($drop_message['from_id'] == '-91050183')){
    //         ModeliVK::create([
    //             'text' => $last_message
    //         ]);


    //         $randomIndex = array_rand($messagesArray['messages']);
    //         $randomMessage = $messagesArray['messages'][$randomIndex]; // Извлекаем сообщение по этому индексу

    //         sleep(rand(2,5));;
    //         $VK->sendMessageWithGuzzle($access_token, '2');
    //         sleep(rand(2,5));;
    //         $VK->sendMessageWithGuzzle($access_token, $randomMessage);
    //         return('MessageSend');
    //     }
    //     else{
    //         sleep(rand(2,5));;
    //         $VK->sendMessageWithGuzzle($access_token, '3');
    //         return('anketa_otklonena');
    //     }
    // }
}
