<?php
/**
 * Description of textnodeclass
 *
 * @author robertcabri
 */
class Paragraph extends DomainText {

	/**
	 *
	 * @param string $sValue
	 */
	public function __construct($sValue=null) {
		parent::__construct($sValue);
	}

	/**
	 * 
	 */
	public function cleanUpHTML() {
		// check if it has paragraph wrapt around it

		$text = trim($this->getValue());
		$text = strip_tags($text, '<p><a><img><br><strong><em><ul><li><ol>');

		$emptyParagraphPattern = "/<p\b[^>]*>(\S+)?<\/p>(<br \/>)?/";
		$paragraphWithAttributesPattern = "/<p\b[^>]*>(.*?)<\/p>(<br \/>)?/";

		$text = preg_replace($emptyParagraphPattern, '', $text);

		$stripper = new StripAttributes();
		$stripper->allow = array('id', 'class');
		$stripper->exceptions = array('img' => array('src', 'alt', 'title', 'width', 'height'), 'a' => array('href', 'title'));
		$text = $stripper->strip($text);


//		$text = preg_replace_callback($paragraphWithAttributesPattern, 'removeGarbageTags', $text);
//		$text = preg_replace_callback($breaksOutsideParagraphPattern, 'removeGarbageBreaks', $text);

		$this->setValue($text);

	}
}

function removeGarbageTags($matches) {
	return '<p>'.$matches[1].'</p>';
}

function removeGarbageBreaks($matches) {
	return '';
}
