<?php

class StaticblockCmsModule implements CmsModuleController {

	/**
	 * @var PageModule
	 */
	private $oPageModule;

	/**
	 * @var StaticBlock
	 */
	private $oStaticBlock;

	/**
	 * @var array
	 */
	private $aErrors;

	/**
	 * @var CmsController
	 */
	private $oCmsController;

	/**
	 * @var Form
	 */
	private $form;

	/**
	 * @var FormMapper
	 */
	private $mapper;

	/**
	 * construct the text line module
	 *
	 * @param string $sIdentifier
	 * @param Page $oPage
	 * @return void
	 */
	public function __construct(PageModule $oMod, Form $form, FormMapper $mapper, CmsController $oCmsController=null) {

		$this->oPageModule = $oMod;
		$this->form = $form;
		$this->mapper = $mapper;
		$this->oCmsController = $oCmsController;

		$this->load();
		$this->defineForm();

	}

	/**
	 * load the needed information
	 */
	private function load() {

		$this->oStaticBlock = Relation::getSingle('pagemodule', 'staticblock', $this->oPageModule);

		if ($this->oStaticBlock === null) {
			$this->oStaticBlock = new StaticBlock();
		}

	}

	private function defineForm() {

		$blocks = StaticBlock::find();

		$selectStaticBlock = new Select($this->oPageModule->getIdentifier());
		$selectStaticBlock->setValue($this->oStaticBlock->getID());

		foreach ($blocks as $block) {
			$selectStaticBlock->addOption($block->getID(), $block->getIdentifier());
		}

		$this->form->addFormElement($selectStaticBlock->getName(), $selectStaticBlock);
		$this->mapper->addFormElementToDomainEntityMapping($selectStaticBlock->getName(), "Staticblock");

	}

	/**
	 * (non-PHPdoc)
	 * @see modules/Module#getEditor()
	 */
	public function getEditor() {

		$view = new View('staticblock/staticblockchooser.php');
		$view->assign('form', $this->form);
		$view->assign('identifier', $this->oPageModule->getIdentifier());

		return $view;

	}

	/**
	 *
	 * @param $oReq
	 * @return boolean
	 */
	public function handleData() {

		$sModIdentifier = $this->oPageModule->getIdentifier();
		$staticBlock = $this->mapper->getModel($sModIdentifier);

		try {
			Relation::remove('pagemodule', 'staticblock', $this->oPageModule);
			Relation::add('pagemodule', 'staticblock', $this->oPageModule, $staticBlock);

		} catch (PDOException $e) {
			// trying to add a duplicate
		}

		return false;

	}

	/**
	 *
	 * @return string
	 */
	public function getIdentifier() {

		return $this->oPageModule->getIdentifier();
	}
}