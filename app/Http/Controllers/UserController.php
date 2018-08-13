<?php

namespace Omega\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Omega\Repositories\UserRepository;

class UserController extends AdminController
{

    private $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }


    public function profile($id = null){

        if(isset($id)){
            $user = $this->userRepository->getById($id);
        }
        else{
            $user = Auth::user();
        }

        return view('user.profile')
            ->with('user', $user)
            ->with('displayUpdateButton', true);
    }
}
