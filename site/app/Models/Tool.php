<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tool extends Model
{
    use HasFactory;

    protected $table = 'tools';

    protected $fillable = [
        'name',
    ];

    /**
     * The requests that belong to the training tool.
     */
    public function trainingRequests(): BelongsToMany
    {
        return $this->belongsToMany(Request::class, 'request_training_tool', 'training_tool_id', 'request_id');
    }

    /**
     * The requests that belong to the technical action tool.
     */
    public function technicalActionRequests(): BelongsToMany
    {
        return $this->belongsToMany(Request::class, 'request_technical_action_tool', 'technical_action_tool_id', 'request_id');
    }
}
