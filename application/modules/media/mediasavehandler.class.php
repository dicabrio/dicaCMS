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
	 * @param Form $oForm
	 */
	public function handleForm(Form $oForm) {
		try {

			$data =  DataFactory::getInstance();
			$data->beginTransaction();

			$this->formmapper->constructModelsFromForm($oForm);

			$this->mediaItem->save();

			$data->commit();
			
			Util::gotoPage(Conf::get('general.url.www').'/page/folder/'.$this->folder->getID());

		} catch (PageRecordException $e) {

			$oForm->getFormElement('media_id')->notMapped();
			$this->formmapper->addMappingError('media', $e->getMessage());

		} catch (FormMapperException $e) {

			$data->rollBack();
			
		}
	}

}