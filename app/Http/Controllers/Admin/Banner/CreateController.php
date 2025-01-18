<?php

namespace App\Http\Controllers\Admin\Banner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CreateController extends BaseController
{
    public function __invoke()
    {
        $notifications = auth()->user()->notifications;
        return view('admin.banner.create', compact('notifications'));
    }
}
