<?php 

class Tweet extends DataRecord {

	
	public function __construct($id=null) {
		
		parent::__construct(__CLASS__, $id);

		if (!$id) {
			$this->setAttr('update', date('Y-m-d H:i:s'));
		}
		
	}
	
	protected function defineColumns() {

		parent::addColumn('id', DataTypes::INT, false, true);
		parent::addColumn('user_id', DataTypes::INT, false, true);
		parent::addColumn('user', DataTypes::VARCHAR, 255, true);
		parent::addColumn('image', DataTypes::VARCHAR, 255, true);
		parent::addColumn('tweet_id', DataTypes::INT, false, true);
		parent::addColumn('tweet', DataTypes::VARCHAR, 255, true);
		parent::addColumn('datum', DataTypes::DATETIME, 1, true);
		parent::addColumn('update', DataTypes::DATETIME, 1, true);
		
	}

	/**
	 * @return string
	 */
	public function getUpdate() {

		return $this->getAttr('update');
		
	}

	public function setUpdate(Date $date) {

		$this->setAttr('update', $date);

	}

	public function getMessage() {

		return $this->parseTweet($this->getAttr('tweet'));
		
	}

	public function getDate() {

		return $this->getAttr('datum');
		
	}

	private function parseTweet($tweet) {

		$patterns = array(
			'/(http:\/\/[a-zA-Z0-9\/\.-_]{3,})/',
			'/@([a-zA-Z-_\.]+)/',
			'/#([a-zA-Z-_\.]+)/',
			);
		$replacements = array(
			'<a href="$1" class="external">$1</a>',
			'@<a href="http://www.twitter.com/$1">$1</a>',
			'<a href="http://twitter.com/#search?q=%23$1">#$1</a>',
			);

		return preg_replace($patterns, $replacements, $tweet);
		
	}

	/**
	 *
	 * @param stdClass $result
	 */
	public function update(stdClass $result) {

		$this->setAttr('user_id', $result->from_user_id);
		$this->setAttr('user', $result->from_user);
		$this->setAttr('image', $result->profile_image_url);
		$this->setAttr('tweet_id', $result->id);
		$this->setAttr('tweet', $result->text);
		$this->setAttr('datum', $this->parseDate($result->created_at));

	}

	private function parseDate($date) {

		return date('Y-m-d H:i:s', strtotime($date));
		
	}
	
	public static function getLast($limit = 1) {
		
		$aReturnVals = parent::findAll(__CLASS__, parent::ALL, null, 'id DESC', $limit);
		
		if (count($aReturnVals) > 0) {
			return $aReturnVals;
		}
		
		return array(new Tweet());
	}

	public static function getContributors($limit = 15) {

		$sql = "SELECT * FROM ".__CLASS__." GROUP BY user_id ORDER BY id DESC LIMIT ".$limit;
		$aReturnVals = parent::findBySql(__CLASS__, $sql);

		if (count($aReturnVals) > 0) {
			return $aReturnVals;
		}

		return null;
	}

	public static function getAll() {

		$aReturnVals = parent::findAll(__CLASS__, parent::ALL, null, 'id ASC');

		if (count($aReturnVals) > 0) {
			return $aReturnVals;
		}

		return array();

	}
	
}


class TweetException extends Exception {}