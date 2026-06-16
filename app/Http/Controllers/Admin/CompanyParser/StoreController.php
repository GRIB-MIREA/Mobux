<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\CompanyParser;

use App\DataTransferObjects\CompanyParser\CompanySearchRequestData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CompanyParser\StoreRequest;
use App\Services\CompanyParser\CompanyParserService;
use Illuminate\Http\RedirectResponse;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request, CompanyParserService $service): RedirectResponse
    {
        $requestedBy = auth()->id();

        $run = $service->scheduleRun(
            CompanySearchRequestData::fromArray($request->validated()),
            is_numeric($requestedBy) ? (int) $requestedBy : null
        );

        return redirect()
            ->route('admin.company-parser.index')
            ->with('success', sprintf('Запуск #%d создан и отправлен в обработку.', $run->id));
    }
}
