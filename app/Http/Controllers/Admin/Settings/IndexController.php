<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Service\EnvSettingsService;

class IndexController extends Controller
{
    public function __invoke(EnvSettingsService $settingsService)
    {
        $notifications = auth()->user()->notifications;
        $groups = $settingsService->groups();
        $values = $settingsService->currentValues();

        return view('admin.settings.index', compact('groups', 'values', 'notifications'));
    }
}
