<?php
namespace OmegaPlugin\SocialLogo;

use Illuminate\Support\Facades\Validator;
use Omega\Models\Lang;
use Omega\Models\Module;
use Omega\Models\Page;
use Omega\Repositories\LangRepository;
use Omega\Repositories\ModuleRepository;
use Omega\Repositories\PageRepository;
use Omega\Utils\Plugin\BController;

class BControllerMultilanguePageReplicate extends  BController {

    private $pageRepository;
    private $langRepository;

    public function __construct() {
        parent::__construct('multilangue_page_replicate');

        $this->pageRepository = new PageRepository(new Page());
        $this->langRepository = new LangRepository(new Lang());
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