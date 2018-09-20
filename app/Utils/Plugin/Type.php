<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 05.08.2017
 * Time: 18:45
 */
namespace Omega\Utils\Plugin;

use Omega\Library\Database\Dbs;

define('ATYPEENTRY', 'Omega\\Library\\Plugin\\ATypeEntry');

class Type{

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
        $count = Dbs::select('count(*) AS nbr')
            ->from('om_form')
            ->where('fkPlugin', '=', $idPlugin)
            ->andwhere('isModule', '=', 1)
            ->runScalar('nbr');
        return $count > 0;
    }

    public static function FormExistsForComponent($idPlugin){
        $count = Dbs::select('count(*) AS nbr')
            ->from('om_form')
            ->where('fkPlugin', '=', $idPlugin)
            ->andwhere('isComponent', '=', 1)
            ->runScalar('nbr');
        return $count > 0;
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
            return '<div class="alert alert-danger">Form type doesn\'t exists ...</div>';
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
            return '<div class="alert alert-danger">Form type doesn\'t exists ...</div>';
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
        $id = Dbs::select('id')
            ->from('om_form')
            ->where('fkPlugin', '=', $idPlugin)
            ->andwhere('(isComponent', '=', '1')
            ->orwhere('isModule', '=', '1)')
            ->runScalar();
        return $id;
    }

    protected static function GetByName($name){
        $id = Dbs::select('id')
            ->from('om_form')
            ->where('name', 'LIKE', '?')
            ->prepare(array($name))
            ->runScalar();
        return $id;
    }

    protected static function GetFormEntries($idForm, $headings = null){
        $entries = Dbs::select('*')
            ->from('om_form_entry')
            ->where('fkForm', '=', $idForm);

        if(isset($headings)){
            $entries->andwhere('heading', '=', $headings);
        }

        $entries = $entries->orderby('`order`', 'ASC')
            ->run()
            ->getAllArray();
        return $entries;
    }

    public static function GetValueForEntry($entryId, $moduleId){
        $stmt = Dbs::select('*')
            ->from('om_form_entry_value')
            ->where('fkFormEntry', '=', $entryId)
            ->andwhere('fkModule', '=', $moduleId)
            ->run();
        if($stmt->length() == 0){
            return null;
        }

        $value = $stmt->getRowArray(0);
        return $value;
    }

    protected static function SaveValueForEntry($entry){

        $newValue = $entry->getType()->getPostedValue();
        $valueEntry = $entry->getValue();
        if(isset($valueEntry)){
            // update
            $res = Dbs::update('om_form_entry_value')
                ->field('value')
                ->value($newValue)
                ->where('id', '=', $valueEntry->getId())
                ->run();
        }
        else {
            // insert
            $res =  Dbs::insert('om_form_entry_value')
                ->field('value', 'fkFormEntry', 'fkModule')
                ->value($newValue, $entry->getId(), $entry->getIdModule())
                ->run();
        }
        return $res;
    }
}