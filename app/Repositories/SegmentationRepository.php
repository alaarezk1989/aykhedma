<?php

namespace App\Repositories;

use App\Models\Segmentation;
use App\Models\User;
use Symfony\Component\HttpFoundation\Request;
use DB;

class SegmentationRepository
{
    /**
     * @param $request
     * @return $this|mixed
     */
    public function search(Request $request)
    {
        $segmentations = Segmentation::query()
            ->orderByDesc("id");

        if ($request->has('title') && !empty($request->get('title'))) {
            $segmentations->whereHas('translations', function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->query->get('title') . '%');
            });
        }

        return $segmentations;
    }

    public function getSegmentationUsers($segmentation)
    {
        $list = User::where('active', 1);

        if ($segmentation->class != null) {
            $list->where('class', $segmentation->class);
        }
        if ($segmentation->location_id != null) {
            $list->whereHas('addresses', function ($query) use ($segmentation) {
                $query->where('location_id', $segmentation->location_id);
            });
        }
        if ($segmentation->location_class != null) {
            $list->whereHas('addresses.location', function ($query) use ($segmentation) {
                $query->where('class', $segmentation->location_class);
            });
        }
        if ($segmentation->company_id != null) {
            $list->where('company_id', $segmentation->company_id);
        }
        if ($segmentation->orders_category != null) {
            $list->whereHas('orders.products', function ($query) use ($segmentation) {
                $query->where('order_products.category_id', $segmentation->orders_category);
            });
        }
        if ($segmentation->orders_wish_list_category != null) {
            $list->whereHas('favoritedProducts.product', function ($query) use ($segmentation) {
                $query->where('category_id', $segmentation->orders_wish_list_category);
            });
        }
        if ($segmentation->orders_amount != null) {
            $date = \Carbon\Carbon::today()->subWeeks($segmentation->weeks_number);
            $list->select('users.*', DB::raw("SUM(orders.total_price) as total_amount"))
                ->join('orders', 'users.id', '=', 'orders.user_id')
                ->where('orders.created_at', '>=', $date)
                ->groupBy('user_id')
                ->having('total_amount', '>=', $segmentation->orders_amount)
                ->orderBy('total_amount', 'DESC');

            return $list->take($segmentation->users_number)->get();
        }

        return $list->get();
    }
}
