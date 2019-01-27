<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Modification extends Model
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
	protected $table = 'modifications';

	/**
	 * Return modifiable relationship.
	 *
	 */
    public function modifiable()
    {
    	if ($this->modifiable_type == 'App\Todo')
        	return $this->belongsTo('App\Todo', 'modifiable_id', 'id');

        return $this->belongsTo('App\Task', 'modifiable_id', 'id');
    }

    /**
	 * Return performer relationship.
	 *
	 */
    public function performer()
    {
        return $this->belongsTo('App\User', 'performer_id', 'id');
    }
}
