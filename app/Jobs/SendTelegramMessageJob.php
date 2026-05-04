<?php

namespace App\Jobs;

use App\Models\TelegramUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Laravel\Facades\Telegram;

class SendTelegramMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public int $backoff = 30;

    public function __construct(
        public int|string $chatId,
        public string $message,
    ) {
    }

    public function handle(): void
    {
        try {
            Telegram::sendMessage([
                'chat_id' => $this->chatId,
                'text' => $this->message,
                'parse_mode' => 'Markdown',
                'disable_web_page_preview' => true,
            ]);
        } catch (TelegramSDKException $exception) {
            if (str_contains($exception->getMessage(), 'bot was blocked by the user')) {
                TelegramUser::where('chat_id', $this->chatId)->delete();
                return;
            }

            Log::error("Error sending Telegram message to {$this->chatId}: " . $exception->getMessage());

            throw $exception;
        }
    }
}
