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
    // public function auth(Request $request){
    //     if(!$this->token($request))
    //     {
    //         throw new \Exception('Токен не валидный');
    //     }
    //     // $url = $request->input('photo_url');
    //     // $ext = pathinfo($url, PATHINFO_EXTENSION);
    //     // $file_name = uniqid().'.'.$ext;
    //     // $response = Http::get($url);

    //     // if ($response->successful()) {
    //     //     // Сохраняем изображение в хранилище
    //     //     Storage::put('public/assets/img/' . $file_name, $response->body());
    //     // } else {
    //     //     // Обработка ошибки, если изображение не удалось загрузить
    //     //     return response()->json(['error' => 'Не удалось загрузить изображение'], 500);
    //     // }

    //     $user = User::updateOrCreate(['telegram_id' => $request->input('id')], [
    //         'telegram_id' => $request->input('id'),
    //         'name' => $request->input('first_name'),
    //         'last_name' => $request->input('last_name'),
    //         'telegram_username' => $request->input('username'),
    //         'image' => $request->input('photo_url'),
    //         'password' => Hash::make(123),
    //     ]);
    //     if(Auth::attempt(['telegram_id' => $user->telegram_id, 'password' => 123])){
    //         $request->session()->regenerate();
    //         return response()->redirectTo('/bot');
    //     }
    //     return response()->redirectTo('/');
    // }

    // public function token(Request $request)
    // {
    //     $data = $request->all();
    //     $check_hash = $request->input('hash');
    //     unset($data['hash']);
    //     $data_check_arr = [];
    //     foreach ($data as $key => $value) {
    //         $data_check_arr[] = $key . '=' . $value;
    //     }
    //     sort($data_check_arr);
    //     $data_check_string = implode("\n", $data_check_arr);
    //     $secret_key = hash('sha256', env('TELEGRAM_BOT_TOKEN'), true);
    //     $hash = hash_hmac('sha256', $data_check_string, $secret_key);
    //     if(strcmp($hash, $check_hash) == 0 && (time() - $data['auth_date']) < 86400)
    //     {
    //         return true;
    //     }
    //     return false;
    // }

    // public function telegramAuth()
    // {
    //     $token = md5(uniqid());
    //     Auth::user()->telegram_token = $token;
    //     Auth::user()->save();
    //     return redirect('https://t.me/mobux_bot?start='.$token);
    // }

    public function authenticate(Request $request)
    {
        $data = $request->all();
        $checkHash = $data['hash'];
        unset($data['hash']);

        // Проверка контрольной суммы
        $secretKey = hash('sha256', env('TELEGRAM_BOT_TOKEN'), true);
        $checkString = collect($data)->map(function ($value, $key) {
            return "$key=$value";
        })->sort()->implode("\n");

        $calculatedHash = hash_hmac('sha256', $checkString, $secretKey);

        if ($calculatedHash !== $checkHash) {
            abort(403, 'Неверная подпись данных.');
        }

        // Проверяем срок действия
        if (time() - $data['auth_date'] > 86400) {
            abort(403, 'Время сессии истекло.');
        }

        // Ищем или создаём пользователя
        $user = User::firstOrCreate(
            ['telegram_id' => $data['id']],
            [
                'name' => $data['first_name'] ?? 'User',
                'username' => $data['username'] ?? null,
                'image' => $data['photo_url'] ?? null,
            ]
        );

        // Логиним пользователя
        Auth::login($user);

        // Перенаправляем в Mini App
        return redirect('/bot');
    }
}
