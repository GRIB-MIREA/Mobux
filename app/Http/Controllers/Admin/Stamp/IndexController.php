<?php

namespace App\Http\Controllers\Admin\Stamp;

use App\Http\Controllers\Controller;
use App\Models\Stamp;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke()
    {
        $notifications = auth()->user()->notifications;
        $stamps = Stamp::all();
        return view('admin.stamp.index', compact('stamps', 'notifications'));
    }
}
