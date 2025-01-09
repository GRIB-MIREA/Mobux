<?php

namespace App\Http\Controllers\Admin\Stamp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stamp;
use App\Http\Requests\Admin\Stamp\UpdateRequest;

class UpdateController extends Controller
{
    public function __invoke(UpdateRequest $request, Stamp $stamp)
    {
        $data = $request->validated();
        $stamp->update($data);
        return view('admin.stamp.show', compact('stamp'));
    }
}
