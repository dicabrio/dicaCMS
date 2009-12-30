<?php

class TemplateController extends CmsController {

	const C_CURRENT_FOLDER = 'currentTemplateFolder';

	public function __construct($sMethod) {

		// we should check for permissions
		parent::__construct('template/'.$sMethod, Lang::get('template.pagetitle'));

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
	public function _index($aErrors = array(), $iParentID = 0) {

		$session = Session::getInstance();
		$session->set(self::C_CURRENT_FOLDER, $iParentID);

		$parentFolder = new TemplateFileFolder($iParentID);
		$aItems = $parentFolder->getChildren();

		$actions = new Menu('actions');
		$actions->addItem(new MenuItem(Conf::get('general.url.www').'/template/edittemplate', Lang::get('template.button.newfile')));
		$actions->addItem(new MenuItem(Conf::get('general.url.www').'/template/editfolder', Lang::get('template.button.newfolder')));

		$breadcrumbFac = new BreadcrumbFactory($parentFolder, Conf::get('general.url.www').'/template');
		$breadcrumb = $breadcrumbFac->build();

		$oTemplateDataSet = new TemplateDataSet();
		$oTemplateDataSet->setValues($aItems);

		$oTable = new Table($oTemplateDataSet);

		$oTemplateOverview = new View('template/templateoverview.php');
		$oTemplateOverview->assign('sSearchFormAction', Conf::get('general.url.www').Conf::get('template.url.searchtemplate'));
		$oTemplateOverview->assign('sShowFormAction', Conf::get('general.url.www').Conf::get('template.url.showtemplate'));
		$oTemplateOverview->assign('aErrors', $aErrors);
		$oTemplateOverview->assign('oOverview', $oTable);
		$oTemplateOverview->assign('actions', $actions);
		$oTemplateOverview->assign('oBreadCrumb', $breadcrumb);

		$oBaseView = parent::getBaseView();
		$oBaseView->assign('oModule', $oTemplateOverview);

		return $oBaseView->getContents();

	}

	/**
	 * edit/upload a new template
	 * 
	 * @return string
	 */
	public function edittemplate() {

		$aErrors = array();
		$req = Request::getInstance();
		$session = Session::getInstance();

		$folder = new TemplateFileFolder($session->get(self::C_CURRENT_FOLDER));
		$template = new TemplateFile(Util::getUrlSegment(2));

		$button = new ActionButton('Save');

		$form = new TemplateFileForm($req, $template);
		$formmapper = new TemplateFileMapper($form);

		$form->addSubmitButton('save', $button, new TemplateFileSaveHandler($formmapper, $template, $folder));
		$form->listen();


			
//		if ($req->post('action') == 'cancel') {
//			Util::gotoPage(Conf::get('general.url.www').Conf::get('template.url.showfolder').$iParentID);
//		}
//
//		if ($req->post('action') == 'save') {
//
//			$iTemplateID = $req->post('templateid');
//			$sError = $req->files('templatefile.error');
//			if ($sError != 4 && $sError != 0) {
//				$aErrors[] = 'validation.uploaderror';
//			}
//
//			if ($sError != 4) {
//				$sFilename = $req->files('templatefile.name');
//				if (!is_string($sFilename)) {
//					$aErrors[] = 'validation.wrongfilename';
//
//				} else if (!preg_match('/\.tpl$|\.txt$|\.html$|\.php$/i', $sFilename)) {
//					$aErrors[] = 'validation.wrongfiletype';
//				}
//			}
//
//			$oTemplateFile = new TemplateFile($iTemplateID);
//
//			if (count($aErrors) == 0) {
//
//				DataFactory::beginTransaction();
//
//				try {
//
//					$oTemplateFile->setTitle($req->post('titlevalue'));
//					$oTemplateFile->setDescription($req->post('descriptionvalue'));
//
//					// set parent dir when a new file is created
//					if ($iTemplateID == 0) {
//						$oTemplateFile->setParent($iParentID);
//					}
//					// check if the file is selected
//					// if the file is selected updateit
//					if ($sError != 4) {
//						$sUploadDir = Conf::get('upload.dir.templates');
//
//						$oFileManager = new FileManager($req->files('templatefile.tmp_name'));
//						$oFileManager->moveTo($sUploadDir, $sFilename);
//
//						$oTemplateFile->setPath($sUploadDir);
//						$oTemplateFile->setFilename($sFilename);
//					}
//
//					$oTemplateFile->save();
//					DataFactory::commit();
//
//					Util::gotoPage(Conf::get('general.url.www').Conf::get('template.url.showfolder').$iParentID);
//				} catch (FileNotFoundException $e) {
//					$aErrors[] = 'validation.filenotfound';
//				} catch (DirException $e) {
//					$aErrors[] = 'validation.dirnotexisting';
//				} catch (DirNotWritableException $e) {
//					test($e->getMessage());
//					$aErrors[] = 'validation.dirnotwritable';
//				} catch (PDOException $e) {
//					$oFileManager->delete();
//					DataFactory::rollBack();
//					$aErrors[] = 'database.saveerror';
//				}
//			}
//		} else {
//			$iTemplateID = intval(Util::getUrlSegment(2));
//			$oTemplateFile = new TemplateFile($iTemplateID);
//		}


		$oModuleView = new View('template/uploadtemplate.php');
		$oModuleView->assign('form', $form);
		$oModuleView->assign('folder_id', $folder->getID());
		$oModuleView->assign('aErrors', $formmapper->getMappingErrors());

		$oBaseView = parent::getBaseView();
		$oBaseView->assign('oModule', $oModuleView);

		return $oBaseView->getContents();
	}

	public function editfolder() {

		$errors = array();
		$req = Request::getInstance();
		$session = Session::getInstance();
		$parentFolder = new TemplateFileFolder($session->get(self::C_CURRENT_FOLDER));
		$currentFolder = new TemplateFileFolder(intval(Util::getUrlSegment(2)));

		$button = new ActionButton('Save');

		$form = new TemplateFileFolderEditForm($req, $currentFolder);
		$formmapper = new TemplateFolderMapper($form);
		$form->addSubmitButton('save', $button, new TemplateFolderSaveHandler($formmapper, $currentFolder, $parentFolder));
		$form->listen();

		$oModule = new View('template/edittemplatefilefolder.php');
		$oModule->assign('form', $form);

		$oModule->assign('folderid', $req->post('folderid', $parentFolder->getID()));
		$oModule->assign('aErrors', $formmapper->getMappingErrors());

		$oBaseView = parent::getBaseView();
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