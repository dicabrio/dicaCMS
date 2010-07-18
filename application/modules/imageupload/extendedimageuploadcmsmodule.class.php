<?php

class ExtendedimageuploadCmsModule extends ImageuploadCmsModule {

	/**
	 * (non-PHPdoc)
	 * @see modules/Module#getEditor()
	 */
	public function getEditor() {
		$view = parent::getEditor();
		$view->extended = true;
		return $view;
	}

}