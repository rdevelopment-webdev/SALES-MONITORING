<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['users', 'sales_task', 'performanceplans', 'leads', 'industries'] as $tableName) {
            if (!Schema::hasColumn($tableName, 'archived_at')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->timestamp('archived_at')->nullable()->after('updated_at');
                });
            }
        }
    }

    public function down(): void
    {
        foreach (['users', 'sales_task', 'performanceplans', 'leads', 'industries'] as $tableName) {
            if (Schema::hasColumn($tableName, 'archived_at')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->dropColumn('archived_at');
                });
            }
        }
    }
};  