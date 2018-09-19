<?php
namespace Omega\Utils\Plugin;

abstract class PluginModule
{
	abstract public function formModule($args);
	abstract public function updateModule($args);
	abstract public function formSettings($args);
	abstract public function updateSettings($args);
	abstract public function display($args);
}