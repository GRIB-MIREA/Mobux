<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TelegramUser ;
use Telegram\Bot\Laravel\Facades\Telegram;

class SendTelegramMessage extends Command
{
    protected $signature = 'telegram:send {message}';
    protected $description = 'Рассылка сообщений в Telegram';

    public function handle()
    {
        $message = $this->argument('message');

        // Получаем всех пользователей
        $users = TelegramUser::all();

        foreach ($users as $user) {
            Telegram::sendMessage([
                'chat_id' => $user->chat_id,
                'text' => $message
            ]);
        }

        $this->info('Сообщение отправлено всем пользователям.');
    }
}
