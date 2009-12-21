<?php
/**
 *
 *
 */
class PageDataSet extends AbstractTableDataSet {

	public function __construct() {

		$this->addColumn(0, Html::getCheckbox('selectall', 'all'));
		$this->addColumn(1, 'title');
		$this->addColumn(2, 'actions');
		
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
				$sTitle = Html::getAnchor($oPageRecord->getName(), Conf::get('general.url.www').'/page/folder/'.$iPageID);
			} else {
				$sImage = 'icon-file.png';
				$sEditLink = 'editpage';
				$sTitle = $oPageRecord->getName();
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
}