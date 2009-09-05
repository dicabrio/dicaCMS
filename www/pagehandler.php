<?php

include_once('main.inc.php');

ServiceFacade::setProtocol(new ViewPageProtocol());
echo ServiceFacade::request($_REQUEST);