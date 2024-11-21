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
        Schema::table('requests', function (Blueprint $table) {
            // Drop existing foreign key constraints
            $table->dropForeign(['user_id']);
            $table->dropForeign(['status_id']);

            // Add new foreign key constraints with onDelete('set null')
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            $table->foreign('status_id')
                ->references('id')
                ->on('statuses')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('requests', function (Blueprint $table) {
            // Drop the modified foreign key constraints
            $table->dropForeign(['user_id']);
            $table->dropForeign(['status_id']);

            // Restore the original foreign key constraints
            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->foreign('status_id')
                ->references('id')
                ->on('statuses');
        });
    }
};
