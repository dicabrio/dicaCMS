<?php

class RecoverableError extends Exception {}

function __errorHandler($iErrorNo, $sErrorStr, $sErrorFile='', $sErrorline='', $aErrorContext='') {
//	test(func_get_args());
	throw new RecoverableError('An error occurred: Error '.$sErrorStr.' in file '.$sErrorFile.' on line '.$sErrorline);
}

function __exceptionHandler(Exception $oException) {

	if (DEBUG === true) {
		echo 'An Error occurred: '.$oException->getMessage();
		test($oException->getTraceAsString());
		exit;
	} else {
		$oView = new View('error.php');
		echo $oView->getContents();
		exit;
	}
}


function __autoload($psClassName) {
	if (!class_exists($psClassName)) {
		// you also can add a class like this data.DataArguments this will be data/DataArguments accordingly
		if (false === strpos('..', $psClassName)) {
			$classFile = str_replace('.', '/', strtolower($psClassName)).'.class.php';
			include($classFile);
		}
	}
}

function test($pVar) {
	if (is_string($pVar)) {
		echo '<pre style="background: white; padding: 5px; border: 1px solid black;">>'.$pVar.'<</pre>';
	} else {
		echo '<pre style="background: white; padding: 5px; border: 1px solid black;">';
		print_r($pVar);
		echo '</pre>';
	}
}