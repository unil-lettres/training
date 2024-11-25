<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Funding extends Model
{
    use HasFactory;

    protected $table = 'fundings';

    protected $fillable = [
        'name',
    ];

    /**
     * The requests that belong to the funding.
     */
    public function requests(): BelongsToMany
    {
        return $this->belongsToMany(Request::class, 'request_funding', 'funding_id', 'request_id');
    }
}
