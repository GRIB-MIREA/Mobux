<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\User;

class CreateController extends Controller
{
    public function __invoke()
    {
        $notifications = auth()->user()->notifications;
        $roles = User::getRoles();
        return view('admin.user.create', compact('roles', 'notifications'));
    }
}
