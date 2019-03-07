<?php
namespace Omega\Http\Controllers\PublicControllers\Member;

use Illuminate\Http\Request;
use Omega\Http\Controllers\PublicControllers\PublicController;

class LoginController extends PublicController
{

    public function login(){




        return page()
            ->withModule(
                module()
                    ->name(__('Member'))
                    ->subtitle(__('Login'))
                    ->view('public.member.login')
            )
            ->get();
    }
}
