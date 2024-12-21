<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\TelegramController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

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

// $http = Http::post('https://api.telegram.org/bot7770123301:AAH_3y0slyu2-BSVEjJ2ruBFivIf5cbRLfQ/setWebhook', [
//     'url' => 'https://mobux.ru/api/webhook'
// ])->json();

// dd($http);

Route::get('/webhook-data', function() {
    dd(Cache::get('webhook-data'));
});

Route::group(['namespace' => 'App\Http\Controllers\Main'], function () {
    Route::get('/', 'IndexController')->name('index');
});

Route::group(['namespace' => 'App\Http\Controllers\Bot', 'prefix' => 'bot'], function () {
    Route::get('/', 'IndexController')->name('bot.index');
});

Auth::routes();
