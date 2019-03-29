<?php

namespace Omega\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

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
        return $this->belongsToMany('Omega\Models\Right', 'userrights', 'fkUser', 'fkRight');
    }

    public function groups(){
        return $this->belongsToMany('Omega\Models\Group', 'usergroups', 'fkUser', 'fkGroup');
    }

    public function getAvatarMedia(){
        if(isset($this->avatar)){
            return asset(Media::Get($this->avatar)->path);
        }
        return null;
    }

    public function displayName(){
        return isset($this->fullname) ? $this->fullname : $this->username;
    }

    /**
     * Check if the user has the given permission
     *
     * @param $ability string The name of the permission
     * @param bool $force Force to check in the database
     * @return bool|int
     */
    public function hasRight($ability, $force = false){
        // if force is true, then we check the perm from the database
        if($force) {
            DB::statement('CALL om_UserHasRight(:ability, :id, @hasRight);', [
                $ability,
                $this->id
            ]);
            $results = DB::select('SELECT @hasRight as hasRight');
            return boolval($results[0]->hasRight);
        }
        // else we check the perm in the session
        $rightMasks = session('perm.masks');
        $userMask = session('perm.umask');
        return $userMask & $rightMasks[$ability] == $rightMasks[$ability];
    }
}