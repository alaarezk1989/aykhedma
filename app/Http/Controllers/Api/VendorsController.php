<?php

namespace App\Http\Controllers\Api;

// use App\Http\Controllers\BaseController;
use App\Repositories\VendorRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Models\Branch ;
use Illuminate\Routing\Controller;

class VendorsController extends Controller
{
    protected $vendorRepository;

    public function __construct(VendorRepository $vendorRepository)
    {
        $this->vendorRepository = $vendorRepository;
    }

    public function index(Request $request)
    {
        $list = $this->vendorRepository->search($request)->get();

        return response()->json($list);
    }

    public function branches(Request $request)
    {
        $branches= Branch::where('vendor_id', $request->vendor_id)->get();

        return response($branches, 200)->header('Content-Type', 'application/json');
    }
}
