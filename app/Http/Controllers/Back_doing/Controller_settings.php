<?php

namespace App\Http\Controllers\Back_doing;

use Illuminate\Http\Request;
use App\Models\AccountListing;
use App\Models\Message;
use App\Http\Controllers\Controller;

class Controller_settings extends Controller
{

    public function index(){
        return view('Doing\AddList_user');
    }

    public function New_user(Request $request){

        $request->validate([
            'name' => 'required|string|max:255',
            'Hash' => 'required|string|max:255',
        ]);

        AccountListing::create([
            'name' => $request->input('name'),
            'Hash' => $request->input('Hash'),
        ]);

        return redirect()->back()->with('success', 'Аккаунт успешно создан!');
    }

    public function destroy_user($id){
        $account = AccountListing::findOrFail($id);
        $account->delete();

        return redirect()->back()->with('success', 'Запись удалена успешно!');
    }

    public function message_destroy($id){
        $message = Message::findOrFail($id);
        $message->delete();

        return redirect()->back()->with('success', 'Запись удалена успешно!');
    }

    public function add_message_route(){
        return view('Doing\AddList_message');
    }

    public function add_message(Request $request){

        $request->validate([
            'name_group' => 'required|string|max:255',
            'message_1' => 'required|string|max:2555',
            'message_2' => 'required|string|max:255',
            'message_3' => 'required|string|max:255',
            'message_4' => 'required|string|max:255',
        ]);

        Message::create([
            'name_group' => $request->input('name_group'),
            'message_1' => $request->input('message_1'),
            'message_2' => $request->input('message_2'),
            'message_3' => $request->input('message_3'),
            'message_4' => $request->input('message_4'),
        ]);

         return redirect()->back()->with('success', 'Аккаунт успешно создан!');
    }


}
