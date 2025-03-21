<?php

namespace App\Http\Controllers\Admin\Promocode;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Card;

class CreateController extends Controller
{
    public function __invoke(Request $request)
    {
        $notifications = auth()->user()->notifications;

        $query = Card::query();
        $cards = $query->orderBy('title')->get();

        return view('admin.promocode.create', compact('cards', 'notifications'));
    }
}
