<?php

class PageText extends DataRecord {

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
		parent::addColumn('pagemodule_id', DataTypes::INT, false, true);
		parent::addColumn('content', DataTypes::TEXT, false, true);

	}

	/**
	 * @param string $sType
	 * @return void
	 */
	public function setPageModule(PageModule $oPageModule) {
		$this->setAttr('pagemodule_id', $oPageModule->getID());
	}
	
	/**
	 * @return string
	 */
	public function getContent() {
		return $this->getAttr('content');
	}
	
	/**
	 * set the content
	 * 
	 * @param string $sContent
	 * @return void
	 */
	public function setContent($sContent) {
		$this->setAttr('content', $sContent);
	}

	/**
	 * Get the pagetext content for a given module. It returns an PageText object when found. If not found it returns PageText
	 * 
	 * @param PageModule $oPage
	 * @return PageText
	 */
	public static function getByPageModule(PageModule $oPageModule) {
		$aResultModules = parent::findAll(__CLASS__, parent::ALL, new Criteria('pagemodule_id = :pageid', array('pageid' => $oPageModule->getID())));
		
		if (count($aResultModules) > 0) {
			return reset($aResultModules);
		}

		return new PageText();
	}
}

