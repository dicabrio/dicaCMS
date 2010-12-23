<?php
/**
 * 
 * SETUP SCRIPT
 *  
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

// define the system directory
define('SYS_DIR', realpath('../'));

// application directory
define('APP_DIR', SYS_DIR.'/application');

// currentfile
define('CURRENT_FILE', str_replace(dirname(__FILE__).'/', '', $_SERVER['SCRIPT_FILENAME']));

// define the www directory. This could be different on every machine
define('WWW_DIR', realpath('.'));

// define lib_dir
define('LIB_DIR', SYS_DIR.'/lib');

// configuration directory
define('CONFIG_DIR', APP_DIR.'/etc');

// domain
define('DOMAIN', $_SERVER['HTTP_HOST']);

// set include path for util
//ini_set('include_path', ini_get('include_path').':'.LIB_DIR.'/util:');

// include the main config
require(CONFIG_DIR.'/config.inc.php');

// include the main functions
require(LIB_DIR.'/util/functions.inc.php');

// utility
require(LIB_DIR.'/util/util.class.php');

// set a custom error handler
set_error_handler('__errorHandler', E_ALL);

// set a custom exception handler
set_exception_handler('__exceptionHandler');

// import modules
Util::import(LIB_DIR.'/blabla');// HACK
Util::import(LIB_DIR.'/controller');
Util::import(LIB_DIR.'/presentation');
Util::import(LIB_DIR.'/data');
Util::import(LIB_DIR.'/util');
Util::import(LIB_DIR.'/service');

// import lib modules
Util::importModules(LIB_DIR.'/modules');

// import application modules
Util::importModules(APP_DIR.'/modules');

// Set the Domain this is needed in order to determine the
// correct configuration directory
Conf::setServer(DOMAIN);
Conf::setDirectory(CONFIG_DIR);

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
