<?php

namespace App\Http\Services;

use App\Http\Resources\QuantityAnalysisReports;
use App\Repositories\ReportRepository;
use Maatwebsite\Excel\Facades\Excel;

class ReportService
{
    protected $reportRepository;
    public function __construct(ReportRepository $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function exportQuantity()
    {
        $headings = [
            [trans('quantity_analysis_report')],
            [
                trans('item_name'),
                trans('number_boxes'),
                trans('kilos_per_box'),
                trans('kilos'),
            ]
        ];

        $list = $this->reportRepository->quantityAnalysis(request())->get();
        $listObjects = QuantityAnalysisReports::collection($list);

        return Excel::download(new ExportService($listObjects, $headings), 'Quantity Analysis Report.xlsx');
    }
}
