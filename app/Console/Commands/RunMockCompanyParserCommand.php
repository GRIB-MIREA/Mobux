<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\DataTransferObjects\CompanyParser\CompanySearchRequestData;
use App\Services\CompanyParser\CompanyParserService;
use Illuminate\Console\Command;

class RunMockCompanyParserCommand extends Command
{
    protected $signature = 'companies:parse-mock
        {city : Город поиска}
        {category : Категория компаний}
        {--limit=20 : Сколько результатов сгенерировать}
        {--sync : Выполнить сразу, без queue worker}';

    protected $description = 'Запускает mock-парсер компаний и сохраняет результаты в базу.';

    public function handle(CompanyParserService $service): int
    {
        $request = new CompanySearchRequestData(
            city: (string) $this->argument('city'),
            category: (string) $this->argument('category'),
            provider: 'mock',
            limit: max(1, (int) $this->option('limit')),
        );

        $run = $service->createRun($request);

        if ((bool) $this->option('sync')) {
            $service->processRun($run);
            $run->refresh();

            $this->info(sprintf(
                'Mock-запуск #%d завершен: найдено %d, новых %d, обновлено %d.',
                $run->id,
                $run->results_count,
                $run->new_companies_count,
                $run->updated_companies_count
            ));

            return self::SUCCESS;
        }

        $service->dispatchRun($run);

        $this->info(sprintf('Mock-запуск #%d поставлен в очередь.', $run->id));

        return self::SUCCESS;
    }
}
