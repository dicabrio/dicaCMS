<?php
/**
 *	class Lang
 *
 */
class Lang
{
	const C_LANG_EXT = 'php';

	/**
	 * @var string
	 */
	private static $sDirName = '/lang';

	/**
	 * @var array
	 */
	private static $lang = array();
	
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

	public static function get( $psFieldname )
	{
		$sLangFile = '';

		if (strpos($psFieldname, '.')) {
			$aFields = explode('.', $psFieldname);
			$sLangFile = array_shift($aFields);
			
			if (!isset(self::$lang[$sLangFile])) {
				if (!file_exists(self::$sDirName.'/'.self::$l.'/'.strtolower($sLangFile).'.'.self::C_LANG_EXT)) {
					return $psFieldname;
				}
				
				require_once(self::$sDirName.'/'.self::$l.'/'.strtolower($sLangFile).'.'.self::C_LANG_EXT);
				self::$lang[$sLangFile] = $lang;
			}
	
			return Util::arrayPath(self::$lang, $psFieldname);
		} else {
			throw new InvalidArgumentException('given language is not available: '.$psFieldname);
		}

	}

}
?>