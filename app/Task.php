<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    /**
     * Using soft deletes property
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'priority', 'project_id'
    ];

    /**
     * Relation many to one with Project
     */
    public function project(){
        return $this->belongsTo('App\Project');
    }
}
