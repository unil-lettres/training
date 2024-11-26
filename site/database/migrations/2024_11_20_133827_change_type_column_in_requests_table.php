<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update existing data
        DB::table('requests')->get()->each(function ($record) {
            if ($record->type !== null && ! is_array(json_decode($record->type, true))) {
                DB::table('requests')
                    ->where('id', $record->id)
                    ->update([
                        'type' => json_encode([$record->type]),
                    ]);
            }
        });

        Schema::table('requests', function (Blueprint $table) {
            // Change the type column to JSON
            $table->json('type')
                ->nullable()
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No rollback
    }
};
