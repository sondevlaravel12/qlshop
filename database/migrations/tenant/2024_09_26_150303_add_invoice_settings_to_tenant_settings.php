<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Thêm các cài đặt hiển thị hóa đơn
        DB::table('tenant_settings')->insert([
            ['key' => 'show_logo', 'value' => 'true'],
            ['key' => 'show_phone', 'value' => 'true'],
            ['key' => 'show_address', 'value' => 'true'],
            ['key' => 'show_website', 'value' => 'true'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Xóa các cài đặt nếu cần
        DB::table('tenant_settings')->where('key', 'show_logo')->delete();
        DB::table('tenant_settings')->where('key', 'show_phone')->delete();
        DB::table('tenant_settings')->where('key', 'show_address')->delete();
        DB::table('tenant_settings')->where('key', 'show_website')->delete();
    }
};
