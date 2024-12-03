<?php

use App\Models\Hero;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    $heros = Hero::all();



    return view('welcome', [
        'heros' => $heros
    ]);
});
