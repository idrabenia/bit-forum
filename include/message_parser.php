<?php

require_once("config.php");


/**
 * Function parse bbcodes and insert corresponding
 * tags, smiles, images and urls.
 * Ex. Input:  Hello, [b]Joe[/b]!
 *     Result: Hello, <b>Joe</b>!
 * @param message User message with bbcodes
 * @return User message in HTML
 */
function user_message_to_html($message) {
    // make string from user safe
    $message = trim($message);
    $message = htmlspecialchars($message);

    // insert new line tag
    $result_message = preg_replace("/(\r\n|[\r\n])/X",
        '<br />', $message);

    // process bbcodes
    $result_message = replace_bbcodes( $result_message );

    // process smiles
    $result_message = insert_smilies( $result_message );

    return $result_message;
} // parse_user_message


/**
 * Function convert all unsafe characters (deactivate tags)
 * to safe html-visible analogs.
 * Ex. Input:  <a>
 *     Result: &lt; a &gt;
 * @param message unsafe message
 * @return Safe string
 */
function make_safe_message($message) {
    $message = trim( $message );
    return htmlspecialchars($message);
} // make_safe_message


/**
 * Function for replace bbcodes to html tags
 * @return Modified string
 */
function replace_bbcodes($message) {
    // describe bbcodes
    $bbcodes = array(
        array(
            'pattern' => "/(\[b\])(.*)(\[\/b\])/XU",
            'replacement' => "<b>$2</b>"
        ),
        array(
            'pattern' => "/(\[i\])(.*)(\[\/i\])/XU",
            'replacement' => "<i>$2</i>"
        ),
        array(
            'pattern' => "/(\[img\])(.*)(\[\/img\])/XU",
            'replacement' => "<img src=\"$2\" />"
        ),
        array(
            'pattern' => "/(\[url\])(.*)(\[\/url\])/XU",
            'replacement' => "<a href=\"$2\">$2</a>"
        ),
        array(
            'pattern' => "/(\[url=)(.*)(\])(.*)(\[\/url\])/XU",
            'replacement' => "<a href=\"$2\">$4</a>"
        )
    );

    // replace bbcodes
    foreach ($bbcodes as $cur_code) {
        do {
            $old_message = $message;
            $message = preg_replace($cur_code['pattern'],
                $cur_code['replacement'], $message);
        } while ($message !== $old_message);
    }
    return $message;
} // replace_bbcodes


/**
 * Function for replace smile alias to smile image reference.
 * @return modified string
 */
function insert_smilies($message) {
    // Fetch smilies data from database
    $db_connection = mysql_connect( DB_PATH, DB_USER, DB_PASSWORD )
        or die('Could not connect to database');

    mysql_select_db('bit_forum', $db_connection)
        or die('Could not select database');

    $smilies = mysql_query(
        "SELECT `smile_alias`, `smile_image_path` FROM `smilies`",
        $db_connection)
        or die('Could not fetch data from database');

    while ($cur_smile = mysql_fetch_array($smilies, MYSQL_ASSOC))
    {
        $image_path = $cur_smile['smile_image_path'];
        $message = str_replace( $cur_smile['smile_alias'],
            "<img src=\"$image_path\" />", $message );
    }

    return $message;
} // insert_smilies


?>
