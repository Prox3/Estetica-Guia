<?php
global $wp_query, $post;
$child_dir =  get_stylesheet_directory();
$child_fn_dir = get_stylesheet_directory() . '/library/functions/';
if (file_exists($child_dir.'/child.txt')) {
    $ct_on=1;
} else{$ct_on=0;}
$current_term = $wp_query->get_queried_object();
//$blog_cat = get_blog_sub_cats_str($type='array');
if($current_term->taxonomy=='eventcategory')
{
	if($ct_on && file_exists($child_dir.'/library/includes/event_listing.php')){include_once ($child_dir. '/library/includes/event_listing.php');}
else{require_once (TEMPLATEPATH . '/library/includes/event_listing.php');}
}
elseif($current_term->taxonomy=='event_tags')
{
	if($ct_on && file_exists($child_dir.'/library/includes/event_listing.php')){include_once ($child_dir. '/library/includes/event_listing.php');}
else{require_once (TEMPLATEPATH . '/library/includes/event_listing.php');}
}elseif($current_term->taxonomy=='category' || is_day() || is_month() || is_year()) //blog category
{
	if($ct_on && file_exists($child_dir.'/library/includes/blog_listing.php')){include_once ($child_dir. '/library/includes/blog_listing.php');}
else{require_once (TEMPLATEPATH . '/library/includes/blog_listing.php');}
}elseif($current_term->taxonomy=='placecategory')
{
	if($ct_on && file_exists($child_dir.'/library/includes/place_listing.php')){include_once ($child_dir. '/library/includes/place_listing.php');}
else{require_once (TEMPLATEPATH . '/library/includes/place_listing.php');}
}
else{
	if($ct_on && file_exists($child_dir.'/library/includes/place_listing.php')){include_once ($child_dir. '/library/includes/place_listing.php');}
else{require_once (TEMPLATEPATH . '/library/includes/place_listing.php');}
}
?>
