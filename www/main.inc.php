<?php

// define the system directory
define('SYS_DIR', realpath('../'));

// currentfile
define('CURRENT_FILE', str_replace(dirname(__FILE__).'/', '', $_SERVER['SCRIPT_FILENAME']));

//define the www directory. This could be different on every machine
define('WWW_DIR', realpath('.'));

define('SYS_DIR', realpath('../'));

define('LIB_DIR', SYS_DIR.'/lib');

$classPaths = array();
$classPaths[] = LIB_DIR.'/controller';
$classPaths[] = LIB_DIR.'/gui';
$classPaths[] = LIB_DIR.'/data';
$classPaths[] = LIB_DIR.'/data/util';
$classPaths[] = LIB_DIR.'/data/model';
$classPaths[] = LIB_DIR.'/util';
$classPaths[] = LIB_DIR.'/service';
$classPaths[] = LIB_DIR.'/modules';

$includePath = implode(':', $classPaths);
ini_set('include_path', ini_get('include_path').':'.$includePath.':');

include_once(SYS_DIR.'/etc/config.inc.php');

include_once('functions.inc.php');

try
{
	// import modules
	Util::importModules(LIB_DIR.'/modules');
	
	Conf::setServer(DOMAIN);
	
	Conf::setDirectory(CONFIG_DIR);

	$oDatabase = new PDO(Conf::get('database.type').':dbname='.Conf::get('database.name').';host='.Conf::get('database.host'), 
						Conf::get('database.user'), 
						Conf::get('database.pass'));
						
	$oDatabase->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	DataFactory::setConnection($oDatabase);
	
	View::setTemplateDirectory(Conf::get('general.dir.templates'));
	
	Lang::setDirectory(Conf::get('general.dir.lang'));
	
	Lang::setLang(Conf::get('general.default_lang'));

}
catch(Exception $e)
{
//	if (DEBUG) {
		test($e);
		exit;
//	} else {
//		Util::gotoPage(WWW_URL.'/oeps.php');
//	}
}


