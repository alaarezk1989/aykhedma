<?php

namespace App\Http\Services;

use App\Http\Resources\Coupons;
use App\Jobs\CreateCouponNotification;
use App\Jobs\OrderNotification;
use App\Mail\CreateCouponClientMail;
use App\Mail\CreateOrderClientMail;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Segmentation;
use App\Repositories\CouponRepository;
use App\Http\Services\ExportService;
use App\Repositories\SegmentationRepository;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Request;

class CouponService
{
    protected $couponRepository;
    protected $segmenationRepository;
    protected $notificationService;

    public function __construct(CouponRepository $couponRepository, SegmentationRepository $segmentationRepository, NotificationService $notificationService)
    {
        $this->couponRepository = $couponRepository;
        $this->segmenationRepository = $segmentationRepository;
        $this->notificationService = $notificationService;
    }

    public function fillFromRequest(Request $request, $coupon = null)
    {
        if (!$coupon) {
            $coupon = new Coupon();
        }

        $coupon->fill($request->request->all());
        $coupon->save();

        if ($request->filled('segmentation_id')) {
            $segmentation = Segmentation::find($request->get('segmentation_id'));
            $users = $this->segmenationRepository->getSegmentationUsers($segmentation);

            dispatch(new CreateCouponNotification($coupon, $users));
        }

        return $coupon;
    }

    public function export()
    {
        $headings = [
            [trans('coupons_list')],
            [
                '#',
                trans('title'),
                trans('code'),
                trans('type'),
                trans('value'),
                trans('minimum_order_price'),
                trans('expire_date'),
                trans('vendor'),
                trans('branch'),
                trans('segmentation')
            ]
        ];
        $list = $this->couponRepository->searchFromRequest(request())->get();
        $listObjects = Coupons::collection($list);

        return Excel::download(new ExportService($listObjects, $headings), 'Coupons Report.xlsx');
    }

    public function isUsed($coupon)
    {
        if (Order::where('promo_code', $coupon->code)->first()) {
            return true;
        }
        return false;
    }
}
