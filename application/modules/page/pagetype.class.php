<?php


class PageType extends DataRecord {

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
		parent::addColumn('label', DataTypes::VARCHAR, 255, true);

	}

	/**
	 * @return string
	 */
	public function getName() {

		return $this->getAttr('name');
		
	}

	public function setName($name) {

		$this->setAttr('name', $name);

	}

	/**
	 * @return string
	 */
	public function getLabel() {

		return $this->getAttr('label');

	}

	public function setLabel($label) {

		$this->setAttr('label', $label);

	}


	/**
	 * @return string
	 */
	public function  __toString() {

		return $this->getName();

	}

	/**
	 *
	 * @return array
	 */
	public static function findAll() {

		return parent::findAll(__CLASS__, parent::ALL);

	}

	/**
	 *
	 * @param string $name
	 * @return Tag
	 */
	public static function findByName($name) {

		$result = parent::findAll(__CLASS__, parent::ALL, new Criteria("name = :name", array('name' => $name)));
		if (count($result) > 0) {
			return reset($result);
		}

		return null;
	}
}