<?php

namespace App\Http\Controllers\Bot;

use Illuminate\Routing\Controller as BaseController;

class IndexController extends BaseController
{
    public function __invoke()
    {   
        return view('bot.index');
    }
}
