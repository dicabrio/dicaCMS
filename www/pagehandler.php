<?php

include_once('main.inc.php');

$serviceFacade = new ServiceFacade(new ViewPageProtocol());
echo $serviceFacade->execute($_REQUEST);