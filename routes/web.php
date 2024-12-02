<?php

use App\Http\Controllers\ChatAppController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::post('/chatroom', [ChatAppController::class, 'index'])->name('chat-room');
Route::post('/send-msg', [ChatAppController::class, 'sendMsg'])->name('send-msg');

