<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Support\Facades\Http;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            $text = (string)view('bot.error', ['error' => $e]);
            // $token = env('TELEGRAM_BOT_TOKEN');
            Http::post('https://api.telegram.org/bot7770123301:AAH_3y0slyu2-BSVEjJ2ruBFivIf5cbRLfQ/sendMessage', [
                'chat_id' => 299814741,
                'text' => $text,
                'parse_mode' => 'html'
            ])->json();
        });    
    }
}
