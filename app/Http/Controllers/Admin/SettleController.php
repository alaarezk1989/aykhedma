<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\TransactionRequest;
use App\Http\Services\TransactionService;
use App\Models\Branch;
use App\Models\User;
use View;

class SettleController extends BaseController
{
    protected $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function create()
    {
        $users = User::whereNotIn('id', [1,2])->get();
        $branches = Branch::where('active', 1)->get();

        return View::make('admin.settles.new', ['users' => $users, 'branches' => $branches]);
    }

    public function store(TransactionRequest $request)
    {
        $this->transactionService->settle($request);

        return redirect(route('admin.transactions.index'))->with('success', trans('settle_successfully'));
    }
}
