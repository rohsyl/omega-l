<?php
namespace OmegaPlugin\Document;


use Omega\Utils\Plugin\FController;

class FControllerDocument extends FController {

    public function __construct(){
        parent::__construct('document');
        //$this->includeFile('library.php');
    }

    public function registerDependencies() {
        return [
            'css' => [
                $this->asset('css/styles.css'),
            ],
            'js' => [
            ]
        ];
    }

    public function display($args, $data) {
        $placement = isset($args['placement']) ? $args['placement'] : 'content';
        if($placement == 'modulearea') {
            return $this->view('display_modulearea')->with($data);
        }
        else {
            return $this->view('display_content')->with($data);
        }
    }
}