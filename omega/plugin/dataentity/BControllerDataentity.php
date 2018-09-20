<?php
namespace Omega\Plugin\Dataentity;

use Omega\Library\Plugin\BController;
use Omega\Library\Util\Form;
use Omega\Library\Util\Message;
use Omega\Library\Util\ParamUtil;
use Omega\Library\Util\Redirect;
use Omega\Library\Util\Util;
use Omega\Plugin\Dataentity\Library\BLL\DataEntityDataManager;
use Omega\Plugin\Dataentity\Library\BLL\DataEntityLayoutManager;
use Omega\Plugin\Dataentity\Library\BLL\EntityManager;
use Omega\Plugin\Dataentity\Library\BLL\PropertyManager;
use Omega\Plugin\Dataentity\Library\BLL\PropertyTypeManager;
use Omega\Plugin\Dataentity\Library\BLL\DataEntityViewManager;
use Omega\Plugin\Dataentity\Library\DataentityUtil;
use Omega\Plugin\Dataentity\Library\DTO\DataEntityLayout;
use Omega\Plugin\Dataentity\Library\DTO\DataEntityView;
use Omega\Plugin\Dataentity\Library\DTO\Entity;
use Omega\Plugin\Dataentity\Library\DTO\Property;
use function Omega\Library\__;
use Omega\Plugin\Dataentity\Library\Form\DataEntityType;


define('DATAENTITY_DEFAULT_TYPE', 'string');

class BControllerDataentity extends  BController {


    public function __construct() {
        parent::__construct('dataentity');

        // add property type with
        PropertyTypeManager::AddType('string', 'Omega\\Library\\Plugin\\Type\\TextSimple', '{}');
        PropertyTypeManager::AddType('text', 'Omega\\Library\\Plugin\\Type\\TextRich', '{}');
        PropertyTypeManager::AddType('int', 'Omega\\Library\\Plugin\\Type\\TextSimple', '{}');
        PropertyTypeManager::AddType('double', 'Omega\\Library\\Plugin\\Type\\TextSimple', '{}');
        PropertyTypeManager::AddType('boolean', 'Omega\\Library\\Plugin\\Type\\CheckBoxes', json_encode(array(
            'default' => array('enabled' => false),
            'options' => array('enabled' => __('Yes', true))
        )));
        PropertyTypeManager::AddType('picture', 'Omega\\Library\\Plugin\\Type\\MediaChooser', json_encode((array(
            'multiple' => false,
            'preview' => true,
            'type' => array('picture')
        ))));

        // Add all entites as property types
        $entites = EntityManager::GetAllEntites();
        foreach($entites as $entity){
            PropertyTypeManager::AddType($entity->title, 'Omega\\Plugin\\Dataentity\\Library\\Type\\DataEntityEntity', json_encode(array(
                'entityName' => $entity->name
            )));
        }
    }

    public function install() {
        if (!$this->isInstalled()) {
            parent::install();
            parent::runSql($this->root . '/sql/install.sql');
        }
    }

    public function uninstall() {
        if($this->isInstalled()) {
            parent::uninstall();
            parent::runSql($this->root . '/sql/uninstall.sql');
        }
    }

    public function index() {
        $entites = EntityManager::GetAllEntites();

        $m['entities'] = $entites;
        return $this->view( $m );
    }

    #region entity definition
    public function addEntity(){

        $form = new Form('addEntity');
        if($form->isPosted()){
            if($form->checkValue('entityName')){
                $entityName = $form->getValue('entityName');

                $entity = new Entity();
                $entity->title = $entityName;
                $entity->name = DataentityUtil::GetPrefixedName($entityName);
                EntityManager::Save($entity);

                Redirect::toUrl($this->getAdminLink('editEntity', array('id' => $entity->id)));
                Message::success('Entity created !');
            }
            else{
                Redirect::toUrl($this->getAdminLink('addEntity'));
                Message::error('Name is required');
            }
        }

        return $this->view();
    }

