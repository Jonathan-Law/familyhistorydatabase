<?php

/**
* Core Paths for Website
**/
// Core Paths - Server Root - For PHP
defined('DS')         ? null : define('DS', '/');
defined('ROOT')       ? null : define('ROOT', $_SERVER['DOCUMENT_ROOT'].DS);
defined('APIROOT')    ? null : define('APIROOT', ROOT.'/v2/api'.DS);
defined('URL')        ? null : define('URL', 'http://'.$_SERVER['SERVER_NAME'].DS);
// Core Relative Paths
defined('LIBRARY')    ? null : define('LIBRARY', APIROOT.'library'.DS);
defined('CLASSES')    ? null : define('CLASSES', APIROOT.'classes'.DS);
defined('OBJECTS')    ? null : define('OBJECTS', CLASSES.'objects'.DS);
defined('TOOLS')      ? null : define('TOOLS', CLASSES.'tools'.DS);
?>
