<?php

namespace App\Http\Controllers\Api;

use App\Repositories\BranchRepository;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Models\Branch ;
use App\Models\User ;
use App\Constants\UserTypes ;

class BranchesController extends Controller
{
    protected $branchRepository;

    public function __construct(BranchRepository $branchRepository)
    {
        $this->branchRepository = $branchRepository;
    }


    public function index(Request $request)
    {
        $list = $this->branchRepository->search($request)->get();
        return response()->json($list);
    }

    public function products(Request $request)
    {
        $list = $this->branchRepository->searchProductsFromRequest($request)->get();

        return response()->json($list);
    }
}
