<?php

namespace App\Http\Controllers\view;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AccountListing;
use App\Models\Message;

class VkViewController extends Controller
{
    public function index(){
        $accounts = AccountListing::all();
        $messages = Message::all();

        // Передаем данные в шаблон
        return view('page/vk_page', compact('accounts', 'messages'));
    }
}