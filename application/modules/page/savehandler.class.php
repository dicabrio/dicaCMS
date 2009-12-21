<?php


class SaveHandler implements FormHandler {

	private $formmapper;

	public function __construct(FormMapper $formmapper) {
		$this->formmapper = $formmapper;
	}

	public function handleForm(Form $oForm) {
		try {

			echo 'page is submitted<br />';

			$this->formmapper->constructModelsFromForm();
			echo get_class($this->formmapper->getModel('pagename'));
			echo get_class($this->formmapper->getModel('template_id'));



		} catch (FormMapperException $e) {
			test($e->getMessage());
		}
	}

}