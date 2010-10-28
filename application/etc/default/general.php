<?php

$config = array(

	'dir' => array(
		'www' => realpath(SYS_DIR.'/www'),
		'templates' => realpath(APP_DIR.'/templates'),
		'lang' => realpath(APP_DIR.'/lang'),
	),

	'url' => array(
		'www' => 'http://'.DOMAIN.'/lckv/www',
		'images' => 'http://'.DOMAIN.'/lckv/www/images',
		'css' => 'http://'.DOMAIN.'/lckv/www/css',
		'js' => 'http://'.DOMAIN.'/lckv/www/js',
	),

	'default_lang' => 'NL',
	
);