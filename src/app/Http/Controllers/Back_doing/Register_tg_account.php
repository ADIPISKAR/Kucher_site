<?php

namespace App\Http\Controllers\Back_doing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Register_tg_account extends Controller
{
    public function register_number(Request $request){
        $phone = $request->input('phone');
        console.log($phone);    
    }
}
