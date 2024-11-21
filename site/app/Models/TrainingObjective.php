<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TrainingObjective extends Model
{
    use HasFactory;

    protected $table = 'training_objectives';

    protected $fillable = [
        'name',
    ];

    /**
     * The requests that belong to the training objective.
     */
    public function requests(): BelongsToMany
    {
        return $this->belongsToMany(Request::class, 'request_training_objective', 'training_objective_id', 'request_id');
    }
}
