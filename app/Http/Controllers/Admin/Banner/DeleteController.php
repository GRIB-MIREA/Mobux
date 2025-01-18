<?php

namespace App\Http\Controllers\Admin\Banner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Http\Requests\Admin\Banner\UpdateRequest;

class DeleteController extends BaseController
{
    public function __invoke(Banner $banner)
    {
        $banner->delete();
        return redirect()->route('admin.banner.index');
    }
}
