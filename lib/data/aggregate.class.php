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

class Aggregate implements Iterator 
{

	/**
	 *	array of properties
	 *	@var array
	 */
	private $container = array();

	/**
	 * resets iterator list to its start
	 *
	 * @access public 
	 * @param type $containeriable
	 * @return datatype description
	 *
	 */
	public function isPresent($value) 
	{
		return array_key_exists($value, $this->container); 
	}

	/**
	 * resets iterator list to its start
	 *
	 * @access public 
	 * @param type $containeriable
	 * @return datatype description
	 *
	 */
	public function rewind() 
	{
		reset($this->container);
	}


	/**
	 * returns the current item
	 *
	 * @access public 
	 * @return datatype description
	 *
	 */
	public function current() 
	{
		return current($this->container);
	}


	/**
	 * returns the key of the current item
	 *
	 * @access public 
	 * @return datatype description
	 *
	 */
	public function key() 
	{
		return key($this->container);
	}


	/**
	 * movers iterator to the next item in the list
	 *
	 * @access public 
	 * @return datatype description
	 *
	 */
	public function next() 
	{
		return next($this->container);
	}

	/**
	 * says if there are additional items in the list
	 *
	 * @access public 
	 * @return datatype description
	 *
	 */
	public function valid() 
	{
		return $this->current() !== false;
	}


	/*
	 * Returns the number of parts
	 *
	 * @access public
	 * @returns integer The number of parts
	 */
	public function count() 
	{
		return count($this->container);
	}


	/*
	 * Adds the passed $item(s) to the $this->collection
	 *
	 * @access public
	 * @returns integer The number of parts
	 */
	public function add($key, $item) 
	{
		$this->container[$key] = $item;
	}

	public function get($key)
	{
		if (isset($this->container[$key]))
			return $this->container[$key];
		
		return null;
	}

	/*
	 * Removes the passed item(s) from $this->collection
	 *
	 * @access public
	 * @returns integer The number of parts
	 */
	public function remove($item) 
	{

		$found = false;

		if (is_array($item)) 
		{
			foreach ($item as $currentIndex => $currentItem) 
			{
				foreach ($this->container as $containerIndex => $containerItem)
				{
					if ($currentItem === $containerItem) 
					{
						unset($this->container[$containerIndex]);
						$found = true;
					}
				}
			}
		} 
		else 
		{			
			foreach ($this->container as $currentIndex => $currentItem) 
			{
				if ($currentItem === $item)
				{
					unset($this->container[$currentIndex]);
					$found = true;
				}
			}
		}
	}
}

?>