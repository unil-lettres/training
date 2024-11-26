<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AnalysisObjective extends Model
{
    use HasFactory;

    protected $table = 'analysis_objectives';

    protected $fillable = [
        'name',
    ];

    /**
     * The requests that belong to the analysis objective.
     */
    public function requests(): BelongsToMany
    {
        return $this->belongsToMany(Request::class, 'request_analysis_objective', 'analysis_objective_id', 'request_id');
    }
}
