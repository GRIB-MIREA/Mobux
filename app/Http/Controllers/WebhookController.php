<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function index(Request $request)
    {
        Cache::forever('webhook-data', $request->all());
        $token = env('TELEGRAM_BOT_TOKEN'); // Получаем токен из файла .env
        $chatId = $request->input('message.chat.id'); // Получаем chat_id из входящего сообщения
        $text = $request->input('message.text'); // Получаем текст сообщения

        // Проверяем, является ли текст командой /start
        if ($text === '/start') {
            $this->sendStartMessage($chatId);
        }
    }

    private function sendStartMessage($chatId)
    {
        $token = env('TELEGRAM');
        $url = "https://api.telegram.org/bot{$token}/sendMessage";

        $webAppUrl = 'https://t.me/mobux_bot/app'; // Замените на URL вашего веб-приложения

        // Создаем кнопку для входа в веб-приложение
        $replyMarkup = [
            'inline_keyboard' => [
                [
                    [
                        'text' => 'Войти в веб-приложение',
                        'url' => $webAppUrl,
                    ],
                ],
            ],
        ];

        $response = Http::post($url, [
            'chat_id' => $chatId,
            'text' => 'Добро пожаловать! Нажмите кнопку ниже, чтобы войти в веб-приложение:',
            'reply_markup' => json_encode($replyMarkup),
        ]);

        if (!$response->successful()) {
            // Обработка ошибок
            Log::error('Ошибка при отправке сообщения: ' . $response->body());
        }
    }
}
