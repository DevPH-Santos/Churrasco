<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChurrascoController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/chat', [ChurrascoController::class, 'chat'])->name('chat');


