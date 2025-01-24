<?php

namespace App\Http\Controllers\Admin\Promocode;

use App\Http\Controllers\Controller;
use App\Models\Promocode;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $notifications = auth()->user()->notifications;

        $search = $request->input('search');
        $query = Promocode::query();

        if ($search) {
            $query->where('title', 'LIKE', "%{$search}%");
        }

        $promocodes = $query->paginate(10);
        return view('admin.promocode.index', compact('promocodes', 'search', 'notifications'));
    }
}
