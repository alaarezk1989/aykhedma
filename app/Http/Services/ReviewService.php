<?php

namespace App\Http\Services;

use App\Models\Review;
use Symfony\Component\HttpFoundation\Request;

class ReviewService
{
    public function fillFromRequest(Request $request, $reviewable, $review = null)
    {
        if (!$review) {
            $review = new Review();
        }

        $review->fill($request->request->all());
        $review->published = $request->request->get('published', 0);
        $reviewable->reviews()->save($review);
        return $review;
    }

    public function publishReview(Request $request, $review)
    {
        $review->published = $request->request->get('published');
        $review->save();
        return $review;
    }

    public function calculateRate($reviewable)
    {
        $reviewsSum = 0;
        $reviews = $reviewable->reviews->where('published', 1);
        foreach ($reviews as $value) {
            $reviewsSum += $value->rate;
        }
        $reviewsSum != 0 ? $rate = ceil($reviewsSum/count($reviews)) : $rate = 0;

        return  $rate;
    }
}
