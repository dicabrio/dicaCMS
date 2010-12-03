<?php

class DashboardController extends CmsController {

	public function __construct($sMethod) {
		// we should check for permissions
		parent::__construct('dashboard/'.$sMethod, 'DashBoard');
	}

	public function _index() {
		$oDashBoard = new View(Conf::get('general.dir.templates').'/dashboard/dashboard.php');

		$oBaseView = parent::getBaseView();
		$oBaseView->assign('oModule', $oDashBoard);

		return $oBaseView->getContents();

	}

	public function _default() {
		return 'DashBoard';
	}
}