<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('performanceplans', function (Blueprint $table) {
            $table->dropForeign(['representative__id']);
            $table->dropColumn('representative__id');
        });
    }

    public function down(): void
    {
        Schema::table('performanceplans', function (Blueprint $table) {
            $table->foreignId('representative__id')
                ->nullable()
                ->constrained('sales__representatives')
                ->onDelete('cascade');
        });
    }
};