<?php


class TextLine implements Module {

	/**
	 * (non-PHPdoc)
	 * @see modules/Module#isDirectEditable()
	 */
	public function editOnPage() {
		return true;
	}

	/**
	 * (non-PHPdoc)
	 * @see modules/Module#getEditor()
	 */
	public function getEditor() {
		return "";
	}

	/* (non-PHPdoc)
	 * @see modules/Module#getEditLink()
	 */
	public function getEditLink() {
		return "";
	}

	/* (non-PHPdoc)
	 * @see modules/Module#setData()
	 */
	public function setData($aData) {

	}
	
	/* (non-PHPdoc)
	 * @see modules/Module#validate()
	 */
	public function validate($aData) {
		
	}
}