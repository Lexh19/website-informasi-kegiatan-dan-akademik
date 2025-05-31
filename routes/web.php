<?php

use App\Models\Hero;
use App\Models\About;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatbotController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

Route::get('/', function () {
    $heros = Hero::all();
    $abouts = About::all();

    return view('welcome', [
        'heros' => $heros,
        'abouts' => $abouts
    ]);
});

Route::post('/chat', ChatbotController::class)
    ->withoutMiddleware([VerifyCsrfToken::class]); 
