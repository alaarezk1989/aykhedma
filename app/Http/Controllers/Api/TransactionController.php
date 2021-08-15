<?php

namespace App\Http\Controllers\Api;

use App\Http\Services\UserService;
use App\Models\UserDevice;
use App\Repositories\TransactionRepository;
use App\Repositories\UserRepository;
use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Request;

class TransactionController extends Controller
{
    protected $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function balance(Request $request)
    {
        $accountType = 'App\Models\User';
        if ($request->get('account_type') == 'branch') {
            $accountType = 'App\Models\Branch';
        }
        $balance = $this->transactionRepository->getBalance($request->get('account_id'), $accountType);

        return response()->json(['result' => round($balance, 2)]);
    }
}
