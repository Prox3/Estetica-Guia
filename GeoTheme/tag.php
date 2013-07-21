<?php
global $wp_query, $post;
$child_dir =  get_stylesheet_directory();
$child_fn_dir = get_stylesheet_directory() . '/library/functions/';
if (file_exists($child_dir.'/child.txt')) {
    $ct_on=1;
} else{$ct_on=0;}
if($ct_on && file_exists($child_dir.'/library/includes/blog_listing.php')){include_once ($child_dir. '/library/includes/blog_listing.php');}
else{require_once (TEMPLATEPATH . '/library/includes/blog_listing.php');}
?>