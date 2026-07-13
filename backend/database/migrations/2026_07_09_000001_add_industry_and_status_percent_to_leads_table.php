<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            if (!Schema::hasColumn('leads', 'industry_id')) {
                $table->foreignId('industry_id')
                    ->nullable()
                    ->after('user_id')
                    ->constrained('industries')
                    ->nullOnDelete();
            }

            if (!Schema::hasColumn('leads', 'status_percent')) {
                $table->unsignedTinyInteger('status_percent')
                    ->default(0)
                    ->after('status_name');
            }
        });

        if (
            Schema::hasColumn('leads', 'status_percentage') &&
            Schema::hasColumn('leads', 'status_percent')
        ) {
            DB::table('leads')->update([
                'status_percent' => DB::raw('status_percentage'),
            ]);
        }
    }

    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            if (Schema::hasColumn('leads', 'industry_id')) {
                $table->dropConstrainedForeignId('industry_id');
            }

            if (Schema::hasColumn('leads', 'status_percent')) {
                $table->dropColumn('status_percent');
            }
        });
    }
};
