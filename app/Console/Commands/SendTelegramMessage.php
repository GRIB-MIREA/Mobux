<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TelegramUser ;
use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Support\Facades\Log;

class SendTelegramMessage extends Command
{
    protected $signature = 'telegram:send {message}';
    protected $description = 'Рассылка сообщений в Telegram';

    public function handle()
    {
        $message = $this->argument('message');

        $users = TelegramUser::all();

        foreach ($users as $user) {
            try {
                Telegram::sendMessage([
                    'chat_id' => $user->chat_id,
                    'text' => $message
                ]);
            } catch (\Telegram\Bot\Exceptions\TelegramSDKException $e) {
                if ($e->getMessage() === 'Forbidden: bot was blocked by the user') {
                    // Здесь вы можете записать информацию о заблокированных пользователях в лог или удалить их из базы данных
                    Log::info("User  with chat_id {$user->chat_id} has blocked the bot.");
                    $user->delete();
                } else {
                    // Обработка других исключений, если это необходимо
                    Log::error("Error sending message to user {$user->chat_id}: " . $e->getMessage());
                }
            }
        }

        $this->info('Сообщение отправлено всем пользователям.');
    }
}
