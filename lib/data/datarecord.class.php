<?php

class RecordException extends Exception {}

abstract class DataRecord
{
	const ALL = "*";

	private $attributes = array();

	private $table = null;

	private $isModified = false;

	/**
	 * Database Connection
	 *
	 * @var PDO
	 */
	private static $dbHandle = null;

	public static $debug = true;

	private $updated = false;

	/**
	 * Constructor of the datarecord. Datarecord itself maynot be initiated. "Abstract" prevents that.
	 * we should extend this and fill given properties and let DataRecord handle most of your
	 * deleting, saving and updating
	 *
	 * @param string $table The tablename of the DB
	 * @param unknown_type $id
	 */
	public function __construct($table, $id=null)
	{
		self::$dbHandle = DataFactory::getConnection();
		$this->table = strtolower($table);

		$this->attributes = new AttributesAggr();
		$this->defineColumns();

		$this->id = intval($id);

		if ($this->id > 0) {
			$this->load();
		}
	}

	/**
	 * define the attributes for the given class that will map to
	 * the database
	 *
	 * @return void
	 */
	abstract protected function defineColumns();

	/**
	 * define the relations and map them to properties
	 *
	 * @return void
	 */
	protected function defineRelations() {
		// it could be that no relations will ever be defined
	}

	public function getID() {
		return $this->id;
	}

	public function setID($iID) {
		$this->id = $iID;
	}

	public function getTable() {
		return $this->table;
	}

	public function save()
	{
		if ($this->isModified == false) {
			return true;
		}

		if (self::$dbHandle == null) {
			self::$dbHandle = DataFactory::getConnection();
		}

		if ($this->id > 0) {
			$this->update();
		} else {
			$this->insert();
		}
	}

	private function insert()
	{
		$query = "INSERT INTO `".$this->table."` SET ";
		$query .= $this->getPreparedQueryAttr();

		$aBindValues = $this->getPreparedQueryValues();

		QueryCache::addQuery($query);

		$statement = self::$dbHandle->prepare($query);
		$statement->execute($aBindValues);

		if (!$statement)
		{
			$errorInfo = $statement->errorInfo();
			throw new RecordException($errorInfo[2]);
		}

		$this->id = self::$dbHandle->lastInsertId();
	}

	private function update()
	{
		if (!$this->id)
		{
			throw new RecordException($this->table." object needs an ID to update()");
		}

		$query = "UPDATE `".$this->table."` SET ";
		$query .= $this->getPreparedQueryAttr();
		$query .=" WHERE id=:id";

		$aBindValues = $this->getPreparedQueryValues();
		$aBindValues['id'] = $this->id;

		QueryCache::addQuery($query);

		$statement = self::$dbHandle->prepare($query);
		$statement->execute($aBindValues);

		if (!$statement)
		{
			$errorInfo = $statement->errorInfo();
			throw new RecordException($errorInfo[2]);
		}

	}

	/**
	 * helper method for retreiving attribute values for binding in your SQL
	 *
	 * @return array associative
	 */
	private function getPreparedQueryValues()
	{
		$aBindValues = array();

		foreach ($this->attributes as $attribute)
		{
			if ($attribute->getName() == 'id') {
				continue;
			}

			switch ($attribute->getType())
			{
				case DataTypes::INT:
					$retVal = intval($attribute->getValue());
					break;
				case DataTypes::DOUBLE:
					$retVal = doubleval($attribute->getValue());
					break;
				default:
					$retVal = ($attribute->getValue());
					break;
			}

			$aBindValues[$attribute->getName()] = $retVal;
		}
		return $aBindValues;
	}

	/**
	 * Helper method for creating the query
	 *
	 * @return string
	 */
	private function getPreparedQueryAttr()
	{
		$query = "";
		foreach ($this->attributes as $attribute)
		{
			if ($attribute->getName() == 'id') {
				continue;
			}

			$query .= "`".$attribute->getName()."`= :".$attribute->getName()." , ";

		}
		$query = substr(trim($query), 0, -1);
		return $query;
	}

	/**
	 * Load the object with data from the database
	 *
	 */
	private function load()
	{
		if ($this->attributes->count())
		{
			$sql = "SELECT ".$this->attributes->getAttributesString()." FROM `".$this->table."` WHERE id = :id";

			QueryCache::addQuery($sql);

			$statement = self::$dbHandle->prepare($sql);
			$statement->bindParam(':id', intval($this->id));
			$statement->execute();

			$row = $statement->fetch(PDO::FETCH_ASSOC);
			// load the attribute values
			if ($row === false) {
				throw new RecordException('Record of '.get_class($this).' was not found with this id:'.$this->id);
			}

			if (count($row) > 0) {
				foreach ($row as $attribute => $value)
				{
					if( $attribute == 'id' )
					{
						continue;
					}

					$this->$attribute = $value;
				}
			}

			$statement = null;
		}
	}

