<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\ReviewsRequest;
use App\Http\Services\ReviewService;
use App\Models\Review;
use App\Models\BranchProduct;
use App\Models\User;
use App\Constants\UserTypes as UserTypes;
use View;

class ProductReviewsController extends BaseController
{
    protected $reviewService;

    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }

    public function index(BranchProduct $product)
    {
        $list = $product->reviews;

        return View::make('admin.productReviews.index', ['list' => $list, 'product' => $product]);
    }

    public function create(BranchProduct $product)
    {
        $users = User::where('type', UserTypes:: NORMAL)->get();

        return View::make('admin.productReviews.new', ['product' => $product, 'users' => $users]);
    }

    public function store(ReviewsRequest $request, BranchProduct $product)
    {
        $this->reviewService->fillFromRequest($request, $product);

        return redirect(route('admin.product.reviews.index', ['product' => $product->id]))->with('success', trans('review_added_successfully'));
    }

    public function edit(BranchProduct $product, Review $review)
    {
        $users = User::where('type', UserTypes:: NORMAL)->get();

        return View::make('admin.productReviews.edit', ['review' => $review, 'users' => $users, 'product' => $product]);
    }

    public function update(ReviewsRequest $request, BranchProduct $product, Review $review)
    {
        $this->reviewService->fillFromRequest($request, $product, $review);

        return redirect(route('admin.product.reviews.index', ['product' => $review->reviewable_id]))->with('success', trans('review_updated_successfully'));
    }

    public function destroy(BranchProduct $product, Review $review)
    {
        $review->delete();

        return redirect()->back()->with('success', trans('review_deleted_successfully'));
    }

    public function publish(Request $request, Review $review)
    {
        $review = $this->reviewService->publishReview($request, $review);

        return response()->json($review);
    }
}
