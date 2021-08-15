<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\SettingRequest;
use App\Http\Services\SettingService;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use View;

class SettingsController extends BaseController
{
    /**
     * @var SettingService
     */
    private $settingService;

    /**
     * SettingsController constructor.
     * @param SettingService $settingService
     */
    public function __construct(SettingService $settingService)
    {
        $this->authorizeResource(Setting::class, "setting");
        $this->settingService = $settingService;
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $this->authorize("index", Setting::class);
        $list = Setting::query()->paginate(10);
        return View::make("admin.settings.index", compact('list'));
    }

    /**
     * @param Setting $setting
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Setting $setting)
    {
        return View::make("admin.settings.edit", compact("setting"));
    }

    public function update(SettingRequest $request, Setting $setting)
    {
        $this->settingService->fillFromRequest($request, $setting);

        return redirect(route("admin.settings.index"))->with('success', trans('item_updated_successfully'));
    }
}
