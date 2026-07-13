<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * FINAL pass: makes every field nullable EXCEPT the three that are
 * actually required — contact_person, contact_number, location.
 *
 * This consolidates every prior partial fix (business_name, job_position,
 * email, service_name, remarks) into one migration so there's no more
 * "fix one field, hit the next NOT NULL error" cycle.
 *
 * Requires doctrine/dbal for column ->change():
 *   composer require doctrine/dbal
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            // Optional — nullable
            $table->string('business_name')->nullable()->change();
            $table->string('job_position')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('service_name')->nullable()->change();
            $table->text('remarks')->nullable()->change();

            // Required — enforced NOT NULL
            $table->string('contact_person')->nullable(false)->change();
            $table->string('contact_number', 20)->nullable(false)->change();
            $table->string('location')->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->string('business_name')->nullable(false)->change();
            $table->string('job_position')->nullable(false)->change();
            $table->string('email')->nullable(false)->change();
            $table->string('service_name')->nullable(false)->change();
            $table->text('remarks')->nullable(false)->change();
        });
    }
};
