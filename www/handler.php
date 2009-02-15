<?php

include_once('main.inc.php');

try
{
	ServiceFacade::setProtocol(new RequestControllerProtocol());
	echo ServiceFacade::request($_REQUEST);
}
catch (Exception $e)
{
	// show 404 page or something
	Util::gotoPage(WWW_URL.'/oeps.php');
	//test($e);
}
?>