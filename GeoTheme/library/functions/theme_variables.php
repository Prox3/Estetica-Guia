<?php

$themename = "Geo Theme";
$shortname = "ptthemes";
$template = get_option('template');
$generaloptionsurl = "".trailingslashit( get_bloginfo('url') )."wp-admin/options-general.php";
$widgetsurl = "".trailingslashit( get_bloginfo('url') )."wp-admin/widgets.php";
$bloghomeurl = "".trailingslashit( get_bloginfo('url') )."";

  $functions_path = TEMPLATEPATH . '/library/functions/';
  $includes_path = TEMPLATEPATH . '/library/includes/';
  $javascript_path = TEMPLATEPATH . '/library/js/';
  $css_path = TEMPLATEPATH . '/library/css/';
  $claim_db_table_name = $table_prefix . "claim";
  $price_db_table_name = $table_prefix . "price";
  $moderation_db_table_name = $table_prefix . "gt_moderation";
 
  define("TTIMG_TW", "40");// Image size for tiny images
  define("TTIMG_TH", "40");
  
  define("TTIMG_SW", "95");// Image size for small images
  define("TTIMG_SH", "65");
  
  define("TTIMG_MW", "158");// Image size for medium images
  define("TTIMG_MH", "105");



?>