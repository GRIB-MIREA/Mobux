<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Service\EnvSettingsService;
use Illuminate\Http\Request;
use RuntimeException;

class UpdateController extends Controller
{
    public function __invoke(Request $request, EnvSettingsService $settingsService)
    {
        $validated = $request->validate($settingsService->validationRules());

        try {
            $settingsService->update($validated);
        } catch (RuntimeException $exception) {
            return back()
                ->withInput()
                ->withErrors(['settings' => $exception->getMessage()]);
        }

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Настройки сохранены. Кеш конфигурации очищен.');
    }
}
