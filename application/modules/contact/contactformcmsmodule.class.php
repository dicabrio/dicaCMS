<?php

class ContactformCmsModule implements CmsModuleController {

	const MAX_LENGTH = 255;

	/**
	 * @var PageModule
	 */
	private $oPageModule;

	/**
	 * @var PageText
	 */
	private $oTextContent;

	/**
	 * @var array
	 */
	private $aErrors;

	/**
	 *
	 * @var array
	 */
	private $pages;

	private $email;

	private $page;

	/**
	 * construct the text line module
	 *
	 * @param string $sIdentifier
	 * @param Page $oPage
	 * @return void
	 */
	public function __construct(PageModule $oMod, Form $form, CmsController $oCmsController=null) {

		$this->oPageModule = $oMod;

		// load the data
		$this->load();
	}

	private function load() {

		$this->oTextContent = PageText::getByPageModule($this->oPageModule);
		
		$values = explode(',', $this->oTextContent->getContent());
		
		if (!isset($values[1])) {
			$this->email = $values[0];
			$this->page = 0;
		} else {
			$this->email = $values[0];
			$this->page = $values[1];
		}

		$this->pages = Page::findActive();

	}

	/**
	 * (non-PHPdoc)
	 * @see modules/Module#getEditor()
	 */
	public function getEditor() {
		$oView = new View('contact/contactconfig.php');

		$select = new Select('bedanktpagina');

		$select->addOption(0, Lang::get('general.choose'));
		foreach ($this->pages as $page) {
			$select->addOption($page->getID(), $page->getName());
		}
		$select->setValue($this->page);

		$oView->select = $select;
		$oView->sMaxLength = self::MAX_LENGTH;
		$oView->sIdentifier = $this->oPageModule->getIdentifier();
		if ($this->oTextContent === null) {
			$oView->sContent = '';
		} else {
			$oView->sContent = $this->email;
		}
		return $oView;
	}

	/* (non-PHPdoc)
	 * @see modules/Module#validate()
	 * TODO make UT8 compliant
	*/
	public function validate($mData) {
		if (is_string($mData) && strlen($mData) <= self::MAX_LENGTH) {
			return true;
		}
		return false;
	}

	/**
	 *
	 * @param $oReq
	 * @return boolean
	 */
	public function handleData(FormMapper $mapper) {

		$sModIdentifier = $this->oPageModule->getIdentifier();
		if ($this->validate($oReq->post($sModIdentifier))) {

			if ($this->oTextContent === null) {
				$this->oTextContent = new PageText();
			}

			$val = $oReq->post('bedanktpagina');

			$this->oTextContent->setContent($oReq->post($sModIdentifier).','.$val);
			$this->oTextContent->setPageModule($this->oPageModule);
			$this->oTextContent->save();




			return true;
		}

		return false;
	}

	/**
	 *
	 * @return array
	 */
	public function getErrors() {
		return $this->aErrors;
	}

	/**
	 *
	 * @return string
	 */
	public function getIdentifier() {

		return $this->oPageModule->getIdentifier();
	}
}