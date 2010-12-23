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

	private function buildMenuItem($url, $name) {

		if ($name == "") {
			$url = $this->baseurl;
			$name = Lang::get('breadcrumb.root');
		}

		return new MenuItem($url, $name);
		
	}

	public function build() {

		if (!$this->build) {
			
			$this->breadcrumb->addItem(new MenuItem(false, Lang::get('breadcrumb.here')));

			$breadcrumbFolders = array();
			$folder = $this->currentfolder;
			while ($folder->hasParent()) {
				
				$parentFolder = $folder->getParent();
				$breadcrumbFolders[] = $this->buildMenuItem($this->baseurl.'/folder/'.$parentFolder->getID(), $parentFolder->getName());

				$folder = $parentFolder;
			}

			if (count($breadcrumbFolders)) {
				$breadcrumbFolders = array_reverse($breadcrumbFolders);

				foreach ($breadcrumbFolders as $menuItem) {
					$this->breadcrumb->addItem($menuItem);
				}
			}
			
			$this->breadcrumb->addItem($this->buildMenuItem($this->baseurl.'/folder/'.$this->currentfolder->getID(), $this->currentfolder->getName()));
		}
		
		return $this->breadcrumb;


	}


}