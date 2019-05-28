<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 28.05.19
 * Time: 19:53
 */

namespace Omega\Utils\Plugin\Form\Renderer;


use Illuminate\Contracts\Support\Renderable;
use Omega\Utils\Plugin\FormEntry;

abstract class AFormRenderer implements Renderable
{
    /**
     * @var FormEntry[]
     */
    private $entries = [];

    /**
     * Set the entries
     *
     * @param $entries FormEntry[]
     */
    public function setEntries($entries) {
        $this->entries = $entries;
    }

    /**
     * Get an entry by name
     *
     * @param $name string The name of the entry
     * @return FormEntry|null
     */
    public function getEntry($name) {
        if(!isset($this->entries[$name]))
            return null;

        return $this->entries[$name];
    }

    /**
     * Return an array with all entries (key is the name of the entry)
     * Entries are ordered.
     *
     * @return FormEntry[]
     */
    public function getEntries() {
        return $this->entries;
    }

    /**
     *
     * @return string
     */
    public abstract function render();
}