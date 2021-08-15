<?php

namespace App\Http\Services;

use App\Constants\PaymentStatus;
use App\Constants\PromotionTypes;
use App\Models\Coupon;
use App\Models\Discount;
use App\Models\Payment;
use App\Models\Voucher;
use App\Repositories\PaymentRepository;
use App\Http\Services\ExportService;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Request;

class PaymentService
{
    protected $paymentRepository;
    public function __construct(PaymentRepository $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }

    public function createDraft(Request $request, $payment = null)
    {
        if (!$payment) {
            $payment = new payment();
        }

        $payment->fill($request->request->all());
        $payment->final_amount = $request['amount'] + $request['amount'] * $request['taxes'] / 100;
        $payment->final_amount += $request['fees'];

        if ($request["voucher_id"]) {
            $promotionModel = Voucher::find($request["voucher_id"]);
        }
        if ($request["discount_id"]) {
            $promotionModel = Discount::find($request["discount_id"]);
        }
        if ($request["coupon_id"]) {
            $promotionModel = Coupon::find($request["coupon_id"]);
        }
        if (isset($promotionModel)) {
            $payment->final_amount =  $this->calculateDiscount($payment->final_amount, $promotionModel);
        }

        $payment->status = $request->get('status', PaymentStatus::DRAFT);

        $payment->save();

        return $payment;
    }

    public function calculateDiscount($amount, $promotionModel)
    {
        if (isset($promotionModel->type)) {
            switch ($promotionModel->type) {
                case PromotionTypes::FIXED:
                    $amount -= $promotionModel->value;
                    break;
                case PromotionTypes::PERCENTAGE:
                    $amount -= $amount * $promotionModel->value / 100;
                    break;
            }
        } else {
            $amount -= $promotionModel->value;
        }

        return $amount > 0 ? $amount : 0 ;
    }

    public function updateInvoiceNumber(Payment $payment)
    {
        $lastInvoiceNumber = $this->paymentRepository->lastInvoiceNumber();
        $payment->invoice_number = $lastInvoiceNumber + 1;
        $payment->save();

        return $payment;
    }

    public function export()
    {
        $headings = [
            '#',
            'Invoice Number',
            'Order ID',
            'Final Amount'
        ];
        $list = $this->paymentRepository->search(request())->get(['id','invoice_number','order_id','final_amount']);

        return Excel::download(new ExportService($list, $headings), 'Payments Report.xlsx');
    }
}
