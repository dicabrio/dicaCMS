<?php


interface PageModuleController {

	/**
	 * 
	 * @param string $sIdentifier
	 * @param Page $oPage
	 * @return void
	 */
	public function __construct(PageModule $oMod, Page $page);
	
	/**
	 * get contents for this module as a string or an object that has a __toString method implemented
	 * 
	 * @return string
	 */
	public function getContents();
	
	/**
	 * Handle the validation and saving of the given data for this page. If the module is validated and saved successful.
	 * return true else return false
	 * 
	 * @param $oReq
	 * @return boolean
	 */
	public function handleData(Request $oReq);
	
	/**
	 * return the errors occurred when validating the given data
	 * @return array
	 */
	public function getErrors();

	/**
	 * validate the data that is posted. If there are any errors
	 * the return array will hold the errormessages. If no error is present it returns an empty array
	 *
	 * @param $aData
	 * @return array
	 */
	public function validate($aData);

	/**
	 * @return string
	 */
	public function getIdentifier();

}