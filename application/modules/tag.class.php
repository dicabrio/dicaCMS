<?php

class Tag extends DataRecord {

	/**
	 * constructor
	 *
	 * @param int $id
	 */
	public function __construct($id=null) {
		parent::__construct(__CLASS__, $id);
	}

	/**
	 * define the columns of the table you want to access with this object
	 *
	 */
	protected function defineColumns() {
		parent::addColumn('id', DataTypes::INT, false, true);
		parent::addColumn('name', DataTypes::VARCHAR, 255, true);
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->getAttr('name');
	}

	/**
	 * @param email $sEmail
	 */
	public function setName($text) {
		$this->setAttr('name', $text);
	}

	/**
	 * find user by username and password. It finds only users that are active
	 *
	 * @param string $type
	 * @param DataRecord $record
	 * @return array
	 */
	public static function findByLinkedItem($type, DataRecord $record) {

		return Relation::getOther($type, 'tag', $record);

	}

	/**
	 * find the
	 * @param string $name
	 * @return array
	 */
	public static function findByName($name) {

		$oCrit = new Criteria('name = :name');
		$oCrit->addBind('name', $name);
		return parent::findAll(__CLASS__, parent::ALL, $oCrit);
		
	}

}

class UserException extends Exception {}