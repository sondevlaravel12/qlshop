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
        Schema::create('webinfos', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('title')->nullable();
            $table->string('keyword')->nullable();
            $table->string('description')->nullable();
            $table->string('logo')->nullable();
            $table->string('icon')->nullable();
            $table->longText('google_map')->nullable();
            $table->string('email')->nullable();
            $table->string('email2')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone2')->nullable();
            $table->text('phonebase')->nullable();
            $table->string('address')->nullable();
            $table->string('address_2')->nullable();
            $table->string('website')->nullable();
            $table->string('zalo_url')->nullable();
            $table->string('facebook_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('webinfos');
    }
};
