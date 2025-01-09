<?php

namespace App\Http\Controllers\Admin\Stamp;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Stamp\StoreRequest;
use App\Models\Stamp;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();
        Stamp::firstOrCreate($data);

        return redirect()->route('admin.stamp.index');
    }
}
