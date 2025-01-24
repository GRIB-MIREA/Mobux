<?php

namespace App\Http\Controllers\Admin\Card;

use App\Http\Controllers\Controller;
use App\Models\Card;
use Illuminate\Http\Request;

class IndexController extends BaseController
{
    public function __invoke(Request $request)
    {
        $notifications = auth()->user()->notifications;

        $sortBy = $request->input('sort_by', 'position');
        $sortDirection = $request->input('sort_direction', 'asc');
        $search = $request->input('search');
        
        $query = Card::withCount('promocodes');

        // Если сортируем по полю position, добавляем соответствующую сортировку
        if ($sortBy === 'position') {
            $query->orderBy('position', $sortDirection);
        } else {
            // В противном случае сортируем по количеству промокодов
            $query->orderBy('promocodes_count', $sortDirection);
        }

        // Если есть значение для поиска, добавляем условие
        if ($search) {
            $query->where('title', 'LIKE', "%{$search}%"); // Поиск по полю title
        }
    
        // Получаем результаты с пагинацией
        $cards = $query->paginate(10);

        return view('admin.card.index', compact('cards', 'sortBy', 'sortDirection', 'search', 'notifications'));
    }
}
