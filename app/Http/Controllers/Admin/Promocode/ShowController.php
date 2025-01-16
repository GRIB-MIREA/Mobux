<?php

namespace App\Http\Controllers\Admin\Promocode;

use App\Http\Controllers\Controller;
use App\Models\Promocode;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    public function __invoke(Promocode $promocode)
    {
        $notifications = auth()->user()->notifications;
        return view('admin.promocode.show', compact('promocode', 'notifications'));
    }
}
