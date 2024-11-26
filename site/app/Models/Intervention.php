<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Intervention extends Model
{
    use HasFactory;

    protected $table = 'interventions';

    protected $fillable = [
        'name',
    ];

    /**
     * The requests that belong to the intervention.
     */
    public function requests(): BelongsToMany
    {
        return $this->belongsToMany(Request::class, 'request_intervention', 'intervention_id', 'request_id');
    }
}
