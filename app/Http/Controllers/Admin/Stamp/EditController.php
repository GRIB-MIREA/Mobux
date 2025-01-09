<?php

namespace App\Http\Controllers\Admin\Stamp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stamp;

class EditController extends Controller
{
    public function __invoke(Stamp $stamp)
    {
        return view('admin.stamp.edit', compact('stamp'));
    }
}
