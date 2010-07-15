<?php


interface CmsModuleController {

	/**
	 * 
	 * @param Page $oPage
	 * @param Form $form
	 * @param FormMapper $mapper
	 * @param CmsController $controller
	 * 
	 * @return void
	 */
	public function __construct(PageModule $oMod, Form $form, FormMapper $mapper, CmsController $controller = null);
	
	/**
	 * This method will return the source of how to edit.
	 * it will return the html code of an textarea or something like that
	 *
	 * @return View
	 */
	public function getEditor();
	
	/**
	 * Handle the validation and saving of the given data for this page. If the module is validated and saved successful.
	 * return true else return false
	 * 
	 * @param FormMapper $mapper 
	 */
	public function handleData();
	
	/**
	 * @return string
	 */
	public function getIdentifier();

}