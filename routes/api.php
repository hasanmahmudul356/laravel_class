<?php

use App\Http\Controllers\Frontend\CommentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('comments_data', [CommentController::class, 'getComments']);
Route::post('comments_data/delete', [CommentController::class, 'commentDelete']);
