<?php

namespace App\Http\Controllers\view;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AccountListing;
use App\Models\Message;

class TgViewController extends Controller
{
    public function index(){

        $accounts = AccountListing::all();
        $messages = Message::all();

         return view('page/tg_page', compact('accounts', 'messages'));
    }
}
