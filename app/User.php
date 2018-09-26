<?php

namespace Omega;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'fullname', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function rights(){
        return $this->belongsToMany('Omega\Right', 'userrights', 'fkUser', 'fkRight');
    }

    public function groups(){
        return $this->belongsToMany('Omega\Group', 'usergroups', 'fkUser', 'fkGroup');
    }
}
