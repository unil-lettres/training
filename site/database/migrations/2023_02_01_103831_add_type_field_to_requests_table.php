<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('requests', function (Blueprint $table) {
            // This migration was modified to avoid a mysql "row size too large" error.
            // Application state from commit ba32e8e to c34f43a should be avoided in production.
            $table->text('type')->nullable();
        });

        // Set existing data to "training" type
        DB::table('requests')
            ->update([
                'type' => 'training',
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
