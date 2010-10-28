<?php

class Authentication {

	const KEY_LOGGEDIN = 'logged_in';

	const KEY_USERID = 'user_id';

	const KEY_IP = 'user_ip';

	const C_AUTH_SESSIONNAME = 'USER_AUTH';

	private static $oSession;

	private static $instance;

	/**
	 * This constructor can only be called by the class itself. It is a singleton
	 * @param $sSessionName
	 * @return void
	 */
	private function __construct($sSessionName) {
		self::$oSession = Session::getInstance($sSessionName);
	}

	/**
	 * check if the user is logged in
	 * @return boolean
	 */
	public function isLoggedIn() {
		if (self::$oSession->get(self::KEY_LOGGEDIN) === true
		&& self::$oSession->get(self::KEY_USERID)
		&& self::$oSession->get(self::KEY_IP) == $_SERVER['REMOTE_ADDR']) {
			return true;
		}

		return false;
	}

	/**
	 * get the loggedin User
	 * @return User
	 */
	public function getUser() {
		$userID = 0;
		if ($this->isLoggedIn()) {
			$userID = self::$oSession->get(self::KEY_USERID);
		}
		return new User($userID);
	}

	/**
	 * Login
	 *
	 * @param string $p_sUsername
	 * @param string $p_sPassword
	 * @return bool true if succes false if not
	 */
	public function login($p_sUsername, $p_sPassword) {
		try {
			$oUser = User::getByUsernameAndPassword($p_sUsername, $p_sPassword);
			if ($oUser instanceof User) {
				self::$oSession->set(self::KEY_LOGGEDIN, true);
				self::$oSession->set(self::KEY_USERID, $oUser->getID());
				self::$oSession->set(self::KEY_IP, $_SERVER['REMOTE_ADDR']);

				return true;
			} else {
				return false;
			}
		} catch(RecordException $e) {
			return false;
		}
	}

	public function logout() {
		self::$oSession->destroy();
	}

	/**
	 *	Singleton::getInstance()
	 *
	 *	the getInstance() method returns a single instance of the object
	 * @return Authentication
	 */
	public static function getInstance($sSessionName = 'default') {
		if (!isset(self::$instance)) {
			$object = __CLASS__;
			self::$instance = new $object($sSessionName);
		}
			
		return self::$instance;
	}
}
