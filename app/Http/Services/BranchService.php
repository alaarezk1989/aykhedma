<?php

namespace App\Http\Services;

use App\Http\Resources\Branches;
use App\Models\Branch;
use App\Models\BranchZone;
use App\Repositories\BranchRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Models\User ;
use App\Constants\UserTypes ;
use App\Constants\DriverOrderStatus ;
use App\Models\DriverOrders ;
use Maatwebsite\Excel\Facades\Excel;

class BranchService
{
    protected $branchRepository;

    public function __construct(BranchRepository $branchRepository)
    {
        $this->branchRepository = $branchRepository;
    }

    public function fillFromRequest(Request $request, $branch = null)
    {
        if (!$branch) {
            $branch = new Branch();
        }

        $branch->fill($request->request->all());
        $branch->stock_enabled = $request->request->get('stock_enabled', 0);
        $branch->active = $request->request->get('active', 0);
        $branch->start_working_hours = date("H:i:s", strtotime($request->input('start_working_hours')));
        $branch->end_working_hours = date("H:i:s", strtotime($request->input('end_working_hours')));
        $branch->save();

        return $branch;
    }

    public function fillBranchZonesFromRequest(Request $request, $branchZone = null)
    {
        if (!$branchZone) {
            $branchZone = new branchZone();
        }

        $branchZone->fill($request->request->all());

        if ($request->filled('region_id')) {
            $branchZone->zone_id = $request->get('region_id');
        }
        if ($request->filled('district_id')) {
            $branchZone->zone_id = $request->get('district_id');
        }

        $branchZone->save();

        return $branchZone;
    }

    public function vendorBranches(Request $request)
    {
        $branches = $this->branchRepository->branchesByVendor($request)->paginate(10);

        return $branches ;
    }

    public function export()
    {
        $headings = [
            [trans('branches_list')],
            ['#',
                trans('vendor'),
                trans('name'),
                trans('address'),
                trans('type'),
                trans('latitude'),
                trans('longitude'),
                trans('rate'),
                trans('status')]
        ];

        $list = $this->branchRepository->search(request())->get();
        $listObjects = Branches::collection($list);

        return Excel::download(new ExportService($listObjects, $headings), 'Branches Report.xlsx');
    }
}
