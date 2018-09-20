<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 29.05.2018
 * Time: 13:03
 */

namespace Omega\Plugin\Dataentity\Library\Form;

use Omega\Library\Plugin\FormEntryValue;

/**
 * Class DataEntityFormEntryValue
 * @package Omega\Plugin\Dataentity\Library\Form
 */
class DataEntityFormEntryValue extends FormEntryValue
{
    /**
     * DataEntityFormEntryValue constructor.
     * @param $id
     * @param $value
     */
    public function __construct($id, $value)
    {
        parent::__construct(null);
        $this->value = array(
            'id' => $id,
            'value' => $value
        );
    }
}