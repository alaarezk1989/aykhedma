<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\ActivityRequest;
use App\Http\Services\ActivityService;
use App\Http\Services\UploaderService;
use App\Models\Activity;
use App\Repositories\ActivityRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use View;
use File;

class ActivitiesController extends BaseController
{
    protected $activityService;
    private $activityRepository;
    private $uploaderService;

    public function __construct(ActivityService $activityService, ActivityRepository $activityRepository, UploaderService $uploaderService)
    {
        $this->authorizeResource(Activity::class, "activity");
        $this->activityService = $activityService;
        $this->activityRepository = $activityRepository;
        $this->uploaderService = $uploaderService;
    }

    public function index(Request $request)
    {
        $this->authorize("index", Activity::class);
        $list = $this->activityRepository->searchFromRequest(request());
        $list = $list->paginate(10);
        $list->appends(request()->all());
        return View::make('admin.activities.index', ['list' => $list]);
    }

    public function create()
    {
        return View::make('admin.activities.new');
    }

    public function store(ActivityRequest $request)
    {
        $this->activityService->fillFromRequest($request);
        return redirect(route('admin.activities.index'))->with('success', trans('item_added_successfully'));
    }

    public function destroy(Activity $activity)
    {
        if (count($activity->vendors)) {
            return redirect()->back()->with('danger', trans('cant_delete_this_item_related_with_vendors'));
        }

        $this->uploaderService->deleteFile($activity->image);
        $activity->delete();

        return redirect()->back()->with('success', trans('item_deleted_successfully'));
    }


    public function edit(Activity $activity)
    {
        return View::make('admin.activities.edit', ['activity' => $activity]);
    }

    public function update(ActivityRequest $request, Activity $activity)
    {
        $this->activityService->fillFromRequest($request, $activity);

        return redirect(route('admin.activities.index'))->with('success', trans('item_updated_successfully'));
    }
}
