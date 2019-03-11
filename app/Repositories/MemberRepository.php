<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 11.10.18
 * Time: 11:33
 */

namespace Omega\Repositories;


use Illuminate\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;
use Omega\Models\Member;

class MemberRepository
{
    private $member;

    public function __construct(Member $member) {
        $this->member = $member;
    }

    public function get($id){
        return $this->member->find($id);
    }

    public function getByRememberToken($id, $token){
        return $this->member
            ->where($this->member->getAuthIdentifierName(), $id)
            ->where($this->member->getRememberTokenName(), $token)
            ->first();
    }

    public function all(){
        return $this->member->get();
    }

    public function create($inputs){
        $member = new Member();
        $member->email = $inputs['email'];
        $member->username = $inputs['username'];
        $member->password = Hash::make($inputs['password']);
        $member->isValid = true;
        $member->isEnabled = true;
        $member->save();
        return $member;
    }

    public function update($member, $inputs){
        $member->email = $inputs['email'];
        $member->save();
        return $member;
    }

    public function updatePassword($member, $newPassword){
        $member->password = Hash::make($newPassword);
        $member->save();
        return $member;
    }

    /**
     * @param $member Authenticatable
     * @param $token
     * @return mixed
     */
    public function updateRememberToken($member, $token){
        $member->{$member->getRememberTokenName()} = $token;
        $member->save();
    }

    public function delete($id){
        return $this->member->destroy($id);
    }

    public function clearMembergroups($member){
        $member->membergroups()->detach();
    }

    public function attachMembers($member, $membergroups){
        if(isset($membergroups))
            foreach($membergroups as $membergroupId){
                $member->membergroups()->attach($membergroupId);
            }
    }


    public function findOrNull($username){
        return $this->member->where('username', $username)->first();
    }
}