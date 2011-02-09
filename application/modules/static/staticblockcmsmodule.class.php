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
	 * @var Form
	 */
	private $form;

	/**
	 * @var Select
	 */
	private $selectElement;

	/**
	 *
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
	public function __construct(PageModule $oMod, Form $form) {

		$this->oPageModule = $oMod;
		$this->form = $form;

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

		$this->selectElement = new Select($this->oPageModule->getIdentifier());
		$this->selectElement->setValue($this->oStaticBlock->getID());
		$this->selectElement->addOption(0, Lang::get('general.choose'));

		foreach ($blocks as $block) {
			$this->selectElement->addOption($block->getID(), $block->getIdentifier());
		}

		$this->form->addFormElement($this->selectElement->getName(), $this->selectElement);

	}

	public function addFormMapping(FormMapper $mapper) {

		$mapper->addFormElementToDomainEntityMapping($this->selectElement->getName(), "Staticblock");
		$this->mapper = $mapper;

	}

	/**
	 * (non-PHPdoc)
	 * @see modules/Module#getEditor()
	 */
	public function getEditor() {

		$view = new View(Conf::get('general.dir.templates').'/staticblock/staticblockchooser.php');
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