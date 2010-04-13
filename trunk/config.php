<?php

/**
 * File contain application options and
 * settings.
 */

/** Database configuration */  
define('DB_USER', 'root');

define('DB_PASSWORD', '');

define('DB_PATH', 'localhost:3306');

define('DB_NAME', 'bit_forum');

/** Application configuration */
define('DEBUG', TRUE);

/* Show errors if necessary */
if (DEBUG === TRUE) { 
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);
} 
else {
	ini_set('display_errors', 'Off');
	error_reporting(0);
} // if

?>
