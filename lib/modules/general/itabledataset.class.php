<?php

interface ITableDataSet {

	public function setValues($aValues);

	public function getColumnName($piColumn);

	public function getColumnCount();

	public function getRowCount();

	public function getValueAt($piRow, $piColumn);

	public function setValueAt($sValue, $piRow, $piColumn);

	public function addColumn($column, $name);
}