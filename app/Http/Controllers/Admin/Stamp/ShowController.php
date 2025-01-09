<?php

namespace App\Http\Controllers\Admin\Stamp;

use App\Http\Controllers\Controller;
use App\Models\Stamp;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    public function __invoke(Stamp $stamp)
    {
        return view('admin.stamp.show', compact('stamp'));
    }
}
