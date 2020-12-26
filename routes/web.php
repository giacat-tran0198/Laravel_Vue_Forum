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
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\ThreadSubscriptionsController;

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::resource('threads', 'ThreadController')->except(['show', 'destroy']);
Route::get('/threads/{channel}', [ThreadController::class, 'index'])->name('threads.index.channel');
Route::get('/threads/{channel}/{thread}/replies', [ReplyController::class, 'index']);
Route::post('/threads/{channel}/{thread}/replies', [ReplyController::class, 'store']);
Route::get('/threads/{channel}/{thread}', [ThreadController::class, 'show'])->name('threads.show');
Route::delete('/threads/{channel}/{thread}', [ThreadController::class, 'destroy'])->name('threads.destroy');

Route::post('/threads/{channel}/{thread}/subscriptions', [ThreadSubscriptionsController::class, 'store'])->middleware('auth');
Route::delete('/threads/{channel}/{thread}/subscriptions', [ThreadSubscriptionsController::class, 'destroy'])->middleware('auth');

Route::post('/replies/{reply}/favorites', [FavoriteController::class, 'store'])->name('replies.favorites');
Route::delete('/replies/{reply}/favorites', [FavoriteController::class, 'destroy'])->name('replies.favorites.destroy');
Route::delete('/replies/{reply}', [ReplyController::class, 'destroy'])->name('replies.destroy');
Route::patch('/replies/{reply}', [ReplyController::class, 'update'])->name('replies.update');

Route::get('/profiles/{user}', [ProfilesController::class, 'show'])->name('profiles');
