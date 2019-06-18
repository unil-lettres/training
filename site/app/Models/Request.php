<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

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
      'status',
      'decision_date',
      'decision_comments',
      'file',
      'extras',
      'user_id',
      'type_id',
      'status_id',
      'extras'
    ];
    protected $fakeColumns = ['extras'];
    protected $casts = [
      'extras' => 'array',
    ];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * Get the type associated with the request.
     */
    public function type()
    {
        return $this->belongsTo('App\Models\Type', 'id');
    }

    /**
     * Get the status associated with the request.
     */
    public function status()
    {
        return $this->belongsTo('App\Models\Status', 'id');
    }

    /**
     * Get the user associated with the request.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\BackpackUser', 'id');
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

    public function setFileAttribute($value)
    {
        $attribute_name = "file";
        $disk = "uploads";
        $destination_path = "uploads";

        $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);
    }
}
