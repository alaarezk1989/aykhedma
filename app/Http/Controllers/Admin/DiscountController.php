<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\DiscountRequest;
use App\Http\Services\DiscountService;
use App\Models\Discount;
use App\Models\Activity;
use App\Repositories\DiscountRepository;
use Illuminate\Http\Request;
use View;

class DiscountController extends BaseController
{

    private $discountRepository;
    protected $discountService;

    public function __construct(DiscountRepository $discountRepository, DiscountService $discountService)
    {
        $this->discountRepository = $discountRepository;
        $this->discountService = $discountService;
        $this->authorizeResource(Discount::class, "discount");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize("index", Discount::class);
        $list = $this->discountRepository->searchFromRequest(request());
        $list = $list->paginate(10);
        $list->appends(request()->all());
        return View::make('admin.promotions.discount.index', ['list' => $list]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $activities = Activity::all();
        return View::make('admin.promotions.discount.create', ['activities' => $activities]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(DiscountRequest $request)
    {
        $this->discountService->fillFromRequest($request);
        return redirect(route('admin.discounts.index'))->with('success', trans('item_added_successfully'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Discount $discount
     * @return \Illuminate\Http\Response
     */
    public function edit(Discount $discount)
    {
        $activities = Activity::all();
        return View::make('admin.promotions.discount.edit', ['discount' => $discount, 'activities' => $activities]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param DiscountRequest $request
     * @param Discount $discount
     * @return \Illuminate\Contracts\View\View
     */
    public function update(DiscountRequest $request, Discount $discount)
    {
        $this->discountService->fillFromRequest($request, $discount);
        return redirect(route('admin.discounts.index'))->with('success', trans('item_added_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Discount $discount
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Discount $discount)
    {
        $discount->delete();

        return redirect()->back()->with('success', trans('item_deleted_successfully'));
    }
}
