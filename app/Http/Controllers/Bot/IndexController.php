<?php

namespace App\Http\Controllers\Bot;

use Illuminate\Routing\Controller as BaseController;
use App\Models\Card;
use App\Models\Stamp;
use Illuminate\Http\Request;

class IndexController extends BaseController
{
    public function __invoke()
    {
        $cards = Card::orderBy('position', 'asc')->with('stamps')->get();  
        return view('bot.index', compact('cards'));
    }
}
