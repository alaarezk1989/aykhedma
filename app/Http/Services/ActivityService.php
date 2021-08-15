<?php

namespace App\Http\Services;

use App\Models\Activity;
use Symfony\Component\HttpFoundation\Request;
use File;

class ActivityService
{
    protected $uploaderService;

    public function __construct(UploaderService $uploaderService)
    {
        $this->uploaderService = $uploaderService;
    }

    public function fillFromRequest(\Illuminate\Http\Request $request, $activity = null)
    {
        if (!$activity) {
            $activity = new Activity();
        }

        if (!empty($request->file('image'))) {
            $activity->image = $this->uploaderService->upload($request->file('image'), 'activities_image');
        }

        $activity->fill($request->request->all());
        $activity->active = $request->request->get('active', 0);

        $activity->save();

        return $activity;
    }
}
