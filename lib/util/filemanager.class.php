<?php

class FileManager
{
	const 	SEP					= '/';

	private $filename			= null;

	private $newFilename		= null;

	private $path				= null;

	private $accessibleFiles 	= array();

	/**
	 * @param string $pFile
	 * @throws FileNotFoundException
	 */
	public function __construct($pFile)
	{
		$this->breakFileName($pFile);
		$this->validateFile();
	}

	public function getPath() {
		return $this->path;
	}

	public function getFilename() {
		return $this->filename;
	}

	public function getFullPath() {
		return $this->path . self::SEP . $this->filename;
	}
	
	public function getContents() {
		return file_get_contents($this->path . self::SEP . $this->filename);
	}

	/**
	 * Move the given file to the specified destination
	 * TODO: check on if it is a uploaded file. We should be able te move not uploaded files
	 *
	 * @param string $destination
	 * @param string $rename
	 * @return boolean
	 * @throws DirException
	 */
	public function moveTo($destination, $rename=null)
	{
		$sFilename = $this->filename;
		$this->validateDestination($destination);
		if ($rename != null) {
			$sFilename = $rename;
		}

		if (!move_uploaded_file($this->path.self::SEP.$this->filename, $destination.self::SEP.$sFilename)) {
			throw new FileException('problem while moving uploaded file');
		}

		$this->path = $destination;
		$this->filename = $sFilename;
	}

	/**
	 * renamin the file to new filename
	 *
	 * @param string $newFilename
	 */
	public function rename($newFilename)
	{
		// rename the file
		//use rename() function
	}

	/**
	 * delete the filename
	 * @throws
	 */
	public function delete()
	{
		$this->validateFile();
		if (!unlink($this->path.self::SEP.$this->filename)) {
			throw new FileException('File: '.$this->path.self::SEP.$this->filename.' cannot be deleted');
		}

		return true;
	}

	/**
	 * @param string $filename
	 */
	private function breakFileName($filename) {
		if (false !== ($pos = strpos($filename, self::SEP))) {
			$afilename = explode(self::SEP, $filename);
			$this->filename = array_pop($afilename);
			$this->path = implode(self::SEP, $afilename);
		}
		else
		{
			$this->filename = $filename;
		}
	}

	/**
	 * @throws FileNotFoundException
	 *
	 */
	private function validateFile()
	{
		// check if file exists
		if (!file_exists($this->path.self::SEP.$this->filename))
		{
			throw new FileNotFoundException('File '.$this->path.self::SEP.$this->filename.' cannot be found');
		}

	}

	/**
	 *	Validate the given destination
	 *	@throws DirException
	 */
	private function validateDestination($destination)
	{
		if (!is_dir($destination)) {
			throw new DirException('Given destination "'.$destination.'" is not a directory');
		}

		if (!is_writable($destination)) {
			throw new DirNotWritableException('Directory '.$destination.' is not writable');
		}

		// we passed the validation stuff!
	}
}

class DirException extends Exception {}
class FileException extends Exception {}
