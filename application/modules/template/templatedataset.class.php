<?php
/**
 *
 *
 */
class TemplateDataSet extends AbstractTableDataSet {

	/**
	 *
	 * @var int
	 */
	private $iRecordCount = 0;

	/**
	 * constructor. Define the columns for the table
	 */
	public function __construct() {

		$this->iRecordCount = 0;

		$this->addColumn(0, Html::getCheckbox('selectall', 'all'));
		$this->addColumn(1, 'title');
		$this->addColumn(2, 'actions');

	}

	private function constuctTitle($image, $title) {

		return '<img src="'.Conf::get('general.url.images').'/'.$image.'" alt="" />'.$title;
		
	}

	private function constructFolderLine(Folder $folder) {

		$folderid = $folder->getID();
		$sTitle = $this->constuctTitle('icon-folder.png', Html::getAnchor($folder->getName(), Conf::get('general.url.www').'/template/folder/'.$folder->getID()));

		$this->constructLine($folderid, $sTitle, array('editfolder', 'deletefolder'));

	}

	private function constructItemLine(TemplateFile $template) {

		$pageid = $template->getID();
		$sTitle = $this->constuctTitle('icon-file.png', $template->getTitle());

		$this->constructLine($pageid, $sTitle, array('edittemplate', 'deletetemplate'));

	}

	/**
	 *
	 * @param int $pid
	 * @param string $title
	 * @param array $actions
	 */
	private function constructLine($pid, $title, $actions) {

		$this->setValueAt(Html::getCheckbox('select[]', $pid), $this->iRecordCount, 0);
		$this->setValueAt($title, $this->iRecordCount, 1);

		$actionstring = "";
		foreach ($actions as $action) {

			$attributes = array('class' => 'button '.$action);
			if (in_array($action, array('deletetemplate','deletefolder'))) {
				$attributes['confirm'] = Lang::get('template.suredeletetemplate');
			}

			$actionstring .= Html::getAnchor(	Lang::get('template.button.'.$action),
												Conf::get('general.url.www').'/template/'.$action.'/'.$pid,
												$attributes).'&nbsp;';
		}

		$this->setValueAt($actionstring, $this->iRecordCount, 2);
		
	}

	/**
	 *
	 * @param array $aTemplateRecords
	 */
	public function setValues($aTemplateRecords) {

		foreach ($aTemplateRecords as $itemrecord) {

			if ($itemrecord instanceof Folder) {
				$this->constructFolderLine($itemrecord);
			} else {
				$this->constructItemLine($itemrecord);
			}

			$this->iRecordCount++;
		}

	}
}