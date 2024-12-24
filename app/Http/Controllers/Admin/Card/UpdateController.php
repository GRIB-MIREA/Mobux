<?php

namespace App\Http\Controllers\Admin\Card;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Card;
use App\Http\Requests\Admin\Card\UpdateRequest;
use Illuminate\Support\Facades\Storage;

class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $request, Card $card)
    {
        $data = $request->validated();
        $card = $this->service->update($data, $card);
        
        return view('admin.card.show', compact('card'));
    }
}
