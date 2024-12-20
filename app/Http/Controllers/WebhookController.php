<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        return response()->json(['status' => 'Webhook received']);
    }

    // private function sendMessage($chatId, $text)
    // {
    //     $token = env('TELEGRAM_BOT_TOKEN'); // Получите токен из .env
    //     $url = "https://api.telegram.org/bot{$token}/sendMessage";

    //     $data = [
    //         'chat_id' => $chatId,
    //         'text' => $text,
    //     ];

    //     // Отправка POST-запроса
    //     Http::post($url, $data);
    // }
}
