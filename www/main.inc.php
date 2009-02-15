<?php
/*
 * Created on 26 apr 2008
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

include_once('../etc/config.inc.php');

// some action may only be done by post like updating or
// ordering
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$_REQUEST['REQUEST_METHOD'] = 'POST';
} else {
	$_REQUEST['REQUEST_METHOD'] = 'GET';
}


try
{
	$dbh = new PDO(DB_TYPE.':dbname='.DB_NAME.';host='.DB_HOST, DB_USER, DB_PASS);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	DataFactory::setConnection($dbh);
	Template::setTemplateDirectory(TEMPLATES_DIR);
	View::setTemplateDirectory(TEMPLATES_DIR);
	Lang::setDirectory(LANG_DIR);
	Lang::setLang(LANG);

}
catch(Exception $e)
{
	if (DEBUG) {
		test($e);
	} else {
		Util::gotoPage(WWW_URL.'/oeps.php');
	}
}


?>
