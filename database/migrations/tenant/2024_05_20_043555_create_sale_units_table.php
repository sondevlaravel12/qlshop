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
        Schema::create('sale_units', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sale_unit_group_id')->unsigned()->nullable();
            $table->string('title');
            $table->timestamps();
            $table->foreign('sale_unit_group_id')
            ->references('id')
            ->on('sale_unit_groups')
            ->onDelete('cascade');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_units');
    }
};
