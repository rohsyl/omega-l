<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 29.05.2018
 * Time: 12:58
 */

namespace Omega\Plugin\Dataentity\Library\Form;

use Omega\Library\Plugin\FormEntry;
use Omega\Library\Util\Util;

/**
 * Class DataEntityFormEntry
 * @package Omega\Plugin\Dataentity\Library\Form
 */
class DataEntityFormEntry extends FormEntry
{
    /**
     * @var int The id of the data value
     */
    private $idData;

    /**
     * @var array The data values
     */
    private $data;

    /**
     * DataEntityFormEntry constructor.
     * @param $entry
     * @param $idData
     * @param $data
     */
    public function __construct($entry, $idData, $data)
    {
        $this->idData = $idData;
        $this->data = $data;
        parent::__construct($entry, null, null);
    }

    /**
     * Load the value of the form entry
     */
    protected function loadValue()
    {
        if(isset($this->data)){
            $this->value = new DataEntityFormEntryValue($this->idData, $this->data);
            return;
        }
        $this->value = null;
    }

    /**
     * Get the uniqid
     * @return string Return the uniqid
     */
    protected function getUniqId(){
        return 'entry-'.$this->getId().'-'.$this->idData;
    }
}