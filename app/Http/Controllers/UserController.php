<?php

namespace Omega\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Omega\Http\Requests\User\ChangePasswordRequest;
use Omega\Http\Requests\User\CreateRequest;
use Omega\Http\Requests\User\UpdateRequest;
use Omega\Models\Media;
use Omega\Policies\OmegaGate;
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
        if(OmegaGate::denies('user_read')) return OmegaGate::accessDeniedView();

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
        if(OmegaGate::denies('user_read')) return OmegaGate::accessDeniedView();

        return view('user.index')->with([
           'users' => $this->userRepository->all()
        ]);
    }

    public function add(){
        if(OmegaGate::denies('user_add')) return OmegaGate::accessDeniedView();

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
        if( OmegaGate::denies('user_update_data') &&
            OmegaGate::denies('user_update_himself') &&
            OmegaGate::denies('user_update_rights') &&
            OmegaGate::denies('user_update_group'))
            return OmegaGate::accessDeniedView();

        $user = $this->userRepository->getById($id);

        return view('user.edit')->with([
            'user' => $user,
            'groups' => $this->groupRepository->all(),
            'rights' => $this->rightRepository->all()
        ]);
    }

    public function update(UpdateRequest $request, $id){
        $user = $this->userRepository->getById($id);

        if(OmegaGate::allows('user_update_data') || OmegaGate::allows('user_update_himself')){
            $user = $this->userRepository->update($user, $request->all());
        }

        if(OmegaGate::allows('user_update_rights')) {
            $this->userRepository->clearRights($user);
            $this->userRepository->attachRights($user, $request->input('rights'));
        }

        if(OmegaGate::allows('user_update_group')) {
            $this->userRepository->clearGroups($user);
            $this->userRepository->attachGroups($user, $request->input('groups'));
        }

        toast()->success(__('User updated'));
        return redirect()->route('user.edit', ['id' => $id]);
    }

    public function editPassword($id){
        if( OmegaGate::denies('user_update_data') &&
            OmegaGate::denies('user_update_himself'))
            return OmegaGate::accessDeniedView();

        $user = $this->userRepository->getById($id);

        return view('user.editPassword')->with([
            'user' => $user
        ]);
    }

    public function updatePassword(ChangePasswordRequest $request, $id){

        $user = $this->userRepository->getById($id);
        $this->userRepository->changePassword($user, $request->all());

        toast()->success(__('Password changed !'));
        return redirect()->route('user.edit', ['id' => $id]);
    }

    public function delete($id, $confirm = false){
        if(OmegaGate::denies('user_delete'))
            return OmegaGate::accessDeniedView();

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
        if(OmegaGate::denies('user_disable'))
            return OmegaGate::redirectBack();

        $user = $this->userRepository->getById($id);
        $this->userRepository->enable($user, $enable);
        toast()->success($enable ? __('User enabled') : __('User disabled'));
        return redirect()->back();
    }

    public function saveAvatar($userId, $mediaId) {

        $result = false;
        $url = 'undefined';

        $user = $this->userRepository->getById($userId);
        $user->avatar = $mediaId;
        $result = $user->save();

        if($result) {
            $url = asset(Media::Get($mediaId)->path);
        }

        return response()->json([
            'result' => $result,
            'url' => $url,
        ]);
    }

    public function deleteAvatar($userId) {
        $user = $this->userRepository->getById($userId);
        $user->avatar = null;
        $result = $user->save();
        return response()->json([
            'result' => $result
        ]);
    }


    /*	public function saveAvatar(){

        $result = false;
        $url = 'undefined';
	    if( isset($_GET['userId']) && !empty($_GET['userId']) &&
            isset($_GET['mediaId']) && !empty($_GET['mediaId'])) {

            $idUser = $_GET['userId'];
            $idMedia = $_GET['mediaId'];

            $user = UserManager::GetUser($idUser);

            $user->userAvatar = $idMedia;

            $result = UserManager::Save($user);

            if($result){
                $media = new Media($idMedia);
                $url = Url::CombAndAbs(ABSPATH, $media->path);
            }
        }

        $this->view->Set('url', $url);
        $this->view->Set('result', $result);
        return $this->view->RenderAjax();
    }

    public function deleteAvatar(){

        $result = false;
        if( isset($_GET['userId']) && !empty($_GET['userId'])) {

            $idUser = $_GET['userId'];

            $user = UserManager::GetUser($idUser);

            $user->userAvatar = null;

            $result = UserManager::Save($user);

        }
        $this->view->Set('result', $result);
        return $this->view->RenderAjax();
    }*/
}
