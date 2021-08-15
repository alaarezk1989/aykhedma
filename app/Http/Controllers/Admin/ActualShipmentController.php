<?php

namespace App\Http\Controllers\Admin;

use App\Constants\BranchTypes;
use App\Constants\UserTypes as UserTypes;
use App\Models\ActualShipment;
use App\Http\Controllers\BaseController;
use App\Models\Branch;
use App\Models\Location;
use App\Models\Order;
use App\Models\Shipment;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\ActualShipmentRequest;
use App\Http\Services\ActualShipmentService;
use App\Repositories\ActualShipmentRepository;
use App\Repositories\VehicleRepository;
use App\Repositories\UserRepository;
use View;

class ActualShipmentController extends BaseController
{
    private $actualShipmentRepository;
    private $actualShipmentService;
    protected $VehicleRepository;
    protected $userRepository;

    public function __construct(ActualShipmentRepository $actualShipmentRepository, ActualShipmentService $actualShipmentService, VehicleRepository $VehicleRepository, UserRepository $userRepository)
    {
        $this->authorizeResource(ActualShipment::class, "actual_shipment");
        $this->actualShipmentRepository = $actualShipmentRepository;
        $this->actualShipmentService = $actualShipmentService;
        $this->VehicleRepository = $VehicleRepository;
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        $this->authorize("index", ActualShipment::class);
        $list = $this->actualShipmentRepository->searchFromRequest(request())   ;

        if ($request->filled('sub')) {
            $list->where('id', $request->get('sub'));
        }

        $list = $list->paginate(10);
        $list->appends(request()->all());

        $subList = $this->actualShipmentRepository->searchFromRequest(request())
            ->where('parent_id', $request->get('sub'))->get();

        return View::make('admin.actual_shipments.index', ['list' => $list, 'subList' => $subList]);
    }

    public function create(Request $request)
    {
        $actualShipments = ActualShipment::where('active', true)->get();
        $locations = Location::where('active', true)->whereIsLeaf()->get();
        $shipments = Shipment::where('active', true)->get();

        $vehicles = Vehicle::where('active', 1)->get();
        $drivers = User::where('active', 1)->where('type', UserTypes::DELIVERY_PERSONAL)->get();
        $branches = Branch::where('active',1)->where('type', '!=', BranchTypes::RETAILER)->get();

        return View::make('admin.actual_shipments.create', ['shipments' => $shipments, 'locations' => $locations, 'actualShipments' => $actualShipments, 'parent_id' => request()->query->get('sub'), 'vehicles' => $vehicles, 'drivers' => $drivers, 'branches' => $branches]);
    }

    public function store(ActualShipmentRequest $request)
    {
        if (is_string($this->actualShipmentService->fillFromRequest($request))) {
            return back()->with('danger', $this->actualShipmentService->fillFromRequest($request));
        }

        return redirect(route('admin.actual-shipments.index') . '?sub=' . $request->input('parent_id'))
            ->with('success', trans('item_added_successfully'));
    }

    public function edit(ActualShipment $actualShipment)
    {
        $actualShipments = ActualShipment::where('active', true)->get();
        $locations = Location::where('active', true)->whereIsLeaf()->get();
        $shipments = Shipment::where('active', true)->get();

        $vehicles = Vehicle::where('active', 1)->get();
        $drivers = User::where('active', 1)->where('type', UserTypes::DELIVERY_PERSONAL)->get();

        return view('admin.actual_shipments.edit', ['shipments' => $shipments, 'actualShipment' => $actualShipment, 'actualShipments' => $actualShipments, 'locations' => $locations, 'vehicles' => $vehicles, 'drivers' => $drivers]);
    }

    public function update(ActualShipmentRequest $request, ActualShipment $actualShipment)
    {
        if (is_string($this->actualShipmentService->fillFromRequest($request, $actualShipment))) {
            return back()->with('danger', $this->actualShipmentService->fillFromRequest($request, $actualShipment));
        }

        return redirect(route('admin.actual-shipments.index'))
            ->with('success', trans('item_updated_successfully'));
    }

    public function destroy(ActualShipment $actualShipment)
    {
        if (count($actualShipment->children)) {
            return redirect()->back()->with('danger', trans('cant_delete_this_item_related_with_sub_shipment'));
        }

        $hasOrder = Order::where('shipment_id', $actualShipment->id)->first();
        if ($hasOrder) {
            return redirect()->back()->with('danger', trans('cant_delete_this_item_has_orders'));
        }

        $actualShipment->delete();

        return redirect()->back()->with('success', trans('item_deleted_successfully'));
    }

    public function createActualShipments(Request $request)
    {
        $this->actualShipmentService->createActualShipments($request);
    }

    public function export()
    {
        return $this->actualShipmentService->export();
    }
}
