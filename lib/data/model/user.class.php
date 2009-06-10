<?php

class User extends DataRecord
{
	/**
	 * constructor
	 *
	 * @param int $id
	 */
	public function __construct($id=null)
	{
		parent::__construct(__CLASS__, $id);
	}

	/**
	 * define the columns of the table you want to access with this object
	 *
	 */
	protected function defineColumns()
	{
		parent::addColumn('id', DataTypes::INT, false, true);
		parent::addColumn('email', DataTypes::VARCHAR, 255, true);
		parent::addColumn('username', DataTypes::VARCHAR, 30, true);
		parent::addColumn('password', DataTypes::CHAR, 32, true);
		parent::addColumn('active', DataTypes::INT, 1, true);
	}

	/**
	 * @return string
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * @return string
	 */
	public function getUsername() {
		return $this->username;
	}

	/**
	 * @return bool
	 */
	public function isActive() {
		return $this->active;
	}

	/**
	 * @param email $sEmail
	 */
	public function setEmail($sEmail) {
		$this->email = $sEmail;
	}

	/**
	 * @param string $sUsername
	 */
	public function setUsername($sUsername) {
		$this->username = $sUsername;
	}

	/**
	 * Set the image active or not
	 *
	 * @param bool $bActive
	 */
	public function setActive($bActive) {

		if ($bActive == true) {
			$this->active =  1;
		} else if ($bActive == false) {
			$this->active = 0;
		}
	}
	
	public static function getByUsernameAndPassword($sUsername, $sPassword) {
		$oQP = new QueryPart('username = :username AND password = MD5(:password) AND active = :active');
		$oQP->addBind('username', $sUsername);
		$oQP->addBind('password', $sPassword);
		$oQP->addBind('active', 1);
		$aReturnVals = parent::findAll(__CLASS__, parent::ALL, $oQP);
		if (count($aReturnVals) > 0) {
			return reset($aReturnVals);
		}
		
		return false;
	}
	
}



?>