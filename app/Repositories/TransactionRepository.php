<?php

namespace App\Repositories;

use App\Models\Transaction;
use Symfony\Component\HttpFoundation\Request;

class TransactionRepository
{
    public function getBalance($account, $accountType)
    {
        $credit = Transaction::where('accountable_id', $account)->where('accountable_type', $accountType)->groupBy('accountable_id')->sum('credit');

        $debit = Transaction::where('accountable_id', $account)->where('accountable_type', $accountType)->groupBy('accountable_id')->sum('debit');

        return $credit - $debit;
    }

    public function search(Request $request)
    {
        $transaction = Transaction::query()->orderByDesc("id");

        if ($request->filled('branch_id')) {
            $transaction->where('accountable_id', $request->get('branch_id'))
                        ->where('accountable_type', 'App\Models\Branch');
        }
        if ($request->filled('user_id')) {
            $transaction->where('accountable_id', $request->get('user_id'))
                ->where('accountable_type', 'App\Models\User');
        }
        if ($request->has('from_date') && !empty($request->get('from_date'))) {
            $transaction->where('created_at', '>=', $request->get('from_date'));
        }

        if ($request->has('to_date') && !empty($request->get('to_date'))) {
            $transaction->where('created_at', '<=', $request->get('to_date'));
        }

        return $transaction;
    }
}
