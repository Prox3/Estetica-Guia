<?php
/**
 * GeoTheme-to-the-Max functions and definitions
 *
 **/
$mr_shortname='mr2max';

// Next section, within if block, is for testing only.
//if ($mr2max_debug || $mr2max_debug=('69.131.197.208' == $_SERVER['REMOTE_ADDR']) ) {
//}//if debugging/IP

foreach (glob(dirname( __FILE__ )."/inc/*.php") as $filename)
{
    include $filename;
}
?>