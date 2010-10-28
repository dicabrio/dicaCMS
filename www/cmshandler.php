<?php

include_once('main.inc.php');

$serviceFacade = new ServiceFacade(new RequestControllerProtocol());
echo $serviceFacade->execute($_REQUEST);