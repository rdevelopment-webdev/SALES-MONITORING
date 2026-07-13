<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_page_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('page_id');
            $table->string('permission_name')->nullable();

            // Nullable on purpose:
            // null  = no override, fall back to the user's role permission
            // true  = explicitly granted for this user
            // false = explicitly revoked for this user
            $table->boolean('can_create')->nullable()->default(null);
            $table->boolean('can_edit')->nullable()->default(null);
            $table->boolean('can_archive')->nullable()->default(null);
            $table->boolean('can_view')->nullable()->default(null);

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');

            // one override row per user per page
            $table->unique(['user_id', 'page_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_page_permissions');
    }
};
