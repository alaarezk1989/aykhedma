<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\BaseController;
use Illuminate\Routing\Controller;
use View;

class HomeController extends BaseController
{
    public function index()
    {
        return View::make('vendor.home.index');
    }
}
