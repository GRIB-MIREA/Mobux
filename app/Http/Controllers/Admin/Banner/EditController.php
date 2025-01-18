<?php

namespace App\Http\Controllers\Admin\Banner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;

class EditController extends BaseController
{
    public function __invoke(Banner $banner)
    {
        $notifications = auth()->user()->notifications;
        return view('admin.banner.edit', compact('banner', 'notifications'));
    }
}
