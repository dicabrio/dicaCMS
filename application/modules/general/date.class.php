<?php

class Date extends DomainText {

	const C_INPUT_FORMAT = "/\d{1,2}-\d{1,2}-\d{4}/";

	const C_OUTPUT_FORMAT = 'Y-m-d H:i:s';

	const C_NULL_VALUE = '0000-00-00 00:00:00';

	public function __construct($value=null) {

		if (empty($value) || self::C_NULL_VALUE == $value) {
			$value = self::C_NULL_VALUE;
		} else {
			$value = date(self::C_OUTPUT_FORMAT, strtotime($value));
		}

		parent::__construct($value);
	}
}