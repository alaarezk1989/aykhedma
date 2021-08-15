<?php

namespace App\Http\Controllers\Api;

use App\Models\Address;
use App\Repositories\AddressRepository;
use Illuminate\Routing\Controller;
use App\Http\Requests\Api\UserAddressesRequest;
use App\Http\Services\UserService;
use Route;
use Symfony\Component\HttpFoundation\Request;

class AddressesController extends Controller
{
    protected $addressRepository;
    protected $userService;

    public function __construct(AddressRepository $addressRepository, UserService $userService)
    {
        $this->addressRepository = $addressRepository;
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        // TODO: Move to a new Custom Request
        if (Route::currentRouteName() == 'api.user.addresses.index') {
            $request->query->set('user', auth()->user()->id);
        }

        $list = $this->addressRepository->search($request)->get();

        return response()->json($list);
    }

    public function store(UserAddressesRequest $request)
    {
        $address = $this->userService->fillUserAddress($request);

        return response()->json($address);
    }

    public function destroy(Address $address)
    {
        $address->delete();
        
        return response([], 204);
    }
}