	/**
	 * Define a column for the object. Specify the right datatype, size and if it is required (null/ not null)
	 *
	 * @param string $columnName
	 * @param const $dataType data type
	 * @param int $size length of the string/number
	 * @param bool $null false = not null / true = null
	 * @param string $joinType
	 */
	protected function addColumn($columnName, $dataType, $size=null, $null=false, $joinType='inner')
	{
		$attr = new Attribute($columnName);
		$attr->setFormattedName(str_replace('_', ' ', $columnName));
		$attr->setType($dataType);
		$attr->setSize($size);
		$attr->setIsNullable($null);

		// set the is_fk and fk_table
		if (preg_match('/^(.*)_id$/', $columnName, $matches))
		{
			$attr->setIsFK(true);
			$attr->setFKTable($matches[1]);
			$attr->setJoinType($joinType);
		}

		$this->attributes->add($attr);
	}

	/**
	 * get interceptor. The accessor is protected to force getters and setters
	 * for subclasses
	 *
	 * @param string $property
	 * @return mixed
	 */
	protected function __get($property)
	{
		if ($this->attributes->isPresent($property))
		{
			return $this->attributes->$property;
		}
	}


	/**
	 * set interceptor the accessor is protected. We have to force
	 * making getters and setters. This will be much better ;)
	 *
	 * @param string $attribute attribute to be set
	 * @param mixed $value value to set attribute to
	 */
	protected function __set($property, $value)
	{
		if ($this->attributes->isPresent($property))
		{
			if ($this->attributes->$property != $value)
			{
				$this->attributes->$property = $value;
				$this->isModified = true;
			}
		}
	}

	/**
	 * findBySql
	 * Works like findAll, but requires a complete SQL string.
	 *
	 * @access public
	 * @param string $query query to execute
	 * @return array
	 */
	protected static function findBySql($tableName, $query, $bind=array())
	{
		$resObject = array();

		if (self::$dbHandle == null)
		{
			self::$dbHandle = DataFactory::getConnection();
		}

		QueryCache::addQuery($query);

		$statement = self::$dbHandle->prepare($query);
		$statement->execute($bind);

		if (!$statement)
		{
			$errorInfo = $statement->errorInfo();
			throw new RecordException($errorInfo[2]);
		}

		while ($row = $statement->fetch())
		{
			$tmpObject = new $tableName();
			foreach ($row as $key => $value)
			{
				$tmpObject->$key = $value;
			}

			$resObject[] = $tmpObject;
		}

		return $resObject;

	}

	/**
	 * Find all
	 *
	 * Returns an array of all the objects that could be instantiated from
	 * the associated table in the database.
	 *
	 * @access public
	 * @param string $tableName name of table to execute query against
	 * @param array $columns the columns you like to retreive
	 * @param QueryPart $conditions conditions to apply in query
	 * @param string $orderings order to return results with
	 * @param string $limit any limit to apply to query
	 * @param string $joins not implemented yet
	 * @return object first object that matches "conditions" and "orderings"
	 */
	protected static function findAll($tableName, $columns, QueryPart $conditions=null, $orderings=null, $limit=null, $joins=null)
	{
		// construct the sql
		$selection = '*';
		$aBindings = array();

		if (is_array($columns) && count($columns) > 0)
		{
			$selection = implode(',', $columns);
		}
		else if (is_array($columns) && count($columns) == 1)
		{
			$selection = $columns[0];
		}

		$sql = "SELECT ".$selection." FROM `".strtolower($tableName)."` ";

		if ($conditions) {
			$sql .= " WHERE ".$conditions->getQuery();
			$aBindings = array_merge($aBindings, $conditions->toArray());
		}

		if ($orderings) {
			$sql .= " ORDER BY ".$orderings;
		}

		if ($limit) {
			$sql .= " LIMIT ".$limit;
		}

		return self::findBySql($tableName, $sql, $aBindings);
	}

	/**
	 * find_first
	 *
	 * Returns the object for the first record matching "conditions"
	 *
	 * @access protected
	 * @param string $table_name name of table to execute query against
	 * @param string $conditions conditions to apply in query
	 * @param string $orderings order to return results with
	 * @return object first object that matches "conditions" and "orderings"
	 */
	protected static function findFirst($tableName, $columns=null, QueryPart $conditions=null, $orderings=null, $joins=null)
	{
		$objArray = self::findAll($tableName, $columns, $conditions, $orderings, 1, $joins);

		if (count($objArray) == 1) {
			return current($objArray);
		}

		return false;
	}

	public function delete() {
		if ($this->id == 0) {
			throw new RecordException($this->table." object has no ID, can't delete it");
		}
		
		if (self::$dbHandle == null) {
			self::$dbHandle = DataFactory::getConnection();
		}
		
		$query = "DELETE FROM ".$this->table." WHERE id = :id";
		
		QueryCache::addQuery($query);
		
		$statement = self::$dbHandle->prepare($query);
		$statement->execute(array('id' => $this->id));

		if (!$statement)
		{
			$errorInfo = $statement->errorInfo();
			throw new RecordException($errorInfo[2]);
		}

		return;
	}


}


?>