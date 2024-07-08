<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/sdsdsadasd', [\App\Http\Controllers\HomeController::class, 'index']);

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index']);

    Route::prefix('news')->group(function () {
        Route::get('list', [\App\Http\Controllers\DashboardController::class, 'newsList'])->name('newslist');
        Route::get('add', [\App\Http\Controllers\DashboardController::class, 'newsAddForm'])->name('news.add');
    });
});

//Route::get('/admin/dashboard', [\App\Http\Controllers\DashboardController::class, 'index']);
//Route::get('/admin/news/list', [\App\Http\Controllers\DashboardController::class, 'newsList'])->name('newslist');
//Route::get('/admin/news/add', [\App\Http\Controllers\DashboardController::class, 'newsAddForm'])->name('news.add');
