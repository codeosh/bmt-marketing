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
        Schema::create('qoutotaion_terms_condtion_remarks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id') // Foreign Key Column
                ->constrained('tbl_customers') // References `id` in `tbl_customers`
                ->onDelete('cascade'); // If customer is deleted, delete related items

            $table->string('condition')->default('year'); // Condition: year
            $table->string('warranty')->default('5yrs'); // Warranty: 5yrs
            $table->string('vat')->default('major parts'); // VAT (12%): major parts
            $table->string('availability')->default('excluded'); // Availability: excluded
            $table->string('rd')->default('onstock'); // RD: onstock
            $table->string('price_effectivity')->default('1 Week'); // Price Effectivity: 1 Week
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qoutotaion_terms_condtion_remarks');
    }
};
