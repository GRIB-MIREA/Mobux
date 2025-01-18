<?php

namespace App\Http\Controllers\Admin\Banner;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class IndexController extends BaseController
{
    public function __invoke()
    {
        $notifications = auth()->user()->notifications;
        $banners = Banner::paginate(10);
        return view('admin.banner.index', compact('banners', 'notifications'));
    }
}
