<?php

interface App {

	public function run();
	
}

/**
 * Description of CMSapp
 *
 * @author robertcabri
 */
class CMSapp implements App {

	/**
	 *
	 * @var string
	 */
	private $applicationDirectory;

	/**
	 *
	 * @var string
	 */
	private $baseUrl;

	/**
	 *
	 * @param string $directory
	 */
	public function setApplactionDirectory($directory) {

		$this->applicationDirectory = $directory;
		
	}

	/**
	 *
	 * @param string $url
	 */
	public function setBaseUrl($url) {

		$this->baseUrl = $url;
		
	}

	/**
	 * 
	 */
	public function run() {

	}
}
