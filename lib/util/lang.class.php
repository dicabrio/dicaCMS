<?php
/**
 *	class Lang
 *
 */
class Lang
{
	/**
	 * @var string
	 */
	const C_LANG_EXT = 'php';

	/**
	 * @var string
	 */
	const C_FILE_PREFIX = 'dict';

	/**
	 * @var string
	 */
	private static $sDirName = 'lang';

	/**
	 * @var array language cache
	 */
	private static $lang = array();

	/**
	 * @var string default lang
	 */
	private static $l = 'EN';

	/**
	 * do not instantiate
	 *
	 */
	private function __construct() {}

	public static function setDirectory($sDirName) {
		self::$sDirName = $sDirName;
	}

	public static function setLang($lang) {
		self::$l = $lang;
	}

	public static function get( $psFieldname ) {
		$sLangFile = '';

		if (strpos($psFieldname, '.')) {
			$aFields = explode('.', $psFieldname);
			$sLangFile = array_shift($aFields);
				
			if (!isset(self::$lang[$sLangFile])) {

				$sFileToInclude = self::$sDirName.'/'.self::$l.'/'.self::C_FILE_PREFIX.strtolower($sLangFile).'.'.self::C_LANG_EXT;
				if (!file_exists($sFileToInclude)) {
					return $psFieldname;
				}

				require_once($sFileToInclude);
				self::$lang[$sLangFile] = $lang;
			}
				
			$sReturnValue = Util::arrayPath(self::$lang, $psFieldname);
				
			$aFuncArgs = func_get_args();
			if (count($aFuncArgs) > 1) {
				array_shift($aFuncArgs);
				array_unshift($aFuncArgs, $sReturnValue);
				return call_user_func_array('sprintf', $aFuncArgs);
			}
				
			return $sReturnValue;
				
		} else {
			throw new InvalidArgumentException('given language is not available: '.$psFieldname);
		}
	}

}
