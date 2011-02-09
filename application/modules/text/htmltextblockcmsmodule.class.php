<?php

class HtmltextblockCmsModule extends TextblockCmsModule {

	/**
	 * construct the text line module
	 *
	 * @param string $sIdentifier
	 * @param Page $oPage
	 * @return void
	 */
	public function __construct(PageModule $oMod, Form $form) {
		parent::__construct($oMod, $form);
		parent::enableHtmlEditor();
	}

}