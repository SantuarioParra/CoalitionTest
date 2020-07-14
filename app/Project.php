<?php

namespace App;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes, SoftCascadeTrait;
    /**
     * Using soft deletes on cascade property
     */
    protected $softCascade = ['tasks'];

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
        'name'
    ];

    /**
     * Relation one to many with Task
     */
    public function tasks(){
        return $this->hasMany('App\Task');
    }
}
