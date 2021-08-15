<?php

namespace App\Repositories;
use App\Constants\PaymentStatus;
use App\Models\Payment;
use Symfony\Component\HttpFoundation\Request;

class PaymentRepository
{
    public function search(Request $request)
    {
        $payments = Payment::query()->orderByDesc("id");

        if ($request->get('status') && !empty($request->get('status'))) {
            $payments->where('status', $request->query->get('status'));
        }
        if ($request->has('from_date') && !empty($request->get('from_date'))) {
            $payments->where('created_at', '>=', $request->get('from_date'));
        }
        if ($request->has('to_date') && !empty($request->get('to_date'))) {
            $payments->where('created_at', '<=', $request->get('to_date'));
        }

        return $payments;
    }

    public function totalAmount()
    {
        $totalAmount = Payment::where('status', PaymentStatus::CONFIRMED)->sum('final_amount');

        return $totalAmount;
    }

    public function lastInvoiceNumber()
    {
        $lastInvoiceNumber = Payment::whereNotNull('invoice_number')->orderBy('id', 'desc')->first() ? Payment::whereNotNull('invoice_number')->orderBy('id', 'desc')->first()->invoice_number : 0;

        return $lastInvoiceNumber;
    }
}
