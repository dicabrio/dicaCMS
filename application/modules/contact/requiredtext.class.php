<?php


class RequiredText extends DomainText {


	public function __construct($text=null) {

		if ($text === null || empty($text)) {
			throw new InvalidArgumentException('text-is-empty', 1);
		}

		parent::__construct($text);
	}
}