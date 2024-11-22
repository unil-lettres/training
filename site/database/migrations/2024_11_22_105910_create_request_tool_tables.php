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
        Schema::create('request_training_tool', function (Blueprint $table) {
            $table->foreignId('request_id');
            $table->foreignId('training_tool_id');
            $table->primary([
                'request_id',
                'training_tool_id',
            ]);
        });

        Schema::create('request_technical_action_tool', function (Blueprint $table) {
            $table->foreignId('request_id');
            $table->foreignId('technical_action_tool_id');
            $table->primary([
                'request_id',
                'technical_action_tool_id',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_training_tool');
        Schema::dropIfExists('request_technical_action_tool');
    }
};
