<?php

include_once('main.inc.php');

ServiceFacade::setProtocol(new RequestControllerProtocol());
echo ServiceFacade::request($_REQUEST);