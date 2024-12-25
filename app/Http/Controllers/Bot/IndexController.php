<?php

namespace App\Http\Controllers\Bot;

use Illuminate\Routing\Controller as BaseController;
use App\Models\Card;
use App\Models\Category;

class IndexController extends BaseController
{
    public function __invoke()
    {
        $cards = Card::orderBy('position', 'asc')->get();  
        return view('bot.index', compact('cards'));
    }
}
