<?php

namespace App\Http\Controllers\Admin\Card;

use App\Http\Controllers\Controller;
use Symfony\Component\Process\Process;
use Throwable;

class ImportPerfluenceController extends Controller
{
    public function __invoke()
    {
        try {
            $process = new Process([
                (string) config('app.artisan_php_binary', 'php'),
                base_path('artisan'),
                'perfluence:import',
                '--no-ansi',
            ], base_path(), null, null, 300);

            $process->run();
            $output = trim($process->getOutput()."\n".$process->getErrorOutput());
        } catch (Throwable $exception) {
            report($exception);

            return redirect()
                ->route('admin.card.index')
                ->with('error', 'Не удалось запустить импорт Perfluence: '.$exception->getMessage());
        }

        if (!$process->isSuccessful()) {
            $message = $output ?: 'Импорт Perfluence завершился с ошибкой.';

            if (str_contains($message, 'Class "DOMDocument" not found')) {
                $message .= ' Проверьте, что расширение php-xml включено для CLI PHP, либо укажите корректный CLI бинарник в ARTISAN_PHP_BINARY.';
            }

            return redirect()
                ->route('admin.card.index')
                ->with('error', $message);
        }

        return redirect()
            ->route('admin.card.index')
            ->with('success', $output ?: 'Импорт Perfluence успешно завершен.');
    }
}
