<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\VoucherRequest;
use App\Http\Services\VoucherService;
use App\Models\Company;
use App\Models\Segmentation;
use App\Repositories\VoucherRepository;
use App\Models\Voucher;
use App\Models\Vendor;
use App\Models\Branch;
use App\Models\Activity;
use View;

class VouchersController extends BaseController
{

    protected $voucherService;
    private $voucherRepository;

    public function __construct(VoucherService $voucherService, VoucherRepository $voucherRepository)
    {
        $this->authorizeResource(Voucher::class, "voucher");
        $this->voucherService = $voucherService;
        $this->voucherRepository = $voucherRepository;
    }

    public function index()
    {
        $this->authorize("index", Voucher::class);
        $list = $this->voucherRepository->search(request());
        $list = $list->paginate(10);
        $list->appends(request()->all());
        $vouchersCount = $this->voucherRepository->search(request())->count();

        return View::make('admin.promotions.vouchers.index', ['list' => $list, 'vouchersCount' => $vouchersCount]);
    }

    public function create()
    {
        $vendors = Vendor::where('active', 1)->get();
        $activities = Activity::all();
        $segmentations = Segmentation::all();
        $companies = Company::all();

        return View::make('admin.promotions.vouchers.new', ['vendors' => $vendors, 'activities' => $activities, 'segmentations' => $segmentations, 'companies' => $companies]);
    }

    public function store(VoucherRequest $request)
    {
        $this->voucherService->fillFromRequest($request);

        return redirect(route('admin.vouchers.index'))->with('success', trans('item_added_successfully'));
    }

    public function edit(Voucher $voucher)
    {
        $vendors = Vendor::where('active', 1)->get();
        $activities = Activity::all();
        $branches = Branch::where('vendor_id', $voucher->vendor_id)->get();
        $segmentations = Segmentation::all();
        $companies = Company::all();

        return view('admin.promotions.vouchers.edit', ['item' => $voucher, 'vendors' => $vendors, 'activities' => $activities, 'branches' => $branches, 'segmentations' => $segmentations, 'companies' => $companies]);
    }

    public function update(VoucherRequest $request, Voucher $voucher)
    {
        $this->voucherService->fillFromRequest($request, $voucher);
        return redirect(route('admin.vouchers.index'))->with('success', trans('item_updated_successfully'));
    }

    public function destroy(Voucher $voucher)
    {
        $voucher->delete();
        $this->voucherService->deleteChildVouchers($voucher);
        return redirect()->back()->with('success', trans('item_deleted_successfully'));
    }

    public function list(Voucher $voucher)
    {
        $this->authorize("list", Voucher::class);

        $list = $this->voucherRepository->search(request(), $voucher);

        $list = $list->paginate(10);

        $list->appends(request()->all());

        return View::make('admin.promotions.vouchers.list', ['list' => $list, 'voucher' => $voucher]);
    }

    public function export()
    {
        return $this->voucherService->export();
    }

    public function exportList(Voucher $voucher)
    {
        return $this->voucherService->exportList($voucher);
    }
}
