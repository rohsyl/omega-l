<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 05.08.2017
 * Time: 18:45
 */
namespace Omega\Utils\Plugin;

use Omega\Repositories\FormRepository;

define('ATYPEENTRY', 'Omega\\Utils\\Plugin\\ATypeEntry');

class Type{

    private static $formRepository = null;

    private static function GetRepository(){
        if(self::$formRepository == null){
            self::$formRepository = new FormRepository(new \Omega\Models\Form(), new \Omega\Models\FormEntry(), new \Omega\Models\FormEntryValue());
        }
        return self::$formRepository;
    }

    public static function GetValues($idPlugin, $idModule, $idPage){
        $idForm = self::Get($idPlugin);
        $data = array();
        if(isset($idForm)){
            $entries = self::GetFormEntries($idForm);
            foreach($entries as $entry){
                $e = new FormEntry($entry, $idModule, $idPage);
                $data[$e->getName()] = $e->getType()->getObjectValue();
            }
        }
        return $data;
    }

    public static function FormExistsForModule($idPlugin){
        return self::GetRepository()->formExistsForModule($idPlugin);
    }

    public static function FormExistsForComponent($idPlugin){
        return self::GetRepository()->formExistsForComponent($idPlugin);
    }

    public static function FormRender($idPlugin, $idModule, $idPage)
    {
        $idForm = self::Get($idPlugin);
        if(isset($idForm)){
            $entries = self::GetFormEntries($idForm);
            $html = '';
            foreach($entries as $entry){
                $e = new FormEntry($entry, $idModule, $idPage);
                $html .= $e->getHtml();
            }
            return $html;
        }
        else{
            return view('form.formtype_notexists');
        }
    }

    public static function FormRenderByname($formName, $idModule, $idPage){
        $idForm = self::GetByName($formName);
        if(isset($idForm)){
            $entries = self::GetFormEntries($idForm);
            $html = '';
            foreach($entries as $entry){
                $e = new FormEntry($entry, $idModule, $idPage);
                $html .= $e->getHtml();
            }
            return $html;
        }
        else{
            return view('form.formtype_notexists');
        }
    }

    public static function FormSave($idPlugin, $idModule, $idPage){
        $idForm = self::Get($idPlugin);
        $success = true;
        if(isset($idForm)){
            $entries = self::GetFormEntries($idForm);
            foreach($entries as $entry){
                $e = new FormEntry($entry, $idModule, $idPage);
                $res = self::SaveValueForEntry($e);
                if(!$res)
                    $success = false;
            }
        }
        return $success;
    }

    public static function FormSaveByName($formName, $idModule, $idPage){
        $idForm = self::GetByName($formName);
        $success = true;
        if(isset($idForm)){
            $entries = self::GetFormEntries($idForm);
            foreach($entries as $entry){
                $e = new FormEntry($entry, $idModule, $idPage);
                $res = self::SaveValueForEntry($e);
                if(!$res)
                    $success = false;
            }
        }
        return $success;
    }

    protected static function Get($idPlugin){
        return self::GetRepository()->getFormId($idPlugin);
    }

    protected static function GetByName($name){
        return self::GetRepository()->getFormIdByName($name);
    }

    protected static function GetFormEntries($idForm, $headings = null){
        return self::GetRepository()->getFormEntries($idForm, $headings);
    }

    public static function GetValueForEntry($entryId, $moduleId){
       return self::GetRepository()->getValueForEntry($entryId, $moduleId);
    }


    public static function DuplicateValues($fromId, $toId){
        $values = self::GetRepository()->getAllValuesForModule($fromId);
        foreach($values as $value){
            $newValue = $value->replicate();
            $newValue->fkModule = $toId;
            $newValue->save();
        }
    }
    /**
     *
     * @param $entry FormEntry
     * @return mixed
     */
    protected static function SaveValueForEntry($entry){
        return self::GetRepository()->saveValueForEntry($entry);
    }
}