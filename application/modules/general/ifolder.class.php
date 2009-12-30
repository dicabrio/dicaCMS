<?php
/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
interface IFolder {

/**
 * @return int
 */
	public function getID();

	/**
	 * @return title
	 */
	public function getName();

	/**
	 * @return IFolder
	 */
	public function getParent();

	/**
	 * @return boolean
	 */
	public function hasParent();

	/**
	 * get children in this folders
	 *
	 * @return array
	 */
	public function getChildren();

}