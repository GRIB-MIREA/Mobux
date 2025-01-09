<?php

namespace App\Http\Controllers\Bot\Card;

use Illuminate\Routing\Controller as BaseController;
use App\Models\Card;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ShowController extends BaseController
{
    public function __invoke(Card $card)
    {
        // $promocode = $card->promocodes()->first();
        // $date = Carbon::parse($promocode->expiration_date); 
        return view('bot.card.show', compact('card'));
    }
}
