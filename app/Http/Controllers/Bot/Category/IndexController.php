<?php

namespace App\Http\Controllers\Bot\Category;

use Illuminate\Routing\Controller as BaseController;
use App\Models\Category;
use Illuminate\Http\Request;

class IndexController extends BaseController
{
    public function __invoke($id)
    {
        $category = Category::findOrFail($id);
        $cards = $category->cards; 
        return view('bot.category.index', compact('cards', 'category'));
    }
}
