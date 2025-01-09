<?php

namespace App\Http\Controllers\Admin\Promocode;

use App\Http\Controllers\Controller;
use App\Models\Promocode;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke()
    {
        $promocodes = Promocode::all();
        return view('admin.promocode.index', compact('promocodes'));
    }
}
