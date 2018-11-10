<?php
namespace OmegaPlugin\SocialLogo;

use Illuminate\Support\Facades\Validator;
use Omega\Models\Module;
use Omega\Repositories\ModuleRepository;
use Omega\Utils\Plugin\BController;

class BControllerSocialLogo extends  BController {

    /**
     * Rule to validate social netowrk field
     */
    const RULE = 'nullable';
    const RULE_TITLE = 'nullable|string';

    private $socialNetwork;
    private $moduleName;

    private $moduleRepository;

    public function __construct() {
        parent::__construct('social_logo');

        $this->moduleName = $this->name;
        $this->socialNetwork = json_decode(file_get_contents($this->root . DS . 'socialnetworklist.json'), true);
        $this->moduleRepository = new ModuleRepository(new Module());
    }

    public function install() {
        $this->moduleRepository->create($this->id, $this->moduleName);
        return true;
    }

    public function uninstall() {
        $this->moduleRepository->destroyByName($this->moduleName);
        return true;
    }

    public function index() {
        $module = $this->moduleRepository->getByName($this->moduleName);
        $param = isset($module) ? json_decode($module->param, true) : array();

        return $this->view('index')->with([
            'param' => $param,
            'title' => isset($param['title']) ? $param['title'] : '',
            'socialNetworks' => $this->socialNetwork
        ]);
    }

    public function save(){

        $request = request();
        $validator = Validator::make($request->all(), array_merge(['title' => self::RULE_TITLE], $this->getValidationRules()));

        if ($validator->fails()) {
            return $this->redirect('index')
                ->withErrors($validator)
                ->withInput();
        }

        $module = $this->moduleRepository->getByName($this->moduleName);
        $param = isset($module) ? json_decode($module->param, true) : array();

        foreach ($this->socialNetwork as $key => $sn) {
            if($request->has($key)){
                $param[$key] = $request->input($key);
            }
        }
        $param['title'] = $request->input('title');
        $this->moduleRepository->saveParam($module, $param);

        toast()->success(__('Saved'));
        return $this->redirect('index');
    }

    private function getValidationRules(){
        $rules = [];
        foreach ($this->socialNetwork as $key => $sn) {
            $rules[$key] = self::RULE;
        }
        return $rules;
    }
}