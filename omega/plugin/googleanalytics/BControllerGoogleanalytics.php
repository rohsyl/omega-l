<?php
namespace Omega\Plugin\Googleanalytics;

use Omega\Library\BLL\ModuleManager;
use Omega\Library\DTO\Module;
use Omega\Library\Plugin\BController;
use Omega\Library\Util\Form;
use Omega\Library\Util\Redirect;
use Omega\Library\Util\Message;

class BControllerGoogleanalytics extends  BController {

    private $moduleName;

    public function __construct() {
        parent::__construct('googleanalytics');

        $this->moduleName = "Google Analytics";
    }

    public function install() {
        if(!$this->isInstalled()) {
            parent::install();
            $module = new Module();
            $module->moduleName = $this->moduleName;
            $module->fkPlugin = $this->id;
            $module->moduleIsEnabled = true;
            $module->moduleParam = json_encode(array());
            $module->moduleOrder = 0;
            $module->isComponent = false;
            ModuleManager::Save($module);
        }
    }

    public  function uninstall() {
        if($this->isInstalled()) {
            $module = ModuleManager::GetModuleByName($this->moduleName);
            ModuleManager::Delete($module->id);
        }
    }

    public function index() {

        $module = ModuleManager::GetModuleByName($this->moduleName);
        $param = isset($module) ? json_decode($module->moduleParam, true) : array();


        $form = new Form('googleanalytics_form');
        if($form->isPosted()) {
            if($form->checkTokenInput()){

                $id = $form->getValue('id');

                if(!$this->isValidId($id)){
                    Message::error("Id is invalid...");
                    Redirect::toLastPage();
                }

                $param['id'] = $id;
                $param['enable'] = $form->checkValue('enabledAnalytics');

                $module->moduleParam = json_encode($param);
                ModuleManager::Save($module);

                Message::success("Updated !");
                Redirect::toLastPage();
            }
        }

        $m['id'] = isset($param['id']) ? $param['id'] : null;
        $m['enabledAnalytics'] = isset($param['enable']) ? $param['enable'] : true;
        return $this->view( $m );
    }

    public function help(){
        return $this->view();
    }

    private function isValidId($id){
        return preg_match('/^ua-\d{4,9}-\d{1,4}$/i', strval($id)) ? true : false;
    }
}