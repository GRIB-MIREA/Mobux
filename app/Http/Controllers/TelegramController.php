<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TelegramController extends Controller
{
    public function sendMessage(Request $request)
    {
        $token = env('TELEGRAM_BOT_TOKEN');
        $chatId = $request->input('chat_id'); // Получите chat_id из запроса
        $text = $request->input('text'); // Получите текст сообщения из запроса

        $url = "https://api.telegram.org/bot{$token}/sendMessage";

        $response = Http::post($url, [
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'HTML', // или 'Markdown', если нужно
        ]);

        if ($response->successful()) {
            return response()->json(['status' => 'success', 'message' => 'Сообщение успешно отправлено!']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Ошибка при отправке сообщения', 'details' => $response->body()], 500);
        }
    }
}
