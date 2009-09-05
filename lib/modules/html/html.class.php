<?php

/**
 * HTML factory for creating valid HTML Tags
 * For now holds only Form tags
 *
 */
class Html {

	private static $docType;

	/**
	 * not enable instantiation
	 *
	 */
	private function __construct() {}

	/**
	 * TODO implement it
	 *
	 * @param const $docType
	 */
	public static function setDocType($docType = '') {
		// set the docType
	}

	/**
	 * Get a select box like
	 * <select name="s">
	 * 	<option value="val">label</option>
	 * </select>
	 *
	 * @param string $name
	 * @param array $options associative array will generate "value" attributes in the options
	 * @param string $selected
	 * @param string $id
	 * @param array $other with this array you can add additional attributes like an "onclick" or a "class"
	 * @return Node
	 */
	public static function getSelect($name, $options, $selected=null, $id=null, $other=array()) {

		if (count($options) == 0) {
			throw new InvalidArgumentException('You should specify some options');
		}
		$node = new TagNode('select');

		$attr = array('name'=> $name);
		if ($id===null) {
			$attr['id'] = $name;
		} else {
			$attr['id'] = $id;
		}

		$attr = array_merge($attr, $other);
		self::addAttr($node, $attr);

		foreach ($options as $key => $value) {
			$bSel = false;
			if ($key == $selected) {
				$bSel = true;
			}
			$node->addChild(self::getOption($value, $key, $bSel));
		}

		return $node;
	}

	/**
	 * get a text field
	 *
	 * @param string $name
	 * @param string $value
	 * @param string $id
	 * @param array $other
	 * @return Node
	 */
	public static function getText($name, $value, $id=null, $other=array()) {
		$node = new TagNode('input');
		$attr = array('type'=>'text', 'name'=> $name, 'value'=>$value);
		if ($id===null) {
			$attr['id'] = $name;
		} else {
			$attr['id'] = $id;
		}

		$attr = array_merge($attr, $other);
			
		self::addAttr($node, $attr);

		return $node;
	}

	/**
	 * get a hidden field
	 *
	 * @param string $name
	 * @param string $value
	 * @return Node
	 */
	public static function getHidden($name, $value) {
		$node = new TagNode('input');
		self::addAttr($node, array('type'=>'hidden', 'name'=>$name, 'value' => $value));
		return $node;
	}

	/**
	 * Get an option tag
	 *
	 * @param string $label
	 * @param string $value
	 * @return Node
	 */
	public static function getOption($label, $value=null, $bSel=false) {

		$node = new TagNode('option');
		$attr = array();

		if ($value!==null) {
			$attr['value'] = $value;
		}

		if ($bSel === true) {
			$attr['selected'] = 'selected';
		}

		self::addAttr($node, $attr);

		$node->addChild(new TextNode($label));
		return $node;
	}

	/**
	 * @param string $name
	 * @param string $value
	 * @param string $bChecked
	 * @return Node
	 */
	public static function getCheckbox($name, $value, $bChecked=false) {
		// <input type="checkbox" value="1" name="checkname" checked="checked" />
		$node = new TagNode('input');
		$attr = array('type'=>'checkbox', 'name'=> $name, 'value'=> $value);

		if ($bChecked === true) {
			$attr['checked'] = 'checked';
		}

		self::addAttr($node, $attr);

		return $node;
	}

	/**
	 * get an anchor (a tag)
	 *
	 * @param string $sText
	 * @param string $sLink
	 * @param array $other
	 * @return TagNode
	 */
	public static function getAnchor($sText, $sLink, $other=array()) {
		$node = new TagNode('a');
		$attr = array('href' => $sLink);
		$attr = array_merge($attr, $other);
			
		self::addAttr($node, $attr);

		$node->addChild(new TextNode($sText));

		return $node;
	}

	/**
	 * Helper method for adding attributes to the node
	 *
	 * @param Node $node where to add the attributes
	 * @param array $attr the attributes to add
	 */
	private static function addAttr(Node $node, $attr) {
		if (count($attr) > 0) {
			foreach ($attr as $key => $value) {
				$node->addAttribute($key, $value);
			}
		}
	}

}




?>