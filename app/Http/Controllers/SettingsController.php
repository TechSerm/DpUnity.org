<?php

namespace App\Http\Controllers;

use App\Enums\SettingEnum;
use App\Models\Setting;
use App\Services\Image\ImageService;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {

        return view('settings.index', [
            'generalSettingOptions' => Setting::general()->get(),
            'logoSettingOptions' => Setting::logo()->get(),
            'socialSettingOptions' => Setting::socialLink()->get(),
        ]);
    }


    public function update(Request $request)
    {
        $settingOptions = Setting::all();
        $settingValues = $request->all();



        foreach ($settingOptions as $settingOption) {
            if ($settingOption->key == SettingEnum::LOGO || $settingOption->key == SettingEnum::FAVICON) continue;

            $settingValue = $settingValues[$settingOption->key] ?? '';
            if ($settingValue != $settingOption->value) {
                $settingOption->update([
                    'value' => $settingValue
                ]);
            }
        }

        $this->createFile(SettingEnum::LOGO, $request, $settingOptions);
        $this->createFile(SettingEnum::FAVICON, $request, $settingOptions);
    }

    private function createFile($key, $request, $settingOptions) {
        if ($request->hasFile($key)) {
            $logoOption = $settingOptions->where('key', $key)->first();
            $image = $logoOption->image;
            $imageService = new ImageService($image);
            $image = $imageService->createAndReplace($key);

            if($image) {
                $logoOption->update([
                    'value' => $image->id
                ]);
            }
        }
    }
}
