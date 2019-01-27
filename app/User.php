<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Return person relationship.
     *
     */
    public function person()
    {
        return $this->belongsTo('App\Person', 'id', 'id');
    }

    /**
     * Return todos relationship.
     *
     */
    public function todos()
    {
        return $this->hasMany('App\Todo', 'creator_id', 'id');
    }
}
