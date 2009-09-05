<?php



/**
 * HTML DOM NODE
 *
 */
class TagNode implements Node {

	private $sNodeName = '';

	/**
	 * the attributes for this Tag
	 *
	 * @var ArrayObject
	 */
	private $oAttributes;

	/**
	 * Enter description here...
	 *
	 * @var ArrayObject
	 */
	private $oChildren;

	/**
	 * TODO validate the tags given as param
	 *
	 * @param string $sNodeName
	 */
	public function __construct($sNodeName) {
		$this->sNodeName = $sNodeName;
		$this->aAttributes = new ArrayObject();
		$this->aChildren = new ArrayObject();
	}

	public function addAttribute($attr, $attrValue) {
		$this->aAttributes->offsetSet($attr, $attrValue);
	}

	/**
	 * Add a child tag
	 *
	 * @param Tag $tag
	 */
	public function addChild(Node $node) {
		$this->aChildren->offsetSet(null, $node);
	}

	/**
	 * Convert this object to a string
	 *
	 * @return string
	 */
	public function __toString() {

		if ($this->hasChildren()) {
			$sNode = '<'.$this->sNodeName.$this->getAttrString().'>';

			foreach ($this->aChildren as $node) {
				$sNode .= $node->__toString();
			}

			$sNode .= '</'.$this->sNodeName.'>';
			return $sNode;
		}

		$sNode = '<'.$this->sNodeName.$this->getAttrString().' />';
		return $sNode;
	}

	private function getAttrString() {
		if ($this->hasAttributes()) {
			$sAttrString = " ";
			foreach ($this->aAttributes as $attrName => $attrValue) {
				$sAttrString .= $attrName.'="'.$attrValue.'" ';
			}
			return $sAttrString;
		}
		return "";
	}

	public function hasAttributes() {
		if ($this->aAttributes->count() > 0) {
			return true;
		}

		return false;
	}

	/**
	 * Check if the tag has children!
	 *
	 * @return bool
	 */
	public function hasChildren() {
		if ($this->aChildren->count() > 0) {
			return true;
		}

		return false;
	}
}

