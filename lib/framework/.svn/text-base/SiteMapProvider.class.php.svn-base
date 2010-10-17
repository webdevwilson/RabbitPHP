<?php

interface SiteMapProvider {

	public function get_sitemap();

}

/**
 * SiteMapNode class
 */
class SiteMapNode extends Object {
	
	public $location;
	
	public $last_modified;
	
	public $change_frequency;
	
	public $priority;
	
	public function __construct($location,$last_modified=false,$change_frequency=false,$priority=false) {
		
		$this->location = $location;
		$this->last_modified = $last_modified;
		$this->change_frequency = $change_frequency;
		$this->priority = $priority;
		
	}
	
}

?>