<?php

/**
 * represents an attribute of an active_record
 *
 * @package active_record
 * @author Jason Perkins <jperkins@sneer.org>
 * @version $Revision: 1.1.1.1 $
 * @copyright Jason Perkins
 */
class Attribute {

	/**
	 *	description of variable
	 *	@var type
	 */
	private $name = null;

	/**
	 *	description of variable
	 *	@var type
	 */
	private $value = null;

	/**
	 *	description of variable
	 *	@var type
	 */
	private $formattedName = '';

	/**
	 *	description of variable
	 *	@var type
	 */
	private $size = 0;

	/**
	 *	description of variable
	 *	@var type
	 */
	private $type = null;

	/**
	 *	description of variable
	 *	@var type
	 */
	private $isNullable = false;

	/**
	 *	description of variable
	 *	@var type
	 */
	private $isFk = false;

	/**
	 *	description of variable
	 *	@var type
	 */
	private $fkTable = null;
	
	private $joinType = 'inner';


	/**
	 * constructor
	 *
	 * @access public
	 * @param datatype $variable description
	 * @return datatype description
	 */
	public function __construct($name)
	{
		$this->name = $name;
	}


	/**
	 * getValue
	 *
	 * @access public
	 * @return datatype description
	 */
	public function getValue()
	{
		return $this->value;
	}


	/**
	 * setValue
	 *
	 * @access public
	 * @param datatype $paramname description
	 * @return datatype description
	 */
	public function setValue($value)
	{
		$this->validateValue($value);
		$this->value = $value;
	}


	/**
	 * getFormattedName
	 *
	 * @access public
	 * @return datatype description
	 */
	public function getFormattedName()
	{
		return $this->formattedName;
	}


	/**
	 * setFormattedName
	 *
	 * @access public
	 * @param datatype $paramname description
	 * @return datatype description
	 */
	public function setFormattedName($name)
	{
		$this->formattedName = $name;
	}


	/**
	 * getSize
	 *
	 * @access public
	 * @return datatype description
	 */
	public function getSize()
	{
		return $this->size;
	}


	/**
	 * setSize
	 *
	 * @access public
	 * @param datatype $paramname description
	 * @return datatype description
	 */
	public function setSize($size)
	{
		$this->size = $size;
	}


	/**
	 * getType
	 *
	 * @access public
	 * @return datatype description
	 */
	public function getType()
	{
		return $this->type;
	}


	/**
	 * setType
	 *
	 * @access public
	 * @param datatype $paramname description
	 * @return datatype description
	 */
	public function setType($type)
	{
		$this->type = $type;
	}


	/**
	 * getIsNullable
	 *
	 * @access public
	 * @return datatype description
	 */
	public function getIsNullable()
	{
		return $this->isNullable;
	}


	/**
	 * setIsNullable
	 *
	 * @access public
	 * @param datatype $paramname description
	 * @return datatype description
	 */
	public function setIsNullable($isNullable)
	{
		$this->isNullable = $isNullable;
	}


	/**
	 * getIsFK
	 *
	 * @access public
	 * @return datatype description
	 */
	public function getIsFK()
	{
		return $this->isFk;
	}


	/**
	 * setIsFK
	 *
	 * @access public
	 * @param datatype $paramname description
	 * @return datatype description
	 */
	public function setIsFK($isFk)
	{
		$this->isFk = $isFk;
	}


	/**
	 * getFKTable
	 *
	 * @access public
	 * @return datatype description
	 */
	public function getFKTable()
	{
		return $this->isFk;
	}


	/**
	 * getFKTable
	 *
	 * @access public
	 * @param datatype $paramname description
	 * @return datatype description
	 */
	public function setFKTable($fkTable)
	{
		$this->fkTable = $fkTable;
	}
	
	public function setJoinType($joinType)
	{
		$this->joinType = $joinType;
	}


	/**
	 * getLength
	 *
	 * @access public
	 * @return datatype description
	 */
	public function getLength()
	{
		return strlen($this->value);
	}

	/**
	 * getName
	 *
	 * @access public
	 * @return datatype description
	 */
	public function getName()
	{
		return $this->name;
	}
	
	private function validateValue($value)
	{
		// validate
		switch ($this->type)
		{
			case DataTypes::VARCHAR:
				if (strlen($value) > $this->size)
					throw new RecordException('The value of `'.$this->name.'` is to long');
				
				if (!$this->isNullable && empty($value))
					throw new RecordException('The value of `'.$this->name.'` may not be null');
			break;
			case DataTypes::INT:
				if (!is_int($value) && !ctype_digit($value))
					throw new RecordException('The value of is `'.$this->name.'` no number');
			break;
		} 
	}
}

?>
