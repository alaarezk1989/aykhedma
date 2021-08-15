<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Vehicle;
use App\Repositories\ReportRepository;
use App\Http\Services\ReportService;
use Illuminate\Http\Request;
use View;

class ReportsController extends BaseController
{
    protected $reportRepository;
    protected $reportService;

    public function __construct(ReportRepository $reportRepository, ReportService $reportService)
    {
        $this->reportRepository = $reportRepository;
        $this->reportService = $reportService;
    }

    public function quantityAnalysisReport(Request $request)
    {
        $this->authorize("quantityAnalysis", Report::class);

        $list = $this->reportRepository->quantityAnalysis(request())->get();

        $vehicles = Vehicle::whereHas('shipments')->get();

        $orders = $list->map(function ($list) {
            return collect($list->toArray())
                ->only(['order'])
                ->all();
        });

        $ordersArr = array_column($orders->toArray(), 'order');
        $uniqueShipments = array_unique(array_map(function ($i) { return $i["shipment_id"]; }, $ordersArr));
        $last = 0;
        $shipments = "(";
        foreach ($uniqueShipments as $shipment) {
            $shipments .= $shipment;
            if ($last != count($uniqueShipments)-1) {
                $shipments .=",";
            }
            $last++;
        }
        $shipments .= ")";

//        echo "<pre>";
//        print_r($list->toArray());die;


        return View::make('admin.reports.quantity', ['list' => $list, 'vehicles' => $vehicles, "shipments" => $shipments]);
    }

    public function exportQuantity()
    {
        return $this->reportService->exportQuantity();
    }
}
