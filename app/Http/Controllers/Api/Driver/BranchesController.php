<?php

namespace App\Http\Controllers\Api\Driver;

use App\Repositories\BranchRepository;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Http\Services\BranchService ;
use Symfony\Component\HttpFoundation\Response;

class BranchesController extends Controller
{
    protected $branchRepository;
    protected $branchService;

    public function __construct(BranchRepository $branchRepository, BranchService $branchService)
    {
        $this->branchRepository = $branchRepository;
        $this->branchService = $branchService;
    }

    public function index(Request $request)
    {
        $request->request->add(['vendor_id' => auth()->user()->vendor_id]);

        $branches = $this->branchService->vendorBranches($request);

        return response()->json(["status" => true, "result" =>$branches]);
    }
}
