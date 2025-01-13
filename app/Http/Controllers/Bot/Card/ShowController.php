<?php

namespace App\Http\Controllers\Bot\Card;

use Illuminate\Routing\Controller as BaseController;
use App\Models\Card;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ShowController extends BaseController
{
    public function __invoke($id)
    {
        $card = Card::findOrFail($id);

        $promocodeCount = $card->promocodes()->count();
        $currentDate = Carbon::now();
        $titleDate = $currentDate->translatedFormat('F Y'); 
        return view('bot.card.show', compact('card', 'titleDate', 'promocodeCount'));
    }
}
