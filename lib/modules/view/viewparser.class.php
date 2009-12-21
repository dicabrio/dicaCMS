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
class ViewParser
{

	const MOD_PATTERN = '/<\?php\s+echo\s+\$o([a-zA-Z0-9]+)_([a-zA-Z0-9]+);?\s?\?>/';
	
	const MOD_VAR_BUILDER = 'o%s_%s'; 

	/**
	 * @var FileManager
	 */
	private $oTemplateFile;

	/**
	 * construct the view if given a template filename it will check if it exists
	 *
	 * @param string $psFileName
	 */
	public function __construct(FileManager $file=null) {
		$this->oTemplateFile = $file;
	}

	/**
	 * parses the template and returns the labels that are on the page
	 *
	 * it gets the following labels:
	 * <?php echo $o<Modname>_<identifier>; ?>
	 *
	 * @return array
	 */
	public function getLabels() {
		$sFileContents = $this->oTemplateFile->getContents();
		preg_match_all(self::MOD_PATTERN, $sFileContents, $aMatches);

		$aModuleNames = $aMatches[1];
		$aModuleIdentifiers = $aMatches[2];

		$aModuleLables = array();
		foreach ($aModuleNames as $iKey => $sModuleName) {
			$aModuleLables[] = array('module' => $sModuleName, 'id' => $aModuleIdentifiers[$iKey]);
		}
		return $aModuleLables;
	}
	
	public static function constructLabel($sModule, $sIdentifier) {
		return sprintf(self::MOD_VAR_BUILDER, $sModule, $sIdentifier);
	}

}