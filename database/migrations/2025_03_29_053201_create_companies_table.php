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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('industry_group')->nullable();
            $table->string('company_name')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('password')->default('bmtx2025');
            $table->string('other_digi_contact_platform')->nullable();
            $table->string('terms_of_payment')->nullable();
            $table->string('contacted')->nullable();
            $table->string('to_recontact')->nullable();
            $table->string('to_email')->nullable();
            $table->string('to_propose')->nullable();
            $table->string('visited')->nullable();
            $table->string('ec_ordered1')->nullable();
            $table->string('problematic')->nullable();
            $table->string('acct_active')->nullable();
            $table->text('notes')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
