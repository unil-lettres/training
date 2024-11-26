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
        Schema::create('request_intervention', function (Blueprint $table) {
            $table->foreignId('request_id');
            $table->foreignId('intervention_id');
            $table->primary([
                'request_id',
                'intervention_id',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_intervention');
    }
};
