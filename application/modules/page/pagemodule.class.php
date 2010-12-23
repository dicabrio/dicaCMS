<?php

class PageModule extends DataRecord {

	/**
	 * constructor
	 *
	 * @param int $id
	 */
	public function __construct($id=null) {

		parent::__construct(__CLASS__, $id);
		
	}

	/**
	 * (non-PHPdoc)
	 * @see data/DataRecord#defineColumns()
	 */
	protected function defineColumns() {

		parent::addColumn('id', DataTypes::INT, false, true);
		parent::addColumn('page_id', DataTypes::INT, false, true);
		parent::addColumn('identifier', DataTypes::VARCHAR, 255, true);
		parent::addColumn('type', DataTypes::VARCHAR, 255, true);

	}

	/**
	 * get the module identifier
	 *
	 * @return string
	 */
	public function getIdentifier() {

		return $this->getAttr('identifier');
		
	}

	/**
	 * @param string $sIdentifier
	 * @return void
	 */
	public function setIdentifier($sIdentifier) {
		$this->setAttr('identifier', $sIdentifier);
	}

	/**
	 * @param Page $oPage
	 * @return void
	 */
	public function setPage(Page $oPage) {
		$this->setAttr('page_id', $oPage->getID());
	}

	/**
	 * This is the module type.
	 * Examples: TextBlock, TextLine, StaticBlock, etc
	 *
	 * @return string
	 */
	public function getType() {
		return $this->getAttr('type');
	}

	/**
	 * @param string $sType
	 * @return void
	 */
	public function setType($sType) {
		$this->setAttr('type', $sType);
	}

	/**
	 * Get the modules for the given page. The keys are the identifiers of the modules
	 * @param Page $oPage
	 * @return array
	 */
	public static function getByPage(Page $oPage) {
		$aResultModules = parent::findAll(__CLASS__, parent::ALL, new Criteria('page_id = :pageid', array('pageid' => $oPage->getID())));
		$aIdentModules = array();
		foreach ($aResultModules as $oModule) {
			$oModule->setPage($oPage);
			$aIdentModules[$oModule->getIdentifier()] = $oModule;
		}
		return $aIdentModules;
	}
}

