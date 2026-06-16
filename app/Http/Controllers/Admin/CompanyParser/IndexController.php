<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\CompanyParser;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanyParserRun;
use App\Services\CompanyParser\CompanyParserRegistry;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(Request $request, CompanyParserRegistry $registry): View
    {
        $notifications = auth()->user()->notifications;
        $providers = $registry->availableProviders();

        $companySearch = trim((string) $request->input('company_search'));
        $cityFilter = trim((string) $request->input('city_filter'));
        $categoryFilter = trim((string) $request->input('category_filter'));
        $providerFilter = trim((string) $request->input('provider_filter'));
        $withoutWebsite = $request->has('without_website') ? $request->boolean('without_website') : true;

        $runs = CompanyParserRun::query()
            ->with('user')
            ->latest('id')
            ->paginate(10, ['*'], 'runs_page');

        $companiesQuery = Company::query()
            ->with('lastParserRun')
            ->latest('updated_at');

        if ($withoutWebsite) {
            $companiesQuery->withoutWebsite();
        }

        if ($companySearch !== '') {
            $companiesQuery->where('name', 'like', '%'.$companySearch.'%');
        }

        if ($cityFilter !== '') {
            $companiesQuery->where('city', 'like', '%'.$cityFilter.'%');
        }

        if ($categoryFilter !== '') {
            $companiesQuery->where('category', 'like', '%'.$categoryFilter.'%');
        }

        if ($providerFilter !== '') {
            $companiesQuery->where('provider', $providerFilter);
        }

        $companies = $companiesQuery
            ->paginate(15, ['*'], 'companies_page')
            ->appends([
                'company_search' => $companySearch,
                'city_filter' => $cityFilter,
                'category_filter' => $categoryFilter,
                'provider_filter' => $providerFilter,
                'without_website' => $withoutWebsite ? '1' : '0',
            ]);

        $stats = [
            'total_companies' => Company::query()->count(),
            'without_website' => Company::query()->withoutWebsite()->count(),
            'completed_runs' => CompanyParserRun::query()
                ->where('status', CompanyParserRun::STATUS_COMPLETED)
                ->count(),
        ];

        return view('admin.company-parser.index', compact(
            'notifications',
            'providers',
            'runs',
            'companies',
            'stats',
            'withoutWebsite'
        ));
    }
}
