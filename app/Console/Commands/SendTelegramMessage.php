<?php

namespace App\Console\Commands;

use App\Jobs\SendTelegramMessageJob;
use App\Models\TelegramUser;
use Illuminate\Console\Command;

class SendTelegramMessage extends Command
{
    protected $signature = 'telegram:send {message} {chat_id?}';

    protected $description = 'Queue Telegram messages';

    public function handle()
    {
        $message = $this->argument('message');
        $chatId = $this->argument('chat_id');

        if ($chatId) {
            SendTelegramMessageJob::dispatch($chatId, $message)->onQueue('telegram-mailing');
            $this->info('Telegram message job queued.');

            return self::SUCCESS;
        }

        $delaySeconds = max(0, (int) config('services.telegram_mailing.delay_seconds', 1));
        $delayIndex = 0;

        TelegramUser::query()
            ->select(['id', 'chat_id'])
            ->orderBy('id')
            ->cursor()
            ->each(function (TelegramUser $user) use ($message, $delaySeconds, &$delayIndex) {
                SendTelegramMessageJob::dispatch($user->chat_id, $message)
                    ->onQueue('telegram-mailing')
                    ->delay(now()->addSeconds($delaySeconds * $delayIndex));

                $delayIndex++;
            });

        $this->info('Telegram message jobs queued.');

        return self::SUCCESS;
    }
}