    public function editEntity(){

        $id = $_GET['id'];
        $entity = EntityManager::GetEntity($id);
        $form = new Form('editEntity');
        if($form->isPosted()){
            if($form->checkValue('entityName')){
                $entity->title = $form->getValue('entityName');
                EntityManager::Save($entity);

                Redirect::toUrl($this->getAdminLink('editEntity', array('id' => $entity->id)));
                Message::success('Entity saved !');
            }
            else{
                Redirect::toUrl($this->getAdminLink('editEntity', array('id' => $entity->id)));
                Message::error('Name is required');
            }
        }

        $m['entity'] = $entity;
        return $this->view( $m );
    }

    public function deleteEntity(){
        if(ParamUtil::IsValidUrlParamId('id')){
            $id = $_GET['id'];
            DataEntityViewManager::DeleteAllForEntity($id);
            DataEntityDataManager::DeleteAllForEntity($id);
            EntityManager::Delete($id);
            Message::success(__('Entity deleted', true));
            Redirect::toUrl($this->getAdminLink('index'));
        }
    }

    public function entityPropertiesTable(){
        if(ParamUtil::IsValidUrlParamId('id')) {
            $id = $_GET['id'];
            $properties = PropertyManager::GetAllPropertiesOfEntity($id);

            $m['properties'] = $properties;
            return $this->view($m);
        }
    }

    public function entityViewsTable(){
        if(ParamUtil::IsValidUrlParamId('id')) {
            $id = $_GET['id'];
            $views = DataEntityViewManager::GetAllViewsForEntity($id);

            $m['views'] = $views;
            return $this->view($m);
        }
    }

    public function addPropertyForm(){
        $m['types'] = PropertyTypeManager::GetAllTypes();
        return $this->view( $m );
    }

    public function addProperty(){
        $prop = new Property();
        $type = PropertyTypeManager::GetType($_POST['type']);
        $prop->title = $_POST['name'];
        $prop->name = Util::SlugifyText($prop->title, '_');
        $prop->mandatory = $_POST['mandatory'];
        $prop->heading = $_POST['heading'];
        $prop->description = $_POST['description'];
        $prop->type = $type['type'];
        $prop->param = $type['param'];
        $prop->fkForm = $_POST['entityId'];

        $this->propertyAddTypeInParam($prop, $type['name']);

        $result = PropertyManager::Save($prop);

        $m['result'] = $result;
        return $this->json($m);
    }

    public function editPropertyForm(){
        if(ParamUtil::IsValidUrlParamId('id')) {
            $id = $_GET['id'];
            $m['property'] = PropertyManager::GetProperty($id);
            $m['types'] = PropertyTypeManager::GetAllTypes();
            return $this->view($m);
        }
    }

    public function editProperty(){
        if(ParamUtil::IsValidUrlParamId('id', false)) {
            $id = $_GET['id'];

            $prop = PropertyManager::GetProperty($id);
            $type = PropertyTypeManager::GetType($_POST['type']);
            $prop->title = $_POST['name'];
            $prop->name = Util::SlugifyText($prop->title, '_');
            $prop->mandatory = $_POST['mandatory'];
            $prop->heading = $_POST['heading'];
            $prop->description = $_POST['description'];
            $prop->type = $type['type'];
            $prop->param = $type['param'];
            $this->propertyAddTypeInParam($prop, $type['name']);

            $result = PropertyManager::Save($prop);

            $m['result'] = $result;
        }
        else{
            $m['result'] = false;
            $m['message'] = 'invalid id';
        }
        return $this->json($m);
    }

    public function deleteProperty(){
        if(ParamUtil::IsValidUrlParamId('id', false)) {
        $id = $_GET['id'];
        $result = PropertyManager::Delete($id);

        $m['result'] = $result;
        }
        else{
            $m['result'] = false;
            $m['message'] = 'invalid id';
        }
        return $this->json($m);
    }

    public function addViewForm(){
        return $this->view();
    }

    public function addView(){

        $view = new DataEntityView();
        $view->name = $_POST['name'];
        $view->fkForm = $_POST['entityId'];
        $result = DataEntityViewManager::Save($view);

        $m['result'] = $result;
        return $this->json($m);
    }

    public function editViewForm(){
        if(ParamUtil::IsValidUrlParamId('id')) {
            $id = $_GET['id'];
            $view = DataEntityViewManager::GetView($id);
            $properties = PropertyManager::GetAllPropertiesOfEntity($view->fkForm);
            $autoCompleteVars = array();
            foreach ($properties as $prop) {
                $autoCompleteVars[] = '$' . $prop->name;
            }
            $m['view'] = $view;
            $m['autoComplete'] = json_encode($autoCompleteVars);
            return $this->view($m);
        }
    }

