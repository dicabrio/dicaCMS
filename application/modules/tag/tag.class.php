<?php


class Tag extends DataRecord {

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

	}

	/**
	 * @return string
	 */
	public function getName() {

		return $this->getAttr('name');
		
	}

	public function setName(TagName $name) {

		$this->setAttr('name', $name->getValue());

	}

	public function getMedia() {

		return Relation::getOther('media', 'tag', null, $this);

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