<?php

use App\Models\Hero;
use App\Models\About;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    $heros = Hero::all();
    $abouts = About::all();



    return view('welcome', [
        'heros' => $heros,
        'abouts' => $abouts
    ]);
});
