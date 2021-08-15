<?php

namespace App\Http\Services;


use App\Models\Setting;
use Illuminate\Http\Request;

class SettingService
{
    public function fillFromRequest(Request $request, $setting = null)
    {
        if (!$setting) {
            $setting = new Setting();
        }

        $setting->fill($request->all());
        $setting->active= $request->request->get('active', 0);
        $setting->save();

        return $setting;
    }
}
