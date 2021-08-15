<?php

namespace App\Repositories;

use App\Models\Voucher;
use Symfony\Component\HttpFoundation\Request;

class VoucherRepository
{
    public function search(Request $request, $voucher = null)
    {
        $vouchers = Voucher::orderByDesc("id");

        if (!$voucher) {
            $vouchers->where('parent_id', null);
        }

        if ($request->get('filter_by') == "title" && !empty($request->get('q'))) {
            $vouchers->whereHas('translations', function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->query->get('q') . '%');
            });
        }
        if ($request->get('filter_by') == "value" && !empty($request->get('q'))) {
            $vouchers->where($request->get('filter_by'), $request->get('q'));
        }
        if ($request->has('from_date') && !empty($request->get('from_date'))) {
            $vouchers->where('expire_date', '>=', $request->get('from_date'));
        }
        if ($request->has('to_date') && !empty($request->get('to_date'))) {
            $vouchers->where('expire_date', '<=', $request->get('to_date'));
        }
        if ($request->has('code') && !empty($request->get('code'))) {
            $vouchers->where('code', $request->get('code'));
        }
        if (($request->has('is_used') && !empty($request->get('is_used'))) || $request->get('is_used') === '0') {
            $vouchers->where('is_used', $request->get('is_used'));
        }
        if ($voucher) {
            $vouchers->where('parent_id', $voucher->id);
        }

        return $vouchers;
    }
}
