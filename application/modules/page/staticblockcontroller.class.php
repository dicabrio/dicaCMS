<?php

class StaticblockController extends CmsController {

	public function __construct($sMethod) {
	// we should check for permissions
		parent::__construct('staticblock/'.$sMethod, Lang::get('static.title'));
	}

	/**
	 * the index method.
	 * 
	 * @return string
	 */
	public function _index() {
		$aErrors = array();

		$actions = new Menu('actions');
		$actions->addItem(new MenuItem(Conf::get('general.url.www').'/staticblock/editblock', Lang::get('static.button.newblock')));

		$blocks = StaticBlock::find();

		$dataset = new StaticBlockDataSet();
		$dataset->setValues($blocks);

		$table = new Table($dataset);

		$overview = new View('staticblock/blockoverview.php');
		$overview->assign('actions', $actions);
		$overview->assign('oOverview', $table);

		$oBaseView = parent::getBaseView();
		$oBaseView->assign('oModule', $overview);

		return $oBaseView->getContents();
	}

	/**
	 * Handle editing the block
	 * 
	 * @return string
	 */
	public function editblock() {

		$req = Request::getInstance();
		$block = new StaticBlock(Util::getUrlSegment(2));

		$button = new ActionButton('Save');
		$form = new StaticBlockForm($req, $block);

		$formmapper = new StaticBlockMapper($form);
		$form->addSubmitButton('save', $button, new StaticBlockHandler($block, $formmapper));
		$form->listen();

		$editview = new View('staticblock/editblock.php');
		$editview->assign('form', $form);
		$editview->assign('aErrors', $formmapper->getMappingErrors());

		$oBaseView = parent::getBaseView();
		$oBaseView->assign('oModule', $editview);

		return $oBaseView->getContents();
	}

	public function _default() {
		return __CLASS__;
	}
}