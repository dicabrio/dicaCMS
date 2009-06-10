<?php

class QueryCache {

	public static $queries = array();

	public static $querycounts = array();

	public static function addQuery($sQuery) {
		if (false !== ($key = array_search($sQuery, self::$queries))) {
			self::$querycounts[$key]++;
		} else {
			$key = count(self::$queries);
			self::$queries[$key] = $sQuery;
			self::$querycounts[$key] = 1;
		}
	}

	/**
	 * let see what kind of querie I have called
	 *
	 */
	public function __destruct() {
		if (DEBUG) {
			test(self::$queries);
			test(self::$querycounts);
		}
	}
}

?>