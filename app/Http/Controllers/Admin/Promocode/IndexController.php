<?php

namespace App\Http\Controllers\Admin\Promocode;

use App\Http\Controllers\Controller;
use App\Models\Promocode;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke()
    {
        $promocodes = Promocode::paginate(10);
        return view('admin.promocode.index', compact('promocodes'));
    }
}
