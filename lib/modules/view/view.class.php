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
	 * @var array
	 */
	private $replaceStrings = array();

	/**
	 *
	 * @var array
	 */
	private $replaceData = array();
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
	}

	/**
	 * @param string $psFileName Templatefilename
	 * @return void
	 * @throws FileNotFoundException if the file is not available
	 */
	public function setTemplateFile($psTemplateFilename) {

		$this->m_sTemplateFile = $psTemplateFilename;
		$oFile = new FileManager($this->m_sTemplateFile);
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
			$pmValue = "" . $pmValue;
		}
		$this->m_aTemplateData[$psVariable] = $pmValue;
	}

	public function replace($variable, $value) {

		$pattern = '[['.$variable.']]';
		$arrayPosition = array_search($pattern, $this->replaceStrings);

		if ($arrayPosition === FALSE)
		{
			$this->replaceStrings[] = $pattern;
			$this->replaceData[] = "".$value;
		}
		else
		{
			$this->replaceStrings[$arrayPosition] = $pattern;
			$this->replaceData[$arrayPosition] = "".$value;
		}


		$this->replaceStrings[] = $variable;
		$this->replaceData[] = $value;
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

		foreach ($this->scripts as $script) {
			$oView->addScript($script);
		}

		foreach ($this->style as $style) {
			$oView->addStyle($style);
		}

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

//		$sTemplateFilename = self::$m_sTemplateDirectory . '/' . $this->m_sTemplateFile;
		$sTemplateFilename = $this->m_sTemplateFile;
		include $sTemplateFilename;

		$output = ob_get_clean();
//test($this->replaceStrings);
//exit;
		return str_replace($this->replaceStrings, $this->replaceData, $output);
//		return $output;
	}
	
	/**
	 *
	 * @param type $fileName
	 * @param type $inline
	 * @return string
	 */
	public function render($fileName, $inline=false) {
		
		$this->setTemplateFile($fileName);
		
		if ($inline !== false) {
			
			ob_start();
		}
		

		if ($this->m_oParentView !== null) {
			extract($this->m_oParentView->getGlobals(), EXTR_SKIP);
		}
		extract($this->m_aTemplateData, EXTR_SKIP);

		$templateFilename = $this->m_sTemplateFile;
		include $templateFilename;

		if ($inline !== false) {
			
			$output = ob_get_clean();
			return str_replace($this->replaceStrings, $this->replaceData, $output);
		}
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
		try {
			return $this->getContents();
		} catch (Exception $e) {
			if (DEBUG == true) {
				return $e->getTraceAsString();
			}
		}
	}
	
	/**
	 *
	 * $anchorInfo = array(
	 *	'controller' => 'user',
	 *	'method' => 'show',
	 *	'params' => array(1),
	 *	'data => array('key' => 'value')
	 *	'label' => 'Show user',
	 *	'class' => 'button',
	 * )
	 *
	 * $anchorInfo = array(
	 *	'href' => 'user/show/1',
	 *	'data => array('key' => 'value')
	 *	'label' => 'Show user',
	 *	'class' => 'button',
	 * )
	 *
	 * @param array $anchorInfo
	 */
	public function getAnchor($anchorInfo=array()) {

		if (!isset($anchorInfo['class'])) {
			$anchorInfo['class'] = '';
		}

		$url = array();
		if (isset($anchorInfo['href'])) {
//			if (strpos($anchorInfo['href'], 'http://') === false) {
//				$url[] = $this->app->config('core/routing.base_url');
//			}
			$url[] = $anchorInfo['href'];

		} else if (isset($anchorInfo['controller'])) {
//			$url[] = $this->app->config('core/routing.base_url');
			$url[] = $anchorInfo['controller'];

			if (isset($anchorInfo['method'])) {

				$url[] = $anchorInfo['method'];
			} else {

				$url[] = 'index';
			}

			if (isset($anchorInfo['params'])) {

				foreach ($anchorInfo['params'] as $param) {
					$url[] = $param;
				}
			}
		}

		$data = '';
		if (isset($anchorInfo['data']) && is_array($anchorInfo['data'])) {
			foreach ($anchorInfo['data'] as $item => $value) {
				$data .= ' data-'.$item.'="'.$value.'"';
			}
		}

		$url = implode('/', $url);

		if (isset($anchorInfo['label'])) {
			$label = $anchorInfo['label'];
		} else {
			$label = $url;
		}

		return '<a href="' . $url. '" class="'.$anchorInfo['class'].'"'.$data.'>' . $label . '</a>';
	}

}
