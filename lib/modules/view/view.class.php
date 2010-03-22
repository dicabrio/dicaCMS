<?php
/**
 * File template.class.php
 *
 */

/**
 * Class template
 * @author Robert Cabri
 * @version 0.01
 */
class View
{
	private static $m_sTemplateDirectory = false;

	private $m_sTemplateFile = false;

	private $m_aTemplateData = array();

	private $source = "";

	private $m_aGlobalData = array();

	/**
	 * @var View
	 */
	private $m_oParentView = null;

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

	/**
	 * @param string $psPattern Pattern that should be replaced
	 * @param string $psVal The content the pattern should replaced with
	 */
	public function assign($psVariable, $pmValue) {
		
		if ($pmValue instanceof View) {
			$pmValue->setParent($this);
		}
		$this->m_aTemplateData[$psVariable] = $pmValue;
	}

	public function assignGlobal($psVariable, $psValue) {
		
		$this->m_aGlobalData[$psVariable] = $psValue;
	}

	public function getGlobals() {
		return $this->m_aGlobalData;
	}

	public function setParent(View $oView) {
		$this->m_oParentView = $oView;
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
