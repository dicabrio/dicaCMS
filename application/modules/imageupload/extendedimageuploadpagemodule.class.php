<?php

class ExtendedimageuploadPageModule extends ImageuploadPageModule {



	/**
	 * @return View
	 */
	public function getContents() {

		try {

			return $this->getView('extendedimageuploadcontent.php');

		} catch (Exception $e) {
		}

		return "";

	}

}