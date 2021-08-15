<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\UserAddressesRequest;
use App\Http\Services\UserService;
use App\Models\User;
use App\Models\Location;
use App\Models\Address;
use App\Repositories\UserRepository;
use Illuminate\Routing\Redirector as RedirectorAlias;
use View;
use Illuminate\Http\Request;

class UserAddressesController extends BaseController
{

    protected $userService;
    private $userRepository;

    public function __construct(UserService $userService, UserRepository $userRepository)
    {
        $this->authorizeResource(Address::class, "address");
        $this->userService = $userService;
        $this->userRepository = $userRepository;
    }

    public function index(User $user)
    {
        $this->authorize("index", Address::class);
        $list = $user->addresses;
        return View::make('admin.users.addresses.index', ['list' => $list, 'user' => $user]);
    }

    public function create(User $user)
    {
        $locations = Location::where('active', true)->where('parent_id', null)->get();
        $regions = [];
        if (old('city_id')) {
            $regions = Location::where('active', true)->where('parent_id', old('city_id'))->get();
        }
        $districts = [];
        if (old('region_id')) {
            $districts = Location::where('active', true)->where('parent_id', old('region_id'))->get();
        }

        return View::make('admin.users.addresses.new', ['user' => $user, 'locations' => $locations, 'regions' => $regions, 'districts' => $districts]);
    }
  
    public function store(UserAddressesRequest $request, User $user)
    {
        $this->userService->fillUserAddress($request);
        return redirect(route('admin.user.addresses.index', ['user' => $user->id]))
            ->with('success', trans('user_address_added_successfully'));
    }
    
    public function edit(User $user, Address $address)
    {
        $locations = Location::where('active', true)->where('parent_id', null)->get();
        $selectedCity = '';
        if (Location::find(Location::find($address->location_id)->parent_id)) {
            $selectedCity = Location::find(Location::find($address->location_id)->parent_id)->id;
            if (Location::find(Location::find($address->location_id)->parent_id)->parent_id) {
                $selectedCity = Location::find(Location::find($address->location_id)->parent_id)->parent_id;
            }
        }

        $regions = [];
        if ($selectedCity) {
            $regions = Location::where('active', true)->where('parent_id', $selectedCity)->get();
        }
        $selectedRegion = Location::find($address->location_id)->parent_id == $selectedCity ? $selectedRegion = Location::find($address->location_id)->id:Location::find($address->location_id)->parent_id;

        $districts = [];

        if ($selectedRegion) {
            $districts = Location::where('active', true)->where('parent_id', $selectedRegion)->get();
        }
        $selectedDistrict = Location::find($address->location_id)->id;

        if (Location::find($address->location_id)->parent_id == $selectedCity) {
            $selectedRegion = Location::find($address->location_id)->id;
            $selectedDistrict = '';
        }

        return View::make('admin.users.addresses.edit', ['address' => $address, 'locations' => $locations, 'regions' => $regions, 'districts' => $districts, 'selectedCity' => $selectedCity, 'selectedRegion' => $selectedRegion, 'selectedDistrict' => $selectedDistrict]);
    }

    public function update(UserAddressesRequest $request, User $user, Address $address)
    {
        $this->userService->fillUserAddress($request, $address);
        return redirect(route('admin.user.addresses.index', ['user' => $address->user_id]))
            ->with('success', trans('user_address_updated_successfully'));
    }

    public function destroy(User $user, Address $address)
    {
        $address->delete();
        return redirect()->back()->with('success', trans('user_address_deleted_successfully'));
    }
}
