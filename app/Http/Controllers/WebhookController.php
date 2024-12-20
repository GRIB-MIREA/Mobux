<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $update = $request->all();

        // Проверяем, есть ли сообщение и команда
        if (isset($update['message'])) {
            $chatId = $update['message']['chat']['id'];
            $text = $update['message']['text'];

            // Проверяем, является ли сообщение командой /start
            if ($text === '/start') {
                $responseText = "Добро пожаловать! Я ваш бот, как я могу помочь?";
                $this->sendMessage($chatId, $responseText);
            } else {
                // Обрабатываем другие команды или текстовые сообщения
                $this->sendMessage($chatId, "Вы написали: " . $text);
            }
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
