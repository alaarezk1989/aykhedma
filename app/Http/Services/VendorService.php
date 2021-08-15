<?php

namespace App\Http\Services;

use App\Http\Resources\Vendors;
use App\Models\Vendor;
use App\Repositories\VendorRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Http\Services\ExportService;
use Maatwebsite\Excel\Facades\Excel;
use File;

class VendorService
{
    protected $uploaderService;
    protected $vendorRepository;

    public function __construct(UploaderService $uploaderService, VendorRepository $vendorRepository)
    {
        $this->uploaderService = $uploaderService;
        $this->vendorRepository = $vendorRepository;
        $this->vendorRepository = $vendorRepository;
    }

    public function fillFromRequest(Request $request, $vendor = null)
    {
        if (!$vendor) {
            $vendor = new Vendor();
        }

        if (!empty($request->file('logo'))) {
            $vendor->logo = $this->uploaderService->upload($request->file('logo'), 'vendors_logo');
        }

        $vendor->fill($request->request->all());

        $vendor->active = $request->request->get('active', 0);

        $vendor->save();

        return $vendor;
    }

    public function export()
    {
        $headings = [
            [trans('vendors_list')],
            ['#',
                trans('activity'),
                trans('name'),
                trans('type'),
                trans('status')]
        ];

        $list = $this->vendorRepository->search(request())->get();
        $listObjects = Vendors::collection($list);

        return Excel::download(new ExportService($listObjects, $headings), 'Vendors Report.xlsx');
    }
}
