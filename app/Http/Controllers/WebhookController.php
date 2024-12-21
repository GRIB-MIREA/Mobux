<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class WebhookController extends Controller
{
    public function index(Request $request)
    {
        Cache::forever('webhook-data', $request->all());
        return true;
    }

    public function sendMessage(){
        Http::post('https://api.telegram.org/bot7770123301:AAH_3y0slyu2-BSVEjJ2ruBFivIf5cbRLfQ/sendMessage', [
            'chat_id' => 299814741,
            'text' => 'Заходи в бота',
            'reply_markup' => [
                'inline_keyboard' => [
                    [
                        'web_app' => [
                            'url' => 'https://t.me/mobux_bot/app'
                        ]
                    ]
                ]
            ]
        ])->json();
    }
}
