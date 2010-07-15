<?php
/**
 * install script
 *
 *
 *	@TODO: url configuration
 *	@TODO: database configuration
 *	@TODO: add initial pages (index and 404?)
 */

exit;
 
include('main.inc.php');

//echo Conf::get('upload.dir.templates');

$prereq = array();


if (!is_dir(Conf::get('upload.dir.templates'))) {
	$prereq[] = 'Templates directory '.Conf::get('upload.dir.templates').' does not exist';
	
	
} else {
	if (!is_writeable(Conf::get('upload.dir.templates'))) {
		$prereq[] = 'Templates directory '.Conf::get('upload.dir.templates').' is not writeable';
	}
}

$oDatabase->beginTransaction();
$sqldump = file_get_contents('../structuredump.sql');
$oDatabase->exec($sqldump);

$oUser = new User();
$oUser->setUsername(new Username('dicabrio'));
$oUser->setPassword(new Password('111111'));
$oUser->setActive(true);
$oUser->save();

$oDatabase->commit();

if (count($prereq) > 0) {
	test($prereq);
	exit;
}
