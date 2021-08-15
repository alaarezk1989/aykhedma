<?php

namespace App\Http\Controllers\Admin;

use App\Constants\UserTypes as UserTypes;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\ReviewsRequest;
use Illuminate\Http\Request;
use App\Http\Services\ReviewService;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Review;
use View;

class VendorReviewsController extends BaseController
{
    private $reviewService;

    /**
     * VendorReviewsController constructor.
     * @param ReviewService $ReviewService
     */
    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }

    public function index(Vendor $vendor)
    {
        $list = $vendor->reviews;
        $rate = $this->reviewService->calculateRate($vendor, 'vendor');

        return View::make('admin.vendors.reviews.index', ['list' => $list, 'vendor' => $vendor, 'rate' => $rate]);
    }

    public function create(Vendor $vendor)
    {
        $users = User::where('type', UserTypes:: NORMAL)->get();
        return View::make('admin.vendors.reviews.new', ['vendor' => $vendor, 'users' => $users]);
    }

    public function store(ReviewsRequest $request, Vendor $vendor)
    {
        $this->reviewService->fillFromRequest($request, $vendor);

        return redirect(route('admin.vendor.reviews.index', ['vendor' => $vendor->id]))->with('success', trans('review_added_successfully'));
    }

    public function edit(Vendor $vendor, Review $review)
    {
        $users = User::where('type', UserTypes:: NORMAL)->get();
        return View::make('admin.vendors.reviews.edit', ['review' => $review, 'users' => $users]);
    }

    public function update(ReviewsRequest $request, vendor $vendor, Review $review)
    {
        $this->reviewService->fillFromRequest($request, $vendor, $review);
        return redirect(route('admin.vendor.reviews.index', ['vendor' => $vendor->id]))->with('success', trans('review_updated_successfully'));
    }

    public function destroy(Vendor $vendor, Review $review)
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
