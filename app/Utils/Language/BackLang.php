<?php
namespace Omega\Utils\Language;

class BackLang{

    private $twoLetterId;
    private $name;
    private $miniFlagPath;
    private $fatFlagPath;

    public function __construct($twoLetterId)
    {
        $this->twoLetterId = strtolower($twoLetterId);
        $this->name = $this->getNameById();
        $this->miniFlagPath = asset('i18n/flags/'.$this->twoLetterId.'.png');
        $this->fatFlagPath = asset('i18n/flags/fat/'.$this->twoLetterId.'.png');
    }

    public function getTwoLetterId()
    {
        return $this->twoLetterId;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getFatFlag()
    {
        return $this->fatFlagPath;
    }
    public function getFlag()
    {
        return $this->miniFlagPath;
    }


    private function getNameById()
    {
        switch (strtolower($this->twoLetterId)) {
            case 'en' :
                return 'English';
                break;
            case 'de' :
                return 'Deutsch';
                break;
            case 'fr' :
                return 'Français';
                break;
            case 'es' :
                return 'Español';
                break;
            case 'pt' :
                return 'Portuguës';
                break;
            case 'nl' :
                return 'Nederlands';
                break;
            case 'it' :
                return 'Italiano';
                break;
        }
    }

}


