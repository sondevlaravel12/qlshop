<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Stancl\Tenancy\Database\Models\Tenant;

class TenantSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // error can not run , why?
    public function run(): void
    {
         // Lấy tất cả các tenant
         $tenants = Tenant::all();

         foreach ($tenants as $tenant) {
             // Chuyển đổi context sang tenant hiện tại
             tenancy()->initialize($tenant);

             // Thêm cài đặt cho từng tenant
             DB::table('tenant_settings')->insert([
                 ['key' => 'show_logo', 'value' => 'true'],
                 ['key' => 'show_phone', 'value' => 'true'],
                 ['key' => 'show_address', 'value' => 'true'],
                 ['key' => 'show_website', 'value' => 'true'],
             ]);
         }
    }
}
