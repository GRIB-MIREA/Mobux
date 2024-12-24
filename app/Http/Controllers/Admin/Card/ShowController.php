<?php

namespace App\Http\Controllers\Admin\Card;

use App\Http\Controllers\Controller;
use App\Models\Card;
use Illuminate\Http\Request;

class ShowController extends BaseController
{
    public function __invoke(Card $card)
    {
        return view('admin.card.show', compact('card'));
    }
}
