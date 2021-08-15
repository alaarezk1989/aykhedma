<?php

namespace App\Repositories;

use App\Models\Revenue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class RevenueRepository
{
    /**
     * @param Request $request
     *
     * @return Builder
     */
    public function search(Request $request)
    {
        $revenues = Revenue::query()->orderByDesc('id');

        if ($request->filled('account_type')) {
            if ($request->get('account_type') == 'user') {
                if ($request->filled('account_id')) {
                    $revenues->where('accountable_type', '=', 'App\Models\User');
                    $revenues->where('accountable_id', '=', $request->get('account_id'));
                }
            }
            if ($request->get('account_type') == 'vendor') {
                if ($request->filled('account_id')) {
                    $revenues->where('accountable_type', '=', 'App\Models\Vendor');
                    $revenues->where('accountable_id', '=', $request->get('account_id'));
                }
            }
        }
        if ($request->filled('from_date')) {
            $revenues->where('created_at', '>=', date("Y-m-d", strtotime($request->get('from_date'))));
        }
        if ($request->filled('to_date')) {
            $revenues->where('created_at', '<=', date("Y-m-d", strtotime($request->get('to_date'))));
        }

        return $revenues ;
    }

    public function getBalance($account, $accountType)
    {
        return  Revenue::where('accountable_id', $account)
                ->where('accountable_type', $accountType)
                ->groupBy('accountable_id')
                ->sum('amount');
    }
}
