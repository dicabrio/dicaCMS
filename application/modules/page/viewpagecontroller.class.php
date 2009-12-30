<?php
/**
 * Special type of controller. Only needed to show pages
 *
 * @author robertcabri
 * @package CMS
 */
class ViewPageController {

	public function __construct() {
		// we should check for permissions
		// change the template directory. This differs from the standard

		View::setTemplateDirectory(Conf::get('upload.dir.templates'));
	}

	public function show($sPagename) {
		$oPage = Page::findByName($sPagename);
		if ($oPage === null) {
			return 'page cannot be found<br />';
		}

		$this->mayShow($oPage);

		$oView = $this->getView($oPage);
		$oView->assign('sJsUrl', Conf::get('general.url.js'));
		$oView->assign('sCssUrl', Conf::get('general.url.css'));
		$oView->assign('title', $oPage->getTitle());
		$oView->assign('description', $oPage->getDescription());
		$oView->assign('keywords', $oPage->getKeywords());
		
		$this->populateViewWithModules($oPage, $oView);
		return $oView->getContents();

	}

	private function redirect($sRedirect) {
		if (empty($sRedirect)) {
			$sRedirect = Conf::get('general.url.www');
		}
		if (!preg_match('/^http:\/\//', $sRedirect)) {
			$sRedirect = Conf::get('general.url.www').$sRedirect;
		}

		header("HTTP/1.1 301 Moved Permanently" );
		header("Location: ".$sRedirect );
		exit;
	}

	private function mayShow(Page $oPage) {
		$sToday = strtotime('now');
		$sPublish = strtotime($oPage->getPublishTime());
		$sExpire = $oPage->getExpireTime();

		if ($sExpire == '0000-00-00 00:00:00' || empty($sExpire)) {
			$sExpire = strtotime('now +1second');
		} else {
			$sExpire = strtotime($sExpire);
		}

		if ($sPublish >= $sToday || $sToday >= $sExpire || !$oPage->isActive() || $oPage->getTemplate() === null) {

			$this->redirect($oPage->getRedirect());
		}
	}

	private function getView(Page $oPage) {
		$oTemplateFile = $oPage->getTemplate();
		return new View($oTemplateFile->getFilename());
	}

	private function populateViewWithModules(Page $oPage, View $oView) {

		$oTemplateFile = $oPage->getTemplate();
		$oViewParser = new ViewParser($oTemplateFile);

		foreach ($oViewParser->getLabels() as $aModule) {
			$sContent = '';
			$sLabel = ViewParser::constructLabel($aModule['module'], $aModule['id']);
			$oModule = $oPage->getModule($aModule['id']);
			if ($oModule !== null) {

				$sModuleClass = $oModule->getType().'Controller';
				$oModuleController = new $sModuleClass($oModule);

				$sContent = $oModuleController->getContents();
			}

			$oView->assign($sLabel, $sContent);
		}

	}
}