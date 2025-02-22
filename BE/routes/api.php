<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\PostController;

Route::middleware(['auth:api'])->get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::resource('/users', UserController::class);
Route::middleware(['auth:api'])->resource('/posts', PostController::class);
