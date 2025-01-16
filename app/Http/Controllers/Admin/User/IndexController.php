<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke()
    {
        $notifications = auth()->user()->notifications;
        $users = User::all();
        return view('admin.user.index', compact('users', 'notifications'));
    }
}
