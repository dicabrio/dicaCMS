<?php
/**
 * this class is to save an xmlfeed to the DB
 */
class XMLFeed extends DataRecord {

	/**
	 * @param int $id
	 */
	public function __construct($id=null) {

		parent::__construct(__CLASS__, $id);
		
	}

	/**
	 * define the columns
	 */
	protected function defineColumns() {

		parent::addColumn('id', DataTypes::INT, false, true);
		parent::addColumn('pagemodule_id', DataTypes::INT, false, true);
		parent::addColumn('url', DataTypes::VARCHAR, 255, true);
		parent::addColumn('xml', DataTypes::TEXT, false, true);

	}

	/**
	 * 
	 * @param XMLGetter $xml
	 */
	public function setXML(XMLGetter $xml) {

		$this->setAttr('xml', $xml);
		$this->setAttr('url', $xml->getSourceLocation());
		
	}

	/**
	 * string
	 */
	public function getSource() {

		return $this->getAttr('url');

	}


	/**
	 * Set the corresponding PageModule
	 * 
	 * @param PageModule $mod
	 */
	public function setPageModule(PageModule $mod) {

		$this->setAttr('pagemodule_id', $mod->getID());

	}

	/**
	 * XMLFeed should be linked to a pagemodule. If this isn't the case it should raise an exception
	 */
	public function save() {

		$pageModuleId = $this->getAttr('pagemodule_id');
		if (empty($pageModuleId)) {
			throw new XMLFeedException('This feed is not linked to a pagemodule. IF we save this it will be lost');
		}

		parent::save();

	}

	/**
	 * Get the XMLFeed content for a given module. It returns an XMLFeed object when found. If not found it returns null
	 *
	 * @param PageModule $oPage
	 * @return XMLFeed
	 */
	public static function getByPageModule(PageModule $oPageModule) {
		$aResultModules = parent::findAll(__CLASS__, parent::ALL, new Criteria('pagemodule_id = :pageid', array('pageid' => $oPageModule->getID())));

		if (count($aResultModules) > 0) {
			return reset($aResultModules);
		}

		return null;
	}
}