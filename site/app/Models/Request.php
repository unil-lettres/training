<?php

namespace App\Models;

use App\User;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Request extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'requests';

    protected $primaryKey = 'id';

    public $timestamps = true;

    // protected $guarded = ['id'];

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

    protected $fakeColumns = ['extras'];

    // protected $hidden = [];

    public static $status = [
        'new' => 'Nouveau',
        'pending' => 'En attente',
        'resolved' => 'Résolue',
    ];

    public static $type = [
        'training' => 'Formation',
        'analysis' => 'Analyse',
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

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
     *
     * @return string
     */
    public function cleanDescription()
    {
        return strip_tags($this->description);
    }

    /**
     * Return cleaned comments
     *
     * @return string
     */
    public function cleanComments()
    {
        return strip_tags($this->comments);
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

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

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
