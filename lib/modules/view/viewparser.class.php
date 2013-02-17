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
class ViewParser {
	const MOD_PATTERN = '/<\?php\s+echo\s+\$([a-zA-Z0-9]+)_([a-zA-Z0-9_]+);?\s?\?>/';

	const MOD_NEW_PATTERN = '/\[\[(([A-Za-z0-9]+):([A-Za-z0-9_-]+)\s?([a-zA-Z=\-_."\s0-9]+)?)\]\]/';

	const MOD_PARAM_PATTERN = '/([a-zA-Z_-]+)=\"([a-zA-Z0-9\s_-]+)\"/';

	const MOD_VAR_BUILDER = '%s_%s';

	/**
	 * @var TemplateFile
	 */
	private $viewFile;

	/**
	 * construct the view if given a template filename it will check if it exists
	 *
	 * @param string $psFileName
	 */
	public function __construct(TemplateFile $file=null) {
		$this->viewFile = $file;
	}

	/**
	 * parses the template and returns the labels that are on the page
	 *
	 * it gets the following labels:
	 * <?php echo $<Modname>_<identifier>; ?>
	 *
	 * @return array
	 */
	public function getLabels() {
		$sFileContents = $this->viewFile->getSource();
		preg_match_all(self::MOD_PATTERN, $sFileContents, $matches);
		preg_match_all(self::MOD_NEW_PATTERN, $sFileContents, $matchesNew);

		$moduleNames = $matches[1];
		$moduleIdentifiers = $matches[2];

		// new
		$modulesReplaceString = $matchesNew[1];
		$moduleNamesNew = $matchesNew[2];
		$moduleIdentifiersNew = $matchesNew[3];
		$moduleParams = $matchesNew[4];

		$moduleLables = array();
		foreach ($moduleNames as $key => $moduleName) {
			$moduleLables[$moduleIdentifiers[$key]] = array(
				'replacestring' => '',
				'module' => $moduleName,
				'id' => $moduleIdentifiers[$key],
				'params' => array());
		}

		foreach ($moduleNamesNew as $key => $moduleName) {
			if (!isset($moduleLables[$moduleIdentifiersNew[$key]])) {
				$moduleLables[$moduleIdentifiersNew[$key]] = array(
					'replacestring' => $modulesReplaceString[$key],
					'module' => $moduleName,
					'id' => $moduleIdentifiersNew[$key],
					'params' => array());
			}

			$moduleLables[$moduleIdentifiersNew[$key]]['params'] = $this->getParametersForLabel($moduleParams[$key]);
		}

		return $moduleLables;
	}

	private function getParametersForLabel($paramsString) {

		preg_match_all(self::MOD_PARAM_PATTERN, $paramsString, $matches);

		$params = array();
		foreach ($matches[1] as $key => $parameterName) {

			$params[] = array('name' => $parameterName, 'value' => $matches[2][$key]);
		}
		return $params;
	}

	public static function constructLabel($sModule, $sIdentifier) {
		return sprintf(self::MOD_VAR_BUILDER, $sModule, $sIdentifier);
	}

}