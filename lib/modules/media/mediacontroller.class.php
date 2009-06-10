<?php

class MediaController extends CmsController {

	const C_CURRENT_FOLDER = 'currentPageFolder';

	/**
	 * @var BaseView
	 */
	private $oBaseView;

	public function __construct($sMethod) {
		// we should check for permissions
		parent::__construct('media/'.$sMethod, 'Media');
		
		$oMainMenu = parent::getMainMenu();
		$oMainMenu->addItem(new MenuItem(Conf::get('general.url.www').'/media/editmedia', 'new Mediaitem', ''));
		$oMainMenu->addItem(new MenuItem(Conf::get('general.url.www').'/media/editfolder', 'new Folder', ''));
	}

	/**
	 * @return string
	 */
	public function folder($sId='') {
		$iItemID = intval(Util::getUrlSegment(2));
		return $this->_index(array(), $iItemID);
	}

	public function _index($aErrors = array(), $iParentID=0) {

		$oSession = Session::getInstance();
		$oSession->set(self::C_CURRENT_FOLDER, $iParentID);

		$iParentID = intval($iParentID);
		$aItems = Page::getByParent($iParentID);

		$oBreadCrumb = new Menu('breadcrumb');
		$oBreadCrumb->addItem(new MenuItem(Conf::get('general.url.www').'/page/folder/', '..'));
		if ($iParentID > 0) {

			$aBreadCrumb = array();
			$iBreadCrumbParentID = $iParentID;
			while ($iBreadCrumbParentID != 0) {
				$oParentItem = new Page($iBreadCrumbParentID);
				$aBreadCrumb[] = new MenuItem(Conf::get('general.url.www').'/page/folder/'.$oParentItem->getID(), $oParentItem->getTitle());
				$iBreadCrumbParentID = $oParentItem->getParent();
			}

			$aBreadCrumb = array_reverse($aBreadCrumb);

			foreach ($aBreadCrumb as $oItem) {
				$oBreadCrumb->addItem($oItem);
			}

		}

		$oPageDataSet = new PageDataSet();
		$oPageDataSet->setValues($aItems);

		$oTable = new Table($oPageDataSet);

		$oPageOverview = new View('page/pageoverview.php');
		$oPageOverview->assign('aErrors', $aErrors);
		$oPageOverview->assign('oOverview', $oTable);
		$oPageOverview->assign('oBreadCrumb', $oBreadCrumb);

		$oBaseView = parent::getBaseView();
		$oBaseView->assign('oModule', $oPageOverview);

		return $oBaseView->getContents();
	}

	/**
	 * add a new page
	 * @return string
	 */
	public function newpage() {

		return "";
	}

	/**
	 * edit an existing page
	 * @return string
	 */
	public function editpage() {

		$aErrors = array();
		$oReq = Request::getInstance();
		$oSession = Session::getInstance();
		$iPageID = 0;
		$iParentID = intval($oSession->get(self::C_CURRENT_FOLDER));

		if ($oReq->post('action') == 'cancel') {
			Util::gotoPage(Conf::get('general.url.www').'/page/folder/'.$iParentID);
		}

		if ($oReq->post('action') == 'save') {

			$iPageID = $oReq->post('page_id');
			$oPage = new Page($iPageID);

			DataFactory::beginTransaction();

			try {

				$oTemplateFile = new TemplateFile($oReq->post('template_id'));
				$oPage->setActive($oReq->post('active'));
				$oPage->setPagename($oReq->post('pagename'));
				$oPage->setTemplate($oTemplateFile);
				$oPage->setPublishTime($oReq->post('publishtime'));
				$oPage->setExpireTime($oReq->post('expiretime'));
				$oPage->setRedirect($oReq->post('redirect'));

				$sGoto = Conf::get('general.url.www').'/page/folder/'.$iParentID;

				// set parent dir when a new file is created
				if ($iPageID == 0) {
					$oPage->setParent($iParentID);
				}

				$oPage->save();
				DataFactory::commit();

				if ($iPageID == 0) {
					$sGoto = Conf::get('general.url.www').'/page/editpage/'.$oPage->getID();
				}

				Util::gotoPage($sGoto);

			} catch (RecordException $e) {
				$aErrors[] = 'template.nosuchtemplate';
				DataFactory::rollBack();
			}
		} else {
			$iPageID = intval(Util::getUrlSegment(2));
			$oPage = new Page($iPageID);
		}

		$aTemplates = TemplateFile::getFiles();

		$oModuleView = new View('page/editpage.php');
		$oModuleView->assign('aTemplates', $aTemplates);
		$oModuleView->assign('iPageID', $oReq->post('page_id', $oPage->getID()));
		$oModuleView->assign('sPagename', $oReq->post('pagename', $oPage->getPagename()));

		try {
			$oTemplateFile = $oPage->getTemplate();
			$sPath = $oTemplateFile->getPath();
			$sFile = $oTemplateFile->getFilename();

			$oViewParser = new ViewParser($sPath.FileManager::SEP.$sFile);
			//test($oViewParser->getLabels());
			$oModuleView->assign('aModules', $oViewParser->getLabels());
			$oModuleView->assign('iTemplateID', $oReq->post('template_id', $oTemplateFile->getID()));

		} catch (RecordException $e) {
			$aErrors[] = 'template.removedtemplate';
			$oModuleView->assign('iTemplateID', $oReq->post('template_id', 0));
		}
		$oModuleView->assign('sPublishtime', $oReq->post('publishtime', $oPage->getPublishTime()));
		$oModuleView->assign('sExpiretime', $oReq->post('expiretime', $oPage->getExpireTime()));
		$oModuleView->assign('sRedirect', $oReq->post('redirect', $oPage->getRedirect()));
		$oModuleView->assign('iActive', $oReq->post('active', $oPage->isActive()));

		$oModuleView->assign('aErrors', $aErrors);
		//$oModuleView->assign('aModules', array());

		//$this->oBaseView->assign('sTitle', $sTitle);
		$this->oBaseView->assign('oModule', $oModuleView);

		return $this->oBaseView->getContents();
	}


	public function _default() {
		return 'PageController';
	}
}