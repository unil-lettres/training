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
        Schema::create('request_analysis_objective', function (Blueprint $table) {
            $table->foreignId('request_id');
            $table->foreignId('analysis_objective_id');
            $table->primary([
                'request_id',
                'analysis_objective_id'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_analysis_objective');
    }
};
