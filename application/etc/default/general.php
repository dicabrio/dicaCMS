<?php

$config = array(

	'dir' => array(
		'www' => realpath(SYS_DIR.'/www'),
		'templates' => realpath(APP_DIR.'/templates'),
		'lang' => realpath(APP_DIR.'/lang'),
	),

	'url' => array(
		'www' => 'http://'.DOMAIN.'/dicabrio/www',
		'images' => 'http://'.DOMAIN.'/dicabrio/www/images',
		'css' => 'http://'.DOMAIN.'/dicabrio/www/css',
		'js' => 'http://'.DOMAIN.'/dicabrio/www/js',
	),

	'default_lang' => 'NL',
	
);