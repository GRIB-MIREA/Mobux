<?php

namespace App\Http\Controllers\Admin\Stamp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stamp;
use App\Http\Requests\Admin\Stamp\UpdateRequest;

class DeleteController extends Controller
{
    public function __invoke(Stamp $stamp)
    {
        $stamp->delete();
        return redirect()->route('admin.stamp.index')->with('success', 'Пометка успешно удалена.');
    }
}
