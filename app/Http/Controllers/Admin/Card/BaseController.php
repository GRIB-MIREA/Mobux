<?php

namespace App\Http\Controllers\Admin\Card;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Service\CardService;

class BaseController extends Controller
{
    public $service;

    public function __construct(CardService $service)
    {
        $this->service = $service;
    }
}
