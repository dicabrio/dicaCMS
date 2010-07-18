<?php

class PriceListXML extends XMLGetter {

	public function __construct($value=null) {

		$priceListXSD = Setting::getByName('pricelistxsd');
		parent::__construct($value, $priceListXSD->getValue());
		
	}

}