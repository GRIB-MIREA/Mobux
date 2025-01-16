<?php

namespace App\Console\Commands;

use App\Events\NotificationCreated;
use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Promocode;
use App\Models\User;
use App\Notifications\ExpiredPromocodesDeleted;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class DeleteExpiredPromocodes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'promocodes:delete-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Удаляет все истекшие промокоды';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::info('DeleteExpiredPromocodes command started.');
        $deletedPromocodes = Promocode::with('card')->where('expiration_date', '<', Carbon::now())->delete();

        foreach ($deletedPromocodes as $promocode) {
            $promocode->delete();
        }

        event(new NotificationCreated($deletedPromocodes));
        Log::info('Expired promocodes deleted event triggered', $deletedPromocodes->toArray());

        $this->info("Истекшие промокоды были удалены.");
    }
}
