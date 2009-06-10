<?php

/** 
 * class that represents an aggregate
 *
 * @package hosting_package
 * @author Jason Perkins <jperkins@sneer.org>
 * @version $Revision: 1.2 $
 * @copyright Jason Perkins
 *
 */

class AttributesAggr extends Aggregate {

	/**
	 * constructur
	 *
	 * @access public
	 * @param datatype $paramname description 
	 * @return datatype description
	 */
	public function __construct() 
	{
		//parent::__construct();
	}


	/*
	 * Adds the passed $item(s) to the $this->collection
	 *
	 * @access public
	 * @returns integer The number of parts
	 */
	public function add($item) 
	{
		parent::add($item->getName(), $item);
		//$this->container[$item->getName()] = $item;
	}


	/**
	 * __get
	 *
	 * @access public
	 * @param datatype $paramname description 
	 * @return datatype description
	 */
	public function __get($property) 
	{
		if( $this->isPresent($property))
		{
			return parent::get($property)->getValue();
		}
	}


	/**
	 * __set
	 *
	 * @access public
	 * @param datatype $paramname description 
	 * @return datatype description
	 */
	public function __set($property, $value) 
	{
		if ($this->isPresent($property))
		{
			$item = parent::get($property);
			$item->setValue($value);
		}
	}


	/**
	 * __toString
	 *
	 * @access public
	 * @param datatype $paramname description 
	 * @return datatype description
	 */
	public function __toString() 
	{
		$string = "Attributes <br />";

		while ($attribute = parent::next())
		{
			$string .= $attribute->getName().": ".$attribute->getValue()."<br />";
		}

		return $string;
	}
	
	public function getAttributesString()
	{
		$string = " ";
		
		while ($attribute = parent::next())
		{
			$string .= "`".$attribute->getName()."`,";
		}
		
		return substr($string, 0, -1)." ";
	}
}

?>
