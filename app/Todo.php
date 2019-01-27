<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Todo extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'todos';

	/**
	 * Return tasks relationship.
	 *
	 */
    public function tasks()
    {
        return $this->hasMany('App\Task', 'todo_id', 'id');
    }

    /**
	 * Return modifications relationship.
	 *
	 */
    public function modifications()
    {
        return $this->hasManyThrough('App\Modification', 'App\Task', 'todo_id', 'modifiable_id', 'id', 'id');
    }
}
