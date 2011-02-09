<?php

$config = array(
	'dir' => array(
		'www' => realpath(SYS_DIR . '/www'),
		'templates' => realpath(APP_DIR . '/templates'),
		'lang' => realpath(APP_DIR . '/lang'),
	),
	'url' => array(
		'www' => 'http://' . DOMAIN,
		'images' => 'http://' . DOMAIN . '/images',
		'css' => 'http://' . DOMAIN . '/css',
		'js' => 'http://' . DOMAIN . '/js',
	),
	'cmsurl' => array(
		'www' => 'http://' . DOMAIN . '/cms',
	),
	'default_lang' => 'NL',
);