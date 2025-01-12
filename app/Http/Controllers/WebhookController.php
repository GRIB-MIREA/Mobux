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
        // Cache::forever('webhook-data', $request->all());
        // $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
        // $updates = $telegram->getWebhookUpdates();
        

        // if ($updates->getMessage()) {
        //     $chatId = $updates->getMessage()->getChat()->getId();
        //     $text = $updates->getMessage()->getText();
        //     $this->sendStartMessage($chatId, $text);
        // }
    }

    private function sendStartMessage($chatId)
    {
        $token = env('TELEGRAM_BOT_TOKEN');
        $url = "https://api.telegram.org/bot"."$token"."/sendMessage";

        $webAppUrl = 'https://t.me/mobux_bot/app';
        $tgChannelUrl = 'https://t.me/m0bux';

        // Создаем кнопку для входа в веб-приложение
        $replyMarkup = [
            'inline_keyboard' => [
                [
                    [
                        'text' => 'Все скидки',
                        'url' => $webAppUrl,
                    ],
                    [
                        'text' => 'Наш канал',
                        'url' => $tgChannelUrl,
                    ],
                ],
            ],
        ];

        $response = Http::post($url, [
            'chat_id' => $chatId,
            'text' => 'Бот MOBUX поможет сэкономить на покупках в ваших любимых магазинах, предоставляя актуальные промокоды и специальные предложения!',
            'reply_markup' => json_encode($replyMarkup),
        ]);

        if (!$response->successful()) {
            // Обработка ошибок
            Log::error('Ошибка при отправке сообщения: ' . $response->body());
        }
    }
}
