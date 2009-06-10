<?php
/**
 * This class is the interface for adding data to a Table view
 * 
 * 
 * 
 */
interface ITableDataSet {

	/**
	 * Get the column of the table set. You have to specify the index of the column
	 *
	 * @param int $piColumn
	 * @return string
	 */
	public function getColumnName($piColumn);

	/**
	 * get the count of the total columns specified in this tableset
	 *
	 * @return int
	 */
	public function getColumnCount();

	/**
	 * get the count of all records
	 * 
	 * @return int
	 */
	public function getRowCount();

	/**
	 * get value at a given row and column. If no value can be found
	 * it will return an empty string
	 *
	 * @param int $piRow
	 * @param int $piColumn
	 */
	public function getValueAt($piRow, $piColumn);

	/**
	 * set a value at a given point in the table
	 * 
	 * @param string $sValue
	 * @param int $piRow
	 * @param int $piColumn
	 */
	public function setValueAt($sValue, $piRow, $piColumn);

}
