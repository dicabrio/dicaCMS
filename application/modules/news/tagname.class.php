<?php

class TagName extends DomainText {


	public function __construct($text=null) {

		if ($text === null || empty($text)) {
			throw new InvalidArgumentException('text-is-empty', 1);
		}

		if (!preg_match('/^[a-z-_]+$/', $text)) {
			throw new InvalidArgumentException('malformed');
		}

		parent::__construct($text);
	}
}