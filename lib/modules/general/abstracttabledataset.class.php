<?php

abstract class AbstractTableDataSet implements ITableDataSet {

	private $aColumns = array();

	private $aData = array();

	private $iColumnCount = false;

	private $iRowCount = false;

	/**
	 * @param mixed $avalues
	 */
	public function setValues($values) {}

	/**
	 *
	 * @param int $column
	 * @param string $name
	 */
	public function addColumn($column, $name) {

		$this->aColumns[$column] = $name;
		
	}

	/**
	 *
	 * @param int $column
	 * @return string
	 */
	public function getColumnName($column) {
		if (isset($this->aColumns[$column])) {
			return $this->aColumns[$column];
		}
		return "";
	}

	/**
	 *
	 * @return int
	 */
	public function getColumnCount() {
		if ($this->iColumnCount === false) {
			$this->iColumnCount = count($this->aColumns);
		}

		return (int)$this->iColumnCount;
	}

	/**
	 *
	 * @return int
	 */
	public function getRowCount() {
		if ($this->iRowCount === false) {
			$this->iRowCount = count($this->aData);
		}

		return (int)$this->iRowCount;
	}

	/**
	 * @param int $row
	 * @param int $column
	 * @return string
	 */
	public function getValueAt($row, $column) {
		if (isset($this->aData[$row]) && isset($this->aData[$row][$column])) {
			return $this->aData[$row][$column];
		}

		return "";
	}

	/**
	 * @param string $value
	 * @param int $row
	 * @param int $column
	 */
	public function setValueAt($value, $row, $column) {
		$this->aData[$row][$column] = $value;
	}
}