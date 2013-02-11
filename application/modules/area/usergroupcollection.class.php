<?php

class UserGroupCollection {

	/**
	 *
	 * @var array
	 */
	private $value;

	/**
	 *
	 * @param array $value
	 */
	public function __construct($value = null) {
		
		if (!is_array($value)) {

			throw new InvalidArgumentException('value-not-array');
		}

		$this->value = $value;
	}

	/**
	 *
	 * @return array
	 */
	public function toArray() {

		$groups = array();
		foreach ($this->value as $value) {
			$userGroup = new UserGroup($value);
			$groups[$userGroup->getID()] = $userGroup;
		}

		return $groups;
	}



}