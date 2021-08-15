<?php

namespace App\Http\Controllers\Api;

use App\Models\Setting;
use Illuminate\Routing\Controller;

class SettingsController extends Controller
{
    public function index()
    {
        $list = Setting::query()
                ->orderBy('id', 'ASC')
                ->get();

        return response()->json(["status" =>true, "result" => $list]);
    }
}
