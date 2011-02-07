<?php

class HtmltextblockPageModule extends TextblockPageModule {


	/**
	 * 
	 * @return string
	 */
	public function getContents() {

		$this->isHTMLContent();
		return parent::getContents();
		
	}

}