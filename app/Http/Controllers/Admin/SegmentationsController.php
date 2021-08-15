<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\SegmentationRequest;
use App\Http\Services\SegmentationService;
use App\Models\Activity;
use App\Models\Category;
use App\Models\Company;
use App\Models\Segmentation;
use App\Models\Vendor;
use App\Models\Location;
use App\Models\Branch;
use App\Repositories\SegmentationRepository;
use View;

class SegmentationsController extends BaseController
{
    protected $segmentationService;
    protected $segmentationRepository;


    public function __construct(SegmentationService $segmentationService, SegmentationRepository $segmentationRepository)
    {
        $this->authorizeResource(Segmentation::class, "segmentation");
        $this->segmentationService = $segmentationService;
        $this->segmentationRepository = $segmentationRepository;
    }

    public function index()
    {
        $this->authorize("index", Segmentation::class);

        $list = $this->segmentationRepository->search(request())->paginate(10);

        $list->appends(request()->all());

        return View::make('admin.segmentations.index', ['list' => $list]);
    }

    public function create()
    {
        $locations = Location::where('active', 1)->get();
        $categories = Category::where('active', 1)->get();
        $companies = Company::all();

        return View::make('admin.segmentations.new', ['categories' => $categories,'locations' => $locations, 'companies' => $companies]);
    }

    public function store(SegmentationRequest $request)
    {
        $this->segmentationService->fillFromRequest($request);
        return redirect(route('admin.segmentations.index'))->with('success', trans('segmentation_added_successfully'));
    }

    public function destroy(Segmentation $segmentation)
    {
        $segmentation->delete();
        return redirect()->back()->with('success', trans('segmentation_deleted_successfully'));
    }

    public function edit(Segmentation $segmentation)
    {
        $locations = Location::where('active', 1)->get();
        $categories = Category::where('active', 1)->get();
        $companies = Company::all();

        return View::make('admin.segmentations.edit', ['segmentation' => $segmentation, 'categories' => $categories,'locations' => $locations, 'companies' => $companies]);
    }

    public function update(SegmentationRequest $request, Segmentation $segmentation)
    {
        $this->segmentationService->fillFromRequest($request, $segmentation);

        return redirect(route('admin.segmentations.index'))->with('success', trans('segmentation_updated_successfully'));
    }
}
