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
        // Migrate categories to objectives for the request model

        // Fetch all requests
        $requests = DB::table('requests')->get();

        foreach ($requests as $request) {
            // Fetch the category of the request
            $category = DB::table('categories')->where('id', $request->category_id)->first();

            if ($category) {
                if ($request->type === 'training') {
                    // Insert into training_objectives
                    $trainingObjective = DB::table('training_objectives')->where('name', $category->name)->first();

                    if (! $trainingObjective) {
                        $trainingObjectiveId = DB::table('training_objectives')->insertGetId([
                            'name' => $category->name,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    } else {
                        $trainingObjectiveId = $trainingObjective->id;
                    }

                    // Check if the pivot entry already exists
                    $exists = DB::table('request_training_objective')
                        ->where('request_id', $request->id)
                        ->where('training_objective_id', $trainingObjectiveId)
                        ->exists();

                    if (! $exists) {
                        // Insert into pivot table
                        DB::table('request_training_objective')->insert([
                            'request_id' => $request->id,
                            'training_objective_id' => $trainingObjectiveId,
                        ]);
                    }
                } elseif ($request->type === 'analysis') {
                    // Insert into analysis_objectives
                    $analysisObjective = DB::table('analysis_objectives')->where('name', $category->name)->first();

                    if (! $analysisObjective) {
                        $analysisObjectiveId = DB::table('analysis_objectives')->insertGetId([
                            'name' => $category->name,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    } else {
                        $analysisObjectiveId = $analysisObjective->id;
                    }

                    // Check if the pivot entry already exists
                    $exists = DB::table('request_analysis_objective')
                        ->where('request_id', $request->id)
                        ->where('analysis_objective_id', $analysisObjectiveId)
                        ->exists();

                    if (! $exists) {
                        // Insert into pivot table
                        DB::table('request_analysis_objective')->insert([
                            'request_id' => $request->id,
                            'analysis_objective_id' => $analysisObjectiveId,
                        ]);
                    }
                }
            }
        }

        // Remove category_id foreign key constraints from requests table
        Schema::table('requests', function (Blueprint $table) {
            $table->dropForeign(['type_id']);
        });

        // Drop category_id column from requests table
        Schema::table('requests', function (Blueprint $table) {
            $table->dropColumn('category_id');
        });

        // Delete categories table
        Schema::dropIfExists('categories');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No rollback
    }
};
