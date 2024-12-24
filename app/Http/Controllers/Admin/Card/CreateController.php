<?php

namespace App\Http\Controllers\Admin\Card;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CreateController extends BaseController
{
    public function __invoke()
    {
        $categories = Category::all();
        return view('admin.card.create', compact('categories'));
    }
}
