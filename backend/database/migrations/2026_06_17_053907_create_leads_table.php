<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('business_name');
            $table->string('contact_person');
            $table->string('job_position')->nullable();
            $table->string('contact_number');
            $table->string('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('service_name');
            $table->string('status_name');
            $table->text('remarks')->nullable();   // ✅ fixed: one line, no ->change()
            $table->string('location');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};