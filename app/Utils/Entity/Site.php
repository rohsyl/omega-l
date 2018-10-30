<?php
namespace Omega\Utils\Entity;

use Omega\Utils\Url;
use Omega\Utils\Path;

class Site{

    public $name;
    public $slogan;
    public $template_directory_uri;
    public  $template_name;
    public  $php_template_path;
    private $url;
    //private $contact;

    public function __construct($template_name = null){

        $this->name = om_config('om_site_title');
        $this->slogan =om_config('om_site_slogan');
        $this->url = om_config('om_web_adress');
        $this->template_name = !isset($template_name) ? om_config('om_template_name') : $template_name;
        $this->template_directory_uri = Url::Absolute(Url::Combine($this->url, 'theme', $this->template_name));
        $this->php_template_path = Path::Combine(theme_path(), om_config('om_template_name'));
        //$this->contact = new ContactInformation();
    }

}