<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('performance_plan_sales_representative', function (Blueprint $table) {
            $table->id();
            $table->foreignId('performance_plan_id');
            $table->foreignId('representative__id');
            $table->timestamps();

            // Explicit short names — the auto-generated ones exceed MySQL's
            // 64-char identifier limit on this table/column name combo.
            $table->foreign('performance_plan_id', 'pp_sr_plan_fk')
                ->references('id')->on('performanceplans')
                ->onDelete('cascade');

            $table->foreign('representative__id', 'pp_sr_rep_fk')
                ->references('id')->on('sales__representatives')
                ->onDelete('cascade');

            $table->unique(['performance_plan_id', 'representative__id'], 'pp_sr_unique');
        });

        // Migrate existing single-rep data into the new pivot table before
        // the old column gets dropped, so no existing assignments are lost.
        $plans = DB::table('performanceplans')
            ->whereNotNull('representative__id')
            ->get(['id', 'representative__id']);

        $now = now();
        $rows = $plans->map(fn ($plan) => [
            'performance_plan_id' => $plan->id,
            'representative__id' => $plan->representative__id,
            'created_at' => $now,
            'updated_at' => $now,
        ])->toArray();

        if (!empty($rows)) {
            DB::table('performance_plan_sales_representative')->insert($rows);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('performance_plan_sales_representative');
    }
};