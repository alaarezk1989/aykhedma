<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Revenue;
use App\Models\User;
use App\Models\Vendor;
use App\Repositories\RevenueRepository;
use Illuminate\Http\Request;

class RevenueController extends BaseController
{
    /**
     * @var RevenueRepository
     */
    private $revenueRepository;

    /**
     * RevenueController constructor.
     * @param RevenueRepository $revenueRepository
     */
    public function __construct(RevenueRepository $revenueRepository)
    {
        $this->revenueRepository = $revenueRepository;
    }

    public function index(Request $request)
    {
        $this->authorize("index", Revenue::class);
        $users = User::all();
        $vendors = Vendor::where('active', 1)->get();
        $list = $this->revenueRepository->search($request)->paginate(10);

        return view("admin.revenues.index", compact("list", "users", "vendors"));
    }
}
