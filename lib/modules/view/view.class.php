<?php
/**
 * File template.class.php
 *
 */

/**
 * Class template
 * @author Robert Cabri
 * @version 1.01
 *
 * @todo remove the static method to set the template directory
 *
 */
class View {

	/**
	 * @todo remove this directory. This is global state we don't want that :(
	 * 
	 * @var string
	 */
	private static $m_sTemplateDirectory = false;

	/**
	 *
	 * @var string
	 */
	private $m_sTemplateFile = false;

	/**
	 *
	 * @var array
	 */
	private $m_aTemplateData = array();

	/**
	 *
	 * @var string
	 */
	private $source = "";

	/**
	 *
	 * @var array
	 */
	private $m_aGlobalData = array();

	/**
	 * @var View
	 */
	private $m_oParentView = null;

	/**
	 *
	 * @var array
	 */
	private $scripts = array();

	/**
	 *
	 * @var array
	 */
	private $style = array();

	/**
	 * construct the view if given a template filename it will check if it exists
	 *
	 * @param string $psFileName
	 */
	public function __construct($psFileName=null) {
		if ($psFileName !== null) {
			$this->setTemplateFile($psFileName);
		}
		
		$this->assign('sTemplateDir', self::$m_sTemplateDirectory);
	}

	/**
	 * This sets the template directory for every view file. It checks if the dir exists. Should be called only once
	 *
	 * @param string $psTemplateDirectory
	 */
	public static function setTemplateDirectory($psTemplateDirectory) {
		if (is_string($psTemplateDirectory) && is_dir($psTemplateDirectory)) {
			self::$m_sTemplateDirectory = $psTemplateDirectory;
		} else {
			throw new Exception('Template directory:'.$psTemplateDirectory.' does not exist', 0);
		}
	}

	/**
	 * @param string $psFileName Templatefilename
	 * @return void
	 * @throws FileNotFoundException if the file is not available
	 */
	public function setTemplateFile($psTemplateFilename) {
		
		$this->m_sTemplateFile = $psTemplateFilename;
		$sTemplateFilename = self::$m_sTemplateDirectory.'/'.$this->m_sTemplateFile;

		$oFile = new FileManager($sTemplateFilename);
	}

	public function defineSource($source) {
		$this->source = $source;
	}

	public function addScript($script) {

		if ($this->hasParent()) {
			$this->m_oParentView->addScript($script);
		} else {
			$this->scripts[] = $script;
		}
	}

	public function addStyle($style) {
		if ($this->hasParent()) {
			$this->m_oParentView->addStyle($style);
		} else {
			$this->style[] = $style;
		}
	}

	/**
	 * @param string $psPattern Pattern that should be replaced
	 * @param string $psVal The content the pattern should replaced with
	 */
	public function assign($psVariable, $pmValue) {
		
		if ($pmValue instanceof View) {
			$pmValue->setParent($this);
			$pmValue = "".$pmValue;
		}
		$this->m_aTemplateData[$psVariable] = $pmValue;
	}

	public function assignGlobal($psVariable, $psValue) {
		
		$this->m_aGlobalData[$psVariable] = $psValue;
	}

	public function getGlobals() {
		return $this->m_aGlobalData;
	}

	/**
	 * set the parent for this view
	 * 
	 * @param View $oView
	 */
	public function setParent(View $oView) {
		$this->m_oParentView = $oView;
	}

	/**
	 * check if this view has a parent view
	 * @return Boolean
	 */
	public function hasParent() {
		if ($this->m_oParentView !== null) {
			return true;
		}
		return false;
	}

	/**
	 * @return string Parsed template
	 */
	public function getContents() {
		ob_start();

		if ($this->m_oParentView !== null) {
			extract($this->m_oParentView->getGlobals(), EXTR_SKIP);
		}
		extract($this->m_aGlobalData, EXTR_SKIP);
		extract($this->m_aTemplateData, EXTR_SKIP);

		$sTemplateFilename = self::$m_sTemplateDirectory.'/'.$this->m_sTemplateFile;
		include $sTemplateFilename;

		return ob_get_clean();
	}

	public function __set($sVarname, $sValue) {
		$this->assign($sVarname, $sValue);
	}
	
	public function __get($psVariable) {
		if (isset($this->m_aTemplateData[$psVariable])) {
			return $this->m_aTemplateData[$psVariable];
		}
		return null;
	}

	public function __toString() {
		return $this->getContents();
	}
}
