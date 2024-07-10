<?php

use Illuminate\Support\Facades\Route;



Route::prefix('/')->group(function (){
    Route::get('/', [\App\Http\Controllers\Frontend\FrontendController::class, 'index']);
    Route::get('/categories', [\App\Http\Controllers\Frontend\FrontendController::class, 'webCategory']);
    Route::get('/contact', [\App\Http\Controllers\Frontend\FrontendController::class, 'webContact']);
});

Route::prefix('admin')->group(function (){
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'dashboard'])->name('dashboard');

    Route::get('/category', [\App\Http\Controllers\Backend\CategoryController::class, 'category'])->name('cat.list');
    Route::get('/category/add', [\App\Http\Controllers\Backend\CategoryController::class, 'create'])->name('cat.add');
    Route::post('/category/add', [\App\Http\Controllers\Backend\CategoryController::class, 'store'])->name('cat.submit');
    Route::get('/category/edit/{id}', [\App\Http\Controllers\Backend\CategoryController::class, 'edit'])->name('cat.edit');
    Route::post('/category/edit', [\App\Http\Controllers\Backend\CategoryController::class, 'update'])->name('cat.update');
    Route::get('/delete/{id}', [\App\Http\Controllers\Backend\CategoryController::class, 'delete'])->name('cat.delete');

    Route::get('/news', [\App\Http\Controllers\DashboardController::class, 'news']);
    Route::get('/contact', [\App\Http\Controllers\DashboardController::class, 'contact']);
});


