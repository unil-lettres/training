<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // establish the table names
        $model_has_roles = config('permission.table_names.model_has_roles');
        $model_has_permissions = config('permission.table_names.model_has_permissions');

        // replace the BackpackUser model with User
        $this->replaceModels($model_has_roles);
        $this->replaceModels($model_has_permissions);

        // Replace guard names of the roles table
        $roles = config('permission.table_names.roles');
        DB::table($roles)
            ->where('guard_name', 'backpack')
            ->update([
                'guard_name' => 'web',
            ]);
    }

    public function replaceModels($table_name): void
    {
        Log::info('Replacing BackpackUser model in '.$table_name);

        // if you've ended up with duplicate entries (both for App\User and App\Models\BackpackUser)
        // we can just delete them
        $userEntries = DB::table($table_name)
            ->where('model_type', "App\User")
            ->get();

        foreach ($userEntries as $entry) {
            DB::table($table_name)
                ->where('role_id', $entry->role_id)
                ->where('model_type', 'App\Models\BackpackUser')
                ->where('model_id', $entry->model_id)
                ->delete();
        }

        // for the rest of them, we can just replace the BackpackUser model with User
        DB::table($table_name)
            ->where('model_type', "App\Models\BackpackUser")
            ->update([
                'model_type' => "App\User",
            ]);
    }
};
