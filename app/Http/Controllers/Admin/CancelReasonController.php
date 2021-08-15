<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\CancelReasonRequest;
use App\Http\Services\CancelReasonService;
use App\Models\CancelReason;
use App\Repositories\CancelReasonRepository;
use View;

class CancelReasonController extends BaseController
{
    protected $cancelReasonService;
    private $cancelReasonRepository;

    public function __construct(CancelReasonService $cancelReasonService, CancelReasonRepository $cancelReasonRepository)
    {
        $this->authorizeResource(CancelReason::class, "cancelReason");
        $this->cancelReasonService = $cancelReasonService;
        $this->cancelReasonRepository = $cancelReasonRepository;
    }

    public function index()
    {
        $this->authorize("index", CancelReason::class);
        $list = $this->cancelReasonRepository->search(request())->paginate(10);
        $list->appends(request()->all());

        return View::make('admin.cancel-reasons.index', ['list' => $list]);
    }

    public function create()
    {
        return View::make('admin.cancel-reasons.new');
    }

    public function store(CancelReasonRequest $request)
    {
        $this->cancelReasonService->fillFromRequest($request);
        return redirect(route('admin.cancelReasons.index'))->with('success', trans('item_added_successfully'));
    }

    public function edit(CancelReason $cancelReason)
    {
        return View::make('admin.cancel-reasons.edit', ['cancelReason' => $cancelReason]);
    }

    public function update(CancelReasonRequest $request, CancelReason $cancelReason)
    {
        $this->cancelReasonService->fillFromRequest($request, $cancelReason);

        return redirect(route('admin.cancelReasons.index'))->with('success', trans('item_updated_successfully'));
    }
}
