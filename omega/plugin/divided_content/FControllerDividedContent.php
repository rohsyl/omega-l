<?php
namespace OmegaPlugin\DividedContent;



use Omega\Utils\Plugin\FController;

define('TYPE_COL_2', 1);
define('TYPE_COL_3', 2);
define('TYPE_COL_4', 3);
define('TYPE_TABS', 4);
define('TYPE_COLLAPSE', 5);
define('TYPE_SLIDER', 6);

class FControllerDividedContent extends  FController {

    public function __construct() {
        parent::__construct('divided_content');
    }

    public function registerDependencies()
    {
        return [
            'css' => [],
            'js' => []
        ];
    }

    public function display( $args, $data ) {
        $data['id'] = $args['settings']['compId'];
        switch($data['type']['value']){
            case TYPE_COL_2:
                $data['countCol'] = 2;
                return $this->view('display_column')->with($data);
                break;
            case TYPE_COL_3:
                $data['countCol'] = 3;
                return $this->view('display_column')->with($data);
                break;
            case TYPE_COL_4:
                $data['countCol'] = 4;
                return $this->view('display_column')->with($data);
                break;
            case TYPE_TABS:
                return $this->view('display_tabs')->with($data);
                break;
            case TYPE_COLLAPSE:
                return $this->view('display_collapse')->with($data);
                break;
            case TYPE_SLIDER:
                return $this->view('display_slider')->with($data);
                break;
        }
        return null;
    }
}