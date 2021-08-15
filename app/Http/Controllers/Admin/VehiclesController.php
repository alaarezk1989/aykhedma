<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\VehicleRequest;
use App\Http\Services\VehicleService;
use App\Repositories\VehicleRepository;
use App\Repositories\ShippingCompanyRepository;
use App\Repositories\UserRepository;
use App\Constants\UserTypes as UserTypes;
use App\Models\Vehicle;
use App\Models\User;
use App\Models\Location;
use App\Constants\VehicleTypes ;
use App\Constants\VehicleStatus;
use Illuminate\Routing\Controller;
use View;

class VehiclesController extends BaseController
{
    protected $vehicleService;
    protected $VehicleRepository;
    protected $shippingCompanyRepository;
    protected $userRepository;


    public function __construct(VehicleService $vehicleService, VehicleRepository $VehicleRepository, ShippingCompanyRepository $shippingCompanyRepository, UserRepository $userRepository)
    {
        $this->authorizeResource(Vehicle::class, "vehicle");
        $this->vehicleService = $vehicleService;
        $this->VehicleRepository = $VehicleRepository;
        $this->shippingCompanyRepository = $shippingCompanyRepository;
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $this->authorize("index", Vehicle::class);
        $drivers = Vehicle::get('driver_id');
        $types = VehicleTypes::getList();
        $status = VehicleStatus::getList();
        $list = $this->VehicleRepository->search(request())->paginate(10);
        $list->appends(request()->all());
        return View::make('admin.vehicles.index', ['list' => $list, 'types' => $types, 'drivers' => $drivers, 'status' => $status]);
    }


    public function create()
    {
        request()->query->set('active', 1);
        request()->query->set('type', UserTypes::DRIVER);
        $locations = Location::orderBy('id', 'DESC')->get();
        $drivers = $this->userRepository->search(request())->get();

        $shippingCompanies = $this->shippingCompanyRepository->searchFromRequest(request())->get();

        return View::make('admin.vehicles.new', ['drivers'=>$drivers, 'locations'=>$locations, 'shippingCompanies' => $shippingCompanies]);
    }

    public function store(VehicleRequest $request)
    {
        $this->vehicleService->fillFromRequest($request);
        return redirect(route('admin.vehicles.index'))->with('success', trans('item_added_successfully'));
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return redirect()->back()->with('success', trans('item_deleted_successfully'));
    }


    public function edit(Vehicle $vehicle)
    {
        request()->query->set('active', 1);

        request()->query->set('type', UserTypes::DRIVER);

        $locations = Location::orderBy('id', 'DESC')->get();

        $drivers = $this->userRepository->search(request())->get();

        $shippingCompanies = $this->shippingCompanyRepository->searchFromRequest(request())->get();

        return View::make('admin.vehicles.edit', ['vehicle' => $vehicle, 'drivers'=>$drivers, 'locations'=>$locations, 'shippingCompanies' => $shippingCompanies]);
    }

    public function update(VehicleRequest $request, Vehicle $vehicle)
    {
        $this->vehicleService->fillFromRequest($request, $vehicle);
        return redirect(route('admin.vehicles.index'))->with('success', trans('item_updated_successfully'));
    }
}
