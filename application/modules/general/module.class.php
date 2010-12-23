<?php

class Module extends DataRecord implements DomainEntity {

	/**
	 * @param int $id
	 * @return void
	 */
	public function __construct($id=null) {

		parent::__construct(__CLASS__, $id);
		
	}

	/**
	 * @return void
	 */
	protected function defineColumns() {
		parent::addColumn('id', DataTypes::INT, false, true);
		parent::addColumn('name', DataTypes::VARCHAR, 255, true);
		parent::addColumn('template', DataTypes::INT, false, true);
		parent::addColumn('active', DataTypes::INT, false, true);
		parent::addColumn('url', DataTypes::VARCHAR, 255, true);
	}

	/**
	 * @return string
	 */
	public function getName() {

		return $this->getAttr('name');
		
	}

	/**
	 * @param string $sTitle
	 */
	public function setName($sTitle) {

		$this->setAttr('name', $sTitle);
	}

	/**
	 *
	 * @return string
	 */
	public function getUrl() {

		return $this->getAttr('url');

	}

	public static function find() {
		return parent::findAll(__CLASS__, parent::ALL);
	}

	public static function getMenu() {

		$crit = new Criteria("url != '' AND active = 1");
		return parent::findAll(__CLASS__, parent::ALL, $crit);

	}

	/**
	 *
	 * @param string $modulename
	 * @return Module
	 */
	public static function getForTemplates($modulename = null) {

		$where = "template = :template";
		$bind = array('template' => 1);
		if ($modulename != null) {
			$where .= " AND name = :name";
			$bind['name'] = $modulename;
		}
		$crit = new Criteria($where, $bind);

		$result = parent::findAll(__CLASS__, parent::ALL, $crit);
		if (count($result) > 0) {
			return $result;
		}

		return null;
	}

	public function __toString() {
		return "jemoeder";
	}

}

