<?php

namespace App\Http\Controllers\Api;

use App\Models\Activity;
use Illuminate\Routing\Controller;

class ActivitiesController extends Controller
{
    public function index()
    {
        $list = Activity::where('active', true)->orderBy('id', 'DESC')->get();
        return response()->json($list);
    }

    public function show(Activity $activity)
    {
        return response()->json($activity);
    }
}
