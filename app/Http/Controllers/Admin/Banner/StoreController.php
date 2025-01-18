<?php

namespace App\Http\Controllers\Admin\Banner;

use App\Http\Requests\Admin\Banner\StoreRequest;
use Illuminate\Http\Request;

class StoreController extends BaseController
{
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();
        $this->service->store($data);

        return redirect()->route('admin.banner.index');
    }
}
