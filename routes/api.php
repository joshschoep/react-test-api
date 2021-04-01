<?php

use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/recent', [BlogPostController::class, 'index']);

Route::group(['prefix' => 'posts'], function () {

    Route::get('{post}', [BlogPostController::class, 'show']);

    Route::post('', [BlogPostController::class, 'store'])->middleware('auth:sanctum');

    Route::put('{post}', [BlogPostController::class, 'update'])->middleware('auth:sanctum');

    Route::delete('{post}', [BlogPostController::class, 'destroy'])->middleware('auth:sanctum');

    Route::get('', [BlogPostController::class, 'index']);

});

Route::post('posts/{post}/comments', [CommentController::class, 'store'])->middleware('auth:sanctum');

Route::group(['prefix' => 'comments'], function () {

    Route::get('{comment}', [CommentController::class, 'show']);

    Route::put('{comment}', [CommentController::class, 'update'])->middleware('auth:sanctum');

    Route::delete('{comment}', [CommentController::class, 'destroy'])->middleware('auth:sanctum');

});

Route::get('users/{id}', [UserController::class, 'show']);