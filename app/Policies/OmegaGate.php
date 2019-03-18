<?php
namespace Omega\Policies;

use Illuminate\Support\Facades\Gate;
use Omega\Models\User;

/**
 * Class OmegaGate
 * @package Omega\Policies
 */
class OmegaGate extends Gate
{

    /**
     * Define gates for Omega
     * @return \Illuminate\Contracts\Auth\Access\Gate|void
     */
    public static function define() {

        // if the authentified user is a super_admin we give him full access on the website
        parent::before(function ($user, $ability) {
            if ($user->hasRight('super_admin')) {
                return true;
            }
        });

        // then we define the gate
        parent::define('omega', 'Omega\Policies\OmegaPolicy@define');
    }

    /**
     * Return true if the current user has the given ability
     * @param string $ability
     * @return bool
     */
    public static function allows($ability) {
        return parent::allows('omega', $ability);
    }

    /**
     * Return true if the current user dont have the given ability
     * @param string $ability
     * @return bool
     */
    public static function denies($ability)
    {
        return parent::denies('omega', $ability);
    }

    /**
     * Return true if the given user has the given ability
     * @param $user User
     * @param $ability string
     * @return bool
     */
    public static function allowsForUser($user, $ability){
        return parent::forUser($user)->allows('omega', $ability);
    }

    /**
     * Return true if the given user dont have the given ability
     * @param $user User the user
     * @param $ability string
     * @return bool
     */
    public static function deniesForUser($user, $ability){
        return parent::forUser($user)->denies('omega', $ability);
    }

    /**
     * Redirct back tu user with a warning message.
     * @return \Illuminate\Http\RedirectResponse
     */
    public static function redirectBack(){
        toast()->warning(__('Access denied.'));
        return redirect()->route('admin.dashboard');
    }

    public static function jsonResponse(){
        return response()->json([
            'result' => false,
            'message' => __('Access denied...')
        ], 403);
    }

    /**
     * Displa a view to inform the user that he has no permission to see this page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public static function accessDeniedView(){
        return view('policy.accessdenied');
    }
}