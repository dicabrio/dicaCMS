<?php
/**
 * 
 * 
 * Modifications to user table:
 * 
 *	ALTER TABLE  `user` ADD  `activationkey` VARCHAR( 255 ) NOT NULL;
 *	ALTER TABLE  `user` ADD  `name` VARCHAR( 255 ) NOT NULL;
 * 
 */
class User extends DataRecord {

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
		parent::addColumn('email', DataTypes::VARCHAR, 255, true);
		parent::addColumn('username', DataTypes::VARCHAR, 30, true);
		parent::addColumn('password', DataTypes::CHAR, 32, true);
		parent::addColumn('active', DataTypes::INT, 1, true);
		parent::addColumn('name', DataTypes::VARCHAR, 255, true);
		parent::addColumn('activationkey', DataTypes::VARCHAR, 255, true);
	}

	/**
	 * @return string
	 */
	public function getEmail() {
		return $this->getAttr('email');
	}

	/**
	 * @return string
	 */
	public function getUsername() {
		return $this->getAttr('username');
	}

	/**
	 *
	 * @return array
	 */
	public function getUserGroups() {

		if ($this->userGroups === null) {
			$this->userGroups = UserGroup::findByUser($this);
		}

		return $this->userGroups;
	}

	public function addUserGroup(UserGroup $group) {

		$this->getUserGroups();
		$this->userGroups[] = $group;
		
	}

	/**
	 * @return bool
	 */
	public function isActive() {
		return $this->getAttr('active');
	}

	/**
	 * @param email $sEmail
	 */
	public function setEmail(Email $sEmail) {
		$this->setAttr('email', $sEmail);
	}

	/**
	 * @param string $sUsername
	 */
	public function setUsername(Username $sUsername) {
		$this->setAttr('username', $sUsername);
	}

	/**
	 *
	 * @param string $name
	 */
	public function setName($name) {
		$this->setAttr('name', $name);
	}

	/**
	 *
	 * @param string $activationkey
	 */
	public function setActivationkey($activationkey) {
		$this->setAttr('activationkey',$activationkey);
	}

	/**
	 * Set the image active or not
	 *
	 * @param bool $bActive
	 */
	public function setActive($bActive) {

		if ($bActive == true) {
			$this->setAttr('active',  1);
		} else if ($bActive == false) {
			$this->setAttr('active', 0);
		}
	}
	
	/**
	 * set the password for the User
	 * 
	 * @param Password $sPassword
	 */
	public function setPassword(Password $sPassword) {
		$this->setAttr('password', md5($sPassword->getValue()));
	}

	public function save() {

		parent::save();
		// we need the ID of the user first
		if (is_array($this->userGroups)) {
			foreach ($this->userGroups as $userGroup) {
				Relation::remove('user', 'usergroup', $this);
				Relation::add('user', 'usergroup', $this, $userGroup);
			}
		}
	}

	/**
	 *
	 * @param Area $area 
	 */
	public function watch(Area $area) {

		$userGroupsOfArea = $area->getUserGroups();
		if (count($userGroupsOfArea) > 0) {
			$this->inAllowedUserGroup($userGroupsOfArea);
		}
	}
	
	private function inAllowedUserGroup($userGroupsOfArea) {

		if (count($this->getUserGroups()) == 0 || count(array_intersect_key($this->getUserGroups(), $userGroupsOfArea)) == 0) {
			//check if you have a similar usergroup
			throw new UserException('no-rights');
		}
	}


	/**
	 * find user by username and password. It finds only users that are active
	 *
	 * @param string $sUsername
	 * @param string $sPassword
	 * @return User
	 */
	public static function getByUsernameAndPassword(Username $sUsername, Password $sPassword) {
		$oCrit = new Criteria('username = :username AND password = MD5(:password) AND active = :active');
		$oCrit->addBind('username', $sUsername);
		$oCrit->addBind('password', $sPassword);
		$oCrit->addBind('active', 1);
		$aReturnVals = parent::findAll(__CLASS__, parent::ALL, $oCrit);
		if (count($aReturnVals) > 0) {
			return reset($aReturnVals);
		}

		return null;
	}

	/**
	 *
	 * @param string18 $activationKey
	 * @return User
	 */
	public static function findByActivationKey($activationKey) {
		$users = parent::findAll(__CLASS__, parent::ALL, new Criteria('activationkey = :actkey', array('actkey' => $activationKey)));
		if (is_array($users) && count($users) > 0) {
			return reset($users);
		}

		return null;
	}

}

class UserException extends Exception {}