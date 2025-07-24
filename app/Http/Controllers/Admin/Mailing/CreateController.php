<?php

namespace App\Http\Controllers\Admin\Mailing;

use App\Http\Controllers\Controller;
use App\Models\MailingHistory;
use App\Models\TelegramUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class CreateController extends Controller
{
    public function __invoke()
    {
        $notifications = auth()->user()->notifications;
        return view('admin.mail.create', compact('notifications'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:5000',
            'test' => 'nullable|boolean',
        ]);

        $message = $request->input('message');
        $cleanedMessage = strip_tags($message);

        if ($request->input('test')) {
            // Укажите Telegram ID администратора для тестовой рассылки
            $adminTelegramId = '299814741'; // Замените на реальный ID администратора
    
            // Отправляем сообщение только администратору
            Artisan::call('telegram:send', [
                'message' => $cleanedMessage,
                'chat_id' => $adminTelegramId, // Передаем ID администратора в команду
            ]);
    
            // Сохраняем информацию об истории рассылки только для теста
            MailingHistory::create([
                'message' => $cleanedMessage,
                'recipients_count' => 1, // Один получатель
            ]);
    
            return redirect()->route('admin.mail.index')->with('success', 'Тестовое сообщение отправлено администратору!');
        }

        $recipients = TelegramUser::all();
        $recipientsCount = $recipients->count();


        // Запускаем команду Artisan
        Artisan::call('telegram:send', ['message' => $cleanedMessage]);

        // Сохраняем информацию об истории рассылки
        MailingHistory::create([
            'message' => $cleanedMessage,
            'recipients_count' => $recipientsCount,
        ]);

        return redirect()->route('admin.mail.index')->with('success', 'Сообщение отправлено всем пользователям!');
    }
}
