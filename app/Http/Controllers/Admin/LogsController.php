<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Log;
use App\Repositories\LogRepository;
use Illuminate\Http\Request;
use View;

class LogsController extends BaseController
{
    private $logRepository;

    /**
     * LogsController constructor.
     * @param LogRepository $logRepository
     */
    public function __construct(LogRepository $logRepository)
    {
        $this->authorizeResource(Log::class, "log");
        $this->logRepository = $logRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $this->authorize("index", Log::class);
        $list = $this->logRepository->search(request())->paginate(10);
        $list->appends(request()->all());

        return View::make('admin.logs.index', ['list' => $list]);
    }
}
