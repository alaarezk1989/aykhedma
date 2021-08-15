<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\FavouriteProductRequest;
use App\Http\Services\UserService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

class FavoritedProductsController extends Controller
{
    /**
     * @var UserService
     */
    private $userService;


    /**
     * FavouritesBranchProductsController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();

        $favourites = $user->favoritedProducts()->with("product");
        if ($request->has('branch')) {
            $favourites = $favourites->where('branch_id', $request->get('branch'));
        }

        return $favourites->paginate(10);
    }

    public function toggle(FavouriteProductRequest $request)
    {
        $this->userService->toggleFavouriteProduct($request);

        return response(['success' => true], Response::HTTP_CREATED);
    }
}
