<?php

class Area extends DataRecord {

	/**
	 *
	 * @var array
	 */
	private $userGroups = null;

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
		parent::addColumn('url', DataTypes::VARCHAR, 255, true);
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->getAttr('name');
	}

	/**
	 * @return string
	 */
	public function getUrl() {
		return $this->getAttr('url');
	}

	/**
	 *
	 * @return array
	 */
	public function getUserGroups() {

		if ($this->userGroups === null) {
			$this->userGroups = UserGroup::findByArea($this);
		}

		return $this->userGroups;
	}

	public function addUserGroup(UserGroup $group) {

		if ($group->getID() == 0) {
			$group->save();
		}

		$this->getUserGroups();
		$this->userGroups[$group->getID()] = $group;
		
	}

	/**
	 * Remove user group from this area
	 * @param UserGroup $group
	 */
	public function removeUserGroup(UserGroup $group) {

		$this->getUserGroups();
		if (isset($this->userGroups[$group->getID()])) {
			unset($this->userGroups[$group->getID()]);
		}
	}

	/**
	 * @param email $name
	 */
	public function setName($name) {
		$this->setAttr('name', $name);
	}

	/**
	 * @param string $url
	 */
	public function setUrl($url) {
		$this->setAttr('url', $url);
	}

	public function save() {

		// to get an ID
		parent::save();

		Relation::remove('area', 'user_group', $this);
		foreach ($this->userGroups as $group) {
			Relation::add('area', 'user_group', $this, $group);
		}

	}

	/**
	 * Find the area for the give page
	 * @param Page $page
	 * @return Area 
	 */
	public static function findByPage(Page $page) {
		$criteria = new Criteria('name = :name', array('name' => $page->getName().'.html'));
		$areas = parent::findAll(__CLASS__, parent::ALL, $criteria);
		if (count($areas) > 0) {
			return reset($areas);
		}

		return new Area(0);
	}

}

