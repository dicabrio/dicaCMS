<?php

class MediaController extends CmsController {
	const C_CURRENT_FOLDER = 'currentMediaFolder';

	/**
	 * @var Request
	 */
	private $request;

	/**
	 *
	 * @param string $sMethod 
	 */
	public function __construct($sMethod) {

		parent::__construct('media/' . $sMethod, Lang::get('media.title'));

		$this->request = Request::getInstance();
	}

	/**
	 * Show an overview of the given folder
	 * 
	 * @param int $folder_id
	 * @return string
	 */
	public function _index($folder_id = 0) {

		$aErrors = array();

		$session = $this->getSession();
		$session->set(self::C_CURRENT_FOLDER, $folder_id);

		$folder = new MediaFolder($folder_id);
		$childFolders = MediaFolder::findInFolder($folder);

		$media = Media::findInFolder($folder);

		$breadcrumbFactory = new BreadcrumbFactory($folder, Conf::get('general.url.cms') . '/media');
		$breadcrumb = $breadcrumbFactory->build();

		$actions = new ActionMenu('actions');
		$actions->addItem(new MenuItem(Conf::get('general.url.cms') . '/media/editmedia', Lang::get('media.button.newitem')));
		$actions->addItem(new MenuItem(Conf::get('general.url.cms') . '/media/editfolder', Lang::get('media.button.newfolder')));

		$overview = new View(Conf::get('general.dir.templates') . '/media/mediaoverview.php');
		$overview->assign('mediaFolders', $childFolders);
		$overview->assign('mediaItems', $media);

		$overview->assign('aErrors', $aErrors);
		$overview->assign('breadcrumb', $breadcrumb);
		$overview->assign('actions', $actions);

		$oBaseView = parent::getBaseView();
		$oBaseView->assign('oModule', $overview);

		return $oBaseView->getContents();
	}

	public function folder($id) {
		return $this->_index($id);
	}

	public function editmedia() {

		$session = $this->getSession();
		$folderID = $session->get(self::C_CURRENT_FOLDER);

		$mediaItem = new Media(intval(Util::getUrlSegment(2)));
		$mediaMapper = new FormMapper();
		$saveButton = new ActionButton('Save');
		
		$folders = MediaFolder::findAll();
		$folder = new MediaFolder($folderID);
		$form = new MediaForm($mediaItem, $folders, $folder);
		$saveHandler = new MediaSaveHandler($mediaMapper, $mediaItem, $folder);

		$form->addSubmitButton($saveButton, $saveHandler);
		$form->listen($this->request);

		try {
			$file = $mediaItem->getFile();
			$filename = Conf::get('general.url.www') . Conf::get('upload.url.general') . '/' . $file->getFilename();
		} catch (FileNotFoundException $e) {
			$file = null;
			$filename = Lang::get('media.file-not-found');
		}

		$updatemode = true;
		if ($mediaItem->getID() == 0) {
			$updatemode = false;
		}

		$view = new View(Conf::get('general.dir.templates') . '/media/uploadmedia.php');
		$view->assign('form', $form);
		$view->assign('filename', $filename);
		$view->assign('updatemode', $updatemode);
		$view->assign('aErrors', $mediaMapper->getMappingErrors());

		$baseview = parent::getBaseView();
		$baseview->assign('oModule', $view);

		return $baseview->getContents();
	}

	public function deletemedia() {

		$data = parent::getConnection();
		try {

			$data->beginTransaction();

			$mediaItem = new Media(intval(Util::getUrlSegment(2)));
			$mediaItem->delete();

			$data->commit();

			$session = $this->getSession();
			$folderID = $session->get(self::C_CURRENT_FOLDER);

			$this->_redirect('media/folder/' . $folderID);
		} catch (RecordException $e) {
			$data->rollBack();

			return $this->_index(array('media.' . $e->getMessage()));
		}
	}

	public function editfolder($folderID = 0) {

		$session = $this->getSession();
		$parentFolderID = $session->get(self::C_CURRENT_FOLDER);

		$parentMediaFolder = new MediaFolder($parentFolderID);
		$currentPageFolder = new MediaFolder($folderID);

		$formmapper = new MediaFolderMapper();

		$button = new ActionButton('Save');
		$form = new MediaFolderEditForm($currentPageFolder);
		$form->addSubmitButton($button, new MediaFolderSaveHandler($formmapper, $currentPageFolder, $parentMediaFolder));
		$form->listen($this->request);

		$breadcrumb = new ActionMenu('breadcrumb');
		$breadcrumb->addItem(new MenuItem(false, Lang::get('breadcrumb.here')));
		$folderName = $parentMediaFolder->getName();
		if ($folderName == '') {
			$folderName = Lang::get('breadcrumb.root');
		}
		$breadcrumb->addItem(new MenuItem(Conf::get('general.cmsurl.www') . '/page/folder/' . $parentMediaFolder->getID(), $folderName));

		$breadcrumbname = Lang::get('page.breadcrumb.editpagefolder', $currentPageFolder->getName());
		if ($currentPageFolder->getID() == 0) {
			$breadcrumbname = Lang::get('page.breadcrumb.newpagefolder');
		}

		$breadcrumb->addItem(new MenuItem(false, $breadcrumbname));

		$view = new View(Conf::get('general.dir.templates') . '/media/editmediafolder.php');
		$view->assign('form', $form);
		$view->assign('folderid', $parentMediaFolder->getID());
		$view->assign('pageid', $currentPageFolder->getID());
		$view->assign('breadcrumb', $breadcrumb);
		$view->assign('aErrors', $formmapper->getMappingErrors());

		$baseView = parent::getBaseView();
		$baseView->assign('oModule', $view);
		return $baseView->getContents();
	}

	/**
	 *
	 * @param int $folderID 
	 */
	public function deletefolder($folderID = 0) {

		$data = parent::getConnection();
		$data->beginTransaction();

		try {
			$folder = new MediaFolder($folderID);
			$folder->delete();
			
			$session = $this->getSession();
			$parentFolderID = $session->get(self::C_CURRENT_FOLDER);
			
			$data->commit();

			$this->_redirect('media/folder/'.$parentFolderID);
		} catch (RecordException $e) {
			$data->rollBack();
		}
	}

	public function _default() {
		return __CLASS__;
	}

}

