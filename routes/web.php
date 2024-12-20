<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\WebhookController;

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
Route::post('/webhook', [WebhookController::class, 'handleWebhook']);

Route::group(['namespace' => 'App\Http\Controllers\Main'], function () {
    Route::get('/', 'IndexController')->name('index');
});

Route::group(['namespace' => 'App\Http\Controllers\Bot', 'prefix' => 'bot'], function () {
    Route::get('/', 'IndexController')->name('bot.index');
});

Auth::routes();
