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
        Schema::create('archive', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lead_id');
            $table->unsignedBigInteger('log_id');
            $table->unsignedBigInteger('performance_id');
            $table->unsignedBigInteger('task_id');
            $table->string('service_name');
            $table->string('status_name');

            $table->timestamps();

            $table->foreign('lead_id')->references('id')->on('leads')->onDelete('cascade');
            $table->foreign('log_id')->references('id')->on('audit_logs')->onDelete('cascade');
            $table->foreign('performance_id')->references('id')->on('performanceplans')->onDelete('cascade');
            $table->foreign('task_id')->references('id')->on('sales_task')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archive');
    }
};
