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

            $table->integer('quantity')->nullable();
            $table->string('unit')->nullable(); // Keep lowercase for consistency
            $table->string('item_name')->nullable();
            $table->decimal('unit_price', 12, 2)->nullable(); // Large monetary values
            $table->decimal('line_amount', 12, 2)->nullable();
            $table->string('attn')->nullable(); // Changed to `string` if it's a reference
            $table->timestamp('date')->nullable();
            $table->string('terms')->nullable(); // Changed to `string` for payment terms
            $table->integer('quotation_no'); // Ensures unique quotation numbers

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
