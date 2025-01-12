<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TelegramRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $data = $request->all();
        $checkHash = $data['hash'];
        unset($data['hash']);

        // Проверка контрольной суммы
        $secretKey = hash('sha256', env('TELEGRAM_BOT_TOKEN'), true);
        $checkString = collect($data)->map(function ($value, $key) {
            return "$key=$value";
        })->sort()->implode("\n");

        $calculatedHash = hash_hmac('sha256', $checkString, $secretKey);

        if ($calculatedHash !== $checkHash) {
            abort(403, 'Неверная подпись данных.');
        }

        // Проверяем срок действия
        if (time() - $data['auth_date'] > 86400) {
            abort(403, 'Время сессии истекло.');
        }

        // Ищем или создаём пользователя
        $user = User::firstOrCreate(
            ['telegram_id' => $data['id']],
            [
                'name' => $data['first_name'] ?? 'User',
                'username' => $data['username'] ?? null,
                'image' => $data['photo_url'] ?? null,
            ]
        );

        // Логиним пользователя
        Auth::login($user);
        return $next($request);
    }
}
