<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class WebhookController extends Controller
{
    public function index(Request $request)
    {
        Cache::forever('webhook-data', $request->all());
        return true;
    }
}
