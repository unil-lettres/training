<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;

    protected $table = 'trainings';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'description',
        'start',
        'end',
        'visible',
    ];

    protected function casts(): array
    {
        return [
            'visible' => 'boolean',
            'start' => 'datetime',
            'end' => 'datetime',
        ];
    }
}
