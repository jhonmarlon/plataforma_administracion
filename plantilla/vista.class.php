<?php
class Vista {
	
	var $page;
	var $breadcrumb;
	var $jquery_form_required = false;
	var $_PAGE_CONFIG;
	var $_PAGE_PERMISSIONS;
	
	function Vista($page,$_PAGE_CONFIG,$_PAGE_PERMISSIONS) {
		$this->page = $page;
		$this->_PAGE_CONFIG = $_PAGE_CONFIG;
		$this->_PAGE_PERMISSIONS = $_PAGE_PERMISSIONS;
		$this->buildBreadcrumb ();
	}
	private function buildBreadcrumb() {
		if(array_key_exists($this->page,$this->_PAGE_CONFIG)){
			$res = $this->_PAGE_CONFIG[$this->page];
			$this->buildBreadcrumParams ($res["big"],$res["small"]);
		}		
	}
	private function buildBreadcrumParams($big, $small) {
		$this->breadcrumb = "<section class=\"content-header\">";
		$this->breadcrumb .= "<h1>";
		$this->breadcrumb .= "$big <small>$small</small>";
		$this->breadcrumb .= "</h1>";
		$this->breadcrumb .= "<ol class=\"breadcrumb\">";
		$this->breadcrumb .= "<li><a href=\"index.php\"><i class=\"fa fa-home\"></i> Inicio</a></li>";
		$this->breadcrumb .= "<li class=\"active\">$small</li>";
		$this->breadcrumb .= "</ol>";
		$this->breadcrumb .= "</section>";
	}
}

?>
