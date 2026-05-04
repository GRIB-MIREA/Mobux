<?php

namespace App\Http\Controllers\Admin\Mailing;

use App\Http\Controllers\Controller;
use App\Jobs\SendTelegramMessageJob;
use App\Models\MailingHistory;
use App\Models\TelegramUser;
use Illuminate\Http\Request;

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
            'message' => 'required|string|max:4096',
            'test' => 'nullable|boolean',
        ]);

        $message = $this->formatTelegramMessage($request->input('message'));
        if ($message === '') {
            return back()
                ->withInput()
                ->withErrors(['message' => 'Message cannot be empty after formatting.']);
        }

        if ($request->boolean('test')) {
            $testChatId = config('services.telegram_mailing.test_chat_id');
            if (!$testChatId) {
                return back()
                    ->withInput()
                    ->withErrors(['test' => 'TELEGRAM_TEST_CHAT_ID is not configured.']);
            }

            SendTelegramMessageJob::dispatch($testChatId, $message)->onQueue('telegram-mailing');

            MailingHistory::create([
                'message' => $message,
                'recipients_count' => 1,
            ]);

            return redirect()
                ->route('admin.mail.index')
                ->with('success', 'Тестовое сообщение поставлено в очередь.');
        }

        $recipientsCount = TelegramUser::query()->count();
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

        MailingHistory::create([
            'message' => $message,
            'recipients_count' => $recipientsCount,
        ]);

        return redirect()
            ->route('admin.mail.index')
            ->with('success', "Рассылка поставлена в очередь для {$recipientsCount} получателей.");
    }

    private function formatTelegramMessage(string $message): string
    {
        $message = html_entity_decode($message, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $message = preg_replace('/<br\s*\/?>/i', "\n", $message);
        $message = preg_replace('/<\/(p|div|h[1-6])>/i', "\n\n", $message);
        $message = preg_replace('/<li[^>]*>/i', "- ", $message);
        $message = preg_replace('/<\/li>/i', "\n", $message);
        $message = preg_replace('/<(strong|b)[^>]*>(.*?)<\/\1>/is', '*$2*', $message);
        $message = preg_replace('/<(em|i)[^>]*>(.*?)<\/\1>/is', '_$2_', $message);
        $message = preg_replace('/<a[^>]+href=["\']([^"\']+)["\'][^>]*>(.*?)<\/a>/is', '[$2]($1)', $message);
        $message = strip_tags($message);
        $message = preg_replace("/[ \t]+\n/", "\n", $message);
        $message = preg_replace("/\n{3,}/", "\n\n", $message);

        return trim($message);
    }
}
