<?php
/**
 *
 *
 */
class PageDataSet extends AbstractTableDataSet {

	private $iRecordCount;

	public function __construct() {
		
		$this->iRecordCount = 0;
		
//		$this->addColumn(0, Html::getCheckbox('selectall', 'all'));
		$this->addColumn(0, '#');
		$this->addColumn(1, 'title');
		$this->addColumn(2, 'type');
		$this->addColumn(3, 'actions');
		
	}

	private function constuctTitle($image, $title) {
		return '<img src="'.Conf::get('general.url.images').'/'.$image.'" alt="" />'.$title;
	}

	private function constructFolderLine(PageFolder $folder) {
		
		$folderid = $folder->getID();
		$sTitle = $this->constuctTitle('icon-folder.png', Html::getAnchor($folder->getName(), Conf::get('general.cmsurl.www').'/page/folder/'.$folder->getID()));

		$this->constructLine($folderid, $sTitle, 'Folder', array('editfolder', 'deletefolder'));

	}

	private function constructPageLine(Page $page) {
		$pageid = $page->getID();
		$sTitle = $this->constuctTitle('icon-file.png', $page->getName());

		$this->constructLine($pageid, $sTitle, $page->getType(), array('editpage', 'deletepage'));
	}

	/**
	 *
	 * @param int $pid
	 * @param string $title
	 * @param array $actions
	 */
	private function constructLine($pid, $title, $type, $actions) {

//		$this->setValueAt(Html::getCheckbox('select[]', $pid), $this->iRecordCount, 0);
		$this->setValueAt($pid, $this->iRecordCount, 0);
		$this->setValueAt($title, $this->iRecordCount, 1);

		$actionstring = "";
		foreach ($actions as $action) {

			$attributes = array('class' => 'button '.$action);
			if (in_array($action, array('deletepage','deletefolder'))) {
				$attributes['confirm'] = Lang::get('page.sure'.$action);
			}

			$actionstring .= Html::getAnchor(	Lang::get('page.button.'.$action),
												Conf::get('general.cmsurl.www').'/page/'.$action.'/'.$pid,
												$attributes).'&nbsp;';
		}
		$this->setValueAt($type, $this->iRecordCount, 2);
		$this->setValueAt($actionstring, $this->iRecordCount, 3);
	}

	/**
	 * @param array $aTemplateRecords
	 */
	public function setValues($aPageRecords) {
		

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