<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LoginController extends Controller
{
    public function auth(Request $request){
        $url = $request->input('photo_url');
        $ext = explode('.', $url);
        $ext = $ext[count($ext) - 1];
        $file_name = uniqid().'.'.$ext;
        Storage::putFileAs('public/assets/img', $request->input('photo_url'), $file_name);

        $player = Player::updateOrCreate(['telegram_id' => $request->input('id')], [
            'telegram_id' => $request->input('id'),
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'telegram_username' => $request->input('username'),
            'image' => $file_name,
        ]);
        if(Auth::attempt(['telegram_id' => $player->telegram_id])){
            $request->session()->regenerate();
            return response()->redirectTo('/bot');
        };
    }
}
