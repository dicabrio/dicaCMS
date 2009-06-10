<?php
/**
 *
 * 
 */
class PageDataSet implements ITableDataSet {

	private $aColumns = array();

	private $iColumnCount = false;

	private $iRowCount = false;

	private $aData = array();

	public function __construct() {
		$this->aColumns[] = new Link('', Html::getCheckbox('selectall', 'all'));
		$this->aColumns[] = new Link(Conf::get('general.url.www').'/page/', 'title');
		$this->aColumns[] = new Link('', 'actions');
	}

	/**
	 * @param array $aTemplateRecords
	 */
	public function setValues($aPageRecords) {
		$iRecordCount = 0;

		foreach ($aPageRecords as $oPageRecord) {

			$iPageID = $oPageRecord->getID();
			if ($oPageRecord->isFolder()) {
				$sImage = 'icon-folder.png';
				$sEditLink = 'editfolder';
				$sTitle = Html::getAnchor($oPageRecord->getPagename(), Conf::get('general.url.www').'/page/folder/'.$iPageID);
			} else {
				$sImage = 'icon-file.png';
				$sEditLink = 'editpage';
				$sTitle = $oPageRecord->getPagename();
			}

			$sTitle = '<img src="'.Conf::get('general.url.images').'/'.$sImage.'" alt="" />'.$sTitle;

			$sDoEdit = Html::getAnchor(Lang::get('general.button.edit'), Conf::get('general.url.www').'/page/'.$sEditLink.'/'.$iPageID);
			$sDoDelete = Html::getAnchor(Lang::get('general.button.delete'), Conf::get('general.url.www').'/page/deletepage/'.$iPageID);

			$this->setValueAt(Html::getCheckbox('select[]', $iPageID), $iRecordCount, 0);
			$this->setValueAt($sTitle, $iRecordCount, 1);
			$this->setValueAt($sDoEdit.' | '.$sDoDelete, $iRecordCount, 2);

			$iRecordCount++;
		}
	}

	public function getColumnName($piColumn) {
		if (isset($this->aColumns[$piColumn])) {
			if ($this->aColumns[$piColumn] instanceof Link) {
				return $this->aColumns[$piColumn]->getLabel();
			}
		}
		return "";
	}

	public function getColumnCount() {
		if ($this->iColumnCount === false) {
			$this->iColumnCount = count($this->aColumns);
		}

		return $this->iColumnCount;
	}

	public function getRowCount() {
		if ($this->iRowCount === false) {
			$this->iRowCount = count($this->aData);
		}

		return $this->iRowCount;
	}

	public function getValueAt($piRow, $piColumn) {
		if (isset($this->aData[$piRow]) && isset($this->aData[$piRow][$piColumn])) {
			return $this->aData[$piRow][$piColumn];
		}

		return "";
	}

	public function setValueAt($sValue, $piRow, $piColumn) {
		$this->aData[$piRow][$piColumn] = $sValue;
	}
}