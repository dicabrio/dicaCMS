<?php

function __autoload($psClassName) {
	if (!class_exists($psClassName)) {
		// you also can add a class like this data.DataArguments this will be data/DataArguments accordingly
		if (false === strpos('..', $psClassName)) {
			$classFile = str_replace('.', '/', strtolower($psClassName)).'.class.php';
			include_once($classFile);
		}
	}
}

function test($pVar) {
	if (is_string($pVar)) {
		echo '>'.$pVar.'<';
	} else {
		echo '<pre>';
		print_r($pVar);
		echo '</pre>';
	}
}
