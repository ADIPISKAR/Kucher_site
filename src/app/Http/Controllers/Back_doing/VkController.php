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
        set_time_limit(0);

        $request->validate([
            'User' => 'required|exists:account_listings,id',
            'MessageGroup' => 'required|exists:messages,id'
        ]);

        $selectedUserId = $request->input('User');
        $selectedMessageGroupId = $request->input('MessageGroup');

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

        dispatch(new VkProcessingJob($access_token, $messagesArray));

        return redirect()->back()->with('message', 'Процесс запущен.');
    }

}
