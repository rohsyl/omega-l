<?php

namespace Omega\Http\Controllers;

use Illuminate\Http\Request;
use Omega\Http\Requests\Group\CreateRequest;
use Omega\Http\Requests\Group\UpdateRequest;
use Omega\Repositories\GroupRepository;
use Omega\Repositories\RightRepository;
use Omega\Repositories\UserRepository;

class GroupController extends AdminController
{
    private $groupRepository;
    private $rightRepository;
    private $userRepository;

    public function __construct(GroupRepository $groupRepository, RightRepository $rightRepository, UserRepository $userRepository) {
        parent::__construct();
        $this->groupRepository = $groupRepository;
        $this->rightRepository = $rightRepository;
        $this->userRepository = $userRepository;
    }


    public function index(){
        return view('group.index')->with([
            'groups' => $this->groupRepository->all()
        ]);
    }

    public function add(){
        return view('group.add')->with([
            'users' => $this->userRepository->all(),
            'rights' => $this->rightRepository->all()
        ]);
    }

    public function create(CreateRequest $request){
        $group = $this->groupRepository->create($request->all());

        $this->groupRepository->clearRights($group);
        $this->groupRepository->clearUsers($group);
        $this->groupRepository->attachRights($group, $request->input('rights'));
        $this->groupRepository->attachUsers($group, $request->input('users'));

        toast()->success(__('Group created'));
        return redirect()->route('group.index');
    }


    public function edit($id){
        $group = $this->groupRepository->getById($id);

        return view('group.edit')->with([
            'group' => $group,
            'users' => $this->userRepository->all(),
            'rights' => $this->rightRepository->all()
        ]);
    }

    public function update(UpdateRequest $request, $id){
        $group = $this->groupRepository->getById($id);
        $group = $this->groupRepository->update($group, $request->all());

        $this->groupRepository->clearRights($group);
        $this->groupRepository->clearUsers($group);
        $this->groupRepository->attachRights($group, $request->input('rights'));
        $this->groupRepository->attachUsers($group, $request->input('users'));

        toast()->success(__('Group updated'));
        return redirect()->route('group.edit', ['id' => $id]);
    }


    public function delete($id, $confirm = false){
        if($confirm){
            $this->groupRepository->delete($id);
            toast()->success(__('Group deleted'));
            return redirect()->route('group.index');
        }
        else{
            return view('group.delete')
                ->with(['id' => $id]);
        }
    }


    public function enable($id, $enable){
        $goup = $this->groupRepository->getById($id);
        $this->groupRepository->enable($goup, $enable);
        toast()->success($enable ? __('Group enabled') : __('Group disabled'));
        return redirect()->back();
    }
}
