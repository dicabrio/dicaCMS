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
	 * construct the text line module
	 *
	 * @param string $sIdentifier
	 * @param Page $oPage
	 * @return void
	 */
	public function __construct(PageModule $oMod, Form $form, CmsController $oCmsController=null) {

		$this->oPageModule = $oMod;
		$this->oCmsController = $oCmsController;
		$this->load();

	}

	/**
	 * load the needed information
	 */
	private function load() {

		$this->oStaticBlock = Relation::getSingle('pagemodule', 'staticblock', $this->oPageModule);

	}

	/**
	 * (non-PHPdoc)
	 * @see modules/Module#getEditor()
	 */
	public function getEditor() {

		$blocks = StaticBlock::find();
		$view = new View('staticblock/staticblockchooser.php');
		$view->assign('identifier', $this->oPageModule->getIdentifier());
		$view->assign('blocks', $blocks);

		$blockID = 0;
		if ($this->oStaticBlock !== null) {
			$blockID = $this->oStaticBlock->getID();
		}

		$view->assign('block_id', $blockID);
		return $view;

	}

	/* (non-PHPdoc)
	 * @see modules/Module#validate()
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

				try {
					$block = new StaticBlock($blockID);
					Relation::remove('pagemodule', 'staticblock', $this->oPageModule);
					Relation::add('pagemodule', 'staticblock', $this->oPageModule, $block);
					
				} catch (PDOException $e) {
					// trying to add a duplicate
				}
			}
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