<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (
            !Schema::hasTable('industries') ||
            !Schema::hasTable('leads') ||
            !Schema::hasColumn('leads', 'industry_id')
        ) {
            return;
        }

        if (DB::table('industries')->count() !== 1) {
            return;
        }

        $industryId = DB::table('industries')->value('id');

        DB::table('leads')
            ->whereNull('industry_id')
            ->update(['industry_id' => $industryId]);
    }

    public function down(): void
    {
        //
    }
};
