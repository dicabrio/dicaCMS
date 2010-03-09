<?php


class Upload implements DomainEntity {


	public function __construct($fileInfo) {
		test($fileInfo);
	}

	public function __toString() {

	}

	public function equals($object) {

		if ($object === null) {
			return null;
		}

		if (!is_a($object, get_class($this))) {
			return false; 
		}
		
		return true;
	}
}