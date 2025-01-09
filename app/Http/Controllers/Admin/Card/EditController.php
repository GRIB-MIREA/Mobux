<?php

namespace App\Http\Controllers\Admin\Card;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Card;
use App\Models\Category;
use App\Models\Stamp;

class EditController extends BaseController
{
    public function __invoke(Card $card)
    {
        $categories = Category::all();
        $stamps = Stamp::all();
        $selectedStampIds = $card->stamps->pluck('id')->toArray();
        return view('admin.card.edit', compact('card', 'categories', 'stamps', 'selectedStampIds'));
    }
}
