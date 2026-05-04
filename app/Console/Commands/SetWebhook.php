<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SetWebhook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:setwebhook';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $token = config('telegram.bots.mybot.token');
        $payload = [
            'url' => config('telegram.bots.mybot.webhook_url'),
        ];

        if (config('telegram.bots.mybot.webhook_secret')) {
            $payload['secret_token'] = config('telegram.bots.mybot.webhook_secret');
        }

        Http::post("https://api.telegram.org/bot{$token}/setWebhook", $payload)->json();
    }
}
