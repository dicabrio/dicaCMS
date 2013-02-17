<?php

/**
 *
 * 	The Session class
 * 	This class is an extend of the Singleton class. This means that you will get only
 * 	on instance of the session class. As only one user can be logged in!.
 */
class Session {

	private static $m_oInstance;

	/**
	 * 	Session::__construct()
	 *
	 * 	This constructor will check if the user is logged in.
	 *
	 * 	@return	void
	 */
	private function __construct($sSessionName='default') {
		// Start the session
//		session_name($sSessionName);
		session_start();
	}

	public function get($key) {
		if (!isset($_SESSION[$key])) {
			return null;
		}
		//return unserialize($this->aSessionVars[$key]);
		return $_SESSION[$key];
	}

	public function set($key, $value) {
		//$this->aSessionVars[$key] = serialize($value);
		if ($value === null) {
			unset($_SESSION[$key]);
		} else {
			$_SESSION[$key] = $value;
		}
	}

	public function has($key) {
		return isset($_SESSION[$key]);
	}

	public function destroy() {
		unset($_SESSION);
		session_destroy();
	}

	/**
	 * Singleton::getInstance()
	 *
	 * the getInstance() method returns a single instance of the object
	 * @return Session
	 */
	public static function getInstance($sSessionName='default') {
		if (!isset(self::$m_oInstance)) {
			$object = __CLASS__;
			self::$m_oInstance = new $object($sSessionName);
		}

		return self::$m_oInstance;
	}

}