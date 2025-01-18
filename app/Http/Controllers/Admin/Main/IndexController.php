<?php

namespace App\Http\Controllers\Admin\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Card;
use App\Models\Category;
use App\Models\Promocode;
use App\Models\TelegramUser;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function __invoke()
    {
        $notifications = Auth::user()->notifications;
        $data = [];
        $data['cardCount'] = Card::all()->count();
        $data['categoryCount'] = Category::all()->count();
        $data['promocodeCount'] = Promocode::all()->count();
        $data['telegramUserCount'] = TelegramUser::all()->count();
        return view('admin.main.index', compact('data', 'notifications'));
    }
}
