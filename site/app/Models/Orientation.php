<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Orientation extends Model
{
    use HasFactory;

    protected $table = 'orientations';

    protected $fillable = [
        'name',
    ];

    /**
     * Get the requests for the orientation.
     */
    public function requests(): HasMany
    {
        return $this->hasMany(Request::class);
    }
}
