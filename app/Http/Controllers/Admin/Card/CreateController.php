<?php

namespace App\Http\Controllers\Admin\Card;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Stamp;

class CreateController extends BaseController
{
    public function __invoke()
    {
        $notifications = auth()->user()->notifications;
        $categories = Category::all();
        $stamps = Stamp::all();
        return view('admin.card.create', compact('categories', 'stamps', 'notifications'));
    }
}
