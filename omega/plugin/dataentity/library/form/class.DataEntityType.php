<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 29.05.2018
 * Time: 12:56
 */

namespace Omega\Plugin\Dataentity\Library\Form;


use Omega\Library\Plugin\Type;
use Omega\Library\Util\Util;
use Omega\Plugin\Dataentity\Library\BLL\DataEntityDataManager;
use Omega\Plugin\Dataentity\Library\DTO\DataEntityData;

/**
 * Class DataEntityType
 * @package Omega\Plugin\Dataentity\Library\Form
 */
class DataEntityType extends Type
{
    /**
     * Render a form by name
     * @param $formName string The name of the form
     * @param int|null $idData The id of the data (the value)
     * @param int|null $idPage The id of the page on which the form is
     * @return string The HTML
     */
    public static function FormRenderByname($formName, $idData = null, $idPage = null)
    {
        $idForm = self::GetByName($formName);
        if(isset($idForm)){
            $entries = self::GetFormEntries($idForm);
            $data = self::GetFormDatas($idData);
            $html = '';
            foreach($entries as $entry){
                $value = isset($data->values[$entry['id']]) ? $data->values[$entry['id']] : null;
                $e = new DataEntityFormEntry($entry, $idData, $value);
                $html .= $e->getHtml();
            }
            return $html;
        }
        else{
            return '<div class="alert alert-danger">Form type doesn\'t exists ...</div>';
        }
    }

    /**
     * Save a form
     * @param $formName string The name of the form
     * @param int|null $idData The id of the data (the value)
     * @param int|null $idPage The id of the page on which the form is
     * @return bool True if success
     */
    public static function FormSaveByName($formName, $idData = null, $idPage = null)
    {
        $idForm = self::GetByName($formName);
        if(isset($idForm)){
            $entries = self::GetFormEntries($idForm);
            $data = self::GetFormDatas($idData);
            foreach($entries as $entry){
                $value = isset($data->values[$entry['id']]) ? $data->values[$entry['id']] : null;
                $e = new DataEntityFormEntry($entry, $idData, $value);
                self::AddValueInData($data, $e);
            }
            $data->fkForm = $idForm;
            $data->values = json_encode($data->values);
            $res = DataEntityDataManager::Save($data);
            return $res;
        }
        else{
            return false;
        }

    }


    public static function GetValues($formName, $idData, $idPage = null){
        $idForm = self::GetByName($formName);
        $data = array();
        if(isset($idForm)){
            $entries = self::GetFormEntries($idForm);
            $entityData = self::GetFormDatas($idData);
            foreach($entries as $entry){
                $value = isset($entityData->values[$entry['id']]) ? $entityData->values[$entry['id']] : null;
                $e = new DataEntityFormEntry($entry, $idData, $value);
                $data[$e->getId()] = $e->getType()->getObjectValue();
            }
        }
        return $data;
    }

    public static function GetValuesHeadingOnly($formName, $idData, $idPage = null){
        $idForm = self::GetByName($formName);
        $data = array();
        if(isset($idForm)){
            $entries = self::GetFormEntries($idForm, true);
            $entityData = self::GetFormDatas($idData);
            foreach($entries as $entry){
                $value = isset($entityData->values[$entry['id']]) ? $entityData->values[$entry['id']] : null;
                $e = new DataEntityFormEntry($entry, $idData, $value);
                $data[$e->getId()] = $e->getType()->getObjectValue();
            }
        }
        return $data;
    }

    /**
     * @param $data
     * @param $entry DataEntityFormEntry
     */
    private static function AddValueInData($data, $entry)
    {
        $data->values[$entry->getId()] = $entry->getType()->getPostedValue();
    }

    /**
     * Get form datas
     * @param $idData int|null The id of the data or null if creation needed
     * @return null|DataEntityData
     */
    protected static function GetFormDatas($idData){
        $data = isset($idData) ? DataEntityDataManager::GetData($idData) : new DataEntityData();
        $data->values = json_decode($data->values, true);
        return $data;
    }
}