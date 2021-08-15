<?php

namespace App\Http\Services;

use App\Http\Resources\Vouchers;
use App\Http\Resources\VouchersList;
use App\Models\Order;
use App\Models\Segmentation;
use App\Models\Voucher;
use App\Repositories\VoucherRepository;
use App\Http\Services\ExportService;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Request;
use App\Jobs\CreateVouchers ;
use App\Jobs\UpdateVouchers ;
use App\Jobs\deleteVouchers ;

class VoucherService
{
    private $voucherRepository;

    public function __construct(VoucherRepository $voucherRepository)
    {
        $this->voucherRepository = $voucherRepository;
    }

    public function fillFromRequest(Request $request, $voucher = null)
    {
        if (!$voucher) {
            $voucher = new Voucher();
        }
        $voucher->fill($request->request->all());
        $voucher->save();

        if ($request->isMethod('post')) {
            dispatch(new CreateVouchers($voucher));
        }

        if ($request->isMethod('put')) {
            dispatch(new UpdateVouchers($voucher));
        }

        return $voucher;
    }

    public function deleteChildVouchers($voucher)
    {
        dispatch(new deleteVouchers($voucher));
    }

    public function export()
    {
        $headings = [
            [trans('vouchers_list')],
            [
                '#',
                trans('title'),
                trans('number'),
                trans('value'),
                trans('company'),
                trans('vendor'),
                trans('branch'),
                trans('segmentation'),
                trans('company'),
                //trans('activity'),
                trans('expire_date'),
                trans('status')
            ]
        ];
        $list = $this->voucherRepository->search(request())->get();
        $listObjects = Vouchers::collection($list);
        return Excel::download(new ExportService($listObjects, $headings), 'Vouchers Report.xlsx');
    }

    public function exportList($voucher)
    {
        $headings = [
            [trans('vouchers_list')],
            [
                trans('code'),
                trans('value'),
                trans('expire_date'),
            ]
        ];

        $list = $this->voucherRepository->search(request(), $voucher)->get();
        $listObjects = VouchersList::collection($list);

        return Excel::download(new ExportService($listObjects, $headings), 'Vouchers List.xlsx');
    }

    public function isUsed($voucher)
    {
        if (Order::where('promo_code', $voucher->code)->first()) {
            return true;
        }
        return false;
    }
}
