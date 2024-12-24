<?php

namespace App\Http\Controllers\Admin\Card;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Card;
use App\Http\Requests\Admin\Card\UpdateRequest;

class DeleteController extends BaseController
{
    public function __invoke(Card $card)
    {
        $card->delete();
        return redirect()->route('admin.card.index');
    }
}
