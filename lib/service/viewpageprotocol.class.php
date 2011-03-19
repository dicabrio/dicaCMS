<?php

class ViewPageProtocol implements ServiceProtocol {
	/**
	 * @var string
	 */
	const ACTION_INDEX = "_index";

	/**
	 * @var string
	 */
	const ACTION_404 = "_default";

	/**
	 * @var array
	 */
	private $arguments;
	/**
	 * @var string
	 */
	private $result;

	/**
	 * execute the stuff
	 *
	 */
	public function execute() {


		$oPageViewer = new ViewPageController();
		$sPagename = Util::getUrlSegment(0);

		$this->result = $oPageViewer->show($sPagename);
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

		try {

			Util::validClass('ViewPageController');
		} catch (ClassException $e) {

			throw new ProtocolException("ViewPageController cannot be found");
		}
	}

	public function error($message) {

		if ($message instanceof Exception) {
			throw $message;
		} else if (is_string($message)) {
			throw new Exception($message);
		}
	}

}

