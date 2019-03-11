<?php
namespace Omega\Http\Controllers\PublicControllers\Member;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Omega\Http\Controllers\PublicControllers\PublicController;
use Omega\Http\Requests\PublicRequests\Member\LoginRequest;
use Omega\Repositories\MemberRepository;

class LoginController extends PublicController
{
    private $memberRepository;

    public function __construct(MemberRepository $memberRepository)
    {
        parent::__construct();

        $this->memberRepository = $memberRepository;
    }

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

    public function doLogin(LoginRequest $request){

        $authSuccess = Auth::guard('member')->attempt($request->only(['username', 'password']));

        if($authSuccess){
            return redirect()->route('public.member.profile');
        }

        return redirect()
            ->back()
            ->withErrors([
                'member_auth_errors' => __('Invalid username or password')
            ]);
    }
}
