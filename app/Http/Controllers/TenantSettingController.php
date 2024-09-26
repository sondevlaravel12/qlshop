<?php

namespace App\Http\Controllers;

use App\Models\TenantSetting;
use Illuminate\Http\Request;

class TenantSettingController extends Controller
{
    public function edit()
    {
        $settings = TenantSetting::all()->keyBy('key'); // Lấy tất cả cài đặt và nhóm theo key
        // Trả về view với các giá trị tùy chỉnh hiện tại hoặc giá trị mặc định
        return view('tenant.settings.edit', compact('settings'));
    }
    public function update(Request $request)
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




        return redirect()->route('tenant.settings.edit')->with('success', 'Cài đặt đã được cập nhật!');
    }
}
