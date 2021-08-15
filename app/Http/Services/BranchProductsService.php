<?php

namespace App\Http\Services;

use App\Models\BranchProduct;
use App\Models\ProductReview;
use Symfony\Component\HttpFoundation\Request;

class BranchProductsService
{
    public function fillFromRequest(Request $request, $branchProduct = null)
    {
        if (!$branchProduct) {
            $branchProduct = new branchProduct();
        }

        $branchProduct->fill($request->request->all());

        $branchProduct->active = $request->request->get('active', 0);
        $branchProduct->wholesale= $request->request->get('wholesale', 0);

        $branchProduct->save();

        return $branchProduct;
    }

    public function fillReviewsFromRequest(Request $request, $review = null)
    {
        if (!$review) {
            $review = new ProductReview();
        }

        $review->fill($request->request->all());

        $review->published = $request->request->get('published', 0);

        $review->save();

        return $review;
    }
}
