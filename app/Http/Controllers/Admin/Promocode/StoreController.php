<?php

namespace App\Http\Controllers\Admin\Promocode;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Promocode\StoreRequest;
use App\Models\Promocode;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();
        Promocode::firstOrCreate($data);

        return redirect()->route('admin.promocode.index')->with('success', 'Промокод успешно создан.');
    }
}
