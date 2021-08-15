<?php

namespace App\Http\Services;

use App\Models\Banner;
use Symfony\Component\HttpFoundation\Request;

class BannerService
{

    /**
     * @var UploaderService
     */
    private $uploaderService;

    /**
     * BannerService constructor.
     * @param UploaderService $uploaderService
     */
    public function __construct(UploaderService $uploaderService)
    {
        $this->uploaderService = $uploaderService;
    }

    /**
     * @param Request $request
     * @param null $banner
     * @return Banner|null
     */
    public function fillFromRequest(Request $request, $banner = null)
    {
        if (!$banner) {
            $banner = new Banner();
        }
        $banner->fill($request->all());
        if ($request->hasFile('image')) {
            $banner->image = $this->uploaderService->upload($request->file('image'), 'banners');
        }
        $banner->active = $request->input("active", 0);

        $banner->save();
        return $banner;
    }


}
