<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
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
	protected $table = 'tasks';

	/**
	 * Return modifications relationship.
	 *
	 */
    public function modifications()
    {
        return $this->hasMany('App\Modification', 'task_id', 'id');
    }
}
