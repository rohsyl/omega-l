<?php
namespace Omega\Repositories;

use Omega\Page;
use Omega\User;

class UserRepository{

    private $user;

    public function __construct(User $user) {

        $this->user = $user;
    }

    public function getById($id){
        return $this->user->where('id', $id)->first();
    }
}