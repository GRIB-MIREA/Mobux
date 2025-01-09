<?php

namespace App\Http\Controllers\Admin\Promocode;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Promocode;
use App\Http\Requests\Admin\Promocode\UpdateRequest;

class UpdateController extends Controller
{
    public function __invoke(UpdateRequest $request, Promocode $promocode)
    {
        $data = $request->validated();
        $promocode->update($data);
        return view('admin.promocode.show', compact('promocode'));
    }
}
