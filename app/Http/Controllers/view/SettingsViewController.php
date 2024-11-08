<?php

namespace App\Http\Controllers\view;

use Illuminate\Http\Request;
use App\Models\AccountListing;
use App\Models\Message;
use App\Http\Controllers\Controller;

class SettingsViewController extends Controller
{
    public function index(){

        $accounts = AccountListing::all();
        $messages = Message::all();

        return view('page/setting_page', compact('accounts', 'messages'));
    }
}
