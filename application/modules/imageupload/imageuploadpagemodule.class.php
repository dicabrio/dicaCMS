<?php

class ImageuploadPageModule implements PageModuleController {

	/**
	 * @var PageModule
	 */
	private $oPageModule;

	/**
	 * @var Page
	 */
	private $page;

	/**
	 *
	 * @var Request
	 */
	private $request;

	/**
	 * @var Media
	 */
	private $mediaItem;

	/**
	 * construct the text line module
	 *
	 * @param string $sIdentifier
	 * @param Page $oPage
	 * @return void
	 */
	public function __construct(PageModule $oMod, Page $page, Request $request) {

		$this->request = $request;
		$this->oPageModule = $oMod;
		$this->page = $page;
		$this->load();

	}

	/**
	 * load the needed information
	 */
	private function load() {

		$mediaItem = Relation::getSingle('pagemodule', 'media', $this->oPageModule);
		if ($mediaItem === null) {
			$mediaItem = new Media();
		}
		$this->mediaItem = $mediaItem;

	}

	/**
	 * @return View
	 */
	public function getContents() {

		try {

			return $this->getView('imageuploadcontent.php');

		} catch (Exception $e) {
			if (DEBUG == true) {
				return $e->getMessage();
			}
		}

		return "";

	}

	protected function getView($viewfile) {
		
		$file = $this->mediaItem->getFile();
		$image = new Image($file);
		$path = Conf::get('general.cmsurl.www').Conf::get('upload.url.general').'/'.$file->getFilename();

		$view = new View(Conf::get('general.dir.templates').'/imageupload/'.$viewfile);
		$view->imageurl = $path;
		$view->title = $this->mediaItem->getTitle();
		$view->description = $this->mediaItem->getDescription();
		$view->imageheight = $image->getHeight();

		return $view;
	}

	/**
	 *
	 * @return string
	 */
	public function getIdentifier() {

		return $this->oPageModule->getIdentifier();

	}

}