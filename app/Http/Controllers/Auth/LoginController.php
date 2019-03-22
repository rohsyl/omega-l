<?php
namespace Omega\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Omega\Facades\OmegaConfig;
use Omega\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Override : force using the username for the login
     * @return string The name of the field to use for the authentication
     */
    public function username(){
        return 'username';
    }

    protected function credentials(Request $request) {
        return array_merge($request->only($this->username(), 'password'), ['isEnabled' => 1]);
    }


    protected function authenticated(Request $request, $user)
    {
        // When the user is authenticated, we will load in the session his permissions
        // We pre-load perm of the user in the session to prevent from doing many many
        // request to the database while check perm.
        OmegaConfig::loadUserPermissionsInSession($user);
    }
}
