<?php

class MediaController extends CmsController {

	const C_CURRENT_FOLDER = 'currentPageFolder';

	public function __construct($sMethod) {

		parent::__construct('media/'.$sMethod, Lang::get('media.title'));

	}

	public function _index($aErrors = array(), $iParentID=0) {

		$media = Media::find();

		$actions = new Menu('actions');
		$actions->addItem(new MenuItem(Conf::get('general.url.www').'/media/editmedia', Lang::get('media.button.newitem')));

		$tableDataSet = new MediaDataSet();
		$tableDataSet->setValues($media);
		$table = new Table($tableDataSet);

		$overview = new View(Conf::get('general.dir.templates').'/media/mediaoverview.php');
		$overview->assign('aErrors', $aErrors);
		$overview->assign('actions', $actions);
		$overview->assign('oOverview', $table);

		$oBaseView = parent::getBaseView();
		$oBaseView->assign('oModule', $overview);

		return $oBaseView->getContents();
	}


	public function editmedia() {

		$req = Request::getInstance();
		$mediaItem = new Media(intval(Util::getUrlSegment(2)));

		$mediaMapper = new FormMapper();

		$saveButton = new ActionButton('Save');
		$saveHandler = new MediaSaveHandler($mediaMapper, $mediaItem);

		$form = new MediaForm($mediaItem);
		$form->addSubmitButton('save', $saveButton, $saveHandler);

		$form->listen($req);

		try {
			$file = $mediaItem->getFile();
			$filename = Conf::get('general.url.www').Conf::get('upload.url.general').'/'.$file->getFilename();
		} catch (FileNotFoundException $e) {
			$file = null;
			$filename = Lang::get('media.file-not-found');
		}

		$updatemode = true;
		if ($mediaItem->getID() == 0) {
			$updatemode = false;
		}

		$view = new View(Conf::get('general.dir.templates').'/media/uploadmedia.php');
		$view->assign('form', $form);
		$view->assign('filename', $filename);
		$view->assign('updatemode', $updatemode);
		$view->assign('aErrors', $mediaMapper->getMappingErrors());

		$baseview = parent::getBaseView();
		$baseview->assign('oModule', $view);

		return $baseview->getContents();

	}

	public function deletemedia() {

		$data = DataFactory::getInstance();
		try {

			$data->beginTransaction();

			$mediaItem = new Media(intval(Util::getUrlSegment(2)));
			$mediaItem->delete();

			$data->commit();

			Util::gotoPage(Conf::get('general.url.www').'/media');

		} catch (RecordException $e) {
			$data->rollBack();

			return $this->_index(array('media.'.$e->getMessage()));
		}
	}

	public function _default() {
		return __CLASS__;
	}
}

