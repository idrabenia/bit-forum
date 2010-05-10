<?php

/**
 * File contain all utilities of project.
 * @author Ilya Drobenya
 */

require_once('config.php');


define('MAIN_PAGE', '/bit-forum/view_forums.php');

/**
 * Create connection to database.
 * @return database connection
 * @author Ilya Drobenya
 */
function connect_to_database() {
    $connection = mysql_connect(DB_PATH, DB_USER, 
        DB_PASSWORD) or die('Could not connect to database');
    mysql_select_db(DB_NAME, $connection) 
        or die('Could not select database');
    return $connection;
}
$db_link = connect_to_database(); 
mysql_query("SET NAMES 'utf8'", $db_link);

/** Show errors if necessary */
if (DEBUG === TRUE) { 
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);
} 
else {
    ini_set('display_errors', 'Off');
    error_reporting(0);
} // if


?>