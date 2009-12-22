<?php

class BreadcrumbFactory {

/**
 * @var IFolder
 */
	private $currentfolder;

	/**
	 * @var BreadCrumb
	 */
	private $breadcrumb;

	private $build = false;

	private $baseurl;

	public function __construct(IFolder $folder, $baseurl) {
		$this->currentfolder = $folder;
		$this->breadcrumb = new BreadCrumb();
		$this->baseurl = $baseurl;
	}

	public function build() {

		if (!$this->build) {
			$this->breadcrumb->addItem(new MenuItem(false, Lang::get('breadcrumb.here')));
			$this->breadcrumb->addItem(new MenuItem($this->baseurl, Lang::get('breadcrumb.root')));

			$breadcrumbFolders = array();
			$folder = $this->currentfolder;
			while ($folder->hasParent()) {
			// it has a parent
				$parentFolder = $folder->getParent();
				$breadcrumbFolders[] = new MenuItem($this->baseurl.'/folder/'.$parentFolder->getID(), $parentFolder->getName());
				$folder = $parentFolder;
			}

			if (count($breadcrumbFolders)) {
				$breadcrumbFolders = array_reverse($breadcrumbFolders);

				foreach ($breadcrumbFolders as $menuItem) {
					$this->breadcrumb->addItem($menuItem);
				}
			}
		}
		
		return $this->breadcrumb;


	}


}