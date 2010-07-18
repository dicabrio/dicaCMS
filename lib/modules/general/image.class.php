<?php
/**
 * Image class
 *
 * Handle some dimension shizzle
 */
class Image  {
	
	private $file;

	private $width;

	private $height;

	/**
	 * 
	 * @param FileManager $file
	 */
	public function __construct(FileManager $file) {

		$this->file = $file;
		list($this->width, $this->height) = getimagesize($this->file->getFullPath());
		
	}

	/**
	 *
	 * @return int
	 */
	public function getWidth() {

		return (int)$this->width;

	}

	/**
	 *
	 * @return int
	 */
	public function getHeight() {

		return (int)$this->height;

	}

}

