<?php

namespace App\Http\Controllers\Admin\Card;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Throwable;

class ImportPerfluenceController extends Controller
{
    public function __invoke()
    {
        try {
            $exitCode = Artisan::call('perfluence:import', ['--no-ansi' => true]);
            $output = trim(Artisan::output());
        } catch (Throwable $exception) {
            report($exception);

            return redirect()
                ->route('admin.card.index')
                ->with('error', 'Не удалось запустить импорт Perfluence: ' . $exception->getMessage());
        }

        if ($exitCode !== 0) {
            return redirect()
                ->route('admin.card.index')
                ->with('error', $output ?: 'Импорт Perfluence завершился с ошибкой.');
        }

        return redirect()
            ->route('admin.card.index')
            ->with('success', $output ?: 'Импорт Perfluence успешно завершен.');
    }
}
