<?php

namespace App\Http\Controllers\Api;

use App\Repositories\BannerRepository;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Request;

class BannersController extends Controller
{

    private $bannerRepository;


    /**
     * BannersController constructor.
     * @param BannerRepository $bannerRepository
     */
    public function __construct(BannerRepository $bannerRepository)
    {
        $this->bannerRepository = $bannerRepository;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $list = $this->bannerRepository->getActiveBanners($request)->paginate(10);
        return response()->json($list);
    }

}
