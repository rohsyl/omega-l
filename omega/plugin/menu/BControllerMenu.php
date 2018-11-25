<?php
namespace OmegaPlugin\Menu;

use Omega\Utils\Plugin\BController;

class BControllerMenu extends  BController {

    public function __construct() {
        parent::__construct('menu');
        $this->model = new ModelMenu();
    }

    public function install() {
        parent::runSql($this->root.'/sql/install.sql');
        return true;
    }

    public function index() {

        $m['listElement'] = $this->model->findAllElement();

        return $this->view( $m );
    }

    public function add() {

        $mModule = new ModelModule();

        $m['listMenu'] = $this->model->findAllMenu();

        $form = new Form('addElement', 'addElement');

        if($form->isPosted())
        {
            if($form->checkTokenInput())
            {

                $param = array();
                $param['title'] = $form->getValue('title');
                if($form->checkValue('idMenu'))
                    $param['idMenu'] = $form->getValue('idMenu');

                if($form->checkValue('beforeTitle'))
                    $param['beforeTitle'] = $form->getValue('beforeTitle');

                if($form->checkValue('aftertitle'))
                    $param['afterTitle'] = $form->getValue('afterTitle');

                if($form->checkValue('displayTitle'))
                    $param['displayTitle'] = 1;
                else
                    $param['displayTitle'] = 0;

                if($form->checkValue('beforeContent'))
                    $param['beforeContent'] = $form->getValue('beforeContent');

                if($form->checkValue('afterContent'))
                    $param['afterContent'] = $form->getValue('afterContent');

                if($form->checkValue('isVertical'))
                    $param['isVertical'] = 1;
                else
                    $param['isVertical'] = 0;

                if($form->checkValue('divClass'))
                    $param['divClass'] = $form->getValue('divClass');

                if($form->checkValue('ulClass'))
                    $param['ulClass'] = $form->getValue('ulClass');

                if($form->checkValue('liclass'))
                    $param['liClass'] = $form->getValue('liClass');

                $mModule->create(
                    $this->name,
                    $param['title'],
                    $param
                );

                //HttpHelper::redirectToLink($this->getAdminLink('index'));
            }
        }

        return $this->view( $m );
    }

    public function delete(){
        $this->model->deleteElement($_GET['id']);

        Redirect::toUrl($this->getAdminLink('index'));
    }

    public function edit() {

        $mModule = new ModelModule();

        $id = $_GET['id'];

        $m['listMenu'] = $this->model->findAllMenu();
        $data = $this->model->findElement($id);

        $m['elementId'] = $data->getInt('id');
        $m['elementName'] = $data->getString('moduleName');
        $m['elementParam'] = json_decode($data->getValue('moduleParam'), true);

        $form = new Form('editElement', 'editElement');

        if($form->isPosted())
        {
            if($form->checkTokenInput())
            {
                $param = array();
                $param['title'] = $form->getValue('title');
                if($form->checkValue('idMenu'))
                    $param['idMenu'] = $form->getValue('idMenu');

                if($form->checkValue('beforeTitle'))
                    $param['beforeTitle'] = $form->getValue('beforeTitle');

                if($form->checkValue('aftertitle'))
                    $param['afterTitle'] = $form->getValue('afterTitle');

                if($form->checkValue('displayTitle'))
                    $param['displayTitle'] = 1;
                else
                    $param['displayTitle'] = 0;

                if($form->checkValue('beforeContent'))
                    $param['beforeContent'] = $form->getValue('beforeContent');

                if($form->checkValue('afterContent'))
                    $param['afterContent'] = $form->getValue('afterContent');

                if($form->checkValue('isVertical'))
                    $param['isVertical'] = 1;
                else
                    $param['isVertical'] = 0;

                if($form->checkValue('divClass'))
                    $param['divClass'] = $form->getValue('divClass');

                if($form->checkValue('ulClass'))
                    $param['ulClass'] = $form->getValue('ulClass');

                if($form->checkValue('liclass'))
                    $param['liClass'] = $form->getValue('liClass');


                $mModule->saveModule(
                    array(
                        'moduleParam' => json_encode($param),
                        'moduleName' => $param['title']
                    ),
                    $_GET['id']
                );

                Redirect::toLastPage();
            }
        }

        return $this->view( $m );
    }

}