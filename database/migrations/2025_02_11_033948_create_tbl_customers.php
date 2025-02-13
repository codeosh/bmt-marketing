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
        Schema::create('tbl_customers', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('nos')->unique(); // Defines a UNIQUE column
            $table->string('customer_name'); // i use _  for clarity bitaw
            $table->string('address');
            $table->string('contact', 20); //`long` is invalid, 20 chars for phone numbers
            $table->timestamps(); // Recommended for tracking record creation/update
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_customers');
    }
};
