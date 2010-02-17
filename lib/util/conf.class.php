<?php

class Conf {

	private static $sDefaultLocation = 'default';

	private static $sDirName;

	private static $aConf;

	private static $sServer;

	private function __construct() {}

	public static function setServer($sServer) {
		self::$sServer = $sServer;
	}

	public static function setDirectory($sDirName) {
		self::$sDirName = $sDirName;
	}

	public static function get( $psFieldname )
	{
		$sConfFile = '';

		if (strpos($psFieldname, '.')) {
			$aFields = explode('.', $psFieldname);
			$sConfFile = array_shift($aFields);

			if (!isset(self::$aConf[$sConfFile])) {
				$sConfigFile = self::$sDirName.'/'.self::$sServer.'/'.strtolower($sConfFile).'.php';
				if (!file_exists($sConfigFile)) {
					$sConfigFile = self::$sDirName.'/'.self::$sDefaultLocation.'/'.strtolower($sConfFile).'.php';
					if (!file_exists($sConfigFile)) {
						throw new InvalidArgumentException('Config file cannot be found: '.$sConfigFile);
					}
				}

				require_once($sConfigFile);
				// the $config variable is defined in the configfile
				self::$aConf[$sConfFile] = $config;
			}

			return Util::arrayPath(self::$aConf, $psFieldname);
		} else {
			throw new InvalidArgumentException('given config is not available: '.$psFieldname);
		}

	}
}