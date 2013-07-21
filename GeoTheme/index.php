<?php
/*
Template Name: Home Page
*/
?>
<?php
############################################
######## ESSENTIAL CORE HEAD START #########
############################################
$child_dir =  get_stylesheet_directory();
$child_fn_dir = get_stylesheet_directory() . '/library/functions/';
if (file_exists($child_dir.'/child.txt')) {
    $ct_on=1;
} else{$ct_on=0;}

if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] != '')
{	
	if($ct_on && file_exists($child_dir.'/ajax_queries.php')){
	include_once($child_dir.'/ajax_queries.php');exit;}
	else{include_once(TEMPLATEPATH.'/ajax_queries.php');exit;}
}else
if(isset($_REQUEST['export']) && $_REQUEST['export'] != '')
{
	include_once(TEMPLATEPATH.'/export.php');exit;
}else
if(isset($_REQUEST['pay_mobile']) && $_REQUEST['pay_mobile'] != '')
{
	include_once(TEMPLATEPATH.'/app/paypal_mobile_response.php');exit;
}else
if(isset($_REQUEST['api']) && $_REQUEST['api'] != '')
{
	include_once(TEMPLATEPATH.'/app/api_get_markers.php');exit;
}else
if(isset($_REQUEST['api_submit']) && $_REQUEST['api_submit'] != '')
{
	include_once(TEMPLATEPATH.'/app/api_submit.php');exit;
}else
if(isset($_REQUEST['ptype']) && $_REQUEST['ptype'] == 'get_markers')
{
	if($ct_on && file_exists($child_dir.'/library/map/get_markers.php')){include_once($child_dir.'/library/map/get_markers.php');exit;}
	else{include_once (TEMPLATEPATH . '/library/map/get_markers.php');exit;}
}else
if(isset($_REQUEST['ptype']) && $_REQUEST['ptype'] == 'ga')
{
	if($ct_on && file_exists($child_dir.'/library/includes/google_analytics.php')){include_once ($child_dir.'/library/includes/google_analytics.php');}
else{include_once (TEMPLATEPATH . '/library/includes/google_analytics.php');}exit;
}else
if(isset($_REQUEST['ptype']) && $_REQUEST['ptype'] == 'calendar')
{
	if($ct_on && file_exists($child_dir.'/library/calendar/calendar.php')){include_once ($child_dir.'/library/calendar/calendar.php');}
else{include_once (TEMPLATEPATH . '/library/calendar/calendar.php');}exit;
}else
if(isset($_REQUEST['ptype']) && $_REQUEST['ptype'] == 'favorite')
{
	if(isset($_REQUEST['action']) && $_REQUEST['action']=='add')
	{
		add_to_favorite($_REQUEST['pid']);
	}else{
		remove_from_favorite($_REQUEST['pid']);
	}
}else
if(isset($_REQUEST['ptype']) && $_REQUEST['ptype']=='profile')
{
	global $current_user;
	if(!$current_user->data->ID)
	{
		wp_redirect(home_url().'/?ptype=login');
		exit;
	}
	if($ct_on && file_exists($child_dir.'/library/includes/profile.php')){include_once ($child_dir.'/library/includes/profile.php');}
else{include_once (TEMPLATEPATH . '/library/includes/profile.php');}exit;
}elseif(isset($_REQUEST['ptype']) && $_REQUEST['ptype'] == 'phpinfo')
{    echo 'Access Denied!'; // Added by Stiofan
	//echo phpinfo();exit; // removed by Stiofan hebtech.co.uk ### Not a security risk by it's self but a window in to your server for the baddies ###
}elseif(isset($_REQUEST['ptype']) && $_REQUEST['ptype'] == 'csvdl')
{
	if($ct_on && file_exists($child_dir."/library/includes/csvdl.php")){include_once ($child_dir."/library/includes/csvdl.php");}
else{include_once (TEMPLATEPATH . "/library/includes/csvdl.php");}
}
elseif(isset($_REQUEST['ptype']) && ($_REQUEST['ptype'] == 'register' || $_REQUEST['ptype'] == 'login'))
{
	if($ct_on && file_exists($child_dir."/library/includes/registration.php")){include_once ($child_dir."/library/includes/registration.php");}
else{include_once (TEMPLATEPATH . "/library/includes/registration.php");}
}
elseif(isset($_REQUEST['ptype']) && $_REQUEST['ptype'] == 'verify')
{
	if($ct_on && file_exists($child_dir."/library/includes/claim_listing_verify.php")){include_once ($child_dir."/library/includes/claim_listing_verify.php");}
else{include_once (TEMPLATEPATH . "/library/includes/claim_listing_verify.php");}
}
elseif(isset($_REQUEST['ptype']) && $_REQUEST['ptype']=='post_listing' && $_REQUEST['pid']){
	$id = $_REQUEST['pid'];
			if(get_edit_post_link($id)){
				if($ct_on && file_exists($child_dir.'/submit_place.php')){include_once ($child_dir.'/submit_place.php');}
else{include_once (TEMPLATEPATH . '/submit_place.php');}exit;
			}else echo 'Access Denied!';
}elseif(isset($_REQUEST['ptype']) && $_REQUEST['ptype']=='post_listing')
{
	if($_REQUEST['ptype']=='post_listing' && get_option('is_user_addevent')=='0'){wp_redirect(home_url());exit;}
if($ct_on && file_exists($child_dir.'/submit_place.php')){include_once ($child_dir.'/submit_place.php');}
else{include_once (TEMPLATEPATH . '/submit_place.php');}exit;
}elseif(isset($_REQUEST['ptype']) && $_REQUEST['ptype']=='post_event')
{
	if($_REQUEST['ptype']=='post_event' && get_option('is_user_eventlist')=='0' && $_REQUEST['pid']==''){wp_redirect(home_url());exit;}
	if($ct_on && file_exists($child_dir.'/submit_event.php')){include_once ($child_dir.'/submit_event.php');}
else{include_once (TEMPLATEPATH . '/submit_event.php');}exit;
}
elseif(isset($_REQUEST['ptype']) && $_REQUEST['ptype'] == 'preview')
{	
	if($_REQUEST['pid']) //SECURITY FIX BY STIOFAN HEBTECH.CO.UK - CHECK IF USER HAS PERMISION TO VIEW DELETE LISTING PAGE
		{
			$id = $_REQUEST['pid'];
			if(get_edit_post_link($id)){
				if($ct_on && file_exists($child_dir."/library/includes/preview.php")){include_once ($child_dir."/library/includes/preview.php");}
else{include_once (TEMPLATEPATH . "/library/includes/preview.php");}
			}elseif($_REQUEST['alook']){
		if($ct_on && file_exists($child_dir."/library/includes/preview.php")){include_once ($child_dir."/library/includes/preview.php");}
else{include_once (TEMPLATEPATH . "/library/includes/preview.php");}
		}	
			else echo 'Access Denied!';
		
		}else {if($ct_on && file_exists($child_dir."/library/includes/preview.php")){include_once ($child_dir."/library/includes/preview.php");}
else{include_once (TEMPLATEPATH . "/library/includes/preview.php");}}
}
elseif(isset($_REQUEST['ptype']) && $_REQUEST['ptype'] == 'preview_event')
{	
	if($_REQUEST['pid']) //SECURITY FIX BY STIOFAN HEBTECH.CO.UK - CHECK IF USER HAS PERMISION TO VIEW DELETE LISTING PAGE
		{
			$id = $_REQUEST['pid'];
			if(get_edit_post_link($id)){
				if($ct_on && file_exists($child_dir."/library/includes/preview_event.php")){include_once ($child_dir."/library/includes/preview_event.php");}
else{include_once (TEMPLATEPATH . "/library/includes/preview_event.php");}
			}elseif($_REQUEST['alook']){if($ct_on && file_exists($child_dir."/library/includes/preview_event.php")){include_once ($child_dir."/library/includes/preview_event.php");}
else{include_once (TEMPLATEPATH . "/library/includes/preview_event.php");}}
				
			else echo 'Access Denied!';
		
		}else {if($ct_on && file_exists($child_dir."/library/includes/preview_event.php")){include_once ($child_dir."/library/includes/preview_event.php");}
else{include_once (TEMPLATEPATH . "/library/includes/preview_event.php");}}
}
elseif(isset($_REQUEST['ptype']) && $_REQUEST['ptype'] == 'paynow')
{
	if($ct_on && file_exists($child_dir."/library/includes/paynow.php")){include_once ($child_dir."/library/includes/paynow.php");}
else{include_once (TEMPLATEPATH . "/library/includes/paynow.php");}
}elseif(isset($_REQUEST['ptype']) && $_REQUEST['ptype'] == 'paynow_event')
{
	if($ct_on && file_exists($child_dir."/library/includes/paynow_event.php")){include_once ($child_dir."/library/includes/paynow_event.php");}
else{include_once (TEMPLATEPATH . "/library/includes/paynow_event.php");}
}
elseif(isset($_REQUEST['ptype']) && $_REQUEST['ptype'] == 'cancel_return')
{
	if($ct_on && file_exists($child_dir.'/library/includes/cancel.php')){include_once ($child_dir.'/library/includes/cancel.php');}
else{include_once (TEMPLATEPATH . '/library/includes/cancel.php');}
	exit;
}
elseif(isset($_GET['ptype']) && ($_GET['ptype'] == 'return' || $_GET['ptype'] == 'payment_success'))  // PAYMENT GATEWAY RETURN
{
	if($ct_on && file_exists($child_dir.'/library/includes/return.php')){include_once ($child_dir.'/library/includes/return.php');}
else{include_once (TEMPLATEPATH . '/library/includes/return.php');}
	exit;
}
elseif(isset($_GET['ptype']) && $_GET['ptype'] == 'success')  // PAYMENT GATEWAY RETURN
{
	if($ct_on && file_exists($child_dir.'/library/includes/success.php')){include_once ($child_dir.'/library/includes/success.php');}
else{include_once (TEMPLATEPATH . '/library/includes/success.php');}
	exit;
}
elseif(isset($_GET['ptype']) && $_GET['ptype'] == 'notifyurl')  // PAYMENT GATEWAY NOTIFY URL
{
	if(isset($_GET['pmethod']) && $_GET['pmethod'] == 'paypal')
	{
		if($ct_on && file_exists($child_dir.'/library/includes/ipn_process.php')){include_once ($child_dir.'/library/includes/ipn_process.php');}
else{include_once (TEMPLATEPATH . '/library/includes/ipn_process.php');}
	}elseif(isset($_GET['pmethod']) && $_GET['pmethod'] == '2co')
	{
		if($ct_on && file_exists($child_dir.'/library/includes/ipn_process_2co.php')){include_once ($child_dir.'/library/includes/ipn_process_2co.php');}
else{include_once (TEMPLATEPATH . '/library/includes/ipn_process_2co.php');}
	}
	exit;
}
elseif(isset($_REQUEST['ptype']) && $_REQUEST['ptype'] == 'sort_image')
{
	global $wpdb;
	//echo $_REQUEST['pid'];
	$arr_pid = explode(',',$_REQUEST['pid']);
	for($j=0;$j<count($arr_pid);$j++)
	{
		$media_id = $arr_pid[$j];
		if(strstr($media_id,'div_'))
		{
			$media_id = str_replace('div_','',$arr_pid[$j]);
		}
		$wpdb->query('update '.$wpdb->posts.' set  menu_order = "'.$j.'" where ID = "'.$media_id.'" ');
	}
	echo 'Image order saved successfully';
}
elseif(isset($_REQUEST['ptype']) && $_REQUEST['ptype'] == 'delete')
{
	global $current_user;
	if($_REQUEST['pid']) //SECURITY FIX BY STIOFAN HEBTECH.CO.UK - CHECK IF USER HAS PERMISION TO DELETE LISTING 
	{$pid = $_REQUEST['pid'];  
	if(get_edit_post_link($pid)){
		wp_delete_post($_REQUEST['pid']);
		wp_redirect(get_author_link($echo = false, $current_user->data->ID));
	}else echo 'Access Denied!'; // Added by Stiofan
}	else echo 'Access Denied!'; // Added by Stiofan
}
elseif(isset($_REQUEST['ptype']) && $_REQUEST['ptype'] == 'att_delete')
{	
    if($_REQUEST['remove'] == 'temp')
	{

		if($_SESSION["file_info"])
		{
			$tmp_file_info = array();
			foreach($_SESSION["file_info"] as $image_id=>$val)
			{
				    if($image_id == $_REQUEST['pid'])
					{
						@unlink(ABSPATH."/".$upload_folder_path."tmp/".$_REQUEST['pid'].".jpg");
					}else{	
						$tmp_file_info[$image_id] = $val;
					}
					
			}
			$_SESSION["file_info"] = $tmp_file_info;
		}
		
		
	}else{	global $current_user;
	if(get_edit_post_link($_REQUEST['pid'])){
			wp_delete_attachment($_REQUEST['pid']);	
			}else echo 'Access Denied!'; // Added by Stiofan
	}	
}
else
{ 
############################################
######## ESSENTIAL CORE HEAD STOP ##########
############################################
get_header();?>
<?php dynamic_sidebar(1);?>
<div id="wrapper" class="clearfix">
<div id="content" class="clearfix">
<?php dynamic_sidebar(2);  ?>  
</div> <!-- content #end -->
<div id="sidebar">
<?php dynamic_sidebar(3);  ?>  
</div> <!-- sidebar #end -->  
<?php  get_footer(); ?>
<?php }?>