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
		$table = new Table($tableDataSet);

		$overview = new View('media/mediaoverview.php');
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
		$mediaMapper->addFormElementToDomainEntityMapping('media_id', 'Media');
		$mediaMapper->addFormElementToDomainEntityMapping('title', 'TextLine');
		$mediaMapper->addFormElementToDomainEntityMapping('description', 'DomainText');
		$mediaMapper->addFormElementToDomainEntityMapping('media', 'Upload');

		$saveButton = new ActionButton('Save');
		$saveHandler = new MediaSaveHandler($mediaMapper, $mediaItem);

		$form = new MediaForm($req, $mediaItem);
		$form->addSubmitButton('save', $saveButton, $saveHandler);

		$form->listen();


		$view = new View('media/uploadmedia.php');
		$view->assign('form', $form);
		$view->assign('aErrors', array());

		$baseview = parent::getBaseView();
		$baseview->assign('oModule', $view);

		return $baseview->getContents();
		
	}

	public function _default() {
		return __CLASS__;
	}
}