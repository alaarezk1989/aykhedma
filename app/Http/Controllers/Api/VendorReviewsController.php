<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\VendorReviewsRequest;
use App\Http\Services\ReviewService;
use App\Models\Vendor;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

class VendorReviewsController extends Controller
{
    private $reviewService;

    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }

    public function index(Vendor $vendor)
    {
        $list = $vendor->reviews->where('published', 1);
        return response()->json($list);
    }


    public function store(VendorReviewsRequest $request, Vendor $vendor)
    {
        $request->request->add(['vendor_id' => $vendor->id]);

        $review = $this->reviewService->fillFromRequest($request, $vendor);

        return response($review, Response::HTTP_CREATED);
    }
}
