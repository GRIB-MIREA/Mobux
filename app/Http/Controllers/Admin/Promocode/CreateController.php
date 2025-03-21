<?php

namespace App\Http\Controllers\Admin\Promocode;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Card;

class CreateController extends Controller
{
    public function __invoke(Request $request)
    {
        $notifications = auth()->user()->notifications;
        // $cards = Card::all();

        $query = Card::query();

        // Если есть поисковый запрос
        if ($request->has('search') && $request->input('search') !== '') {
            $search = $request->input('search');

            // Добавьте условие поиска по заголовку
            $query->where('title', 'LIKE', "%{$search}%");
        }

        // Сортировка по заголовку
        $cards = $query->orderBy('title')->get();

        return view('admin.promocode.create', compact('cards', 'notifications'));
    }
}
