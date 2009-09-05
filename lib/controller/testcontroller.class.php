<?php



class TestController implements Controller {

	public function __construct() {
		// we should check for permissions
	}

	public function setArguments($arguments) {
		$this->arguments = $arguments;
	}

	public function _index() {

		return 'testing<br />';
		//		$oDataSet = new TableDataSet();
		//		$oDataSet->addColumn('id');
		//		$oDataSet->addColumn('customer');
		//		$oDataSet->addColumn('paymethod');
		//		$oDataSet->addColumn('total');
		//		$oDataSet->addColumn('date');
		//		$oDataSet->addColumn('status');
		//		$oDataSet->addColumn('action');
		//
		//
		//		$oTable = new Table($oDataSet);
		//		return $oTable->getContents();
	}

	public function _default() {
		return 'this is the default method';
	}
}