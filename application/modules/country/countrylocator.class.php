<?php
/**
 * 
 */
class CountryLocator {

	const LOCATOR_API = 'http://api.hostip.info/country.php?ip=';

	/**
	 *
	 * @var string
	 */
	public function getCountryByIP($ip) {

		$curlResource = curl_init(self::LOCATOR_API.$ip);

		curl_setopt($curlResource, CURLOPT_RETURNTRANSFER, true);
		return curl_exec($curlResource);

	}

}