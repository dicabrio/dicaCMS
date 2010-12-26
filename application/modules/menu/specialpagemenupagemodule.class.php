<?php

class SpecialpagemenuPageModule implements PageModuleController {

	/**
	 * @var PageModule
	 */
	private $pageModule;
	/**
	 * @var Page
	 */
	private $page;
	/**
	 * @var Request
	 */
	private $request;
	/**
	 * @var PageModuleController
	 */
	private $imageUploadModule;
	/**
	 * @var PageModuleController
	 */
	private $textBlockModule;

	/**
	 *
	 * @param PageModule $module
	 * @param Page $oPage
	 * @param Request $request
	 * @return void
	 */
	public function __construct(PageModule $module, Page $page, Request $request) {

		$this->pageModule = $module;
		$this->page = $page;
		$this->request = $request;

		$this->imageUploadModule = new ImageuploadPageModule($module, $page, $request);
		$this->textBlockModule = new TextblockPageModule($module, $page, $request);
	}

	/**
	 * get contents for this module as a string or an object that has a __toString method implemented
	 *
	 * @return string
	 */
	public function getContents() {

		$activePages = Page::findActive();
		
		$str = '<ol id="mainMenu">';
		foreach ($activePages as $page) {
			if ($this->page->getName() == $page->getName()) {
				$str .= '
					<li class="mainMenuItem mainMenuItemOpened">
						<a class="opened" href="' . Conf::get('general.cmsurl.www') . '/' . $page->getName() . '.html" title="' . $page->getTitle() . '" id="currentItem">' . $page->getTitle() . '</a>
						<div class="when whencurrentItem" id="currentContent">

							<div class="content" >
								<div class="innerDiv">
									'.$this->imageUploadModule->getContents().'
									<p>'.$this->textBlockModule->getContents().'</p>
								</div>
							</div>

							<div class="ruler">
								<div class="linkerkant">&nbsp;</div>
								<div class="rechterkant">&circ;&nbsp;<a href="#container" title="Top">Top</a></div>
								<div class="midden">&nbsp;</div>
							</div>
						</div>

					</li>';
			} else {
				$str .= '
					<li class="mainMenuItem">
						<a class="closed" href="' . Conf::get('general.url.www') . '/' . $page->getName() . '/" title="' . $page->getTitle() . '">' . $page->getTitle() . '</a>
					</li>';
			}
		}
		$str .= '</ol>';

		return $str;
	}

	/**
	 * @return string
	 */
	public function getIdentifier() {

		return '';
	}

}