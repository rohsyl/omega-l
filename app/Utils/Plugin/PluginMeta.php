<?php
namespace Omega\Utils\Plugin;

use Omega\Utils\Path;

class PluginMeta {
	
	private $name;
	private $title;
	private $author;
	private $version;
	private $description;
	private $options;
	
	private $metadata;
	
	public function __construct($name) {
		
		$this->name = $name;
		$path = Path::Combine(PLUGINPATH, $this->name);
		
		$this->metadata = json_decode(file_get_contents($path.'/plugin.json'), true);
		
		$this->title = $this->metadata['pluginTitle'];
		$this->version = $this->metadata['pluginVersion'];
		$this->author = $this->metadata['author'];
		$this->description = $this->metadata['description'];
		$this->options = isset($this->metadata['options']) ? $this->metadata['options'] : array();
	}
	
	public function getName() { return $this->name; }
	public function getVersion() { return $this->version; }
	public function getAuthor() { return $this->author; }
	public function getDescription() { return $this->description; }
	public function getTitle() { return $this->title; }
	
	public function get($key) { return $this->metadata[$key]; }

	public function getOption($key){ return isset($this->options[$key]) ? $this->options[$key] : null; }
}