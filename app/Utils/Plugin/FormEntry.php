<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 05.08.2017
 * Time: 18:58
 */
namespace Omega\Utils\Plugin;

use Omega\Library\Util\Util;

class FormEntry{

    protected $entry;
    private $idModule;
    private $idPage;
    protected $type;
    protected $value;

    public function __construct($entry, $idModule, $idPage)
    {
        $this->entry = $entry;
        $this->idModule = $idModule;
        $this->idPage = $idPage;
        $this->loadValue();
        $this->loadType();
    }

    protected function loadType(){
        $typeClassName = $this->getTypeName();
        if(class_exists($typeClassName)){
            $type = new $typeClassName($this->getUniqId(), $this->getParam(), $this->getValueValue(), $this->idPage);
            if(is_subclass_of($type, ATYPEENTRY)){
                $this->type = $type;
                return;
            }
        }
        $this->type = null;
    }

    protected function loadValue(){
        $value = Type::GetValueForEntry($this->getId(), $this->getIdModule());
        if(isset($value)){
            $this->value = new FormEntryValue($value);
            return;
        }
        $this->value = null;
    }

    protected function getUniqId(){
        return 'entry-'.$this->getId().'-'.$this->getIdModule();
    }

    protected function getParam(){
        if(isset($this->entry['param']) && !empty($this->entry['param'])){
            $param = json_decode($this->entry['param'], true);
            return $param;
        }
        return null;
    }

    public function getValue(){
        return $this->value;
    }

    protected function getValueValue(){
        if(isset($this->value) && !empty($this->value)){
            return $this->value->getValue();
        }
        return null;
    }

    public function getIdModule(){
        return $this->idModule;
    }

    public function getId(){
        return $this->entry['id'];
    }

    public function getIdForm(){
        return $this->entry['fkForm'];
    }

    public function getName(){
        return $this->entry['name'];
    }

    public function getTitle(){
        return $this->entry['title'];
    }

    public function getDescription(){
        return $this->entry['description'];
    }

    public function getTypeName(){
        return $this->entry['type'];
    }

    /**
     * @return ATypeEntry Type
     */
    public function getType(){
        return $this->type;
    }

    public function getHtml()
    {
        $h = '<div class="form-group">';

        // display title if set
        $title = $this->getTitle();
        $h .= isset($title) && !empty($title)
                ? '<label class="control-label" for="' . $this->getUniqId() . '">' . $title . '</label>'
                : '';


        // display entry
        $h .= isset($this->type)
                ? $this->type->getHtml()
                : '<div class="alert alert-danger">Entry type does\'nt exists ...</div>';

        // display help description if set
        $description = $this->getDescription();
        $h .= isset($description) && !empty($description)
                ? '<span class="help-block">' . $description . '</span>'
                : '';

        $h .= '</div>';

        return $h;
    }
}