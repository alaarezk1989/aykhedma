<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\BaseController;
use View;

class HomeController extends BaseController
{
    public function index()
    {
        return View::make('web.home.index');
    }
}
