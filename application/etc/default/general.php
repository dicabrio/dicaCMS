<?php

$config = array(

	'dir' => array(
		'www' => realpath(SYS_DIR.'/www'),
		'templates' => realpath(APP_DIR.'/templates'),
		'lang' => realpath(APP_DIR.'/lang'),
	),

	'url' => array(
		'www' => 'http://'.DOMAIN.'/lckvsite/www',
		'images' => 'http://'.DOMAIN.'/lckvsite/www/images',
		'css' => 'http://'.DOMAIN.'/lckvsite/www/css',
		'js' => 'http://'.DOMAIN.'/lckvsite/www/js',
	),

	'default_lang' => 'NL',
	
);