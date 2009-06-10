<?php


interface Module {
	
	/**
	 * this method is used to determine if the module that is being shown on the edit
	 * page needs a save on that page
	 * 
	 * @return boolean
	 */
	public function editOnPage();
	
	/**
	 * This method will return the source of how to edit. 
	 * it will return the html code of an textarea or something like that 
	 * 
	 * @return string
	 */
	public function getEditor();
	
	/**
	 * if a module cannot be edited directly on the page or if you choose. give
	 * a link to edit the module
	 * 
	 * @return string
	 */
	public function getEditLink();
	
	/**
	 * set the data to be saved
	 * 
	 * @param $aData
	 * @return void
	 */
	public function setData($aData);
	
	/**
	 * validate the data that is posted. If there are any errors
	 * the return array will hold the errormessages. If no error is present it returns an empty array
	 * 
	 * @param $aData
	 * @return array 
	 */
	public function validate($aData);
	
}