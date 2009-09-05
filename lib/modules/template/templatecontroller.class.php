<?php

class TemplateController extends CmsController {

	const C_CURRENT_FOLDER = 'currentTemplateFolder';

	/**
	 * @var BaseView
	 */
	private $oBaseView;

	public function __construct($sMethod) {
		// we should check for permissions
		parent::__construct('template/'.$sMethod, 'Templates');

		$oMainMenu = parent::getMainMenu();
		$oMainMenu->addItem(new MenuItem(Conf::get('general.url.www').Conf::get('template.url.edittemplate'), 'new Template', ''));
		$oMainMenu->addItem(new MenuItem(Conf::get('general.url.www').Conf::get('template.url.editfolder'), 'new Folder', ''));

	}

	/**
	 * @return string
	 */
	public function folder($sId='') {
		$iItemID = intval(Util::getUrlSegment(2));
		return $this->_index(array(), $iItemID);
	}

	/**
	 * @param array $aErrors
	 * @param int $iParentID
	 * @return string
	 */
	public function _index($aErrors = array(), $iParentID=0) {

		$oSession = Session::getInstance();
		$oSession->set(self::C_CURRENT_FOLDER, $iParentID);

		$iParentID = intval($iParentID);
		$aItems = TemplateFile::getByParent($iParentID);

		$oBreadCrumb = new Menu('breadcrumb');
		$oBreadCrumb->addItem(new MenuItem(false, 'U bent hier:'));
		$oBreadCrumb->addItem(new MenuItem(Conf::get('general.url.www').Conf::get('template.url.showfolder'), '..'));
		if ($iParentID > 0) {

			$aBreadCrumb = array();
			$iBreadCrumbParentID = $iParentID;
			while ($iBreadCrumbParentID != 0) {
				$oParentItem = new TemplateFile($iBreadCrumbParentID);
				$aBreadCrumb[] = new MenuItem(Conf::get('general.url.www').Conf::get('template.url.showfolder').$oParentItem->getID(), $oParentItem->getTitle());
				$iBreadCrumbParentID = $oParentItem->getParent();
			}

			$aBreadCrumb = array_reverse($aBreadCrumb);

			foreach ($aBreadCrumb as $oItem) {
				$oBreadCrumb->addItem($oItem);
			}

		}

		$oTemplateDataSet = new TemplateDataSet();
		$oTemplateDataSet->setValues($aItems);

		$oTable = new Table($oTemplateDataSet);

		$oTemplateOverview = new View('template/templateoverview.php');
		$oTemplateOverview->assign('sSearchFormAction', Conf::get('general.url.www').Conf::get('template.url.searchtemplate'));
		$oTemplateOverview->assign('sShowFormAction', Conf::get('general.url.www').Conf::get('template.url.showtemplate'));
		$oTemplateOverview->assign('aErrors', $aErrors);
		$oTemplateOverview->assign('oOverview', $oTable);
		$oTemplateOverview->assign('oBreadCrumb', $oBreadCrumb);

		$oBaseView = parent::getBaseView();
		$oBaseView->assign('oModule', $oTemplateOverview);

		return $oBaseView->getContents();

	}


	public function edittemplate() {

		$aErrors = array();
		$oReq = Request::getInstance();
		$oSession = Session::getInstance();
		$iTemplateID = 0;
		$iParentID = intval($oSession->get(self::C_CURRENT_FOLDER));
			
		if ($oReq->post('action') == 'cancel') {
			Util::gotoPage(Conf::get('general.url.www').Conf::get('template.url.showfolder').$iParentID);
		}

		if ($oReq->post('action') == 'save') {

			$iTemplateID = $oReq->post('templateid');
			$sError = $oReq->files('templatefile.error');
			if ($sError != 4 && $sError != 0) {
				$aErrors[] = 'validation.uploaderror';
			}

			if ($sError != 4) {
				$sFilename = $oReq->files('templatefile.name');
				if (!is_string($sFilename)) {
					$aErrors[] = 'validation.wrongfilename';

				} else if (!preg_match('/\.tpl$|\.txt$|\.html$|\.php$/i', $sFilename)) {
					$aErrors[] = 'validation.wrongfiletype';
				}
			}

			$oTemplateFile = new TemplateFile($iTemplateID);

			if (count($aErrors) == 0) {

				DataFactory::beginTransaction();

				try {

					$oTemplateFile->setTitle($oReq->post('titlevalue'));
					$oTemplateFile->setDescription($oReq->post('descriptionvalue'));

					// set parent dir when a new file is created
					if ($iTemplateID == 0) {
						$oTemplateFile->setParent($iParentID);
					}
					// check if the file is selected
					// if the file is selected updateit
					if ($sError != 4) {
						$sUploadDir = Conf::get('upload.dir.templates');

						$oFileManager = new FileManager($oReq->files('templatefile.tmp_name'));
						$oFileManager->moveTo($sUploadDir, $sFilename);

						$oTemplateFile->setPath($sUploadDir);
						$oTemplateFile->setFilename($sFilename);
					}

					$oTemplateFile->save();
					DataFactory::commit();

					Util::gotoPage(Conf::get('general.url.www').Conf::get('template.url.showfolder').$iParentID);
				} catch (FileNotFoundException $e) {
					$aErrors[] = 'validation.filenotfound';
				} catch (DirException $e) {
					$aErrors[] = 'validation.dirnotexisting';
				} catch (DirNotWritableException $e) {
					test($e->getMessage());
					$aErrors[] = 'validation.dirnotwritable';
				} catch (PDOException $e) {
					$oFileManager->delete();
					DataFactory::rollBack();
					$aErrors[] = 'database.saveerror';
				}
			}
		} else {
			$iTemplateID = intval(Util::getUrlSegment(2));
			$oTemplateFile = new TemplateFile($iTemplateID);
		}

		$sTitle = 'edittemplate';
		if ($iTemplateID == 0) {
			$sTitle = 'newtemplate';
		}

		$oModuleView = new View('template/uploadtemplate.php');
		$oModuleView->assign('formaction', Conf::get('general.url.www').Conf::get('template.url.edittemplate'));
		$oModuleView->assign('templateid', $oReq->post('templateid', $oTemplateFile->getID()));
		$oModuleView->assign('titlevalue', $oReq->post('titlevalue', $oTemplateFile->getTitle()));
		$oModuleView->assign('descriptionvalue', $oReq->post('descriptionvalue', $oTemplateFile->getDescription()));
		$oModuleView->assign('aErrors', $aErrors);

		$oBaseView = parent::getBaseView();
		$oBaseView->assign('sTitle', $sTitle);
		$oBaseView->assign('oModule', $oModuleView);

		return $oBaseView->getContents();
	}

