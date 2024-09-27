<?php

namespace App\Http\Controllers;

use App\Models\TenantSetting;
use App\Models\Webinfo;
use Illuminate\Http\Request;

class TenantSettingController extends Controller
{
    public function editDisplaySettings()
    {
        $settings = TenantSetting::all()->keyBy('key'); // Lấy tất cả cài đặt và nhóm theo key
        // Trả về view với các giá trị tùy chỉnh hiện tại hoặc giá trị mặc định
        return view('tenant.settings.display_edit', compact('settings'));
    }
    public function updateDisplaySettings(Request $request)
    {
        $request->validate([
            'shipping_fee' => 'nullable|numeric',
        ]);

        // // Cập nhật logo
        // if ($request->hasFile('logo')) {
        //     $path = $request->file('logo')->store('logos', 'public');
        //     TenantSetting::updateOrCreate(['key' => 'logo'], ['value' => $path]);
        // }

        // Cập nhật phí giao hàng
        if ($request->filled('shipping_fee')) {
            TenantSetting::updateOrCreate(['key' => 'shipping_fee'], ['value' => $request->input('shipping_fee')]);
        }

        TenantSetting::updateOrCreate(['key' => 'show_logo'], ['value' => $request->input('show_logo')=='on'?'true':'false']);
        TenantSetting::updateOrCreate(['key' => 'show_phone'], ['value' => $request->input('show_phone')=='on'?'true':'false']);
        TenantSetting::updateOrCreate(['key' => 'show_address'], ['value' => $request->input('show_address')=='on'?'true':'false']);
        TenantSetting::updateOrCreate(['key' => 'show_website'], ['value' => $request->input('show_website')=='on'?'true':'false']);




        return redirect()->back()->with('success', 'Cài đặt đã được cập nhật!');
    }
    public function editInfo(){
        $tenantInfo = Webinfo::first();
        // dd($tenantInfo);

        return view('tenant.settings.info_edit', compact('tenantInfo'));
    }
    public function updateInfo(Request $request)
    {
        $request->validate([
            'address' => 'nullable|string|max:255',
            'phonebase' => 'nullable|string|max:20',
            'facebook_url' => 'nullable|url|max:255',
            // Thêm các trường thông tin khác tùy nhu cầu
        ]);

        $tenantInfo = Webinfo::first();

        if (!$tenantInfo) {
            $tenantInfo = new Webinfo();
        }

        $tenantInfo->address = $request->input('address');
        $tenantInfo->phonebase = $request->input('phonebase');
        $tenantInfo->facebook_url = $request->input('facebook_url');
        // Cập nhật các thông tin khác tùy nhu cầu

        // Cập nhật logo nếu có (nếu thông tin logo thuộc về thông tin tenant)
        if ($request->hasFile('logo')) {
            $tenantInfo->addMediaFromRequest('logo')
                       ->toMediaCollection('logo');
        }

        $tenantInfo->save();

        return redirect()->route('tenant.settings.info.edit')->with('success', 'Thông tin tenant đã được cập nhật!');
    }
}
