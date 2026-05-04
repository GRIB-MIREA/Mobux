<?php

namespace App\Http\Controllers\Bot;

use App\Models\Banner;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Card;
use Illuminate\Http\Request;

class IndexController extends BaseController
{
    public function __invoke(Request $request)
    {
        //  // Получаем данные пользователя из параметров URL
        //  $telegramId = $request->query('user_id');
        //  $username = $request->query('username');
        //  $name = $request->query('first_name');
        //  $last_name = $request->query('last_name');
        //  $image = $request->query('photo_url');
 
        //  // Проверяем, есть ли данные пользователя
        //  if ($telegramId) {
        //      // Сохраняем или обновляем данные пользователя в базе данных
        //      $user = User::updateOrCreate(
        //          ['telegram_id' => $telegramId], // Уникальное поле для поиска
        //          [
        //              'telegram_username' => $username,
        //              'name' => $name,
        //              'last_name' => $last_name,
        //              'image' => $image,
        //          ]
        //      );
 
        //      // Сохраняем данные пользователя в сессии
        //      session([
        //          'user_id' => $user->id, // Сохраняем ID пользователя в сессии
        //          'telegram_username' => $username,
        //          'first_name' => $name,
        //          'last_name' => $last_name,
        //          'photo_url' => $image,
        //      ]);
        //  }
        $banners = Banner::all();
        $cards = Card::withPromocodes()
            ->orderBy('position', 'asc')
            ->with(['category', 'stamps'])
            ->get();

        return view('bot.index', compact('cards', 'banners'));
    }
}
