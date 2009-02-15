<?php

abstract class AWidget {
	
	private $aWidgets = array();
	
	abstract function getLabel();
	
	abstract function render();
	
	public function addWidget(Widget $w) {
		$this->aWidgets[] = $w;
	}
}

class Header extends AWidget {
	private $oTemplate;
	private $aWidgets;
	const C_LABEL_HEADER = 'header';
	public function render() {
	}
	
	public function getLabel() {}
}

class Page extends AWidget {

	private $oTemplate;
	
	private $sIdentifier;
	
	const C_LABEL_PAGE = 'page';
	
	public function __construct($mValue) {
	
		if (is_numeric($mValue)) {
			$id;
		} else if (is_string($mValue)) {
			// load by name
		} else {
			throw new Exception('cannot load this page');
		}
		
		// 
	
	}
	
	public function getLabel() {
		
	}
	
	public function render() {
	
	}
}

$oPage = new Page('pagename');
echo $oPage->render();

/**





*/
?>