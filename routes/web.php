<?php

use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/sdsdsadasd', [\App\Http\Controllers\HomeController::class, 'index']);
