<?php

use App\Http\Controllers\Admin\NotificationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\Mailing\CreateController;

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

Route::group(['namespace' => 'App\Http\Controllers\Main'], function () {
    Route::get('/', 'IndexController')->name('index');
});

Route::group(['namespace' => 'App\Http\Controllers\Bot', 'prefix' => 'bot'], function () {
    Route::get('/', 'IndexController')->name('bot.index');
    Route::get('/categories', 'CategoryController')->name('bot.categories');
    Route::get('/about', 'AboutController')->name('bot.about');
    Route::group(['namespace' => 'Card', 'prefix' => 'card'], function() {
        Route::get('/{card}', 'ShowController')->name('card.show');
    });
    Route::group(['namespace' => 'Category', 'prefix' => '{category}/cards'], function() {
        Route::get('/', 'IndexController')->name('category.card.index');
    });
});

Route::group(['namespace' => 'App\Http\Controllers\Admin', 'prefix' => 'admin', 'middleware' => ['auth', 'admin']], function () {
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
        Route::post('/perfluence/import', 'ImportPerfluenceController')->name('admin.card.perfluence.import');
        Route::get('/{card}', 'ShowController')->name('admin.card.show');
        Route::get('/{card}/edit', 'EditController')->name('admin.card.edit');
        Route::patch('/{card}', 'UpdateController')->name('admin.card.update');
        Route::delete('/{card}', 'DeleteController')->name('admin.card.delete');
    });
    Route::group(['namespace' => 'Promocode', 'prefix' => 'promocodes'], function () {
        Route::get('/', 'IndexController')->name('admin.promocode.index');
        Route::get('/create', 'CreateController')->name('admin.promocode.create');
        Route::post('/', 'StoreController')->name('admin.promocode.store');
        Route::get('/{promocode}', 'ShowController')->name('admin.promocode.show');
        Route::get('/{promocode}/edit', 'EditController')->name('admin.promocode.edit');
        Route::patch('/{promocode}', 'UpdateController')->name('admin.promocode.update');
        Route::delete('/{promocode}', 'DeleteController')->name('admin.promocode.delete');
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
    Route::group(['namespace' => 'Stamp', 'prefix' => 'stamps'], function () {
        Route::get('/', 'IndexController')->name('admin.stamp.index');
        Route::get('/create', 'CreateController')->name('admin.stamp.create');
        Route::post('/', 'StoreController')->name('admin.stamp.store');
        Route::get('/{stamp}', 'ShowController')->name('admin.stamp.show');
        Route::get('/{stamp}/edit', 'EditController')->name('admin.stamp.edit');
        Route::patch('/{stamp}', 'UpdateController')->name('admin.stamp.update');
        Route::delete('/{stamp}', 'DeleteController')->name('admin.stamp.delete');
    });
    Route::group(['namespace' => 'Banner', 'prefix' => 'banners'], function () {
        Route::get('/', 'IndexController')->name('admin.banner.index');
        Route::get('/create', 'CreateController')->name('admin.banner.create');
        Route::post('/', 'StoreController')->name('admin.banner.store');
        Route::get('/{banner}', 'ShowController')->name('admin.banner.show');
        Route::get('/{banner}/edit', 'EditController')->name('admin.banner.edit');
        Route::patch('/{banner}', 'UpdateController')->name('admin.banner.update');
        Route::delete('/{banner}', 'DeleteController')->name('admin.banner.delete');
    });
    Route::group(['namespace' => 'Mailing', 'prefix' => 'mails'], function () {
        Route::get('/', 'IndexController')->name('admin.mail.index');
        Route::get('/create', 'CreateController')->name('admin.mail.create');
        Route::post('/', [CreateController::class, 'sendMessage'])->name('admin.mail.send');
    });
    Route::group(['namespace' => 'Settings', 'prefix' => 'settings'], function () {
        Route::get('/', 'IndexController')->name('admin.settings.index');
        Route::patch('/', 'UpdateController')->name('admin.settings.update');
    });
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
});

Auth::routes(['register' => false]);
