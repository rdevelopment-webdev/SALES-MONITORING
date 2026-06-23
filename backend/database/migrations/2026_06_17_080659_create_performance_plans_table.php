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
        Schema::create('performanceplans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('date_recorded');
            $table->string('client_name');
            $table->string('technique_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('service_name');
            $table->string('status(percentage)');
            $table->string('area_input');
            $table->string('sales_representative');
            $table->string('onboarding_date');
            $table->string('remarks');
            $table->string('contact_name');
            $table->string('contact_number');
            $table->string('ways_of_communication');
            $table->timestamps();


            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performance_plans');
    }
};
