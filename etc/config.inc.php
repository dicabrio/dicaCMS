<?php
/*
 * Created on 12 dec 2007
 * File config.inc.php
 * Project CMSje
 * User Robert Cabri <robert@dicabrio.com>
 */

define('DEBUG', true);

//if (DEBUG)
//{
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
//}
//else
//{
//	ini_set('display_errors', 0);
//}

//define('DB_TYPE', 'mysql');
//define('DB_HOST', 'mysql.dicabrio.com');
//define('DB_NAME', 'dicabrio');
//define('DB_USER', 'dicabrio');
//define('DB_PASS', 'robcabri');
define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME', 'dicabrio');
define('DB_USER', 'dicabrio');
define('DB_PASS', 'robcabri');


define('LANG', 'NL');

/**
 * All directories
 */
define('SYS_DIR'		, $_SERVER['DOCUMENT_ROOT'].'/cms');
define('CONFIG_DIR'		, SYS_DIR.'/etc');
define('WWW_DIR'		, SYS_DIR.'/www');
define('LIB_DIR'		, SYS_DIR.'/dica');
define('TEMPLATES_DIR'	, SYS_DIR.'/templates');
define('UPLOAD_DIR'		, SYS_DIR.'/upload');
define('LANG_DIR'		, SYS_DIR.'/lang');

/**
 * All urls
 */
define('DOMAIN'			, 'test.robertcabri.nl');
define('WWW_URL'		, 'http://'.DOMAIN.'/cms/www');
define('IMAGES_URL'		, WWW_URL.'/images');
define('UPLOAD_URL'		, WWW_URL.'/upload');
define('CSS_URL'		, WWW_URL.'/css');
define('JS_URL'			, WWW_URL.'/js'); 


define('DEFAULT_SECURE_PAGE', 'dashboard');


/**
 * Define include paths
 */
$classPaths = array();
$classPaths[] = LIB_DIR.'/controller';
$classPaths[] = LIB_DIR.'/gui';
$classPaths[] = LIB_DIR.'/data';
$classPaths[] = LIB_DIR.'/data/util';
$classPaths[] = LIB_DIR.'/data/model';
$classPaths[] = LIB_DIR.'/util';
$classPaths[] = LIB_DIR.'/service';
$classPaths[] = LIB_DIR.'/modules';
$classPaths[] = LIB_DIR.'/modules/auth';
$classPaths[] = LIB_DIR.'/modules/html';
$classPaths[] = LIB_DIR.'/modules/phpmailer';
$classPaths[] = LIB_DIR.'/modules/swift';

/**
 * By defining the includepath this way you only have to add classpaths folders in this config
 * and you can include the files without knowing there exact location 
 */
$includePath = implode(':', $classPaths);
ini_set('include_path', ini_get('include_path').':'.$includePath.':');


/**
 * include standard functions
 */
include_once('functions.inc.php');


?>
