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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no')->uniqid();
            $table->integer('customer_id');

            $table->integer('subtotal');
            $table->integer('amount_off');
            $table->integer('percentage_off');
            $table->integer('subtotal_discounted');
            $table->integer('shipping');
            $table->integer('total');


            $table->string('status'); // should be enum
            $table->string('note');
            $table->date('date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
