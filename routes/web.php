<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VkController;


Route::get('/', function () {
    return view('auth/login');
});


// Route::middleware(['auth'])->group(function(){
//     Route::get('/dasboard', function(){return view('dashboard');})->name('dashboard');
// });

Route::get('/your-route', [VkController::class, 'getUserData'])->name('getUserData');

Auth::routes();


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/vk_page', [App\Http\Controllers\view\VkViewController::class, 'index'])->name('vk_page');
Route::get('/tg_page', [App\Http\Controllers\view\TgViewController::class, 'index'])->name('tg_page');
Route::get('/tg_settings', [App\Http\Controllers\view\SettingsViewController::class, 'index'])->name('setting_page');

Route::get('/Add_list', [App\Http\Controllers\Back_doing\Controller_settings::class, 'index'])->name('Add_list');

Route::post('/New_user', [App\Http\Controllers\Back_doing\Controller_settings::class, 'New_user'])->name('New_user');
Route::post('/Add_message', [App\Http\Controllers\Back_doing\Controller_settings::class, 'add_message'])->name('add_message');
Route::delete('/account/{id}', [App\Http\Controllers\Back_doing\Controller_settings::class, 'destroy_user'])->name('destroy_user');
Route::delete('/message/{id}', [App\Http\Controllers\Back_doing\Controller_settings::class, 'message_destroy'])->name('message_destroy');

Route::get('/add_message_route', [App\Http\Controllers\Back_doing\Controller_settings::class, 'add_message_route'])->name('add_message_route');

Route::post('/vk_doing', [App\Http\Controllers\Back_doing\VkController::class, 'init'])->name('vk_doing');


