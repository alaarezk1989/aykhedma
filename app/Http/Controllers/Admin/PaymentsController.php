<?php

namespace App\Http\Controllers\Admin;

use App\Constants\PaymentStatus;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\PaymentRequest;
use App\Http\Services\PaymentService;
use App\Models\Payment;
use App\Repositories\PaymentRepository;
use Illuminate\Support\Facades\Request;
use View;

class PaymentsController extends BaseController
{
    protected $paymentService;
    protected $paymentRepository;
    public function __construct(PaymentService $paymentService, PaymentRepository $paymentRepository)
    {
        $this->authorizeResource(Payment::class, "payment");
        $this->paymentService = $paymentService;
        $this->paymentRepository = $paymentRepository;
    }

    public function index()
    {
        $this->authorize("index", Payment::class);
        $list = $this->paymentRepository->search(request())->paginate(10);
        $list->appends(request()->all());
        $status = PaymentStatus::getList();
        $count = $this->paymentRepository->search(request())->count();

        $totalAmount = 0;
        if (Request::get('status') == PaymentStatus::CONFIRMED) {
            $totalAmount = $this->paymentRepository->totalAmount();
        }

        return View::make('admin.payments.index', ['list' => $list, 'status' => $status, 'count' => $count, 'totalAmount' => $totalAmount]);
    }

    public function create()
    {
        return View::make('admin.payments.new');
    }

    public function store(PaymentRequest $request)
    {
        $this->paymentService->createDraft($request);

        return redirect(route('admin.payments.index'))->with('success', trans('payment_added_successfully'));
    }

    public function export()
    {
        return $this->paymentService->export();
    }
}
