<?php
class QueryPart extends Collection {
	private $query = "";
	
	public function __construct($sQueryPart, $bind=array()) {
		$this->query = $sQueryPart;
		
		if (count($bind) > 0) {
			parent::__construct($bind);
		}
		
	}
	
	public function addBind($key, $value) {
		parent::set($key, $value);
	}
	
	public function addBinds($bindings) {
		parent::addAll(new Collection($bindings));
	}
	
	public function getQuery() {
		return $this->query;
	}
	
}
?>