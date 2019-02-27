<?php

namespace Omega\Http\Controllers;

use Illuminate\Http\Request;
use Omega\Http\Requests\Member\CreateMemberGroupRequest;
use Omega\Http\Requests\Member\CreateMemberRequest;
use Omega\Http\Requests\Member\UpdateMemberGroupRequest;
use Omega\Http\Requests\Member\UpdateMemberRequest;
use Omega\Http\Requests\Member\UpdatePasswordRequest;
use Omega\Policies\OmegaGate;
use Omega\Repositories\MembergroupRepository;
use Omega\Repositories\MemberRepository;

class MemberController extends AdminController
{
    private $membergroupRepository;
    private $memberRepository;

    public function __construct(MembergroupRepository $membergroupRepository, MemberRepository $memberRepository){
        parent::__construct();

        $this->membergroupRepository = $membergroupRepository;
        $this->memberRepository = $memberRepository;
    }

    public function index(){
        if(OmegaGate::denies('member_read') && OmegaGate::denies('membergroup_read'))
            return OmegaGate::accessDeniedView();

        return view('member.index')->with([
            'membergroups' => $this->membergroupRepository->all(),
            'members' => $this->memberRepository->all(),
        ]);
    }


    #region member
    public function member_add(){
        if(OmegaGate::denies('member_add'))
            return OmegaGate::accessDeniedView();

        return view('member.addmember');
    }

    public function member_create(CreateMemberRequest $request) {
        $this->memberRepository->create($request->all());

        toast()->success(__('Member created'));
        return redirect()->route('member.index');
    }

    public function member_edit($id){
        if(OmegaGate::denies('member_update'))
            return OmegaGate::accessDeniedView();

        $member = $this->memberRepository->get($id);

        return view('member.editmember')->with([
            'member' => $member,
            'membergroups' => $this->membergroupRepository->all(),
        ]);
    }

    public function member_update(UpdateMemberRequest $request, $id) {
        $member = $this->memberRepository->get($id);

        $this->memberRepository->update($member, $request->all());

        toast()->success(__('Member updated'));
        return redirect()->back();
    }

    public function member_edit_password($id) {
        if(OmegaGate::denies('member_update'))
            return OmegaGate::accessDeniedView();
        return view('member.editpassword')->with([
           'id' => $id
        ]);
    }

    public function member_update_password(UpdatePasswordRequest $request, $id) {
        $member = $this->memberRepository->get($id);
        $this->memberRepository->updatePassword($member, $request->input('password'));

        toast()->success(__('Member password changed'));
        return redirect()->route('member.editmember', ['id' => $id]);
    }

    public function member_delete($id, $confirm = null){
        if(OmegaGate::denies('member_delete'))
            return OmegaGate::accessDeniedView();

        if(isset($confirm) && $confirm){
            $this->memberRepository->delete($id);
            toast()->success(__('Member deleted'));
            return redirect()->route('member.index');
        }
        else{
            return view('member.deletemember')
                ->with(['id' => $id]);
        }
    }
    #endregion


    #region membergroup
    public function membergroup_add() {
        if(OmegaGate::denies('membergroup_add'))
            return OmegaGate::accessDeniedView();

        return view('member.addmembergroup');
    }

    public function membergroup_create(CreateMemberGroupRequest $request) {
        $this->membergroupRepository->create($request->all());

        toast()->success(__('Membergroup created'));
        return redirect()->route('member.index');
    }

    public function membergroup_edit($id) {
        if(OmegaGate::denies('membergroup_update'))
            return OmegaGate::accessDeniedView();

        $membergroup = $this->membergroupRepository->get($id);

        return view('member.editmembergroup')->with([
            'membergroup' => $membergroup,
            'members' => $this->memberRepository->all(),
        ]);
    }

    public function membergroup_update(UpdateMemberGroupRequest $request, $id) {
        $membergroup = $this->membergroupRepository->get($id);

        $this->membergroupRepository->clearMembers($membergroup);
        $this->membergroupRepository->attachMembers($membergroup, $request->input('members'));

        toast()->success(__('Membergroup updated'));
        return redirect()->back();
    }

    public function membergroup_delete($id, $confirm = null) {
        if(OmegaGate::denies('membergroup_delete'))
            return OmegaGate::accessDeniedView();

        if(isset($confirm) && $confirm){
            $this->membergroupRepository->delete($id);
            toast()->success(__('Membergroup deleted'));
            return redirect()->route('member.index');
        }
        else{
            return view('member.deletemembergroup')
                ->with(['id' => $id]);
        }
    }
    #endregion
}
