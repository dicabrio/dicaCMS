<?php
/**
 * handle stuff with files with this class
 *
 */
class FileManager {

	/**
	 * @var const
	 */
	const SEP = '/';

	/**
	 *
	 * @var string
	 */
	private $filename;

	/**
	 *
	 * @var string
	 */
	private $path;

	/**
	 *
	 * @var string
	 */
	private $extension;

	/**
	 * Constructor checks if the given file exists
	 *
	 * @param string $pFile
	 * @param boolean $create
	 * @throws FileNotFoundException
	 */
	public function __construct($pFile, $create=false) {

		$this->breakFileName($pFile);
		if ($create === false) {
			$this->validateFile();
		} else if ($create === true) {
			$this->createFile($pFile);
		}

	}

	public function getPath() {

		return realpath($this->path);

	}

	public function getFilename() {

		return $this->filename;

	}

	/**
	 *
	 *
	 * @return string
	 */
	public function getFullPath() {

		if (empty($this->path)) {
			return realpath($this->filename);
		}

		return realpath($this->path . self::SEP . $this->filename);

	}

	/**
	 * get the extension of the file
	 *
	 * @return string
	 */
	public function getExtension() {

		$afile = explode('.',$this->filename);
		$extension = array_pop($afile);

		return $extension;

	}

	/**
	 * @return get the contents of the file
	 */
	public function getContents() {

		$sFileContents = file_get_contents($this->getFullPath());
		return $sFileContents;

	}

	/**
	 *
	 * @param mixed $contents
	 * @return boolean
	 */
	public function setContents($contents) {

		return file_put_contents($this->getFullPath(), $contents);
		
	}

	/**
	 *
	 * @return boolean
	 */
	private function exists() {

		return (file_exists($this->getFullPath()) && is_file($this->getFullPath()));

	}

	/**
	 * create a file
	 * 
	 * @param string $pFilename
	 */
	private function createFile($pFilename) {
		touch($pFilename);
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
	public function moveTo($destination, $rename=null) {

		$sFilename = $this->filename;
		$this->validateDestination($destination);
		if ($rename != null) {
			$sFilename = $rename;
		}

		if (is_uploaded_file($this->getFullPath())) {
			if (!move_uploaded_file($this->getFullPath(), $destination.self::SEP.$sFilename)) {
				throw new FileException('problem while moving uploaded file');
			}
		} else {
			rename($this->getFullPath(), $destination.self::SEP.$sFilename);
		}

		$this->path = $destination;
		$this->filename = $sFilename;



	}

	/**
	 * returns the mimetype of the file
	 *
	 * @return string
	 */
	public function getMimeType() {

		$fileinfo = new finfo(FILEINFO_MIME);
		return $fileinfo->file($this->getFullPath());

	}

	/**
	 * delete the filename
	 * @throws
	 */
	public function delete() {

		$this->validateFile();
		if (!unlink($this->getFullPath())) {
			throw new FileException('File: '.$this->getFullPath().' cannot be deleted');
		}

		return true;

	}

	/**
	 * breaks the filestring apart to path filename extension (filename is with extension included)
	 * @param string $filename
	 */
	private function breakFileName($filename) {

		if (false !== ($pos = strpos($filename, self::SEP))) {
			// get filename
			$afilename = explode(self::SEP, $filename);
			$this->filename = array_pop($afilename);
			// get path
			$this->path = implode(self::SEP, $afilename);
			// get extension
			$afile = explode('.',$this->filename);
			$this->extension = $this->getExtension();
		} else {
			$this->filename = $filename;
		}

	}

	/**
	 * Validate if file exists
	 * @throws FileNotFoundException
	 */
	private function validateFile() {

		if (!$this->exists()) {
			throw new FileNotFoundException('File '.$this->getFullPath().' cannot be found');
		}

	}

	/**
	 *	Validate the given destination
	 *	@throws DirException
	 */
	private function validateDestination($destination) {

		if (!is_dir($destination)) {
			throw new DirException('Given destination "'.$destination.'" is not a directory');
		}

		if (!is_writable($destination)) {
			throw new DirNotWritableException('Directory '.$destination.' is not writable');
		}

	}
}

class DirException extends Exception {

}
class FileException extends Exception {

}
