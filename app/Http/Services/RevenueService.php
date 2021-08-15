<?php

namespace App\Http\Services;

use App\Models\Revenue;
use App\Models\User;
use App\Models\Vendor;
use App\Repositories\RevenueRepository;
use Illuminate\Http\Request;

class RevenueService
{
    protected $revenueRepository;

    public function __construct(RevenueRepository $revenueRepository)
    {
        $this->revenueRepository = $revenueRepository;
    }

    public function fill(Request $request)
    {
        $revenue = new Revenue();

        if ($request->input('account_type') == 'user') {
            $accountable = User::find($request->input('account_id'));
            $accountType = 'App\Models\User';
        } else {
            $accountable = Vendor::find($request->input('account_id'));
            $accountType = 'App\Models\Vendor';
        }
        $revenue->fill($request->request->all());

        $balance = $this->revenueRepository->getBalance($request->input("account_id"), $accountType);
        $revenue->balance = $balance + $request->input("amount");

        $accountable->revenues()->save($revenue);

        return $revenue;
    }
}
