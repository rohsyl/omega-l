<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 08.03.19
 * Time: 15:10
 */

namespace Omega\Http\Controllers\PublicControllers\Member;


use Illuminate\Support\Facades\Auth;
use Omega\Http\Controllers\PublicControllers\PublicController;

class LogoutController extends PublicController
{
    public function logout(){
        Auth::guard('member')->logout();
        return redirect()->route('public.member.login');
    }
}