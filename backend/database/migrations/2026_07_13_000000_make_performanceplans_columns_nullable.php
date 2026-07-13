<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Columns that were previously required and now need to accept null,
     * matching the now-optional fields on the create form.
     */
    public function up(): void
    {
        Schema::table('performanceplans', function (Blueprint $table) {
            // Foreign-keyed columns need their constraint dropped before the
            // column itself can be modified, then re-added afterward.
            $table->dropForeign(['user_id']);
            $table->dropForeign(['technique_id']);
            $table->dropForeign(['service_id']);
            $table->dropForeign(['representative__id']);
            $table->dropForeign(['communication_id']);

            $table->foreignId('user_id')->nullable()->change();
            $table->date('date_recorded')->nullable()->change();
            $table->string('client_name')->nullable()->change();
            $table->foreignId('technique_id')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->foreignId('service_id')->nullable()->change();
            $table->string('status')->nullable()->change();
            $table->foreignId('representative__id')->nullable()->change();  // double underscore
            $table->string('contact_name')->nullable()->change();
            $table->string('contact_number')->nullable()->change();
            $table->foreignId('communication_id')->nullable()->change();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('technique_id')->references('id')->on('prospect_techniques')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->foreign('representative__id')->references('id')->on('sales__representatives')->onDelete('cascade');
            $table->foreign('communication_id')->references('id')->on('ways_of_communication')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('performanceplans', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['technique_id']);
            $table->dropForeign(['service_id']);
            $table->dropForeign(['representative__id']);
            $table->dropForeign(['communication_id']);

            $table->foreignId('user_id')->nullable(false)->change();
            $table->date('date_recorded')->nullable(false)->change();
            $table->string('client_name')->nullable(false)->change();
            $table->foreignId('technique_id')->nullable(false)->change();
            $table->string('email')->nullable(false)->change();
            $table->foreignId('service_id')->nullable(false)->change();
            $table->string('status')->nullable(false)->change();
            $table->foreignId('representative__id')->nullable(false)->change();  // double underscore
            $table->string('contact_name')->nullable(false)->change();
            $table->string('contact_number')->nullable(false)->change();
            $table->foreignId('communication_id')->nullable(false)->change();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('technique_id')->references('id')->on('prospect_techniques')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->foreign('representative__id')->references('id')->on('sales__representatives')->onDelete('cascade');
            $table->foreign('communication_id')->references('id')->on('ways_of_communication')->onDelete('cascade');
        });
    }
};
