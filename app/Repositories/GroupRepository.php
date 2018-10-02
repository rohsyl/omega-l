<?php
namespace Omega\Repositories;

use Omega\Group;

class GroupRepository{

    private $group;

    public function __construct(Group $group) {

        $this->group = $group;
    }
    public function getById($id){
        return $this->group->find($id);
    }

    public function all(){
        return $this->group->get();
    }

    public function delete($id){
        return $this->group->destroy($id);
    }

    public function create($inputs){
        $group = new Group();
        $group->name = $inputs['name'];
        $group->description = $inputs['description'];
        $group->isSystem = false;
        $group->isEnabled = true;
        $group->save();
        return $group;
    }

    public function update($user, $inputs){
        $user->name = $inputs['name'];
        $user->description = $inputs['description'];
        $user->save();
        return $user;
    }


    public function enable($group, $enable){
        $group->isEnabled = $enable;
        $group->save();
        return $group;
    }

    public function clearRights($group){
        $group->rights()->detach();
    }

    public function attachRights($group, $rights){
        if(isset($rights))
            foreach($rights as $rightId){
                $group->rights()->attach($rightId);
            }
    }
    public function clearUsers($group){
        $group->users()->detach();
    }

    public function attachUsers($group, $users){
        if(isset($users))
            foreach($users as $userId){
                $group->users()->attach($userId);
            }
    }

}