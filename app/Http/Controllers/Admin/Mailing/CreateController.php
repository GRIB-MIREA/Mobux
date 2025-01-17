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
        ]);

        $recipients = TelegramUser::all();
        $recipientsCount = $recipients->count();

        $message = $request->input('message');
        $cleanedMessage = strip_tags($message);

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
