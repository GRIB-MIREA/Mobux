<?php

namespace App\Http\Controllers\Admin\Promocode;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Promocode;
use App\Http\Requests\Admin\Promocode\UpdateRequest;

class DeleteController extends Controller
{
    public function __invoke(Promocode $promocode)
    {
        $promocode->delete();
        return redirect()->route('admin.promocode.index')->with('success', 'Промокод успешно удален.');
    }
}
