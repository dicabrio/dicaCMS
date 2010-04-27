<?php

class TwitterPageModule implements PageModuleController {

	/**
	 * @var PageModule
	 */
	private $oPageModule;

	/**
	 * @var TemplateFile
	 */
	private $templateFile;

	/**
	 * @var array
	 */
	private $aErrors;

	/**
	 * @var Page
	 */
	private $page;

	/**
	 * @var string
	 */
	private $twitterAccount;

	/**
	 * construct the text line module
	 *
	 * @param string $sIdentifier
	 * @param Page $oPage
	 * @return void
	 */
	public function __construct(PageModule $oMod, Page $page) {

		$this->oPageModule = $oMod;
		$this->page = $page;
		$this->load();

	}

	/**
	 * load the needed information
	 */
	private function load() {

		$this->templateFile = Relation::getSingle('pagemodule', 'templatefile', $this->oPageModule);

		$configValue = Config::getByName('twitteraccount');
		$this->twitterAccount = $configValue->getValue();

		$this->getTweets();

	}

	/**
	 * @return View
	 */
	public function getContents() {

		if ($this->templateFile === null) {
			return '';
		}
//		$view = $this->templateFile->getView();

		$view = new View($this->templateFile->getFilename());

		$view->assign('wwwurl', Conf::get('general.url.www'));
		$view->assign('imagesurl', Conf::get('general.url.images'));
		$view->assign('mediaurl', Conf::get('general.url.www').Conf::get('upload.url.general'));

		$tweet = current(Tweet::getLast(1));

//		test($tweet->getMessagee());
		$view->assign('twittermessage', $tweet->getMessage());
		$view->assign('twitteraccount', $this->twitterAccount);

		$view->assign('pagename', $this->page->getName());

		return $view;

//		return '';

	}

	/* (non-PHPdoc)
	 * @see modules/Module#validate()
	*/
	public function validate($mData) {

		return true;

	}

	/**
	 *
	 * @param $oReq
	 * @return boolean
	 */
	public function handleData(Request $oReq) {

	}

	/**
	 *
	 * @return array
	 */
	public function getErrors() {

		return $this->aErrors;

	}

	/**
	 *
	 * @return string
	 */
	public function getIdentifier() {

		return $this->oPageModule->getIdentifier();

	}


	private function getTweets() {

		$lastTweets = Tweet::getLast();
		$tweetConnectionString = sprintf('http://twitter.com/users/show/%s.json', $this->twitterAccount);
		$twitterresource = curl_init();

		curl_setopt($twitterresource, CURLOPT_USERAGENT, 'PHP Twitter/TweetStory');
		curl_setopt($twitterresource, CURLOPT_URL, $tweetConnectionString);
		curl_setopt($twitterresource, CURLOPT_RETURNTRANSFER, TRUE);
		$jsonstring = curl_exec($twitterresource);
		curl_close($twitterresource);

		$result = json_decode($jsonstring);
		$data = DataFactory::getInstance();

		$data->beginTransaction();
		try {
			$twitterinfo = new stdClass();
			$twitterinfo->from_user_id = $result->id;
			$twitterinfo->from_user = $result->name;
			$twitterinfo->profile_image_url = $result->profile_image_url;
			$twitterinfo->id = $result->status->id;
			$twitterinfo->text = $result->status->text;
			$twitterinfo->created_at = $result->status->created_at;

			$tweet = new Tweet();
			$tweet->update($twitterinfo);
			$tweet->save();

			$data->commit();

		} catch (Exception $e) {
			// duplicates or incorrect message?
//			test($e->getMessage());

			$data->rollBack();
		}
	}
}