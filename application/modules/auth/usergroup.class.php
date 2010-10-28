<?php
/**
 *
 *
 *
 * 
 */
class UserGroup extends DataRecord {

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
		parent::addColumn('title', DataTypes::VARCHAR, 255, true);
		parent::addColumn('description', DataTypes::TEXT, false, true);
	}

	public function getTitle() {

		return $this->getAttr('title');

	}

	public function setTitle($title) {

		$this->setAttr('title', $title);

	}

	/**
	 * return all the User Groups that are available in the database
	 * Factory Method
	 * @return array
	 */
	public static function findAll() {

		return parent::findAll(__CLASS__, parent::ALL);

	}

	/**
	 *
	 * @param User $user
	 * @return array
	 */
	public static function findByUser(User $user) {

		$userGroups = Relation::getOther('user', 'usergroup', $user);
		$newOrderedGroups = array();
		foreach ($userGroups as $group) {
			$newOrderedGroups[$group->getID()] = $group;
		}

		return $newOrderedGroups;

	}

	public static function findByArea(Area $area) {

		$userGroups = Relation::getOther('area', 'usergroup', $area);
		$newOrderedGroups = array();
		foreach ($userGroups as $group) {
			$newOrderedGroups[$group->getID()] = $group;
		}

		return $newOrderedGroups;

	}

}