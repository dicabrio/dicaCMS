<?php
/**
 *
 *
 */
class MediaDataSet extends AbstractTableDataSet {

	private $iRecordCount;

	/**
	 *
	 */
	public function __construct() {
		
		$this->iRecordCount = 0;
		
		$this->addColumn(0, Html::getCheckbox('selectall', 'all'));
		$this->addColumn(1, 'title');
		$this->addColumn(2, 'actions');
		
	}

	/**
	 *
	 * @param string $image
	 * @param string $title
	 * @return string
	 */
	private function constuctTitle($image, $title) {

		return '<img src="'.Conf::get('general.url.images').'/'.$image.'" alt="" />'.$title;
		
	}

	/**
	 * @param StaticBlock $mediaItem
	 */
	private function constructMediaLine(Media $mediaItem) {
		
		$mediaID = $mediaItem->getID();
		$sTitle = $this->constuctTitle('icon-file.png', $mediaItem->getTitle());
		$this->constructLine($mediaID, $sTitle, array('editmedia', 'deletemedia'));

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
			if (in_array($action, array('deletemedia'))) {
				$attributes['confirm'] = Lang::get('media.sure'.$action);
			}

			$actionstring .= Html::getAnchor(	Lang::get('media.button.'.$action),
												Conf::get('general.url.www').'/media/'.$action.'/'.$pid,
												$attributes).'&nbsp;';
		}

		$this->setValueAt($actionstring, $this->iRecordCount, 2);
		
	}

	/**
	 * @param array $aTemplateRecords
	 */
	public function setValues($mediaItems) {
		
		foreach ($mediaItems as $mediaRecord) {
			$this->constructMediaLine($mediaRecord);
			$this->iRecordCount++;
		}

	}
}