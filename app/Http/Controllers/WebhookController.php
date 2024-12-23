<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Api;

class WebhookController extends Controller
{
    public function index(Request $request)
    {
        Cache::forever('webhook-data', $request->all());
        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
        $updates = $telegram->getWebhookUpdates();
        

        if ($updates->getMessage()) {
            $chatId = $updates->getMessage()->getChat()->getId();
            $text = $updates->getMessage()->getText();
    
            // Проверяем, является ли сообщение командой /start
            if ($text === '/start') {
                $this->sendStartMessage($chatId);
            }
        }
    }

    private function sendStartMessage($chatId)
    {
        $token = env('TELEGRAM_BOT_TOKEN');
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
