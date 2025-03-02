<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('quotation_header_and_footers', function (Blueprint $table) {
            $table->id();
            $table->string('header_image')->default('pictures/BMT_Quotation_Ibabao_Estancia_Letter_Header.bmp');
            $table->string('footer_image')->default('pictures/BMT_Quotation_Letter_Footers.bmp');
            $table->timestamps();
        });

        // Insert default record
        DB::table('quotation_header_and_footers')->insert([
            'header_image' => 'pictures/BMT_Quotation_Ibabao_Estancia_Letter_Header.bmp',
            'footer_image' => 'pictures/BMT_Quotation_Letter_Footers.bmp',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('quotation_header_and_footers');
    }
};
