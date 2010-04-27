<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of configclass
 *
 * @author robertcabri
 */
class Config extends DataRecord {

	public function __construct($id = null) {
		parent::__construct(__CLASS__, $id);
	}

	/**
	 * attribute
	 */
	protected function defineColumns() {
		parent::addColumn('id', DataTypes::INT, false, true);
		parent::addColumn('name', DataTypes::VARCHAR, 255, true);
		parent::addColumn('value', DataTypes::VARCHAR, 255, true);
	}

	/**
	 *
	 * @param string $columns
	 * @return Config
	 */
	public static function getByName($name) {

		$qp = new Criteria("name=:name", array('name' => $name));
		$result = parent::findAll(__CLASS__, self::ALL, $qp);

		if (is_array($result) && count($result) > 0) {
			return current($result);
		}

		return null;
	}

	/**
	 *
	 * @return string
	 */
	public function getValue() {

		return $this->getAttr('value');
		
	}

}
