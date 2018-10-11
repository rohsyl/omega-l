<?php

namespace Omega\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Omega\Http\Requests\User\ChangePasswordRequest;
use Omega\Http\Requests\User\CreateRequest;
use Omega\Http\Requests\User\UpdateRequest;
use Omega\Repositories\GroupRepository;
use Omega\Repositories\RightRepository;
use Omega\Repositories\UserRepository;

class UserController extends AdminController
{
    private $userRepository;
    private $groupRepository;
    private $rightRepository;

    public function __construct(UserRepository $userRepository, GroupRepository $groupRepository, RightRepository $rightRepository) {
        parent::__construct();
        $this->userRepository = $userRepository;
        $this->groupRepository = $groupRepository;
        $this->rightRepository = $rightRepository;
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
            ->with('displayUpdateButton', true); // TODO : has current user right to edit this user
    }

    public function index(){
        return view('user.index')->with([
           'users' => $this->userRepository->all()
        ]);
    }

    public function add(){
        return view('user.add')->with([
            'groups' => $this->groupRepository->all(),
            'rights' => $this->rightRepository->all()
        ]);
    }

    public function create(CreateRequest $request){

        $user = $this->userRepository->create($request->all());

        $this->userRepository->clearRights($user);
        $this->userRepository->clearGroups($user);

        $this->userRepository->attachRights($user, $request->input('rights'));
        $this->userRepository->attachGroups($user, $request->input('groups'));

        toast()->success(__('User created'));
        return redirect()->route('user.index');
    }

    public function edit($id){
        $user = $this->userRepository->getById($id);

        return view('user.edit')->with([
            'user' => $user,
            'groups' => $this->groupRepository->all(),
            'rights' => $this->rightRepository->all()
        ]);
    }

    public function update(UpdateRequest $request, $id){
        $user = $this->userRepository->getById($id);
        $user = $this->userRepository->update($user, $request->all());

        $this->userRepository->clearRights($user);
        $this->userRepository->clearGroups($user);
        $this->userRepository->attachRights($user, $request->input('rights'));
        $this->userRepository->attachGroups($user, $request->input('groups'));

        toast()->success(__('User updated'));
        return redirect()->route('user.edit', ['id' => $id]);
    }

    public function editPassword($id){
        $user = $this->userRepository->getById($id);

        return view('user.editPassword')->with([
            'user' => $user
        ]);
    }

    public function updatePassword(ChangePasswordRequest $request, $id){

        $user = $this->userRepository->getById($id);
        $user = $this->userRepository->changePassword($user, $request->all());
        toast()->success(__('Password changed !'));
        return redirect()->route('user.edit', ['id' => $id]);
    }

    public function delete($id, $confirm = false){
        if($confirm){
            $this->userRepository->delete($id);
            toast()->success(__('User deleted'));
            return redirect()->route('user.index');
        }
        else{
            return view('user.delete')
                ->with(['id' => $id]);
        }
    }

    public function enable($id, $enable){
        $user = $this->userRepository->getById($id);
        $this->userRepository->enable($user, $enable);
        toast()->success($enable ? __('User enabled') : __('User disabled'));
        return redirect()->back();
    }
}
