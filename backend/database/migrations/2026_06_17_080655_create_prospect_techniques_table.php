<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prospect_techniques', function (Blueprint $table) {  // FIX: single underscore
            $table->id();
            $table->string('technique_name')->unique();
            $table->timestamps();
        });
    }

    public function down(): void 
    {
        Schema::dropIfExists('prospect_techniques');  // FIX: single underscore
    }
};