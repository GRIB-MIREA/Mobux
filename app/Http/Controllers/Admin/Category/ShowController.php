<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    public function __invoke(Category $category)
    {
        $notifications = auth()->user()->notifications;
        return view('admin.category.show', compact('category', 'notifications'));
    }
}
