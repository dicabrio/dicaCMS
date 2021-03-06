<?php


interface PageModuleController {

	/**
	 * 
	 * @param PageModule $oMod
	 * @param Page $oPage
	 * @param Request $request
	 */
	public function __construct(PageModule $oMod, Page $page, Request $request);
	
	/**
	 * get contents for this module as a string or an object that has a __toString method implemented
	 * 
	 * @return View
	 */
	public function getContents();
	
	/**
	 * @return string
	 */
	public function getIdentifier();

}