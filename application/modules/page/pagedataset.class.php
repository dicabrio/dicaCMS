<?php
/**
 *
 *
 */
class PageDataSet extends AbstractTableDataSet {

	private $iRecordCount;

	public function __construct() {

		$this->addColumn(0, Html::getCheckbox('selectall', 'all'));
		$this->addColumn(1, 'title');
		$this->addColumn(2, 'actions');
		
	}

	private function constuctTitle($image, $title) {
		return '<img src="'.Conf::get('general.url.images').'/'.$image.'" alt="" />'.$title;
	}

	private function constructFolderLine(PageFolder $folder) {
		
		$folderid = $folder->getID();
		$sTitle = $this->constuctTitle('icon-folder.png', Html::getAnchor($folder->getName(), Conf::get('general.url.www').'/page/folder/'.$folder->getID()));

		$sDoEdit = Html::getAnchor(Lang::get('general.button.edit'), Conf::get('general.url.www').'/page/editfolder/'.$folderid);
		$sDoDelete = Html::getAnchor(Lang::get('general.button.delete'), Conf::get('general.url.www').'/page/deletefolder/'.$folderid);

		$this->constructLine($folderid, $sTitle, $sDoEdit.'|'.$sDoDelete);

	}

	private function constructPageLine(Page $page) {
		$pageid = $page->getID();
		$sTitle = $this->constuctTitle('icon-file.png', $page->getName());

		$sDoEdit = Html::getAnchor(Lang::get('general.button.edit'), Conf::get('general.url.www').'/page/editpage/'.$pageid);
		$sDoDelete = Html::getAnchor(Lang::get('general.button.delete'), Conf::get('general.url.www').'/page/deletepage/'.$pageid);

		$this->constructLine($pageid, $sTitle, $sDoEdit.'|'.$sDoDelete);
	}

	private function constructLine($pid, $title, $actions) {

		$this->setValueAt(Html::getCheckbox('select[]', $pid), $this->iRecordCount, 0);
		$this->setValueAt($title, $this->iRecordCount, 1);
		$this->setValueAt($actions, $this->iRecordCount, 2);
	}

	/**
	 * @param array $aTemplateRecords
	 */
	public function setValues($aPageRecords) {
		$this->iRecordCount = 0;

		foreach ($aPageRecords as $oPageRecord) {

			if ($oPageRecord instanceof Page) {
				$this->constructPageLine($oPageRecord);
			} else {
				$this->constructFolderLine($oPageRecord);
			}

			$this->iRecordCount++;
		}
	}
}