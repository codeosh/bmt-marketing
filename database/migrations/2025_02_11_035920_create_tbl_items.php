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
            $table->unsignedBigInteger('customer_id'); // Foreign Key Column

            $table->integer('quantity');
            $table->string('unit'); // Lowercase for consistency
            $table->string('item_name');
            $table->decimal('unit_price', 15, 2); // Large monetary values
            $table->decimal('line_amount', 15, 2);
            $table->integer('attn')->nullable(); // If necessary, provide a better column name
            $table->timestamp('date')->nullable();
            $table->date('terms'); // Ensure it's really a date
            $table->integer('quotation_no');

            // Foreign key constraint
            $table->foreign('customer_id')
                ->references('id')->on('tbl_customers') // Make sure this matches your customers table
                ->onDelete('cascade'); // If customer is deleted, delete related items

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
