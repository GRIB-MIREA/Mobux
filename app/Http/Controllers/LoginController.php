<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

        $user = User::updateOrCreate(['telegram_id' => $request->input('id')], [
            'telegram_id' => $request->input('id'),
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'telegram_username' => $request->input('username'),
            'image' => $request->input('photo_url'),
            'password' => Hash::make(123),
        ]);
        if(Auth::attempt(['telegram_id' => $user->telegram_id, 'password' => 123])){
            $request->session()->regenerate();
            return response()->redirectTo('/bot');
        }
        return response()->redirectTo('/');
    }
}
