<?php

$config = array(

	'dir' => array(
		'www' => realpath(SYS_DIR.'/www'),
		'templates' => realpath(APP_DIR.'/templates'),
		'lang' => realpath(APP_DIR.'/lang'),
	),

	'url' => array(
		'www' => 'http://'.DOMAIN.'/swz/www',
		'images' => 'http://'.DOMAIN.'/swz/www/images',
		'css' => 'http://'.DOMAIN.'/swz/www/css',
		'js' => 'http://'.DOMAIN.'/swz/www/js',
	),

	'default_lang' => 'NL',
	
);