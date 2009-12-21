<?php


class Table {

	/**
	 * @var View
	 */
	private $oView;

	/**
	 * @var bool
	 */
	private $bShowHeader = true;

	/**
	 * @var bool
	 */
	private $bShowFooter = false;

	/**
	 * @var ITableDataSet
	 */
	private $oData;

	public function __construct(ITableDataSet $oData=null) {

		$this->oView = new View('table.php');

		if ($oData !== null) {
			$this->setTableData($oData);
		}
	}

	public function showHeader($pbShow) {
		$this->bShowHeader = $pbShow;
	}

	public function showFooter($pbShow) {
		$this->bShowFooter = $pbShow;
	}

	public function setTableData(ITableDataSet $oData) {
		$this->oData = $oData;
	}

	public function getContents() {
		$this->oView->assign('bShowHeader', $this->bShowHeader);
		$this->oView->assign('bShowFooter', $this->bShowFooter);
		$this->oView->assign('oDataSet', $this->oData);
		return $this->oView->getContents();
	}

}