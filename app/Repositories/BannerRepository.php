<?php

namespace App\Repositories;

use App\Constants\BannerTypes;
use App\Models\Banner;
use Symfony\Component\HttpFoundation\Request;

class BannerRepository
{
    public function search(Request $request)
    {
        $banners = Banner::with('branch')
            ->when($request->get('type'), function ($banners) use ($request) {
                return $banners->where('type', '=', $request->get('type'));
            })
            ->orderBy('id', 'DESC');

        return $banners;
    }

    public function getActiveBanners(Request $request)
    {
        $banners = Banner::where('active', '=', true)
            ->when($request->get('branch'), function ($banners) use ($request) {
                $banners->where('type', '=', $request->get('type', BannerTypes::BRANCH_BANNER));
                return $banners->where('branch_id', '=', $request->get('branch'));
            }, function ($banners) use ($request) {
                return $banners->where('type', '=', $request->get('type', BannerTypes::GLOBAL));
            })
            ->orderBy('id', 'DESC');

        return $banners;
    }
}
