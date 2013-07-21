<?php
session_start();
global $upload_folder_path,$wpdb,$child_dir,$child_fn_dir,$ct_on;
if($_POST)
{
$_SESSION['file_info'] = $_POST["file_info"];
// Record time took on submit page n seconds
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$submit_time = round(($finish - $_SESSION['submit_start']), 4);
$_POST['submit_time'] = $submit_time;
$_POST['submit_ip'] = $_SERVER['REMOTE_ADDR'];
// Record time took on submit page n seconds


	$proprty_name = stripslashes($_POST['proprty_name']);
	$address = stripslashes($_POST['address']);
	$geo_latitude = $_POST['geo_latitude'];
	$geo_longitude = $_POST['geo_longitude'];
	$claimed = $_POST['claimed'];
	$map_view = $_POST['map_view'];
	$timing = $_POST['timing'];
	$contact = stripslashes($_POST['contact']);
	$email = $_POST['email'];
	$website = $_POST['website'];
	$twitter = $_POST['twitter'];
	$facebook = $_POST['facebook'];
	$a_businesses = $_POST['a_businesses'];
	$post_city_id = $_POST['post_city_id'];
	$package_pid = $_POST['package_pid'];
	$video = $_POST['video'];
	
	$stdate = $_POST['stdate'];
	$sttime = $_POST['sttime'];
	$enddate = $_POST['enddate'];
	$endtime = $_POST['endtime'];
	$recurring = $_POST['recurring'];
	$kw_tags = $_POST['kw_tags'];
	$reg_desc = stripslashes($_POST['reg_desc']);
	$reg_fees = $_POST['reg_fees'];
	
	$proprty_desc = stripslashes($_POST['proprty_desc']);
	$proprty_feature = stripslashes($_POST['proprty_feature']);
		
	$_SESSION['property_info'] = $_POST;
	if($_POST['user_email'] && $_FILES['user_photo']['name'])
	{
		$src = $_FILES['user_photo']['tmp_name'];
		$dest_path = get_image_phy_destination_path_user().date('Ymdhis')."_".$_FILES['user_photo']['name'];
		$user_photo = image_resize_custom($src,$dest_path,150,150);        
        $photo_path = get_image_rel_destination_path_user().$user_photo['file'];
		$_SESSION['property_info']['user_photo'] = $photo_path;
	}
}else
{

	$catid_info_arr = get_property_cat_id_name($_REQUEST['pid']);
	$post_info = get_post_info($_REQUEST['pid']);
	$proprty_name = stripslashes($post_info['post_title']);
	$proprty_desc = stripslashes($post_info['post_content']);
	$proprty_feature = stripslashes($post_info['proprty_feature']);	
	$post_meta = get_post_meta($_REQUEST['pid'], '',false);
	$address = stripslashes($post_meta['address'][0]);
	$geo_latitude = $post_meta['geo_latitude'][0];
	$geo_longitude = $post_meta['geo_longitude'][0];
	$claimed = $post_meta['claimed'][0];
	$map_view = $post_meta['map_view'][0];
	$timing = $post_meta['timing'][0];
	$contact = $post_meta['contact'][0];
	$email = $post_meta['email'][0];
	$website = $post_meta['website'][0];
	$twitter = $post_meta['twitter'][0];
	$facebook = $post_meta['facebook'][0];
	$a_businesses = $post_meta['a_businesses'][0];
	$post_city_id = $post_meta['post_city_id'][0];
	$kw_tags = $post_meta['kw_tags'][0];
	$package_pid = $post_meta['package_pid'][0];
	$video = $post_meta['video'][0];
	
	$stdate = $post_meta['st_date'][0];
	$sttime = $post_meta['st_time'][0];
	$enddate = $post_meta['end_date'][0];
	$endtime = $post_meta['end_time'][0];
	$recurring = $post_meta['recurring'][0];
	$reg_desc = stripslashes($post_meta['reg_desc'][0]);
	$reg_fees = $post_meta['reg_fees'][0];
	if($_REQUEST['pid'])
	{
		$is_delet_property = 1;
	}
}
global $upload_folder_path;
if(isset($_POST["file_info"]))
{ 
	$tmpimgArr = explode(",", $_POST["file_info"]);
	foreach($tmpimgArr as $image)
	{		 
		 $image_src[] =  $image;
	}
}else
{
	$image_src = $thumb_img_arr[0];
	if($_REQUEST['pid']){
	$large_img_arr = bdw_get_images($_REQUEST['pid'],'large');
	$thumb_img_arr = bdw_get_images($_REQUEST['pid'],'thumb');
	}
	$image_src = $large_img_arr[0];
}
if($_REQUEST['pid'])
{
	$large_img_arr = bdw_get_images($_REQUEST['pid'],'large');
	$thumb_img_arr = bdw_get_images($_REQUEST['pid'],'thumb');
}

############ USER REG AND LOGIN CHECK ################
if(!is_allow_user_register() && $current_user->ID=='0')
{
wp_redirect(home_url().'/?ptype=post_event&backandedit=1&emsg=captch&pkg='.$_SESSION['property_info']['price_select']);
exit;
}

############ USER REG AND LOGIN CHECK ################

if(function_exists('pt_check_captch_cond') && $_REQUEST['pid']==''){
if(!pt_check_captch_cond())
{
wp_redirect(home_url().'/?ptype=post_event&backandedit=1&emsg=captch&pkg='.$_SESSION['property_info']['price_select']);
exit;
}
}
?>
<?php get_header(); ?>
<?php include (TEMPLATEPATH . "/library/includes/preview_buttons_event.php");?>
<?php if($_REQUEST['ptype']=='preview_event'){$preview=1;} ?>
<?php if($ct_on && file_exists($child_dir.'/library/includes/event_detail.php')){include_once ($child_dir. '/library/includes/event_detail.php');}
else{require_once (TEMPLATEPATH . '/library/includes/event_detail.php');}?>