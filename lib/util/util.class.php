<?php

class ClassException extends Exception {}

class Util {
	private static $url = null;

	public static function validClass($className) {
		if (!class_exists($className, true)) {
			throw new ClassException('Specified '.$className.' cannot be found');
		}
	}

	/**
	 * Enter description here...
	 *
	 * @param int $index the segment of the url string
	 * @return string
	 */
	public static function getUrlSegment($index) {
		if (self::$url != null && isset(self::$url[$index])) {

			return self::$url[$index];

		} else if (isset($_REQUEST['url'])) {

			self::$url = explode('/',$_REQUEST['url']);

			if (isset(self::$url[$index]))
			{
				return self::$url[$index];
			}
		}

		return "";
	}

	public static function gotoPage($sPageName) {
		header('location:'.$sPageName);
		exit;
	}

	/**
	 * it will trancend an array with a given path. the path should have a dotted notation like:
	 * test.item1.subitem1
	 *
	 * if the given path isn't found it will return the path string
	 *
	 * @param array $aHayStack
	 * @param string $sPath
	 * @return mixed
	 */
	public static function arrayPath($aHayStack, $sPath) {
		$mLocalHayStack = $aHayStack;

		$aFields = array();
		if (false !== strpos($sPath, '.')) {
			$aFields = explode('.', $sPath);
		} else {
			$aFields[] = $sPath;
		}

		foreach ($aFields as $sField) {
			if (isset($mLocalHayStack[$sField])) {
				$mLocalHayStack = $mLocalHayStack[$sField];
			} else {
				// the path could not be trancended
				return $sPath;
			}
		}

		return $mLocalHayStack;
	}

	/**
	 * add a package location on the fly
	 * @param $sPackageLocation
	 * @return void
	 */
	public static function import($sPackageLocation) {

		$sep = ':';
		if (false !== strpos(PHP_OS, 'WIN')) {
			$sep = ';';
		}

		ini_set('include_path', ini_get('include_path').$sPackageLocation.$sep);
	}

	public static function importModules($sModuleLocation) {
		$oDir = dir($sModuleLocation);
		while (false !== ($sModule = $oDir->read())) {
			$sImportMod = $sModuleLocation.'/'.$sModule;
			if (is_dir($sImportMod)) {
				Util::import($sImportMod);
			}
		}
	}
}

