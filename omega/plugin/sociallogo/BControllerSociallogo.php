<?php
namespace Omega\Plugin\Sociallogo;

use Omega\Library\BLL\ModuleManager;
use Omega\Library\DTO\Module;
use Omega\Library\Plugin\BController;
use Omega\Library\Util\Form;
use Omega\Library\Util\Redirect;
use Omega\Library\Util\Message;

class BControllerSociallogo extends  BController {

    private $socialNetwork;
    private $moduleName;

    public function __construct() {
        parent::__construct('sociallogo');

        $this->moduleName = "Social Logo";
        $this->socialNetwork = json_decode(file_get_contents($this->root . DS . 'socialnetworklist.json'), true);
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

    public function uninstall() {
        if($this->isInstalled()) {
            $module = ModuleManager::GetModuleByName($this->moduleName);
            ModuleManager::Delete($module->id);
        }
    }

    public function index() {

        $module = ModuleManager::GetModuleByName($this->moduleName);
        $param = isset($module) ? json_decode($module->moduleParam, true) : array();


        $form = new Form('social_logo');
        if($form->isPosted()) {
            if($form->checkTokenInput()){
                foreach ($this->socialNetwork as $key => $sn) {
                    if($form->checkValue($key)) {
                        $param[$key] = $form->getValue($key);
                    }
                    else
                        if(isset($param[$key]))
                            unset($param[$key]);
                }
                $param['title'] = $form->getValue('title');
                $module->moduleParam = json_encode($param);
                ModuleManager::Save($module);

                Message::success("Updated !");
                Redirect::toLastPage();
            }
        }

        $m['moduleParam'] = $param;
        $m['title'] = isset($param['title']) ? $param['title'] : '';
        $m['socialNetworks'] = $this->socialNetwork;
        return $this->view( $m );
    }
}