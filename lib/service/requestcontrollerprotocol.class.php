<?php

class RequestControllerProtocol implements ServiceProtocol {

/**
 * @var string
 */
	const SUFFIX = "Controller";

	/**
	 * maybe this will get of some use lateron
	 *
	 */
	const ACTION_DEFAULT 	= "_default";

	/**
	 * @var string
	 */
	const ACTION_INDEX 		= "_index";

	/**
	 * @var string
	 */
	const ACTION_404		= "_default";

	/**
	 * @var array
	 */
	private $arguments;

	/**
	 * @var Controller
	 */
	private $controller;

	/**
	 * @var string
	 */
	private $result;

	/**
	 * execute the stuff
	 *
	 */
	public function execute() {

		$controllerClass = ucfirst($this->controller).self::SUFFIX;
		$reflection = new ReflectionClass($controllerClass);

		$method = Util::getUrlSegment(1);

		if (empty($method)) {
		// no metod is called zo we provide the _index()
			$method = self::ACTION_INDEX;
		}

		try {
			$oReflMethod = $reflection->getMethod($method);
			if ($oReflMethod->isPrivate() || $oReflMethod->isProtected()) {
			// sorry this method is not accessable
				throw new ReflectionException('Not allowed to access this method');
			}
		} catch (ReflectionException $e) {
		// the method is not found so we go to the index
		// or the default for now the index
			$oReflMethod = $reflection->getMethod(self::ACTION_404);
		}

		// we need to check if it is a valid controller
		if (!($reflection->implementsInterface('Controller'))) {
			throw new Exception('Not a valid Controller');
		}
		$controller = $reflection->newInstance($oReflMethod->getName());
		$controller->setArguments($this->arguments);
		$this->result = $oReflMethod->invokeArgs($controller, array());
	}

	public function decode($newData) {
		$this->arguments = $newData;
	}

	/**
	 * Get the result in an encoded string for this protocol
	 *
	 * @return string
	 */
	public function encode() {
		return $this->result;
	}

	public function validate() {
	// check if request data is ok
		$this->controller = Util::getUrlSegment(0);
		if (empty($this->controller)) {
			throw new ProtocolException('No controller defined');
		}

		try {
			Util::validClass(ucfirst($this->controller).self::SUFFIX);
		} catch (ClassException $e) {
			throw new ProtocolException("Controller cannot be found");
		}
	}

	public function error($message) {

		if ($message instanceof Exception) {
			return $message->getTraceAsString();
		} else if (is_string($message)) {
			return $message;
		}
	}
}


