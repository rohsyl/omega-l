<?php
namespace Omega\Plugin\Contact;

use Omega\Library\Plugin\BController;
use Omega\Library\Util\Form;
use Omega\Library\Util\Message;
use Omega\Library\Util\Redirect;
use Omega\Library\Util\Config as ConfigHelper;

class BControllerContact extends  BController {

    public function __construct(){
        parent::__construct('contact');
    }

    public function install() {
        if (!$this->isInstalled()) {
            parent::install();
            parent::runSql($this->root . DS . 'sql/install.sql');
        }
    }


    public function index() {

        $form = new Form('contactForm');

        $param = json_decode(ConfigHelper::get('contact_param'), true);
        $param = isset($param) ? $param : array();

        if($form->isPosted()) {
            if($form->checkTokenInput()) {
                $param = array(
                    'contactLogo' => $form->getValue('logo'),
                    'displayLogo' => $form->checkValue('displayLogo'),
                    'phone' => $form->getValue('phone'),
                    'mobile' => $form->getValue('mobile'),
                    'fax' => $form->getValue('fax'),
                    'mail_info' => $form->getValue('mail_info'),
                    'mail' => $form->getValue('mail'),
                    'name' => $form->getValue('name'),
                    'street' => $form->getValue('street'),
                    'npa' => $form->getValue('npa'),
                    'locality' => $form->getValue('locality'),
                    'conf_message' => $form->getValue('conf_message'),
                    'is_antispam' => $form->checkValue('is_antispam')
                );

                ConfigHelper::set('contact_param', json_encode($param));

                Message::success("Updated !");
                Redirect::toLastPage();
            }
            else
            {
                die('invalid token');
            }
        }

        $m['paramData'] = $param;
        return $this->view($m);
    }
}