<?php
/*
 * Created on 12 dec 2007
 * File config.inc.php
 * Project CMSje
 * User Robert Cabri <robert@dicabrio.com>
 */

define('DEBUG', true);

define('DOMAIN', $_SERVER['HTTP_HOST']);

define('CONFIG_DIR', SYS_DIR.'/etc');

// comment
define('LANG', 'NL');

error_reporting(E_ALL);
ini_set('display_errors', 1);

