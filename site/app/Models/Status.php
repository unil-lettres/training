<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Status extends Model
{
    use HasFactory;

    protected $table = 'statuses';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = ['name'];

    /**
     * Get the requests for the status.
     */
    public function requests(): HasMany
    {
        return $this->hasMany(Request::class);
    }
}
