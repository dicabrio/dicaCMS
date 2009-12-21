<?php
/**
 *
 *
 */
class TemplateDataSet implements ITableDataSet {

	private $aColumns = array();

	private $iColumnCount = false;

	private $iRowCount = false;

	private $aData = array();

	public function __construct() {
		$this->aColumns[] = new Link('', Html::getCheckbox('selectall', 'all'));
		$this->aColumns[] = new Link(Conf::get('general.url.www').'/template/', 'title');
		$this->aColumns[] = new Link('', 'actions');
	}

	/**
	 * @param array $aTemplateRecords
	 */
	public function setValues($aTemplateRecords) {
		$iRecordCount = 0;

		foreach ($aTemplateRecords as $oTemplateRecord) {

			if ($oTemplateRecord->isFolder()) {
				$sImage = 'icon-folder.png';
				$sEditLink = 'editfolder';
				$sTitle = Html::getAnchor($oTemplateRecord->getTitle(), Conf::get('general.url.www').'/template/folder/'.$oTemplateRecord->getID());
			} else {
				$sImage = 'icon-file.png';
				$sEditLink = 'edittemplate';
				$sTitle = $oTemplateRecord->getTitle();
			}

			$sTitle = '<img src="'.Conf::get('general.url.images').'/'.$sImage.'" alt="" />'.$sTitle;

			$sDoEdit = Html::getAnchor(Lang::get('general.button.edit'), Conf::get('general.url.www').'/template/'.$sEditLink.'/'.$oTemplateRecord->getID());
			$sDoDelete = Html::getAnchor(Lang::get('general.button.delete'), Conf::get('general.url.www').'/template/deletetemplate/'.$oTemplateRecord->getID());

			$this->setValueAt(Html::getCheckbox('select[]', $oTemplateRecord->getID()), $iRecordCount, 0);
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