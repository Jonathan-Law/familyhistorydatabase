<?php
	
	/* /////////////////////////////////////////////////////////////////////////
		        		    Core Paths for Website
	///////////////////////////////////////////////////////////////////////// */
	
	// Core Paths - Server Root - For PHP
	defined('DS') ? null : define('DS', "/");//define('DS',DIRECTORY_SEPARATOR); // The Directory Separator
	defined('ROOT') ? null : define('ROOT', $_SERVER['DOCUMENT_ROOT'].DS); // Public Site Root
	defined('URL') ? null : define('URL', 'http://'.$_SERVER['SERVER_NAME'].DS); // The Root URL
	// Core Relative Paths 
   defined('INCLUDES') ? null : define('INCLUDES', ROOT.'includes'.DS); // Includes Folder
   defined('WINDOWS') ? null : define('WINDOWS', ROOT.'windows'.DS); // Includes Folder
	defined('PAGE') ? null : define('PAGE', ROOT.'pages'.DS); // Modules Folder
   defined('UPLOAD') ? null : define('UPLOAD', 'upload'.DS); // Includes Folder
   defined('LIBRARY') ? null : define('LIBRARY', INCLUDES.'library'.DS); // Library Folder
   defined('MODULES') ? null : define('MODULES', INCLUDES.'modules'.DS); // Modules Folder
   defined('CLASSES') ? null : define('CLASSES', INCLUDES.'classes'.DS); // Classes Folder
   defined('OBJECTS') ? null : define('OBJECTS', CLASSES.'objects'.DS); // Classes Folder
	defined('TOOLS') ? null : define('TOOLS', CLASSES.'tools'.DS); // Classes Folder

	defined('CONTROLLER') ? null : define('CONTROLLER', INCLUDES.'controller'.DS); // Controller Folder
	defined('LOGS') ? null : define('LOGS', INCLUDES.'logs'.DS); // Logs Folder
	
?>