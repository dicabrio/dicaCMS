<?php
/**
 *
 *
 */
class BlogDataSet extends AbstractTableDataSet {

	private $iRecordCount;

	public function __construct() {
		
		$this->iRecordCount = 0;
		
		$this->addColumn(0, '');
		$this->addColumn(1, 'title');
		$this->addColumn(2, 'actions');
		
	}

	private function constuctTitle($image, $title) {
		return '<img src="'.Conf::get('general.url.images').'/'.$image.'" alt="" />'.$title;
	}

	private function constructFolderLine(PageFolder $folder) {
		
		$folderid = $folder->getID();
		$sTitle = $this->constuctTitle('icon-folder.png', Html::getAnchor($folder->getName(), Conf::get('general.url.www').'/page/folder/'.$folder->getID()));

		$this->constructLine($folderid, $sTitle, array('editfolder', 'deletefolder'));

	}

	private function constructPageLine(Blog $blog) {
		$blogID = $blog->getID();
		$sTitle = $this->constuctTitle('icon-file.png', $blog->getPage()->getName());

		$this->constructLine($blogID, $sTitle, array('editblog', 'deleteblog'));
	}

	/**
	 *
	 * @param int $pid
	 * @param string $title
	 * @param array $actions
	 */
	private function constructLine($pid, $title, $actions) {

		$this->setValueAt('', $this->iRecordCount, 0);
		$this->setValueAt($title, $this->iRecordCount, 1);

		$actionstring = "";
		foreach ($actions as $action) {

			$attributes = array('class' => 'button '.$action);
			if (in_array($action, array('deletepage','deletefolder'))) {
				$attributes['confirm'] = Lang::get('page.sure'.$action);
			}

			$actionstring .= Html::getAnchor(	Lang::get('page.button.'.$action),
												Conf::get('general.url.www').'/page/'.$action.'/'.$pid,
												$attributes).'&nbsp;';
		}

		$this->setValueAt($actionstring, $this->iRecordCount, 2);
	}

	/**
	 * @param array $aTemplateRecords
	 */
	public function setValues($blogItems) {
		
		foreach ($blogItems as $blogItems) {
			$this->constructPageLine($blogItems);
			$this->iRecordCount++;
		}
	}
}