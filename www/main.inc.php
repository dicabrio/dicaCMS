<?php
/**
 * 
 * SETUP SCRIPT
 *  
 */


// define the system directory
define('SYS_DIR', realpath('../'));

// currentfile
define('CURRENT_FILE', str_replace(dirname(__FILE__).'/', '', $_SERVER['SCRIPT_FILENAME']));

// define the www directory. This could be different on every machine
define('WWW_DIR', realpath('.'));

// define sys_dir
define('SYS_DIR', realpath('../'));

// define lib_dir
define('LIB_DIR', SYS_DIR.'/lib');

// set include path for util
ini_set('include_path', ini_get('include_path').':'.LIB_DIR.'/util:');

// include the main config
require(SYS_DIR.'/etc/config.inc.php');

// include the main functions
require('functions.inc.php');

// set a custom error handler
set_error_handler('__errorHandler', E_ALL);

// set a custom exception handler
set_exception_handler('__exceptionHandler');

// import modules
Util::import(LIB_DIR.'/controller');
Util::import(LIB_DIR.'/gui');
Util::import(LIB_DIR.'/data');
Util::import(LIB_DIR.'/data/util');
Util::import(LIB_DIR.'/service');

Util::importModules(LIB_DIR.'/modules');

// Set the Domain this is needed in order to determine the
// correct configuration directory
Conf::setServer(DOMAIN);
Conf::setDirectory(CONFIG_DIR);

// Set templates dir.
// Change if you like in the config file
View::setTemplateDirectory(Conf::get('general.dir.templates'));

// Set lang dir. 
// Change if you like in the config file
Lang::setDirectory(Conf::get('general.dir.lang'));
Lang::setLang(Conf::get('general.default_lang'));

// Only load when DB is needed?
// so call when a DB is asked. The Datafactory should lookup the right database
// Load the DB
$oDatabase = new PDO(Conf::get('database.dbtype').':dbname='.Conf::get('database.dbname').';host='.Conf::get('database.dbhost'), 
					Conf::get('database.dbuser'), 
					Conf::get('database.dbpass'));
					
$oDataFactory = DataFactory::getInstance();
$oDataFactory->addConnection($oDatabase, DataFactory::C_DEFAULT_DB);

// language settings
setlocale(LC_ALL, Conf::get('locale.language'));

// set timezone settings
date_default_timezone_set(Conf::get('locale.timezone'));

