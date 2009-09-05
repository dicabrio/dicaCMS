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
class Template
{
	private static $m_sTemplateDirectory = false;

	private $m_sTemplateFile 	= false;

	private $m_sContent 		= false;

	private $m_aTemplateLabels 	= array();

	private $m_aPlaceholders 	= array();

	private $m_aReplacements 	= array();

	private $m_aConstPlaceholders = array();

	private $m_aConstReplacements = array();

	public function __construct($psContent='') {
		if (is_string($psContent))
		{
			$this->m_sContent = $psContent;
		}
		else
		{
			throw new Exception('Content is not of the right type', 0);
		}
	}

	public static function setTemplateDirectory($psTemplateDirectory)
	{
		if (is_string($psTemplateDirectory) && is_dir($psTemplateDirectory))
		{
			self::$m_sTemplateDirectory = $psTemplateDirectory;
		}
		else
		{
			throw new Exception('Template directory:'.$psTemplateDirectory.' does not exist', 0);
		}
	}

	/**
	 * @param string $psFileName Templatefilename
	 * @return void
	 * @throws exception
	 */
	public function setTemplateFile($psTemplateFilename)
	{
		$this->m_sTemplateFile = $psTemplateFilename;
		$sTemplateFilename = self::$m_sTemplateDirectory.'/'.$this->m_sTemplateFile;
		if (file_exists($sTemplateFilename))
		{
			$this->m_sContent = file_get_contents($sTemplateFilename);
			$this->__parseTemplateIncludes();
		}
		else
		{
			throw new Exception('FileName:'.$this->m_sTemplateFile
			.' does not exists in template directory', 0);
		}
	}

	public function setTemplateContents($psContent)
	{
		if (is_string($psContent))
		{
			$this->m_sContent = $psContent;
		}
		else
		{
			throw new Exception('Content is not of the right type', 0);
		}
	}


	public function setContents()
	{

	}

	/**
	 * Includes all files specified in the template
	 */
	private function __parseTemplateIncludes()
	{
		$aFilesToInclude = array();
		preg_match_all('/\[\[include:([A-Za-z0-9_.-]+)\]\]/', $this->m_sContent, $aFilesToInclude);
		for($i=0; $i < count($aFilesToInclude[1]); $i++)
		{
			//It is not allowed to go a dir higher
			if (FALSE === strpos($aFilesToInclude[1][$i], '..'))
			{
				$sContentToInclude = file_get_contents(self::$m_sTemplateDirectory .'/'.$aFilesToInclude[1][$i]);
				$this->m_sContent = str_replace($aFilesToInclude[0][$i], $sContentToInclude, $this->m_sContent);
			}
			else
			{
				$this->m_sContent = str_replace($aFilesToInclude[0][$i], "", $this->m_sContent);
			}
		}

		if (strpos($this->m_sContent, '[[include:'))
		{
			$this->__parseTemplateIncludes();
		}
	}

	/**
	 * [[agenda:test]]
	 * [[news:blaat]]
	 * [[header]]
	 * [[include:file.html]]
	 */
	private function __getLabels($psPattern)
	{
		$aTemplateLabes = array();
		preg_match_all($psPattern, $this->m_sContent, $aTemplateLabes);

		return $aTemplateLabes;
	}

	public function getAllLabels()
	{
		return $this->__getLabels('/\[\[([A-Za-z0-9_:.]+)\]\]/');
	}

	public function getModules()
	{
		return $this->__getLabels('/\[\[([A-Za-z0-9_]+):([A-Za-z0-9_.]+)\]\]/');
	}

	/**
	 * @param string $psPattern Pattern that should be replaced
	 * @param string $psVal The content the pattern should replaced with
	 */
	public function assign($psPattern, $psVal)
	{
		$sPattern = '[['.$psPattern.']]';
		$iPos = array_search($sPattern, $this->m_aPlaceholders);
		if (is_object($psVal)) {
			$psVal = $psVal->__toString();
		}

		if ($iPos === FALSE)
		{
			$this->m_aPlaceholders[] = $sPattern;
			$this->m_aReplacements[] = $psVal;
		}
		else
		{
			$this->m_aPlaceholders[$iPos] = $sPattern;
			$this->m_aReplacements[$iPos] = $psVal;
		}
	}

	public function assignConst($psPattern, $psVal)
	{
		$sPattern = '[['.$psPattern.']]';
		$iPos = array_search($sPattern, $this->m_aPlaceholders);

		if ($iPos === FALSE)
		{
			$this->m_aConstPlaceholders[] = $sPattern;
			$this->m_aConstReplacements[] = $psVal;
		}
		else
		{
			$this->m_aConstPlaceholders[$iPos] = $sPattern;
			$this->m_aConstReplacements[$iPos] = $psVal;
		}
	}

	/**
	 * @return string Parsed template
	 */
	public function getContents()
	{
		return str_replace($this->m_aConstPlaceholders
		, $this->m_aConstReplacements
		, str_replace($this->m_aPlaceholders
		, $this->m_aReplacements
		, $this->m_sContent));
	}
}

?>