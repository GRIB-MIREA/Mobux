<?php

namespace App\Http\Controllers\Admin\Card;

use App\Http\Requests\Admin\Card\StoreRequest;
use Illuminate\Http\Request;

class StoreController extends BaseController
{
    public function __invoke(StoreRequest $request)
    {
        $this->service->store($request);

        return redirect()->route('admin.card.index')->with('success', 'Карточка успешно создана.');
    }
}
