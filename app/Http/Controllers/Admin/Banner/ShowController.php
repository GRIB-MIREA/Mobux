<?php

namespace App\Http\Controllers\Admin\Banner;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class ShowController extends BaseController
{
    public function __invoke(Banner $banner)
    {
        $notifications = auth()->user()->notifications;
        return view('admin.banner.show', compact('banner', 'notifications'));
    }
}