    public function editView(){
        if(ParamUtil::IsValidUrlParamId('id', false)) {
            $id = $_GET['id'];
            $view = DataEntityViewManager::GetView($id);
            $view->name = $_POST['name'];
            $view->view = $_POST['view'];
            $result = DataEntityViewManager::Save($view);

            $m['result'] = $result;
        }
        else {
            $m['result'] = false;
            $m['message'] = 'Invalid id...';
        }
        return $this->json($m);
    }

    public function editViewFullPage(){
        if(ParamUtil::IsValidUrlParamId('id')) {
            $id = $_GET['id'];
            $view = DataEntityViewManager::GetView($id);
            $properties = PropertyManager::GetAllPropertiesOfEntity($view->fkForm);
            $autoCompleteVars = array();
            foreach ($properties as $prop) {
                $autoCompleteVars[] = '$' . $prop->name;
            }
            $m['view'] = $view;
            $m['autoComplete'] = json_encode($autoCompleteVars);
            return $this->view($m);
        }
    }

    public function deleteView(){
        if(ParamUtil::IsValidUrlParamId('id', false)) {
            $id = $_GET['id'];
            $result = DataEntityViewManager::Delete($id);
            $m['result'] = $result;
        }
        else {
            $m['result'] = false;
            $m['message'] = 'Invalid id...';
        }
        return $this->json($m);
    }

    private function propertyAddTypeInParam($prop, $typeName){
        $param = json_decode($prop->param, true);
        $param['dataentity_type'] = $typeName;
        $prop->param = json_encode($param);
    }
    #endregion

    #region entity data
    public function manageData(){
        if(ParamUtil::IsValidUrlParamId('id')){
            $idEntity = $_GET['id'];
            // Get the entity by id
            $entity = EntityManager::GetEntity($idEntity);

            // Get all properties of the given entity
            $properties = PropertyManager::GetAllPropertiesOfEntity($idEntity);

            // Find all raw data for the given entity
            $datas = DataEntityDataManager::GetAllDatas($idEntity);

            $dataList = array();
            foreach($datas as $d){
                // Get real object value
                $item = DataEntityType::GetValues($entity->name, $d->id);
                $item['id'] = $d->id;
                $dataList[] = $item;
            }

            $m['entity'] = $entity;
            $m['properties'] = $properties;
            $m['datas'] = $dataList;
            return $this->view( $m );
        }
    }

    public function newData(){
        if(ParamUtil::IsValidUrlParamId('id')) {
            $idEntity = $_GET['id'];
            $entity = EntityManager::GetEntity($idEntity);

            $form = new Form('btnNewData');
            if($form->isPosted()){
                DataEntityType::FormSaveByName($entity->name);
                Message::success(__('New ' . $entity->title . ' added !', true));
                Redirect::toUrl($this->getAdminLink('manageData', array('id' => $idEntity)));
            }

            $m['entity'] = $entity;
            return $this->view( $m );
        }
    }

    public function editData(){
        if(ParamUtil::IsValidUrlParamId('id')) {
            $idData = $_GET['id'];
            $data = DataEntityDataManager::GetData($idData);
            $idEntity = $data->fkForm;
            $entity = EntityManager::GetEntity($idEntity);

            $form = new Form('btnEditData');
            if($form->isPosted()){
                DataEntityType::FormSaveByName($entity->name, $idData);
                Message::success(__($entity->title . ' updated !', true));
                Redirect::toUrl($this->getAdminLink('editData', array('id' => $idData)));
            }

            $m['idData'] = $idData;
            $m['entity'] = $entity;
            return $this->view( $m );
        }
    }

    public function deleteData(){
        if(ParamUtil::IsValidUrlParamId('id')) {
            $idData = $_GET['id'];
            $data = DataEntityDataManager::GetData($idData);
            $idEntity = $data->fkForm;
            $entity = EntityManager::GetEntity($idEntity);
            DataEntityDataManager::Delete($idData);
            Message::success(__($entity->title . ' deleted !', true));
            Redirect::toUrl($this->getAdminLink('manageData', array('id' => $idEntity)));
        }

    }
    #endregion

