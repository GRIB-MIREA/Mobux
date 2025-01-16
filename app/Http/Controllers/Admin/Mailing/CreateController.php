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
            'message' => 'required|text',
        ]);

        $recipients = TelegramUser::all();
        $recipientsCount = $recipients->count();

        $message = $request->input('message');

        // Запускаем команду Artisan
        Artisan::call('telegram:send', ['message' => $message]);

        // Сохраняем информацию об истории рассылки
        MailingHistory::create([
            'message' => $message,
            'recipients_count' => $recipientsCount,
        ]);

        return redirect()->route('admin.mail.index')->with('success', 'Сообщение отправлено всем пользователям!');
    }
}
