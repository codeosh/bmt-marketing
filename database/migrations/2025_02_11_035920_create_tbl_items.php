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
        Schema::create('tbl_items', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->foreignId('customer_id') // Foreign Key Column
                ->constrained('tbl_customers') // References `id` in `tbl_customers`
                ->onDelete('cascade'); // If customer is deleted, delete related items

            $table->integer('quantity');
            $table->string('unit'); // Keep lowercase for consistency
            $table->string('item_name');
            $table->decimal('unit_price', 15, 2); // Large monetary values
            $table->decimal('line_amount', 15, 2);
            $table->string('attn')->nullable(); // Changed to `string` if it's a reference
            $table->timestamp('date')->nullable();
            $table->string('terms'); // Changed to `string` for payment terms
            $table->integer('quotation_no')->unique(); // Ensures unique quotation numbers

            $table->timestamps(); // Adds `created_at` and `updated_at`
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_items');
    }
};
