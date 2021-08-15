<?php

namespace App\Http\Controllers\Admin;

use App\Constants\BranchTypes;
use App\Constants\RecurringTypes;
use App\Http\Controllers\BaseController;
use App\Models\Address;
use App\Models\Branch;
use App\Models\Location;
use App\Models\Shipment;
use App\Http\Requests\Admin\ShipmentRequest;
use App\Http\Services\ShipmentService;
use App\Repositories\ActualShipmentRepository;
use App\Repositories\ShipmentRepository;
use App\Repositories\VehicleRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Constants\UserTypes as UserTypes;
use View;

class ShipmentsController extends BaseController
{

    private $shipmentRepository;
    private $actualShipmentRepository;
    private $shipmentService;
    protected $VehicleRepository;
    protected $userRepository;

    public function __construct(ShipmentRepository $shipmentRepository, ShipmentService $shipmentService, VehicleRepository $VehicleRepository, UserRepository $userRepository, ActualShipmentRepository $actualShipmentRepository)
    {
        $this->authorizeResource(Shipment::class, 'shipment');
        $this->shipmentRepository = $shipmentRepository;
        $this->shipmentService = $shipmentService;
        $this->VehicleRepository = $VehicleRepository;
        $this->userRepository = $userRepository;
        $this->actualShipmentRepository = $actualShipmentRepository;
    }

    public function index(Request $request)
    {

        $this->authorize("index", Shipment::class);

        $list = $this->shipmentRepository->searchFromRequest(request());

        if ($request->filled('sub')) {
            $list->where('id', $request->get('sub'));
        }

        $list = $list->paginate(10);
        $list->appends(request()->all());

        if (request()->query->get('sub')) {
            request()->query->set('parent_id', request()->query->get('sub'));
            $subList = $this->shipmentRepository->searchFromRequest(request())->get();

            return View::make('admin.shipments.index', ['list' => $list, 'subList'=> $subList, 'parent_id' => request()->query->get('sub')]);
        }

        return View::make('admin.shipments.index', ['list' => $list, 'parent_id' => request()->query->get('sub')]);
    }

    public function create()
    {
        $locations = Location::where('active', true)->whereIsLeaf()->get();
        $days = (old('recurring') != RecurringTypes::MONTHLY) || (old('recurring') == RecurringTypes::WEEKLY) ? 7 : 31;
        request()->query->set('active', 1);
        $vehicles = $this->VehicleRepository->search(request())->get();

        request()->query->set('type', UserTypes::DELIVERY_PERSONAL);
        $drivers = $this->userRepository->search(request())->get();

        $shipments = Shipment::where('active', true)->get();
        $branches = Branch::where('active',1)->where('type', '!=', BranchTypes::RETAILER)->get();

        $cities = Location::where('active', true)->where('parent_id', null)->get();
        $regions = [];
        if (old('city_id')) {
            $regions = Location::where('active', true)->where('parent_id', old('city_id'))->get();
        }
        $districts = [];
        if (old('region_id')) {
            $districts = Location::where('active', true)->where('parent_id', old('region_id'))->get();
        }


        return View::make('admin.shipments.create', ['shipments' => $shipments, 'days' => $days, 'locations' => $locations, 'parent_id' => request()->query->get('sub'),'vehicles' => $vehicles, 'drivers' => $drivers, 'branches' => $branches, 'cities'=>$cities, 'regions'=>$regions, 'districts'=>$districts]);
    }

    public function store(ShipmentRequest $request)
    {
        if (is_string($this->shipmentService->fillFromRequest($request))) {
            return back()->with('danger', $this->shipmentService->fillFromRequest($request));
        }

        return redirect(route('admin.shipments.index') . '?sub=' . $request->input('parent_id'))
            ->with('success', trans('item_added_successfully'));
    }

    public function edit(Shipment $shipment)
    {
        $locations = Location::where('active', true)->whereIsLeaf()->get();
        request()->query->set('active', 1);
        $vehicles = $this->VehicleRepository->search(request())->get();

        request()->query->set('type', UserTypes::DELIVERY_PERSONAL);
        $drivers = $this->userRepository->search(request())->get();

        $shipments = Shipment::where('active', true)->get();
        $branches = Branch::where('active',1)->where('type', '!=', BranchTypes::RETAILER)->get();

        $cities = Location::where('active', true)->where('parent_id', null)->get();
        $regions = [];
        if (old('city_id')) {
            $regions = Location::where('active', true)->where('parent_id', old('city_id'))->get();
        }
        $districts = [];
        if (old('region_id')) {
            $districts = Location::where('active', true)->where('parent_id', old('region_id'))->get();
        }

        if ($shipment->one_delivery_address_id){
            $selectedCity = '';
            $one_delivery_address_id = Address::find($shipment->one_delivery_address_id)->location_id;

            if (Location::find(Location::find($one_delivery_address_id)->parent_id)) {
                $selectedCity = Location::find(Location::find($one_delivery_address_id)->parent_id)->id;
                if (Location::find(Location::find($one_delivery_address_id)->parent_id)->parent_id) {
                    $selectedCity = Location::find(Location::find($one_delivery_address_id)->parent_id)->parent_id;
                }
            }

            $regions = [];
            if ($selectedCity) {
                $regions = Location::where('active', true)->where('parent_id', $selectedCity)->get();
            }

            $selectedRegion = Location::find($one_delivery_address_id)->parent_id == $selectedCity ? $selectedRegion = Location::find($one_delivery_address_id)->id:Location::find($one_delivery_address_id)->parent_id;

            $districts = [];
            if ($selectedRegion) {
                $districts = Location::where('active', true)->where('parent_id', $selectedRegion)->get();
            }
            $selectedDistrict = Location::find($one_delivery_address_id)->id;

            if (Location::find($one_delivery_address_id)->parent_id == $selectedCity) {
                $selectedRegion = Location::find($one_delivery_address_id)->id;
                $selectedDistrict = '';
            }
        }

        return view('admin.shipments.edit', ['shipment' => $shipment, 'shipments' => $shipments, 'locations' => $locations, 'parent_id' => request()->query->get('sub'),'vehicles' => $vehicles, 'drivers' => $drivers, 'branches' => $branches, 'cities'=>$cities, 'regions'=>$regions, 'districts'=>$districts, 'selectedCity' => @$selectedCity, 'selectedRegion' => @$selectedRegion, 'selectedDistrict' => @$selectedDistrict]);
    }

    public function update(ShipmentRequest $request, Shipment $shipment)
    {
        $this->shipmentService->fillFromRequest($request, $shipment);

        return redirect(route('admin.shipments.index') . '?sub=' . $request->input('parent_id'))
            ->with('success', trans('item_updated_successfully'));
    }

    public function destroy(Shipment $shipment)
    {
        $children = Shipment::where('parent_id', $shipment->id)->get();

        if (count($children)) {
            foreach ($children as $child) {
                $actualShipments = $this->actualShipmentRepository->getAvailableDeletedActualShipment($child);
                foreach ($actualShipments as $actualShipment) {
                    $actualShipment->delete();
                }
            }
        }

        $actualShipments = $this->actualShipmentRepository->getAvailableDeletedActualShipment($shipment);
        foreach ($actualShipments as $actualShipment) {
            $actualShipment->delete();
        }

        $shipment->delete();
        return redirect()->back()->with('success', trans('item_deleted_successfully'));
    }

    public function export()
    {
        return $this->shipmentService->export();
    }
}
