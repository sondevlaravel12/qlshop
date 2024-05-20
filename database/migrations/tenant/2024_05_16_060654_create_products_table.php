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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('SKU');
            $table->string('name');
            $table->string('slug')->nullable();
            $table->integer('price')->nullable();
            $table->integer('original_price')->nullable();
            $table->string('sale_unit')->nullable();
            $table->bigInteger('parent_id')->unsigned()->nullable();
            $table->text('description')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('parent_id')
            ->references('id')
            ->on('products')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
