<?php
/**
 * File contain functions for processing templates. 
 */


/**
 * Function replace holders in template
 * @param $tpl template
 * @param $holders_map map of holders and its values
 * @return None
 */
function replace_holders(&$tpl, $holders_map) {
    foreach ($holders_map as $holder => $value) {
        $tpl = str_replace($holder, $value, $tpl);
    }
} // replace_holders


/**
 * Function parse files and return templates
 * as array
 * @param path to file with template
 * @param regexp of template. 
 * Ex. "/{(LINK)}(.*){EOT}/Us" 1st mask - key, 
 * 2nd - value.
 * @return array of templates (template_name 
 * => template)
 */
function get_templates($file_path, $tpl_regexps) {
    // load templates
    $tpl_file = file_get_contents($file_path);
    
    $templates = array();
    foreach ($tpl_regexps as $regexp) {
        preg_match($regexp, $tpl_file, $result);
        $templates[ $result[1] ] = $result[2];
    }
    
    return $templates;
} // search_users

?>