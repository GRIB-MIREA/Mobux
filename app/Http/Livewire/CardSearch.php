<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Card;
use App\Models\Category;

class CardSearch extends Component
{
    public $search = '';

    public function render()
    {
        $cards = Card::withPromocodes()
            ->where('title', 'like', '%' . $this->search . '%')
            ->with(['category', 'stamps'])
            ->get();

        $categories = Category::where('title', 'like', '%' . $this->search . '%')
                // ->orWhere('category_id', 'like', '%' . $this->search . '%')
                   ->get();

        return view('livewire.card-search', [
            'cards' => $cards,
            'categories' => $categories,
        ]);
    }
}
