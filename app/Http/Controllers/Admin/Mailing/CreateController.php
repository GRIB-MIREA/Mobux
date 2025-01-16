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
        $cleanedMessage = $this->convertToTelegramFormat($message);

        // Запускаем команду Artisan
        Artisan::call('telegram:send', ['message' => $cleanedMessage, 'parse_mode' => 'Markdown']);

        // Сохраняем информацию об истории рассылки
        MailingHistory::create([
            'message' => $cleanedMessage,
            'recipients_count' => $recipientsCount,
        ]);

        return redirect()->route('admin.mail.index')->with('success', 'Сообщение отправлено всем пользователям!');
    }

    private function convertToTelegramFormat($text) {
        // Заменяем <strong> и <b> на * (жирный текст)
        $text = preg_replace('/<(strong|b)>(.*?)<\/(strong|b)>/is', '*\$2*', $text);
        // Заменяем <em> на _ (курсивный текст)
        $text = preg_replace('/<em>(.*?)<\/em>/is', '_\$1_', $text);
        // Заменяем <u> на __ (подчеркнутый текст)
        $text = preg_replace('/<u>(.*?)<\/u>/is', '__\$1__', $text);
        // Заменяем <br> на перенос строки
        $text = preg_replace('/<br\s*\/?>/is', "\n", $text);
        // Удаляем все остальные HTML-теги
        $text = strip_tags($text);
    
        // Возвращаем очищенный и отформатированный текст
        return $text;
    }
}
