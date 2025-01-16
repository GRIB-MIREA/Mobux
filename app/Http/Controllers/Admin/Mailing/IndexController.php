<?php

namespace App\Http\Controllers\Admin\Mailing;

use App\Http\Controllers\Controller;
use App\Models\MailingHistory;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke()
    {
        $notifications = auth()->user()->notifications;
        $mailing_histories = MailingHistory::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.mail.index', compact('mailing_histories', 'notifications'));
    }
}
