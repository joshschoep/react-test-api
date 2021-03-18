<?php

use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [BlogPostController::class, 'root']);

Route::get('/recent', [BlogPostController::class, 'index']);

Route::group(['prefix' => 'posts', 'middleware' => 'auth'], function () {

    Route::get('create', [BlogPostController::class, 'create']);

    Route::get('{post}/edit', [BlogPostController::class, 'edit']);

    Route::get('{post}', [BlogPostController::class, 'show'])->withoutMiddleware('auth');

    Route::put('{post}', [BlogPostController::class, 'update']);

    Route::get('', [BlogPostController::class, 'index'])->withoutMiddleware('auth');

    Route::post('', [BlogPostController::class, 'store']);

});

Auth::routes();

Route::get('users/{id}', [UserController::class, 'show']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
