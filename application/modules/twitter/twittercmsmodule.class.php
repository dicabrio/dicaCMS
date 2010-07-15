<?php

class TwitterCmsModule implements CmsModuleController {

	/**
	 * @var PageModule
	 */
	private $oPageModule;

	/**
	 * @var PageText
	 */
	private $oTextContent;

	/**
	 * @var TemplateFile
	 */
	private $templateFile;

	/**
	 * @var array
	 */
	private $aErrors;

	/**
	 * @var CmsController
	 */
	private $oCmsController;

	/**
	 * construct the text line module
	 *
	 * @param string $sIdentifier
	 * @param Page $oPage
	 * @return void
	 */
	public function __construct(PageModule $oMod, Form $form, CmsController $oCmsController=null) {

		$this->oPageModule = $oMod;

		$this->oCmsController = $oCmsController;

		// load the data
		$this->load();
	}

	private function load() {
		$this->templateFile = Relation::getSingle('pagemodule', 'templatefile', $this->oPageModule);
		//$this->oTextContent = PageText::getByPageModule($this->oPageModule);
	}

	/**
	 * (non-PHPdoc)
	 * @see modules/CmsModuleController#getEditor()
	 */
	public function getEditor() {

		$module = current(Module::getForTemplates('twitter'));
		$blocks = TemplateFile::getFiles($module);
		$view = new View('twitter/twitterchooser.php');
		$view->assign('identifier', $this->oPageModule->getIdentifier());
		$view->assign('blocks', $blocks);

		$blockID = 0;
		if ($this->templateFile !== null) {
			$blockID = $this->templateFile->getID();
		}

		$view->assign('block_id', $blockID);
		return $view;
	}

	/* (non-PHPdoc)
	 * @see modules/CmsModuleController#validate()
	 */
	public function validate($mData) {
		return true;
	}

	/**
	 *
	 * @param $oReq
	 * @return boolean
	 */
	public function handleData(FormMapper $mapper) {

		$sModIdentifier = $this->oPageModule->getIdentifier();
		$blockID = (int)$oReq->post($sModIdentifier);
		if ($this->validate($blockID)) {
			if ($blockID > 0) {
				$block = new TemplateFile($blockID);

				try {
					Relation::add('pagemodule', 'templatefile', $this->oPageModule, $block);
				} catch (PDOException $e) {
					// trying to add a duplicate
				}
			}
			return true;
		}

		return false;

	}

	public function getErrors() {
		return $this->aErrors;
	}

	public function getIdentifier() {
		return $this->oPageModule->getIdentifier();
	}
}