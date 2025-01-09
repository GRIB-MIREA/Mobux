<?php

namespace App\Http\Controllers\Bot;

use Illuminate\Routing\Controller as BaseController;
use App\Models\Card;
use App\Models\Stamp;
use Illuminate\Http\Request;

class AboutController extends BaseController
{
    public function __invoke()
    {  
        return view('bot.about');
    }
}