    #region AJAX
    public function getEntityInstanceList(){
        $idEntity = $_GET['entityId'];
        $entity = EntityManager::GetEntity($idEntity);
        $datas = DataEntityDataManager::GetAllDatas($idEntity);
        $dataList = array();
        foreach($datas as $d) {
            $i = array();
            $item = DataEntityType::GetValuesHeadingOnly($entity->name, $d->id);
            $i['id'] = $d->id;
            $i['data'] = $item;
            $dataList[] = $i;
        }
        return $this->json($dataList);
    }
    #endregion

    #region ENTITY BROWSER
    public function browser(){
        $entities = EntityManager::GetAllEntites();
        $m['entities'] = $entities;
        return $this->view( $m );
    }

    public function entitiesList(){
        $entities = EntityManager::GetAllEntites();
        $m['entities'] = $entities;
        return $this->view( $m );
    }

    public function dataInstancesList(){
        $idEntity = $_GET['idEntity'];
        $entity = EntityManager::GetEntity($idEntity);
        $datas = DataEntityDataManager::GetAllDatas($idEntity);
        $dataList = array();
        foreach($datas as $d) {
            $i = array();
            $item = DataEntityType::GetValuesHeadingOnly($entity->name, $d->id);
            $i['id'] = $d->id;
            $i['data'] = $item;
            $dataList[] = $i;
        }
        $m['entity'] = $entity;
        $m['dataList'] = $dataList;
        return $this->view( $m );
    }

    public function getViewsForEntityData(){
        $idData = $_GET['dataId'];
        $idView = $_GET['viewId'];
        $data = DataEntityDataManager::GetData($idData);
        $views = DataEntityViewManager::GetAllViewsForEntity($data->fkForm);
        $m['views'] = $views;
        $m['idView'] = $idView;
        return $this->view( $m );
    }
    #endregion


    #region LAYOUT
    public function layout(){
        $m['layouts'] = DataEntityLayoutManager::GetAllLayouts();
        return $this->view( $m );
    }

    public function addLayout(){

        $form = new Form('addLayout');
        if($form->isPosted()){

            if($form->checkValue('layoutName')){

                $view = new DataEntityLayout();
                $view->name = $form->getValue('layoutName');
                $result = DataEntityLayoutManager::Save($view);

                if($result){
                    Message::success('Layout added!');
                    Redirect::toUrl($this->getAdminLink('layout'));
                }
                else{
                    Message::error('Error while adding layout');
                    Redirect::toUrl($this->getAdminLink('addLayout'));
                }
            }
            else{
                Message::error('Please give a name...');
                Redirect::toUrl($this->getAdminLink('addLayout'));
            }

        }

        return $this->view();
    }

    public function editLayout(){
        if(ParamUtil::IsValidUrlParamId('id')) {
            $id = $_GET['id'];
            $layout = DataEntityLayoutManager::GetLayout($id);
            $autoCompleteVars = array(DataentityUtil::GetContentLayoutPlaceHolder(), DataentityUtil::GetTitleLayoutPlaceHolder());
            $m['layout'] = $layout;
            $m['autoComplete'] = json_encode($autoCompleteVars);
            return $this->view($m);
        }
    }

    public function saveLayout(){
        if(ParamUtil::IsValidUrlParamId('id', false)) {
            $id = $_GET['id'];
            $layout = DataEntityLayoutManager::GetLayout($id);
            $layout->name = $_POST['name'];
            $layout->view = $_POST['view'];
            $result = DataEntityLayoutManager::Save($layout);

            $m['result'] = $result;
        }
        else {
            $m['result'] = false;
            $m['message'] = 'Invalid id...';
        }
        return $this->json($m);
    }

    public function deleteLayout(){
        if(ParamUtil::IsValidUrlParamId('id', false)) {
            $id = $_GET['id'];
            $result = DataEntityLayoutManager::Delete($id);

            if($result){
                Message::success('Layout deleted!');
                Redirect::toUrl($this->getAdminLink('layout'));
            }
            else{
                Message::error('Error while deleting layout');
                Redirect::toUrl($this->getAdminLink('addLayout'));
            }
        }
    }
    #endregion
}