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
        Schema::create('invoice_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id');
            $table->string('product_id');
            $table->integer('quantity');
            $table->integer('unit_price')->nullable();
            $table->integer('amount_off')->nullable();
            $table->integer('percentage_off')->nullable();

            $table->integer('selling_price');
            $table->integer('line_total');
            $table->timestamps();
            $table->date('date')->nullable();
            $table->string('status')->nullable();

            $table->foreign('invoice_id')
            ->references('id')
            ->on('invoices')
            ->onDelete('cascade');
            // no need set foreignkey for customer right now
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_details');
    }
};
