<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        // Получите данные от Telegram
        $update = $request->all();

        // Обработайте данные (например, отправьте ответ, сохраните в БД и т.д.)
        // Пример простого ответа
        if (isset($update['message'])) {
            $chatId = $update['message']['chat']['id'];
            $text = "Hello, this is a response from your webhook!";

            // Отправка сообщения обратно в Telegram
            $this->sendMessage($chatId, $text);
        }

        return response()->json(['status' => 'success']);
    }

    private function sendMessage($chatId, $text)
    {
        $token = env('TELEGRAM_BOT_TOKEN'); // Получите токен из .env
        $url = "https://api.telegram.org/bot{$token}/sendMessage";

        $data = [
            'chat_id' => $chatId,
            'text' => $text,
        ];

        // Отправка POST-запроса
        Http::post($url, $data);
    }
}
