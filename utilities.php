<?php

/**
 * File contain all utilities of project.
 * @author Ilya Drobenya
 */


/**
 * Create connection to database.
 * @return Database connection
 * @author Ilya Drobenya
 */
function connect_to_database() {
    $connection = mysql_connect(DB_PATH, DB_USER, 
        DB_PASSWORD) or die('Could not connect to database');
    mysql_select_db(DB_NAME, $connection) 
        or die('Could not select database');
    return $connection;
}


?>