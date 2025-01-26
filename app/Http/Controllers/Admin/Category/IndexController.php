<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $notifications = auth()->user()->notifications;

        $search = $request->input('search');
        $query = Category::query();

        if ($search) {
            $query->where('title', 'LIKE', "%{$search}%");
        }

        $categories = $query->orderBy('position', 'asc')->paginate(10);
        return view('admin.category.index', compact('categories', 'notifications', 'search'));
    }
}
