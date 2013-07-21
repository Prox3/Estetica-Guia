<?php
global $wpdb;
$child_dir =  get_stylesheet_directory();
$child_fn_dir = get_stylesheet_directory() . '/library/functions/';
if (file_exists($child_dir.'/child.txt')) {
    $ct_on=1;
} else{$ct_on=0;}

if(isset($_POST['sendact']) && $_POST['sendact']=='send_inqury')
{
	if($ct_on && file_exists($child_dir.'/library/includes/send_inquiry_frm.php')){include_once ($child_dir. '/library/includes/send_inquiry_frm.php');}
else{require_once (TEMPLATEPATH . '/library/includes/send_inquiry_frm.php');exit;}	
}elseif(isset($_POST['sendact']) && $_POST['sendact']=='email_frnd')
{
	if($ct_on && file_exists($child_dir.'/library/includes/email_friend_frm.php')){include_once ($child_dir. '/library/includes/email_friend_frm.php');}
else{require_once (TEMPLATEPATH . '/library/includes/email_friend_frm.php');exit;}
}
elseif(isset($_POST['sendact']) && $_POST['sendact']=='claim_listing')
{
	if($ct_on && file_exists($child_dir.'/library/includes/claim_listing_frm.php')){include_once ($child_dir. '/library/includes/claim_listing_frm.php');}
else{require_once (TEMPLATEPATH . '/library/includes/claim_listing_frm.php');exit;}
}
global $wp_query, $post;
$cat_array = array();
$blog_cat = array();
$blog_cat = get_option('ptthemes_blogcategory');
$blog_cat = get_blog_sub_cats_str($type='array');
/*$cagInfo = get_the_category();
foreach($cagInfo as $cagInfo_obj)
{
	$cat_array[] = $cagInfo_obj->term_id;
}*/
if($post->post_type=='event')
{
	$is_event_post = 1;
	if($ct_on && file_exists($child_dir.'/library/includes/event_detail.php')){include_once ($child_dir. '/library/includes/event_detail.php');}
else{require_once (TEMPLATEPATH . '/library/includes/event_detail.php');}
}else
{
	if($post->post_type=='post') //blog detail
	{
		$is_blog_post = 1;
		if($ct_on && file_exists($child_dir.'/library/includes/blog_detail.php')){include_once ($child_dir. '/library/includes/blog_detail.php');}
else{require_once (TEMPLATEPATH . '/library/includes/blog_detail.php');}
	}elseif($post->post_type=='place')
	{
		$is_place_post = 1;
		if($ct_on && file_exists($child_dir.'/library/includes/place_detail.php')){include_once ($child_dir. '/library/includes/place_detail.php');}
else{require_once (TEMPLATEPATH . '/library/includes/place_detail.php');}
	}
	else
	{
		if($ct_on && file_exists($child_dir.'/page.php')){include_once ($child_dir. '/page.php');}
else{require_once (TEMPLATEPATH . '/page.php');}
	}
}
?>