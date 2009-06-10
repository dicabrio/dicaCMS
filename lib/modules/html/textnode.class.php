<?php
/**
 * HTML TEXT NODE
 *
 */
class TextNode implements Node {
	private $content;
	public function __construct($sContent) {
		$this->content = $sContent;
	}

	public function __toString() {
		return $this->content;
	}
}
?>