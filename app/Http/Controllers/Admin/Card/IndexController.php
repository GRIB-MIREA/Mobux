<?php

namespace App\Http\Controllers\Admin\Card;

use App\Http\Controllers\Controller;
use App\Models\Card;
use Illuminate\Http\Request;

class IndexController extends BaseController
{
    public function __invoke()
    {
        $notifications = auth()->user()->notifications;
        $cards = Card::orderBy('position', 'asc')->paginate(10);
        return view('admin.card.index', compact('cards', 'notifications'));
    }
}
