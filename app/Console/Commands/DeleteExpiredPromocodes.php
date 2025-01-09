<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Promocode;

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
    protected $description = 'Удалить истекшие промокоды';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $deleted = Promocode::where('expiration_date', '<', Carbon::now())->delete();
        $this->info("Удалено промокодов: $deleted");
    }
}
