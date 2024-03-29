<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

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

    protected $casts = [
        'extras' => 'array',
        'contacts' => 'array',
        'deadline' => 'datetime',
        'filling_date' => 'datetime',
        'decision_date' => 'datetime',
    ];

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
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    /**
     * Get the status associated with the request.
     */
    public function status()
    {
        return $this->belongsTo('App\Models\Status');
    }

    /**
     * Get the user associated with the request.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
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
