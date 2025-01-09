<?php

namespace App\Http\Controllers\Admin\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Card;
use App\Models\Category;
use App\Models\Promocode;

class IndexController extends Controller
{
    public function __invoke()
    {
        $data = [];
        $data['cardCount'] = Card::all()->count();
        $data['categoryCount'] = Category::all()->count();
        $data['promocodeCount'] = Promocode::all()->count();
        return view('admin.main.index', compact('data'));
    }
}
