<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Request extends Model
{
    use HasFactory;

    protected $table = 'requests';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'theme',
        'description',
        'deadline',
        'level',
        'applicants',
        'contact',
        'comments',
        'filling_date',
        'status_admin',
        'decision_date',
        'decision_comments',
        'file',
        'extras',
        'user_id',
        'status_id',
        'extras',
        'type',
        'contacts',
    ];

    protected function casts(): array
    {
        return [
            'extras' => 'array',
            'contacts' => 'array',
            'deadline' => 'datetime',
            'filling_date' => 'datetime',
            'decision_date' => 'datetime',
            'type' => 'array',
        ];
    }

    /**
     * Return cleaned description
     */
    public function cleanDescription(): string
    {
        return strip_tags($this->description);
    }

    /**
     * Return cleaned comments
     */
    public function cleanComments(): string
    {
        return strip_tags($this->comments);
    }

    /**
     * Get the status associated with the request.
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    /**
     * Get the user associated with the request.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The training objectives that belong to the request.
     */
    public function trainingObjectives(): BelongsToMany
    {
        return $this->belongsToMany(TrainingObjective::class, 'request_training_objective', 'request_id', 'training_objective_id');
    }

    /**
     * The analysis objectives that belong to the request.
     */
    public function analysisObjectives(): BelongsToMany
    {
        return $this->belongsToMany(AnalysisObjective::class, 'request_analysis_objective', 'request_id', 'analysis_objective_id');
    }

    /**
     * Get the orientation associated with the request.
     */
    public function orientation(): BelongsTo
    {
        return $this->belongsTo(Orientation::class);
    }

    /**
     * The training tools that belong to the request.
     */
    public function trainingTools(): BelongsToMany
    {
        return $this->belongsToMany(Tool::class, 'request_training_tool', 'request_id', 'training_tool_id');
    }

    /**
     * The technical action tools that belong to the request.
     */
    public function technicalActionTools(): BelongsToMany
    {
        return $this->belongsToMany(Tool::class, 'request_technical_action_tool', 'request_id', 'technical_action_tool_id');
    }

    /**
     * The fundings that belong to the request.
     */
    public function fundings(): BelongsToMany
    {
        return $this->belongsToMany(Funding::class, 'request_funding', 'request_id', 'funding_id');
    }
}
