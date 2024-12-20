<?php

namespace App\Telegram\Bot;

class Message extends Bot
{
    protected $data;
    protected $method;

    public function message(mixed $chat_id, $text, $reply_id = null) {
        $this->method = 'sendMessage';
        $this->data = [
            'chat_id' => $chat_id,
            'text' => $text,
            'parse_mode' => 'html'
        ];
        return $this;
    }
}