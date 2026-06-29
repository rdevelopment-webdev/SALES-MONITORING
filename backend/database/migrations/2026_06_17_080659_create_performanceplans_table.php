<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('performanceplans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->date('date_recorded');
            $table->string('client_name');
            $table->foreignId('technique_id')->constrained('prospect_techniques')->onDelete('cascade');
            $table->string('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            $table->string('status');
            $table->decimal('percentage', 5, 2)->nullable();
            $table->string('area_input')->nullable();
            $table->foreignId('representative__id')->constrained('sales__representatives')->onDelete('cascade');
            $table->date('onboarding_date')->nullable();
            $table->text('remarks')->nullable();
            $table->string('contact_name');
            $table->string('contact_number');
            $table->foreignId('communication_id')->constrained('ways_of_communication')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('performanceplans');
    }
};