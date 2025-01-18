<?php

namespace App\Http\Controllers\Admin\Banner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\BannerService;

class BaseController extends Controller
{
    public $service;

    public function __construct(BannerService $service)
    {
        $this->service = $service;
    }
}