	public function editfolder() {

		$aErrors = array();
		$oReq = Request::getInstance();
		$oSession = Session::getInstance();
		$iParentID = intval($oSession->get(self::C_CURRENT_FOLDER));

		if ($oReq->post('action') == 'cancel') {
			Util::gotoPage(Conf::get('general.url.www').Conf::get('template.url.showfolder').$iParentID);
		}


		if ($oReq->post('action') == 'save') {
			//update
			DataFactory::beginTransaction();
			try {
				$iFolderID = $oReq->post('folderid');
				$oTplFolder = new TemplateFile($iFolderID);
				$oTplFolder->setTitle($oReq->post('titlevalue'));
				$oTplFolder->setDescription($oReq->post('descriptionvalue'));
				$oTplFolder->setFolder(true);

				// set parent dir when a new file is created
				if ($iFolderID == 0) {
					$oTplFolder->setParent($iParentID);
				}

				$oTplFolder->save();

				DataFactory::commit();

				Util::gotoPage(Conf::get('general.url.www').Conf::get('template.url.showfolder').$iParentID);
			} catch (RecordException $e) {
				DataFactory::rollBack();
				$aErrors[] = 'Record not found';
			} catch (PDOException $e) {
				DataFactory::rollBack();
				$aErrors[] = 'Problem while adding folder';
			}
		} else {
			// edit
			$iFolderID = intval(Util::getUrlSegment(2));
			$oTplFolder = new TemplateFile($iFolderID);
		}

		$sTitle = 'Edit Folder';
		if ($iFolderID == 0) {
			// new
			$sTitle = 'New Folder';
		}

		$oModule = new View('template/newfolder.php');

		$oModule->assign('sEditFolderFormAction', Conf::get('general.www.url').Conf::get('template.url.editfolder'));
		$oModule->assign('folderid', $oReq->post('folderid', $oTplFolder->getID()));
		$oModule->assign('titlevalue', $oReq->post('titlevalue', $oTplFolder->getTitle()));
		$oModule->assign('descriptionvalue', $oReq->post('descriptionvalue', $oTplFolder->getDescription()));
		$oModule->assign('aErrors', $aErrors);

		$oBaseView = parent::getBaseView();
		$oBaseView->assign('title', $sTitle);
		$oBaseView->assign('oModule', $oModule);
		return $oBaseView->getContents();
	}

	public function deletetemplate() {
		$iItemID = intval(Util::getUrlSegment(2));
		$aErrors = array();
		$oSession = Session::getInstance();
		$iParentID = intval($oSession->get(self::C_CURRENT_FOLDER));

		parent::getConnection()->beginTransaction();

		try {

			$oTemplate = new TemplateFile($iItemID);

			// a folder has no reference to a file on the disc
			if (!$oTemplate->isFolder()) {
				$sFile = $oTemplate->getPath().'/'.$oTemplate->getFilename();
				$oFile = new FileManager($sFile);
				$oFile->delete();
			}

			$oTemplate->delete();
			parent::getConnection()->commit();
			Util::gotoPage(Conf::get('general.url.www').Conf::get('template.url.showfolder').$iParentID);


		} catch (FileNotFoundException $e) {
			$aErrors[] = 'validation.filenotexists';
				
			// file does exist in DB, but not on the hard drive Just delete it
			if (isset($oTemplate) && $oTemplate instanceof TemplateFile) {
				$oTemplate->delete();
				parent::getConnection()->commit();
			}
		} catch (RecordException $e) {
			$aErrors[] = 'database.recordnotexists';

		} catch (FileException $e) {
			$aErrors[] = 'file.fileerror';
			parent::getConnection()->rollBack();
		}

		return $this->_index($aErrors);
	}

	public function _default() {
		return __CLASS__;
	}
}