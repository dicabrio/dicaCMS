<?php



/**
 * HTML DOM NODE
 *
 */
class TagNode implements Node {

	private $nodeName = '';

	/**
	 * the attributes for this Tag
	 *
	 * @var Collection
	 */
	private $attributes;

	/**
	 * Enter description here...
	 *
	 * @var Collection
	 */
	private $children;

	/**
	 * TODO validate the tags given as param
	 *
	 * @param string $nodeName
	 */
	public function __construct($nodeName) {
		$this->nodeName = $nodeName;
		$this->attributes = new Collection();
		$this->children = new Collection();
	}

	public function addAttribute($attr, $attrValue) {
		$this->attributes->set($attr, $attrValue);
	}

	/**
	 * Add a child tag
	 *
	 * @param Tag $tag
	 */
	public function addChild(Node $node) {
		$this->children->set(null, $node);
	}

	/**
	 * Convert this object to a string
	 *
	 * @return string
	 */
	public function __toString() {

		if ($this->hasChildren()) {
			$sNode = '<'.$this->nodeName.$this->getAttrString().'>';

			foreach ($this->children->toArray() as $node) {
				$sNode .= $node->__toString();
			}

			$sNode .= '</'.$this->nodeName.'>';
			return $sNode;
		}

		$sNode = '<'.$this->nodeName.$this->getAttrString().' />';
		return $sNode;
	}

	private function getAttrString() {
		if ($this->hasAttributes()) {
			$sAttrString = " ";
			foreach ($this->attributes->toArray() as $attrName => $attrValue) {
				$sAttrString .= $attrName.'="'.$attrValue.'" ';
			}
			return $sAttrString;
		}
		return "";
	}

	public function hasAttributes() {
		if ($this->attributes->size() > 0) {
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
		if ($this->children->size() > 0) {
			return true;
		}

		return false;
	}
}

?>