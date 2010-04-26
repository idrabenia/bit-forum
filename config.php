<?php

/**
 * File contain application options and
 * settings.
 */

/** Database configuration */  
define('DB_USER', 'root');

define('DB_PASSWORD', '1');

define('DB_PATH', 'localhost:3306');

define('DB_NAME', 'bit_forum');

/** Path after host to application folder */
define('ROOT_PATH', '/');

/** Application configuration */
define('DEBUG', TRUE);

/** Global database connection */
$db_link = FALSE;

/** Path to main page template */
define('MAIN_TPL_PATH', './templates/main.tpl');

?>
