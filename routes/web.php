<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LoginController;
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

Http::post('https://api.telegram.org/bot7770123301:AAH_3y0slyu2-BSVEjJ2ruBFivIf5cbRLfQ/setWebhook', [
    'url' => 'https://mobux.ru/api/webhook'
])->json();
Route::get('/webhook-data', function() {
    dd(Cache::get('webhook-data'));
});
Route::any('/api/auth', [LoginController::class, 'auth']);
Route::get('/telegram-auth', [LoginController::class, 'telegramAuth'])->middleware('auth');


Route::group(['namespace' => 'App\Http\Controllers\Main'], function () {
    Route::get('/', 'IndexController')->name('index');
});

Route::group(['namespace' => 'App\Http\Controllers\Bot', 'prefix' => 'bot'], function () {
    Route::get('/', 'IndexController')->name('bot.index');
});

Route::group(['namespace' => 'App\Http\Controllers\Admin', 'prefix' => 'admin'], function () {
    Route::group(['namespace' => 'Main'], function () {
        Route::get('/', 'IndexController')->name('admin.index');
    });
    Route::group(['namespace' => 'User', 'prefix' => 'users'], function () {
        Route::get('/', 'IndexController')->name('admin.user.index');
        Route::get('/create', 'CreateController')->name('admin.user.create');
        Route::post('/', 'StoreController')->name('admin.user.store');
        Route::get('/{user}', 'ShowController')->name('admin.user.show');
        Route::get('/{user}/edit', 'EditController')->name('admin.user.edit');
        Route::patch('/{user}', 'UpdateController')->name('admin.user.update');
        Route::delete('/{user}', 'DeleteController')->name('admin.user.delete');
    });
    Route::group(['namespace' => 'Card', 'prefix' => 'cards'], function () {
        Route::get('/', 'IndexController')->name('admin.card.index');
        Route::get('/create', 'CreateController')->name('admin.card.create');
        Route::post('/', 'StoreController')->name('admin.card.store');
        Route::get('/{card}', 'ShowController')->name('admin.card.show');
        Route::get('/{card}/edit', 'EditController')->name('admin.card.edit');
        Route::patch('/{card}', 'UpdateController')->name('admin.card.update');
        Route::delete('/{card}', 'DeleteController')->name('admin.card.delete');
    });
    Route::group(['namespace' => 'Category', 'prefix' => 'categories'], function () {
        Route::get('/', 'IndexController')->name('admin.category.index');
        Route::get('/create', 'CreateController')->name('admin.category.create');
        Route::post('/', 'StoreController')->name('admin.category.store');
        Route::get('/{category}', 'ShowController')->name('admin.category.show');
        Route::get('/{category}/edit', 'EditController')->name('admin.category.edit');
        Route::patch('/{category}', 'UpdateController')->name('admin.category.update');
        Route::delete('/{category}', 'DeleteController')->name('admin.category.delete');
    });
});

Auth::routes();
