<?php
namespace Omega\Repositories;

use Illuminate\Support\Facades\Hash;
use Omega\Page;
use Omega\User;

class UserRepository{

    private $user;

    public function __construct(User $user) {

        $this->user = $user;
    }

    public function getById($id){
        return $this->user->find($id);
    }

    public function all(){
        return $this->user->get();
    }

    public function delete($id){
        return $this->user->destroy($id);
    }

    public function canBeDeleted($id){
        if($this->user->count() == 1){
            return false;
        }

        return true;
    }

    public function create($inputs){
        $user = new User();
        $user->username = $inputs['username'];
        $user->email = $inputs['email'];
        $user->fullname = $inputs['fullname'];
        $user->password = Hash::make($inputs['password']);
        $user->save();
        return $user;
    }
    public function update($user, $inputs){
        $user->email = $inputs['email'];
        $user->fullname = $inputs['fullname'];
        $user->save();
        return $user;
    }

    public function changePassword($user, $inputs){
        $user->password = Hash::make($inputs['password']);
        $user->save();
        return $user;
    }

    public function enable($user, $enable){
        $user->isEnabled = $enable;
        $user->save();
        return $user;
    }

    public function clearRights($user){
        $user->rights()->detach();
    }

    public function attachRights($user, $rights){
        if(isset($rights))
            foreach($rights as $rightId){
                $user->rights()->attach($rightId);
            }
    }
    public function clearGroups($user){
        $user->groups()->detach();
    }

    public function attachGroups($user, $groups){
        if(isset($groups))
            foreach($groups as $groupId){
                $user->groups()->attach($groupId);
            }
    }
}