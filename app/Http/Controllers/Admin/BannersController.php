<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\BannerRequest;
use App\Http\Services\UploaderService;
use App\Models\Banner;
use App\Http\Controllers\BaseController;
use App\Models\Vendor;
use App\Repositories\BranchRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Repositories\BannerRepository;
use App\Http\Services\BannerService;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector as RedirectorAlias;
use View;

class BannersController extends BaseController
{

    private $bannerRepository;
    protected $bannerService;
    protected $branchRepository;
    private $uploaderService;


    /**
     * BannersController constructor.
     * @param BannerRepository $bannerRepository
     * @param BannerService $bannerService
     * @param UploaderService $uploaderService
     */
    public function __construct(BannerRepository $bannerRepository, BannerService $bannerService, UploaderService $uploaderService, BranchRepository $branchRepository)
    {
        $this->authorizeResource(Banner::class, "banner");
        $this->branchRepository = $branchRepository;
        $this->uploaderService = $uploaderService;
        $this->bannerService = $bannerService;
        $this->bannerRepository = $bannerRepository;
    }

    public function index()
    {
        $this->authorize("index", Banner::class);
        $list = $this->bannerRepository->search(request())->paginate(10);
        $list->appends(request()->all());
        return View::make('admin.banners.index', ['list' => $list]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $vendors = Vendor::where('active', true)->get();
        return View::make('admin.banners.create', ['vendors' => $vendors]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BannerRequest $request
     * @return Response
     */
    public function store(BannerRequest $request)
    {
        $this->bannerService->fillFromRequest($request);
        return redirect(route('admin.banners.index'))->with('success', trans('item_added_successfully'));
    }

    /**
     * @param Banner $banner
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(banner $banner)
    {
        $vendors = Vendor::where('active', true)->get();
        $branches = [];
        if ($banner->branch) {
            request()->query->set('vendor_id', $banner->branch->vendor_id);
            $branches = $this->branchRepository->search(request())->get();
        }
        return View::make('admin.banners.edit', ['banner' => $banner, 'vendors' => $vendors, 'branches' => $branches]);
    }

    /**
     * @param BannerRequest $request
     * @param Banner $banner
     * @return RedirectResponse|RedirectorAlias
     */
    public function update(BannerRequest $request, banner $banner)
    {
        $this->bannerService->fillFromRequest($request, $banner);

        return redirect(route('admin.banners.index'))->with('success', trans('item_updated_successfully'));
    }

    /**
     * @param Banner $banner
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy(banner $banner)
    {
        $this->uploaderService->deleteFile($banner->image);
        $banner->delete();
        return redirect()->back()->with('success', 'Item Deleted Successfully');
    }
}
