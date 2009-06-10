<?php

class DataFactoryException extends Exception {}

class DataFactory
{

	/**
	 * holds the databaseconnection
	 * 
	 * @var PDO
	 */
	private static $databaseConnection = null;
	
	private function __construct() 
	{
		// disable instantiation
	}
	
	/**
	 * Set the database connection for the Facade.
	 *
	 * @param PDO $connection
	 */
	public static function getConnection()
	{
		if (self::$databaseConnection == null)
			throw new DataFactoryException('Database connection is not set');
			
		return self::$databaseConnection;
	}
	
	public static function setConnection(PDO $conn)
	{
		self::$databaseConnection = $conn;
	}
	
	public static function beginTransaction()
	{
		self::$databaseConnection->beginTransaction();
	}
	
	public static function commit()
	{
		self::$databaseConnection->commit();
	}
	
	public static function rollBack()
	{
		self::$databaseConnection->rollBack();
	}
		
}

?>