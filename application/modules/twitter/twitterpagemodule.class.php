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
	 * @var Page
	 */
	private $page;

	/**
	 * @var string
	 */
	private $twitterAccount;

	/**
	 *
	 * @var string
	 */
	private $twitterAmount;
	
	/**
	 * construct the text line module
	 *
	 * @param string $sIdentifier
	 * @param Page $oPage
	 * @return void
	 */
	public function __construct(PageModule $oMod, Page $page, Request $request) {

		$this->oPageModule = $oMod;
		$this->page = $page;
		$this->load();

	}

	/**
	 * load the needed information
	 */
	private function load() {

		$this->templateFile = Relation::getSingle('pagemodule', 'templatefile', $this->oPageModule);

		$accountSetting = Setting::getByName('twitteraccount');
		$amountSetting = Setting::getByName('twitteramount');
		$this->twitterAccount = $accountSetting->getValue();
		$this->twitterAmount = $amountSetting->getValue();

		$this->getTweets();

	}

	/**
	 * @return View
	 */
	public function getContents() {

		if ($this->templateFile === null) {
			return '';
		}
		
		$tweet = current(Tweet::getLast(1));
		$tweets = Tweet::getLast((int)$this->twitterAmount);


		$tweetMessages = array();
		foreach ($tweets as $tweety) {
			$tweetMessages[] = array('message' => $tweety->getMessage(), 'date' => $tweety->getDate());
		}

		$view = new View(Conf::get('upload.dir.templates').'/'.$this->templateFile->getFilename());
		$view->assign('wwwurl', Conf::get('general.url.www'));
		$view->assign('imagesurl', Conf::get('general.url.images'));
		$view->assign('mediaurl', Conf::get('general.url.www').Conf::get('upload.url.general'));
		$view->assign('twittermessage', $tweet->getMessage());
		$view->assign('twittermessages', $tweetMessages);
		$view->assign('twitteraccount', $this->twitterAccount);
		$view->assign('pagename', $this->page->getName());

		return $view;

	}

	/**
	 *
	 * @return string
	 */
	public function getIdentifier() {

		return $this->oPageModule->getIdentifier();

	}

	/**
	 * load the tweets from twitter
	 */
	private function getTweets() {

		$lastTweet = current(Tweet::getLast());
			test($lastTweet->getUpdate());

		if (strtotime($lastTweet->getUpdate()) < strtotime('now - 30 minutes')) {

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

				$data->rollBack();

				$lastTweet->setUpdate(new Date('now'));
				$lastTweet->save();
			}
		}
		
	}
}