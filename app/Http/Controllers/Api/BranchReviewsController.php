<?php

namespace App\Http\Controllers\Api;

use App\Models\Branch;
use App\Http\Requests\Api\BranchReviewsRequest;
use App\Http\Services\ReviewService;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

class BranchReviewsController extends Controller
{
    private $reviewService;

    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }

    public function index(Branch $branch)
    {
        $list = $branch->reviews;
        return response()->json($list);
    }

    public function store(BranchReviewsRequest $request, Branch $branch)
    {
        $request->request->add(['branch_id' => $branch->id]);

        $review = $this->reviewService->fillFromRequest($request, $branch);

        return response($review, Response::HTTP_CREATED);
    }
}
