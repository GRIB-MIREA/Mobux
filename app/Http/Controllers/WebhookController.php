<?php

namespace App\Http\Controllers;

use App\Models\TelegramUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Api;

class WebhookController extends Controller
{
    public function index(Request $request)
    {
        $secret = config('telegram.bots.mybot.webhook_secret');
        if ($secret && !hash_equals($secret, (string) $request->header('X-Telegram-Bot-Api-Secret-Token'))) {
            abort(403);
        }

        $telegram = new Api(config('telegram.bots.mybot.token'));
        $updates = $telegram->getWebhookUpdates();
        

        if ($updates->getMessage()) {
            $chatId = $updates->getMessage()->getChat()->getId();
            $this->sendStartMessage($chatId);
        }

        return response()->noContent();
    }

    private function sendStartMessage($chatId)
    {
        TelegramUser::firstOrCreate(['chat_id' => $chatId]);
        $token = config('telegram.bots.mybot.token');
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
