<?php


class MediaSaveHandler implements FormHandler {

	/**
	 * @var FormMapper
	 */
	private $formmapper;

	/**
	 * @var Media
	 */
	private $mediaItem;

	/**
	 * @param FormMapper $formmapper
	 * @param Page $page
	 * @param PageFolder $folder
	 */
	public function __construct(FormMapper $formmapper, Media $page) {
		$this->formmapper = $formmapper;
		$this->mediaItem = $page;
	}

	/**
	 *
	 * @param FileManager $file
	 * @param boolean $exception
	 */
	private function moveFile(Upload $upload, $exception = false) {

		$upload->moveTo(Conf::get('upload.dir.general'));
		$file = $upload->getFile();

		if ($this->mediaItem->getID() == 0 && $file === null) {
			throw new FileNotFoundException('no-file-uploaded');
		}

		$this->mediaItem->update($this->formmapper->getModel('title'), $this->formmapper->getModel('description'), $file);
	}

	/**
	 * @param Form $oForm
	 */
	public function handleForm(Form $oForm) {
		try {

			$data =  DataFactory::getInstance();
			$data->beginTransaction();

			$this->formmapper->addFormElementToDomainEntityMapping('title', 'RequiredTextLine');
			$this->formmapper->addFormElementToDomainEntityMapping('description', 'DomainText');
			$this->formmapper->addFormElementToDomainEntityMapping('media', 'Upload');

			$this->formmapper->constructModelsFromForm($oForm);

			$upload = $this->formmapper->getModel('media');
			$this->moveFile($upload);

			$this->mediaItem->save();

			$data->commit();
			Util::gotoPage(Conf::get('general.url.www').'/media/');

		} catch (PageRecordException $e) {

			$this->formmapper->addMappingError('media', $e->getMessage());

		} catch (FileNotFoundException $e) {

			$this->formmapper->addMappingError('media', $e->getMessage());

		} catch (FormMapperException $e) {

			$data->rollBack();

		}
	}

}