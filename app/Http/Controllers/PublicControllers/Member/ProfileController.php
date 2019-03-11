<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 08.03.19
 * Time: 14:47
 */

namespace Omega\Http\Controllers\PublicControllers\Member;


use Omega\Http\Controllers\PublicControllers\PublicController;

class ProfileController extends PublicController
{

    public function profile(){
        return page()
            ->withModule(
                module()
                    ->name(__('Member'))
                    ->subtitle(__('Profile'))
                    ->view('public.member.profile')
            )
            ->get();
    }
}