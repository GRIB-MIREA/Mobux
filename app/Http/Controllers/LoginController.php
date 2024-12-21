<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    public function auth(Request $request){
        // $url = $request->input('photo_url');
        // $ext = pathinfo($url, PATHINFO_EXTENSION);
        // $file_name = uniqid().'.'.$ext;
        // $response = Http::get($url);

        // if ($response->successful()) {
        //     // Сохраняем изображение в хранилище
        //     Storage::put('public/assets/img/' . $file_name, $response->body());
        // } else {
        //     // Обработка ошибки, если изображение не удалось загрузить
        //     return response()->json(['error' => 'Не удалось загрузить изображение'], 500);
        // }

        $player = Player::updateOrCreate(['telegram_id' => $request->input('id')], [
            'telegram_id' => $request->input('id'),
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'telegram_username' => $request->input('username'),
            'image' => $request->input('photo_url'),
        ]);
        if(Auth::attempt(['telegram_id' => $player->telegram_id])){
            $request->session()->regenerate();
            return response()->redirectTo('/bot');
        };
    }
}
