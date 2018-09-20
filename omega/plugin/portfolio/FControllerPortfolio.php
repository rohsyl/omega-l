<?php
namespace Omega\Plugin\Portfolio;

use Omega\Library\Entity\Media;
use Omega\Library\Plugin\FController;
use Omega\Plugin\Portfolio\Library\BLL\PortfolioCategoryManager;
use Omega\Plugin\Portfolio\Library\BLL\PortfolioConfig;
use Omega\Plugin\Portfolio\Library\BLL\PortfolioCPValuesManager;
use Omega\Plugin\Portfolio\Library\BLL\PortfolioItemManager;
use Omega\Plugin\Portfolio\Library\BLL\PortfolioSliderItemManager;
use Omega\Plugin\Portfolio\Library\DTO\PortfolioItem;

define('PORTFOLIO_DISPLAY_LIST', 1);
define('PORTFOLIO_DISPLAY_GRID2', 2);
define('PORTFOLIO_DISPLAY_GRID3', 3);
define('PORTFOLIO_DISPLAY_GRID4', 4);

class FControllerPortfolio extends  FController {

	public function __construct() {
		parent::__construct('portfolio');
	}

 
	public function registerDependencies()
	{
		return array(
			'css' => array(
				'plugin/portfolio/css/styles.css',
				'plugin/portfolio/css/owl.carousel.css'
			),
			'js' => array(
				//'plugin/portfolio/js/blueimp-helper.js',
				'plugin/portfolio/js/owl.carousel.min.js'
			)
		);
	}
				 
	public function display($param, $data) {
	 
		$view = $data['display']['value'];

        $settings = PortfolioConfig::GetSettings();


        $m['placement'] = isset($param['placement']) ? $param['placement'] : 'content';

		if(isset($_GET['item']))
		{
		    $item = PortfolioItemManager::GetItem($_GET['item']);
            $this->loadItemData($item);
			$m['item'] = $item;
			$m['imageZoom'] = $settings['image-zoom'];
            $m['owlNav'] = $settings['owl-nav'];
			return $this->partialView('display-item', $m);
		}

        $items = PortfolioItemManager::GetAllItems();
		foreach($items as $item){
            $item->image = new Media($item->imageThumbnail);
            $item->category = PortfolioCategoryManager::GetCategory($item->fkCategory);
        }

		$m['filterCategories'] = PortfolioCategoryManager::GetAllCategories();
		$m['items'] = $items;
		switch($view)
		{
			case PORTFOLIO_DISPLAY_LIST :
				return $this->partialView('display-list', $m);
				break;
			case PORTFOLIO_DISPLAY_GRID2 :
				$m['gridSize'] = 2;
				return $this->partialView('display-grid', $m);
				break;
            case PORTFOLIO_DISPLAY_GRID3 :
                $m['gridSize'] = 3;
                return $this->partialView('display-grid', $m);
                break;
            case PORTFOLIO_DISPLAY_GRID4 :
                $m['gridSize'] = 4;
                return $this->partialView('display-grid', $m);
                break;
		}
		return null;
	}

    /**
     * @param $item PortfolioItem
     */
	private function loadItemData($item){
	    $item->category = PortfolioCategoryManager::GetCategory($item->fkCategory);
	    $item->image = new Media($item->imageThumbnail);
        $item->slides = PortfolioSliderItemManager::GetAllSliderItems($item->id);
        $item->properties = PortfolioCPValuesManager::GetValuesWithProperty($item->id);
    }
} 