<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 18.03.19
 * Time: 12:40
 */

namespace Omega\Utils\Plugin\Form;


use Omega\Models\Form;
use Omega\Models\FormEntry;
use Omega\Models\Plugin;
use Omega\Repositories\FormRepository;
use Omega\Repositories\PluginRepository;

class FormFactory
{
    /**
     * @var PluginRepository
     */
    private static $pluginRepository = null;

    /**
     * @return PluginRepository
     */
    private static function GetPluginRepository(){
        if(self::$pluginRepository == null){
            self::$pluginRepository = new PluginRepository(new Plugin());
        }
        return self::$pluginRepository;
    }

    /**
     * This method allow you to create a form
     *
     * @param string $formName The name of the form
     * @param string $pluginName The name of the plugin
     * @param bool $isModule Is this form a module
     * @param bool $isComponent Is this form a component
     * @param string $title The title of the form
     * @return Form The form
     */
    public function newForm(string $formName, string $pluginName, bool $isModule, bool $isComponent, string $title) {
        $form = new Form();
        $form->name = $formName;
        $form->title = $title;
        $form->isModule = $isModule;
        $form->isComponent = $isComponent;
        $form->fkPlugin = self::GetPluginRepository()->getByName($pluginName)->id;
        $form->save();
        return $form;
    }

    /**
     * This method allow you to create an entry for a given form
     *
     * @param $form string|Form The form name or an instance of the form
     * @param string $entryName The name for the entry
     * @param int $order The order
     * @param string $type The type
     * @param array $param The parameters as an arry
     * @param string $title The title
     * @param string $description The description
     * @param bool $mandatory True if this entry must be mandatory
     */
    public function newFormEntry($form, string $entryName, int $order, string $type, array $param, string $title, string $description, bool $mandatory = false) {

        // If the $form is not an instance of form, then we assume that $form is the name of the form as a string
        if (!$form instanceof Form){
            // we need the id of the form
            $formId = FormRepository::Get()->getFormIdByName($form);
        }
        else{
            $formId = $form->id;
        }

        $formEntry = new FormEntry();
        $formEntry->name = $entryName;
        $formEntry->order = $order;
        $formEntry->type = $type;
        $formEntry->param = json_encode($param);
        $formEntry->title = $title;
        $formEntry->description = $description;
        $formEntry->mandatory = $mandatory;
        $formEntry->heading = 0;
        $formEntry->fkForm = $formId;
        $formEntry->save();
        return $formEntry;
    }

}