<?php

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

use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\ThreadController;

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::resource('threads', 'ThreadController')->except('show');
Route::get('/threads/{channel}', [ThreadController::class, 'index'])->name('threads.index.channel');
Route::post('/threads/{channel}/{thread}/replies', [ReplyController::class, 'store']);
Route::get('/threads/{channel}/{thread}', [ThreadController::class, 'show'])->name('threads.show');

Route::post('/replies/{reply}/favorites', [FavoriteController::class, 'store'])->name('replies.favorites');
