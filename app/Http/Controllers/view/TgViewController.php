<?php

namespace App\Http\Controllers\view;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TgViewController extends Controller
{
    public function index(){

         return view('page/tg_page');
    }
}
