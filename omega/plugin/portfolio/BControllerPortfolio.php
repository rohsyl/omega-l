<?php
 namespace Omega\Plugin\Portfolio;

 use Omega\Library\Plugin\BController;
 use Omega\Library\Util\ParamUtil;
 use Omega\Library\Util\Redirect;
 use Omega\Library\Util\Message;
 use Omega\Library\Util\Form;
 use Omega\Plugin\Portfolio\Library\BLL\PortfolioCategoryManager;
 use Omega\Plugin\Portfolio\Library\BLL\PortfolioConfig;
 use Omega\Plugin\Portfolio\Library\BLL\PortfolioCPValuesManager;
 use Omega\Plugin\Portfolio\Library\BLL\PortfolioCustomPropertyManager;
 use Omega\Plugin\Portfolio\Library\BLL\PortfolioItemManager;
 use Omega\Plugin\Portfolio\Library\BLL\PortfolioSliderItemManager;
 use Omega\Plugin\Portfolio\Library\DTO\PortfolioCategory;
 use Omega\Plugin\Portfolio\Library\DTO\PortfolioCustomProperty;
 use Omega\Plugin\Portfolio\Library\DTO\PortfolioItem;
 use Omega\Plugin\Portfolio\Library\DTO\PortfolioSliderItem;

 class BControllerPortfolio extends  BController {

	public $moduleNameList;
	public $moduleNameGrid2;
	public $moduleNameGrid3;
	public $moduleNameGrid4;


	public function __construct() {
		parent::__construct('portfolio');

		$this->moduleNameList = 'Module portfolio - List';
		$this->moduleNameGrid2 = 'Module portfolio - Grid 2';
		$this->moduleNameGrid3 = 'Module portfolio - Grid 3';
		$this->moduleNameGrid4 = 'Module portfolio - Grid 4';
	}

	public function install() {
		if(!$this->isInstalled()) {
			parent::install();
			parent::runSql($this->root.'/sql/install.sql');
		}
	}



	public function index()
	{
	    $items = PortfolioItemManager::GetAllItems();
	    foreach($items as $item){
	        $item->category = PortfolioCategoryManager::GetCategory($item->fkCategory);
        }
		$m['items'] = $items;
		return $this->view($m);
	}

	public function addItem() {
		$form = new Form('btnSaveItem');
		$categories = PortfolioCategoryManager::GetAllCategories();
		if($form->isPosted())
		{
			if($form->checkValue('name'))
			{
				$item = new PortfolioItem();
				$item->name = $form->getValue('name');
				$item->imageThumbnail = 0;
				$item->fkCategory = $form->getValue('category');
				$item->dateCreated = date('Y-m-d H:i:s');
				PortfolioItemManager::Save($item);
				Message::success('Item added');
                Redirect::toUrl($this->getAdminLink('index'));
			}
			else
			{
				Message::error('Please set a name');
                Redirect::toUrl($this->getAdminLink('addItem'));
			}
		}
		$m['categories'] = $categories;
		return $this->view($m);
	}
	public function editItem() {
	    if(ParamUtil::IsValidUrlParamId('id')){
            $id = $_GET['id'];
            $form = new Form('btnSave');
            $item = PortfolioItemManager::GetItem($id);
            $slider = PortfolioSliderItemManager::GetAllSliderItems($id);
            $categories = PortfolioCategoryManager::GetAllCategories();
            $cpValues = PortfolioCPValuesManager::GetValuesWithProperty($id);
            if($form->isPosted())
            {
                if($form->checkValue('name'))
                {
                    $item->name = $form->getValue('name');
                    $item->place = $form->getValue('place');
                    $item->dateItem = $form->getValue('dateItem');
                    $item->imageThumbnail = $form->getValue('imageId');
                    $item->hat = substr($form->getValue('text'), 0, 150);
                    $item->text = $form->getValue('text');
                    $item->fkCategory = $form->getValue('category');
                    PortfolioItemManager::Save($item);
                    Message::success('Item updated');
                    Redirect::toUrl($this->getAdminLink('editItem', array('id' => $id, 'tab' => 'info')));
                }
                else {
                    Message::error('Please set a name');
                    Redirect::toUrl($this->getAdminLink('editItem', array('id' => $id, 'tab' => 'info')));
                }
            }
            if(isset($_GET['slider_action']))
            {
                $act = $_GET['slider_action'];
                switch($act)
                {
                    case 'add_new_slide':
                        PortfolioSliderItemManager::AddSliderItem($id);
                        Message::success('Slide added');
                        Redirect::toUrl($this->getAdminLink('editItem', array('id' => $id, 'tab' => 'slider')));
                        break;
                    case 'delete_image':
                        $sid = $_GET['slide_id'];
                        PortfolioSliderItemManager::Delete($sid);
                        Message::success('Slide deleted');
                        Redirect::toUrl($this->getAdminLink('editItem', array('id' => $id, 'tab' => 'slider')));
                        break;
                    case 'save':
                        $sliders = $_POST['slider'];
                        foreach($sliders as $sid => $media)
                        {
                            $si = new PortfolioSliderItem();
                            $si->id = $sid;
                            $si->fkPortfolioItem = $id;
                            $si->fkMedia = $media;
                            PortfolioSliderItemManager::SaveSliderItem($si);
                        }
                        Message::success('Slider saved');
                        Redirect::toUrl($this->getAdminLink('editItem', array('id' => $id, 'tab' => 'slider')));
                        break;
                }
            }
            if(isset($_GET['values_action']))
            {
                $act = $_GET['values_action'];
                switch($act)
                {
                    case 'save':
                        $values = $_POST['v'];
                        foreach($values as $vid => $value)
                        {
                            $v = PortfolioCPValuesManager::GetCPValue($vid);
                            $v->value = $value;
                            PortfolioCPValuesManager::Save($v);
                        }
                        Message::success('Values saved');
                        Redirect::toUrl($this->getAdminLink('editItem', array('id' => $id, 'tab' => 'cp')));
                        break;
                }
            }
            $m['item'] = $item;
            $m['slider'] = $slider;
            $m['categories'] = $categories;
            $m['cpValues'] = $cpValues;
            return $this->view($m);
        }
	}
	public function deleteItem(){
	    if(ParamUtil::IsValidUrlParamId('id')){
            $id = $_GET['id'];
            PortfolioItemManager::Delete($id);
            Message::success('item deleted');
            Redirect::toUrl($this->getAdminLink('index'));
        }
	}
	

	public function categories()
	{
		$m['categories'] = PortfolioCategoryManager::GetAllCategories();
		return $this->view( $m );
	}
	public function addCategory()
	{
		$form = new Form('btnAddCategory');
		if($form->isPosted()) {
			if($form->checkValue('name')) {
				$cat = new PortfolioCategory();
				$cat->name = $form->getValue('name');
				$cat->color = '#333333';
				$cat->orderItem = 0;
				PortfolioCategoryManager::Save($cat);
				Message::success('Category added');
                Redirect::toUrl($this->getAdminLink('categories'));
			}
			else {
				Message::error('Please set a name');
                Redirect::toUrl($this->getAdminLink('addCategory'));
			}
		}
		return $this->view();
	}
	public function editCategory() {
	    if(ParamUtil::IsValidUrlParamId('id')){
            $id = $_GET['id'];
            $cat = PortfolioCategoryManager::GetCategory($id);
            $form = new Form('btnSaveCat');
            if($form->isPosted()) {
                if($form->checkValue('name')) {
                    $cat->name = $form->getValue('name');
                    $cat->color = $form->getValue('color');
                    PortfolioCategoryManager::Save($cat);
                    Message::success('Category updated');
                    Redirect::toUrl($this->getAdminLink('editCategory', array('id' => $id)));
                }
                else {
                    Message::error('Please set a name');
                    Redirect::toUrl($this->getAdminLink('editCategory', array('id' => $id)));
                }
            }
            $m['item'] = $cat;
            return $this->view($m);
        }
	}
	public function deleteCategory() {
	    if(ParamUtil::IsValidUrlParamId('id')){
            $id = $_GET['id'];
            PortfolioCategoryManager::Delete($id);
            Message::success('Category deleted');
            Redirect::toUrl($this->getAdminLink('categories'));
        }
	}

	public function settings()
	{
	    $form = new Form('btnSavePortfolioSettings');

	    $settings = PortfolioConfig::GetSettings();

	    if($form->isPosted()){
            $newSettings = array(
                'image-zoom' => $form->checkValue('image-zoom'),
                'owl-nav' => $form->checkValue('owl-nav')
            );
            PortfolioConfig::SetSettings($newSettings);
            Redirect::toUrl($this->getAdminLink('settings'));
        }


	    $m['settings'] = $settings;
		return $this->view($m);
	}

	public function customProperties()
	{

		$properties = PortfolioCustomPropertyManager::GetAllCustonmProperties();

		if(isset($_GET['cp'])) {
			$act = $_GET['cp'];
			switch($act)
			{
				case 'save':
					foreach($_POST['cpTitles'] as $pid => $title)
					{
						$p = PortfolioCustomPropertyManager::GetCustomProperty($pid);
						$p->title = $title;
                        PortfolioCustomPropertyManager::Save($p);
					}
					Message::success('Properties saved');
                    Redirect::toUrl($this->getAdminLink('customProperties'));
					break;
				case 'new':
				    PortfolioCustomPropertyManager::Save(new PortfolioCustomProperty());
					Message::success('Property added');
                    Redirect::toUrl($this->getAdminLink('customProperties'));
					break;
				case 'delete':
					$pid = $_GET['pid'];
                    PortfolioCustomPropertyManager::Delete($pid);
					Message::success('Property deleted');
                    Redirect::toUrl($this->getAdminLink('customProperties'));
					break;
			}
		}
		$m['properties'] = $properties;
		return $this->view( $m );
	}

	public function cpTable() {
        $properties = PortfolioCustomPropertyManager::GetAllCustonmProperties();
 		return $this->partialView('customProperties-table', array('properties' => $properties));
	}

	public function formOrder() {
        $properties = PortfolioCustomPropertyManager::GetAllCustonmProperties();
		$m['properties'] = $properties;
		return $this->view( $m );
	}

	public function saveOrder() {
		$order = $_POST['order'];
		foreach($order as $o) {
            $p = PortfolioCustomPropertyManager::GetCustomProperty($o['id']);
            $p->propOrder = $o['order'];
            PortfolioCustomPropertyManager::Save($p);
		}
	}
} 