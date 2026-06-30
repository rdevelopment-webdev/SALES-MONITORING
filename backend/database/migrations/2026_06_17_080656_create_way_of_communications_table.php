<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ways_of_communication', function (Blueprint $table) {
            $table->id();
            $table->string('communication_name')->unique();
            $table->timestamps();
        });
    }

    public function down(): void 
    {
        Schema::dropIfExists('ways_of_communication');
    }
};