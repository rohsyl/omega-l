<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 05.08.2017
 * Time: 18:58
 */
namespace Omega\Utils\Plugin;

use Omega\Library\Util\Util;

/**
 * Class FormEntry. Helper for FormEntry
 * @package Omega\Utils\Plugin
 */
class FormEntry{

    protected $entry;
    private $idModule;
    private $idPage;
    protected $type;
    protected $value;

    /**
     * FormEntry constructor.
     * @param $entry
     * @param $idModule
     * @param $idPage
     */
    public function __construct($entry, $idModule, $idPage)
    {
        $this->entry = $entry;
        $this->idModule = $idModule;
        $this->idPage = $idPage;
        $this->loadValue();
        $this->loadType();
    }

    /**
     * Instance the type of the entry
     */
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

    /**
     * Load the value of the entry
     */
    protected function loadValue(){
        $value = Type::GetValueForEntry($this->getId(), $this->getIdModule());
        if(isset($value)){
            $this->value = new FormEntryValue($value);
            return;
        }
        $this->value = null;
    }

    /**
     * Use this uniq id as name for your inputs
     * @return string
     */
    protected function getUniqId(){
        return 'entry-'.$this->getId().'-'.$this->getIdModule();
    }

    /**
     * Get the params of the entry
     * @return mixed|null
     */
    protected function getParam(){
        if(isset($this->entry->param) && !empty($this->entry->param)){
            $param = json_decode($this->entry->param, true);
            return $param;
        }
        return null;
    }

    /**
     * Get the FormEntryValue
     * @return mixed
     */
    public function getValue(){
        return $this->value;
    }

    /**
     * Get the value contained in the FormEntryValue
     * @return null|mixed
     */
    protected function getValueValue(){
        if(isset($this->value) && !empty($this->value)){
            return $this->value->getValue();
        }
        return null;
    }

    /**
     * Get the id of the module
     * @return int
     */
    public function getIdModule(){
        return $this->idModule;
    }

    /**
     * Get the id of the entry
     * @return mixed
     */
    public function getId(){
        return $this->entry->id;
    }

    /**
     * Get the id of the form in which the entry is
     * @return mixed
     */
    public function getIdForm(){
        return $this->entry->fkForm;
    }

    /**
     * Get the name of the entry
     * @return mixed
     */
    public function getName(){
        return $this->entry->name;
    }

    /**
     * Get the title of the entry
     * @return mixed
     */
    public function getTitle(){
        return $this->entry->title;
    }

    /**
     * Get the description of the entry
     * @return mixed
     */
    public function getDescription(){
        return $this->entry->description;
    }

    /**
     * Get the name of the type of the entry
     * @return mixed
     */
    public function getTypeName(){
        return $this->entry->type;
    }

    /**
     * Get the type
     * @return ATypeEntry Type
     */
    public function getType(){
        return $this->type;
    }

    public function getHtml() {
        return view('form.formentryhtml')->with([
            'uid' => $this->getUniqId(),
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'type' => $this->getType(),
        ]);
    }
}