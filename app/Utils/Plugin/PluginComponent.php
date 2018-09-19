<?php
namespace Omega\Library\Plugin;

abstract class PluginComponent
{
	abstract public function formComponent($args);
	abstract public function updateComponent($args);
	abstract public function formSettings($args);
	abstract public function updateSettings($args);
	abstract public function display($args);
}