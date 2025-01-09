<?php

namespace App\Http\Controllers\Admin\Promocode;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Promocode;

class EditController extends Controller
{
    public function __invoke(Promocode $promocode)
    {
        return view('admin.promocode.edit', compact('promocode'));
    }
}
