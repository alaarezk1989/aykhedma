<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Segmentation;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Vendor;
use App\Models\Branch;
use App\Models\Activity;
use App\Constants\PromotionTypes;
use App\Http\Requests\Admin\CouponRequest;
use App\Http\Services\CouponService;
use App\Repositories\CouponRepository;

class CouponsController extends BaseController
{
    protected $couponService;
    protected $couponRepository;

    public function __construct(CouponService $couponService, CouponRepository $couponRepository)
    {
        $this->couponService = $couponService;
        $this->couponRepository = $couponRepository;
        $this->authorizeResource(Coupon::class, "coupon");
    }


    public function index(Request $request)
    {
        $this->authorize("index", Coupon::class);
        $coupons = $this->couponRepository->searchFromRequest(request())->paginate(10);
        $coupons->appends(request()->all());
        return view('admin.promotions.coupons.index', compact('coupons'));
    }

    public function create()
    {
        $vendors = Vendor::where('active', 1)->get();
        $activities = Activity::all();
        $segmentations = Segmentation::all();
        $types = PromotionTypes::getList();

        $branches = [];
        if (old('vendor_id') ) {
            $vendorId = old('vendor_id') ?? '';
            $branches = Branch::where('active', 1)->where('vendor_id', $vendorId)->get();
        }

        return view('admin.promotions.coupons.create', compact('vendors', 'branches', 'activities', 'segmentations', 'types'));
    }

    public function store(CouponRequest $request)
    {
        $this->couponService->fillFromRequest($request);

        return redirect(route('admin.coupons.index'))->with('success', 'item added successfuly');
    }

    public function edit(Coupon $coupon)
    {
        if ($this->couponService->isUsed($coupon)) {
            return redirect()->back()->with('danger', trans('cant_edit_this_coupon'));
        }

        $vendors = Vendor::where('active', 1)->get();

        $branches = Branch::where('active', 1)
            ->where('vendor_id', $coupon->vendor_id)
            ->get();

        $activities = Activity::all();
        $types = PromotionTypes::getList();
        $segmentations = Segmentation::all();

        return view('admin.promotions.coupons.edit', compact('coupon', 'vendors', 'segmentations', 'branches', 'activities', 'types'));
    }

    public function update(CouponRequest $request, Coupon $coupon)
    {
        $this->couponService->fillFromRequest($request, $coupon);

        return redirect(route('admin.coupons.index'))->with('success', 'item updated successfuly');
    }

    public function destroy(Coupon $coupon)
    {
        if ($this->couponService->isUsed($coupon)) {
            return redirect()->back()->with('danger', trans('cant_delete_this_coupon'));
        }

        $coupon->delete();

        return redirect()->back()->with('success', trans('item_deleted_successfully'));
    }

    public function export()
    {
        return $this->couponService->export();
    }
}
