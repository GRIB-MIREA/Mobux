<?php

namespace App\Http\Controllers\Bot;

use Illuminate\Routing\Controller as BaseController;
use App\Models\Category;

class CategoryController extends BaseController
{
    public function __invoke()
    {
        $categories = Category::orderBy('position', 'asc')->get();  
        return view('bot.categories', compact('categories'));
    }
}
