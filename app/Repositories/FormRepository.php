<?php
/**
 * Created by PhpStorm.
 * User: syzin
 * Date: 26.10.2018
 * Time: 16:09
 */

namespace Omega\Repositories;


use Illuminate\Support\Facades\DB;
use Omega\Models\Form;
use Omega\Models\FormEntry;
use Omega\Models\FormEntryValue;

class FormRepository
{
    private $form;
    private $formEntry;
    private $formEntryValue;

    public function __construct(Form $form, FormEntry $formEntry, FormEntryValue $formEntryValue) {
        $this->form = $form;
        $this->formEntry = $formEntry;
        $this->formEntryValue = $formEntryValue;
    }

    /**
     * Return true if the plugin has a form for modules
     * @param $idPlugin int The id of the plugin
     * @return bool
     */
    public function formExistsForModule($idPlugin){
        return DB::table('forms')
            ->where('fkPlugin', $idPlugin)
            ->where('isModule', true)
            ->exists();
    }

    /**
     * Return true if the plugin has a form for components
     * @param $idPlugin int The id of the plugin
     * @return bool
     */
    public function formExistsForComponent($idPlugin){
        return DB::table('forms')
            ->where('fkPlugin', $idPlugin)
            ->where('isComponent', true)
            ->exists();
    }

    /**
     * Get the form id of the plugin
     * @param $idPlugin int The id of the plugin
     * @return int|null The id of the form
     */
    public function getFormId($idPlugin){
        $form = $this->form
            ->where('fkPlugin', $idPlugin)
            ->where(function($q) {
                $q->where('isComponent', 1)
                    ->orWhere('isModule', 1);
            })
            ->first();
        return isset($form) ? $form->id : null;
    }

    /**
     * Get the form id by the form name
     * @param $formName string The name of the form
     * @return int|null The id of the form
     */
    public function getFormIdByName($formName){
        $form = $this->form
            ->where('name', $formName)
            ->first();
        return isset($form) ? $form->id : null;
    }

    /**
     * Get all entries for the given form
     * @param $idForm int The id of the form
     * @param null $headings
     * @return mixed
     */
    public function getFormEntries($idForm, $headings = null){
        return $this->formEntry
            ->where('fkForm', $idForm)
            ->when(isset($headings), function($q) use($headings) {
                $q->where('heading', $headings);
            })
            ->orderBy('order', 'ASC')
            ->get();
    }

    /**
     * Get a value for the given entry and the given module/component instance
     * @param $entryId int The id of the entry
     * @param $moduleId int The id of the module/componet instance
     * @return null|mixed
     */
    public function getValueForEntry($entryId, $moduleId){

        return $this->formEntryValue
            ->where('fkFormEntry', $entryId)
            ->where('fkModule', $moduleId)
            ->first();
    }

    /**
     * Get all values for the given moduleId
     * @param $moduleId int The id of the module/component
     * @return mixed
     */
    public function getAllValuesForModule($moduleId){
        return $this->formEntryValue
            ->where('fkModule', $moduleId)
            ->get();
    }

    /**
     * Save the value of the given entry
     * @param \Omega\Utils\Plugin\FormEntry $entry
     * @return boolean True if success
     */
    public function saveValueForEntry(\Omega\Utils\Plugin\FormEntry $entry){

        $newValue = $entry->getType()->getPostedValue();
        $valueEntry = $entry->getValue();
        if(isset($valueEntry)){

            $valueEntryModel = $this->formEntryValue->find($valueEntry->getId());
            $valueEntryModel->value = $newValue;
            $res = $valueEntryModel->save();
        }
        else {
            $valueEntryModel = new $this->formEntryValue;
            $valueEntryModel->value = $newValue;
            $valueEntryModel->fkFormEntry = $entry->getId();
            $valueEntryModel->fkModule = $entry->getIdModule();
            $res = $valueEntryModel->save();
        }
        return $res;
    }
}