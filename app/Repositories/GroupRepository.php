<?php
namespace Omega\Repositories;

use Omega\Group;

class GroupRepository{

    private $group;

    public function __construct(Group $group) {

        $this->group = $group;
    }

    public function all(){
        return $this->group->get();
    }

}