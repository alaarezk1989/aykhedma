<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\ProductReviewsRequest;
use App\Http\Services\ReviewService;
use App\Models\BranchProduct;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

class ProductReviewsController extends Controller
{
    private $reviewService;

    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }

    public function index(BranchProduct $product)
    {
        $list = $product->reviews->where('published', 1);

        return response()->json($list);
    }


    public function store(ProductReviewsRequest $request, BranchProduct $product)
    {
        $request->request->add(['product_id' => $product->id]);

        $review = $this->reviewService->fillFromRequest($request, $product);

        return response($review, Response::HTTP_CREATED);
    }
}
