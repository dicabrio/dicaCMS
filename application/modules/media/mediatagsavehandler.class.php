<?php

class MediaTagSaveHandler implements FormHandler {

	/**
	 * @var FormMapper
	 */
	private $formmapper;

	/**
	 * @var Media
	 */
	private $mediaItem;
	
	/**
	 *
	 * @var Page
	 */
	private $page;
	
	/**
	 *
	 * @var string
	 */
	private $redirect = '';

	/**
	 * 
	 * @param FormMapper $formmapper
	 * @param Page $page
	 */
	public function __construct(FormMapper $formmapper, Page $page, $redirect = '') {
		$this->formmapper = $formmapper;
		$this->page = $page;
		$this->redirect = $redirect;
	}

	/**
	 * @param Form $oForm
	 */
	public function handleForm(Form $oForm) {

		try {

			$data = DataFactory::getInstance();
			$data->beginTransaction();

			$auth = Authentication::getInstance();

			$this->formmapper->addFormElementToDomainEntityMapping('title', 'RequiredTextLine');
			$this->formmapper->addFormElementToDomainEntityMapping('description', 'DomainText');
			$this->formmapper->addFormElementToDomainEntityMapping('media', 'Upload');
			$this->formmapper->addFormElementToDomainEntityMapping('tags', 'TagsFactory');

			$this->formmapper->constructModelsFromForm($oForm);

			$upload = $this->formmapper->getModel('media');
			$tagsFactory = $this->formmapper->getModel('tags');

			$this->mediaItem = new Media();
			$this->moveFileAndUpdateMediaItem($upload);
			$this->mediaItem->setOwner($auth->getUser());
			$this->mediaItem->save();

			$this->updateTagsForMediaItem($tagsFactory);

			$data->commit();
			
			if (!empty($this->redirect)) {
				
				Util::gotoPage($this->redirect);
			} 
			else {
				
				Util::gotoPage(Conf::get('general.url.www').'/'.$this->page->getName());
			}
			
		} catch (PageRecordException $e) {

			$this->formmapper->addMappingError('media', $e->getMessage());
		} catch (FileNotFoundException $e) {

			$this->formmapper->addMappingError('media', $e->getMessage());
		} catch (FormMapperException $e) {

			$data->rollBack();
		}
	}
	
	/**
	 *
	 * @param FileManager $file
	 * @param boolean $exception
	 */
	private function moveFileAndUpdateMediaItem(Upload $upload, $exception = false) {

		$upload->moveTo(Conf::get('upload.dir.general'));
		$file = $upload->getFile();

		if ($this->mediaItem->getID() == 0 && $file === null) {
			throw new FileNotFoundException('no-file-uploaded');
		}

		$this->mediaItem->update($this->formmapper->getModel('title'), $this->formmapper->getModel('description'), $file);
	}
	
	/**
	 * 
	 * @param TagsFactory $tagFactory
	 */
	private function updateTagsForMediaItem(TagsFactory $tagFactory) {
		
		$this->mediaItem->getID();
		
		foreach ($tagFactory->getTags() as $tag) {
			Relation::add('media', 'tag', $this->mediaItem, $tag);
		}
	}

}