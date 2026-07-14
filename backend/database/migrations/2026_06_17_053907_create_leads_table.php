<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            // Add the missing industry_id column + FK used by the controller
            if (!Schema::hasColumn('leads', 'industry_id')) {
                $table->unsignedBigInteger('industry_id')->nullable()->after('user_id');
                $table->foreign('industry_id')->references('id')->on('industries')->onDelete('cascade');
            }
        });

        Schema::table('leads', function (Blueprint $table) {
            // Rename status_percentage -> status_percent so it matches the
            // model's $fillable and the controller's validation rules
            if (Schema::hasColumn('leads', 'status_percentage') && !Schema::hasColumn('leads', 'status_percent')) {
                $table->renameColumn('status_percentage', 'status_percent');
            }
        });

        Schema::table('leads', function (Blueprint $table) {
            // Relax NOT NULL constraints to match the frontend, where only
            // Location is a hard-required field (Contact person / Contact
            // number are also being relaxed per request)
            $table->string('business_name')->nullable()->change();
            $table->string('service_name')->nullable()->change();
            $table->string('contact_person')->nullable()->change();
            $table->string('contact_number')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropForeign(['industry_id']);
            $table->dropColumn('industry_id');
        });

        Schema::table('leads', function (Blueprint $table) {
            if (Schema::hasColumn('leads', 'status_percent')) {
                $table->renameColumn('status_percent', 'status_percentage');
            }
        });

        Schema::table('leads', function (Blueprint $table) {
            $table->string('business_name')->nullable(false)->change();
            $table->string('service_name')->nullable(false)->change();
            $table->string('contact_person')->nullable(false)->change();
            $table->string('contact_number')->nullable(false)->change();
        });
    }
};