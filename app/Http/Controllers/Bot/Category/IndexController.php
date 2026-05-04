<?php

namespace App\Http\Controllers\Bot\Category;

use Illuminate\Routing\Controller as BaseController;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IndexController extends BaseController
{
    public function __invoke($id)
    {
        $category = Category::findOrFail($id);
        $cards = $category->cards()
            ->withPromocodes()
            ->orderBy('position', 'asc')
            ->with(['category', 'stamps'])
            ->get();

        $cardsCount = $category->cards()->withPromocodes()->count();
        $currentDate = Carbon::now();
        $titleDate = $currentDate->translatedFormat('F Y');  
        return view('bot.category.index', compact('cards', 'category', 'titleDate', 'cardsCount'));
    }
}
