<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'category_id',
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
     * Get the category associated with the request.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
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
}
