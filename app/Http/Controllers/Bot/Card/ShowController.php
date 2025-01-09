<?php

namespace App\Http\Controllers\Bot\Card;

use Illuminate\Routing\Controller as BaseController;
use App\Models\Card;
use Illuminate\Http\Request;

class ShowController extends BaseController
{
    public function __invoke(Card $card)
    { 
        return view('bot.card.show', compact('card'));
    }
}
