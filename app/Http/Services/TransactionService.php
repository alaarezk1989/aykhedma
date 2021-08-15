<?php

namespace App\Http\Services;

use App\Constants\PaymentTypes;
use App\Constants\RevenueTypes;
use App\Constants\TransactionTypes;
use App\Models\Branch;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Vendor;
use App\Repositories\TransactionRepository;
use Symfony\Component\HttpFoundation\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Resources\Transactions;


class TransactionService
{

    protected $transactionRepository;
    protected $transaction;
    protected $revenueService;

    public function __construct(TransactionRepository $transactionRepository, RevenueService $revenueService)
    {
        $this->transactionRepository = $transactionRepository;
        $this->revenueService = $revenueService;
    }

    public function fillFromRequest(Request $request)
    {
        $transaction = new Transaction();

        if ($request->input('account_type') == 'user') {
            $accountable = User::find($request->input('account_id'));
            $accountType = 'App\Models\User';
        } else {
            $accountable = Branch::find($request->input('account_id'));
            $accountType = 'App\Models\Branch';
        }

        $balance = $this->transactionRepository->getBalance($request->input("account_id"), $accountType);

        $transaction->fill($request->request->all());
        $transaction->balance = $balance + $request->input("credit") - $request->input("debit") ;
        $transaction->created_by = auth()->user()->id;

        $accountable->transactions()->save($transaction);

        return $transaction;
    }

    public function export()
    {
        $headings = [
            [trans('transactions_list')],
            [
                '#',
                trans('account'),
                trans('debit'),
                trans('credit'),
                trans('balance'),
                trans('order_id'),
                trans('order_type'),
                trans('transaction_type'),
                trans('description'),
                trans('created_at')
            ]
        ];
        $list = $this->transactionRepository->search(request())->get();
        $listObjects = Transactions::collection($list);

        return Excel::download(new ExportService($listObjects, $headings), 'Transactions Report.xlsx');
    }

    public function settle(Request $request)
    {
        $transactionsData = [];
        if ($request->filled('credit')) {
            $transactionsData = [
                [
                    'account_id' => $request->get('account_id'),
                    'account_type' => $request->get('account_type'),
                    'credit' => $request->get('credit'),
                    'debit' => 0,
                    'transaction_type' => TransactionTypes::SETTLE,
                ],
                [
                    'account_id' => 1,
                    'account_type' => 'user',
                    'credit' => 0,
                    'debit' => $request->get('credit'),
                    'transaction_type' => TransactionTypes::SETTLE,
                ],
            ];
        }
        if ($request->filled('debit')) {
            $transactionsData = [
                [
                    'account_id' => $request->get('account_id'),
                    'account_type' => $request->get('account_type'),
                    'credit' => 0,
                    'debit' => $request->get('debit'),
                    'transaction_type' => TransactionTypes::SETTLE,
                ],
                [
                    'account_id' => 1,
                    'account_type' => 'user',
                    'credit' =>  $request->get('debit'),
                    'debit' => 0,
                    'transaction_type' => TransactionTypes::SETTLE,
                ],
            ];
        }

        foreach ($transactionsData as $transactionData) {
            request()->request->add($transactionData);
            $this->fillFromRequest(request());
        }

        return true;
    }
}
