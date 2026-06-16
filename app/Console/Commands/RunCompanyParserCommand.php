<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\DataTransferObjects\CompanyParser\CompanySearchRequestData;
use App\Services\CompanyParser\CompanyParserRegistry;
use App\Services\CompanyParser\CompanyParserService;
use Illuminate\Console\Command;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class RunCompanyParserCommand extends Command
{
    protected $signature = 'companies:parse
        {city : Город поиска}
        {category : Категория компаний}
        {--provider=overpass : Провайдер парсинга}
        {--limit=50 : Сколько результатов запросить}
        {--sync : Выполнить сразу, без queue worker}';

    protected $description = 'Запускает Company Parser c выбранным provider и сохраняет результаты в базу.';

    public function handle(CompanyParserService $service, CompanyParserRegistry $registry): int
    {
        $provider = (string) $this->option('provider');
        $availableProviders = array_keys($registry->availableProviders());

        try {
            Validator::validate([
                'provider' => $provider,
                'limit' => $this->option('limit'),
            ], [
                'provider' => ['required', 'string', Rule::in($availableProviders)],
                'limit' => ['required', 'integer', 'min:1', 'max:100'],
            ]);
        } catch (ValidationException $exception) {
            foreach ($exception->errors() as $messages) {
                foreach ($messages as $message) {
                    $this->error($message);
                }
            }

            return self::FAILURE;
        }

        $request = new CompanySearchRequestData(
            city: (string) $this->argument('city'),
            category: (string) $this->argument('category'),
            provider: $provider,
            limit: max(1, (int) $this->option('limit')),
        );

        $run = $service->createRun($request);

        if ((bool) $this->option('sync')) {
            $service->processRun($run);
            $run->refresh();

            $this->info(sprintf(
                'Запуск #%d завершен: provider=%s, найдено %d, новых %d, обновлено %d.',
                $run->id,
                $provider,
                $run->results_count,
                $run->new_companies_count,
                $run->updated_companies_count
            ));

            return self::SUCCESS;
        }

        $service->dispatchRun($run);

        $this->info(sprintf('Запуск #%d поставлен в очередь (provider=%s).', $run->id, $provider));

        return self::SUCCESS;
    }
}
