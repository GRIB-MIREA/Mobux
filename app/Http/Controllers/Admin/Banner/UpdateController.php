<?php

namespace App\Http\Controllers\Admin\Banner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Http\Requests\Admin\Banner\UpdateRequest;

class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $request, Banner $banner)
    {
        $data = $request->validated();
        $card = $this->service->update($data, $banner);
        
        return view('admin.banner.show', compact('banner'));
    }
}
