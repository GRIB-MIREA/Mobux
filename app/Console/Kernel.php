<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Promocode;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('promocodes:delete-expired')->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        $this->command('promocodes:delete-expired', function () {
            // Логика команды для удаления истекших промокодов
            // Например, вызов модели для удаления промокодов
            // Пример:
            Promocode::where('expiration_date', '<', now())->delete();
            
            $this->info('Истекшие промокоды успешно удалены!');
        })->describe('Удалить истекшие промокоды');

        require base_path('routes/console.php');
    }
}
