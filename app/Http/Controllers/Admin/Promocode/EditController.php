<?php

namespace App\Http\Controllers\Admin\Promocode;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Promocode;
use App\Models\Card;

class EditController extends Controller
{
    public function __invoke(Promocode $promocode)
    {
        $notifications = auth()->user()->notifications;
        $cards = Card::all();
        return view('admin.promocode.edit', compact('promocode', 'cards', 'notifications'));
    }
}
