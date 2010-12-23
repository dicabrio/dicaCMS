<?php
/**
 *
 *
 */
class StaticBlockDataSet extends AbstractTableDataSet {

	private $iRecordCount;

	/**
	 *
	 */
	public function __construct() {
		
		$this->iRecordCount = 0;
		
		$this->addColumn(0, Html::getCheckbox('selectall', 'all'));
		$this->addColumn(1, 'identifier');
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
	 * @param StaticBlock $block
	 */
	private function constructBlockLine(StaticBlock $block) {
		
		$pageid = $block->getID();
		$sTitle = $this->constuctTitle('icon-file.png', $block->getIdentifier());
		$this->constructLine($pageid, $sTitle, array('editblock', 'deleteblock'));

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
			if (in_array($action, array('deleteblock'))) {
				$attributes['confirm'] = Lang::get('staticblock.suredeleteblock');
			}

			$actionstring .= Html::getAnchor(	Lang::get('staticblock.button.'.$action),
												Conf::get('general.url.www').'/staticblock/'.$action.'/'.$pid,
												$attributes).'&nbsp;';
		}

		$this->setValueAt($actionstring, $this->iRecordCount, 2);
		
	}

	/**
	 * @param array $aTemplateRecords
	 */
	public function setValues($blocks) {
		
		foreach ($blocks as $blockrecord) {
			$this->constructBlockLine($blockrecord);
			$this->iRecordCount++;
		}

	}
}