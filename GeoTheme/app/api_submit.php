<?php
session_start();
ob_start();
require_once(ABSPATH . WPINC . '/ms-functions.php');

if($_REQUEST['api_submit']=='capver'){
echo $_SESSION[get_captch_id()];exit;
}
############################################## AUTHENTICATE USER ####################################################################
/* gets the data from a URL */
function curl_get_data2($url) {
  $ch = curl_init();
  $timeout = 5;
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
  $data = curl_exec($ch);
  curl_close($ch);
  return $data;
}

$user = get_user_id_from_string($_REQUEST['user_name']);
if($user){
  // echo $user->ID;
   $current_user_id = $user; // set the user id
   $user_info = get_userdata($current_user_id); // get the users hashed password 
   $auth =  wp_check_password( $_REQUEST['user_pass'], $user_info->user_pass, $current_user_id); // check the users password is correct
   
  if($auth){}else{
$user_fb_pass = get_user_meta($current_user_id, 'app_facebook_pass', true);
if($user_fb_pass==$_REQUEST['user_pass']){
	$auth = true;
	}
}

// Check facebook token
if($auth){}else{
$access_token = $_REQUEST['access_token'];
if($access_token){
	$fbuser = json_decode(curl_get_data2("https://graph.facebook.com/me?access_token=".$access_token));
	if($fbuser->email==$_REQUEST['user_name']){$auth = true;}
	//$auth = true;
	}
}

if($auth){}else{$result = array('auth'=>false, 'msg'=>'Login Fail'); echo json_encode($result);exit;}
}else{$result = array('auth'=>false, 'msg'=>'Login Fail'); echo json_encode($result);exit;}
############################################## END AUTHENTICATE USER ####################################################################
############################################## ADD TO FAV ######################################################################
//?api_submit=add_fav&post_id=POST_ID&user_name=USERNAME&user_pass=PASSWORD
if($_REQUEST['api_submit']=='add_fav' && $auth){
global $wpdb;
$fav_post_id = mysql_real_escape_string($_REQUEST['post_id']);
$user_meta_data = array();
$user_meta_data = get_usermeta($user,'user_favourite_post');
$user_meta_data[]=$fav_post_id;
update_usermeta($user, 'user_favourite_post', $user_meta_data);
echo json_encode(array('add_fav'=>true, 'msg'=>ADDED_FAV));exit;
}elseif($_REQUEST['add_fav'] && !$auth){echo json_encode(array('add_fav'=>false, 'msg'=>'Login Fail'));exit;}
############################################## REMOVE FROM FAV ######################################################################
//?api_submit=remove_fav&post_id=POST_ID&user_name=USERNAME&user_pass=PASSWORD
if($_REQUEST['api_submit']=='remove_fav' && $auth){
global $wpdb;
$fav_post_id = mysql_real_escape_string($_REQUEST['post_id']);
$user_meta_data = array();
$user_meta_data = get_usermeta($user,'user_favourite_post');
if(in_array($fav_post_id,$user_meta_data))
{ $user_new_data = array();
	foreach($user_meta_data as $key => $value)
		{
			if($fav_post_id == $value)
			{
				$value= '';
			}else{
				$user_new_data[] = $value;
			}
		}
		
		$user_meta_data	= $user_new_data;
}
update_usermeta($user, 'user_favourite_post', $user_meta_data); 	
echo json_encode(array('remove_fav'=>true, 'msg'=>REMOVED_FAV));exit;
}elseif($_REQUEST['remove_fav'] && !$auth){echo json_encode(array('remove_fav'=>false, 'msg'=>'Login Fail'));exit;}

############################################## MODERATION REPORT ####################################################################
//?api_submit=report&user_name=USERNAME&user_pass=PASSWORD&moderation_report=POST_ID&reason=REASON_ID&user_comments=USER_COMMENTS
if($_REQUEST['moderation_report'] && $auth){
global $wpdb,$moderation_db_table_name;
$post_id = mysql_real_escape_string($_REQUEST['moderation_report']);
$reason = mysql_real_escape_string($_REQUEST['reason']);
$user_comments = mysql_real_escape_string($_REQUEST['user_comments']);


$wpdb->query("SELECT * from $moderation_db_table_name where user_id='".$user."' AND list_id='".$post_id."'");	
$reports = $wpdb->num_rows;
if($reports >0){echo json_encode(array('moderation_report'=>false, 'msg'=>'REPORT_ALREADY_MSG'));exit;}else{
$time = time();
$reported = get_post($post_id, ARRAY_A);
$moderation_insert = '
INSERT INTO `'.$moderation_db_table_name.'` (`list_id`, `list_title`, `user_id`, `user_comments`, `user_ip`, `claim_date`, `moderation_reason`, `authorid`, `status`) VALUES
("'.$post_id.'", "'.$reported['post_title'].'", '.$user.', "'.$user_comments.'", "'.$_SERVER['REMOTE_ADDR'].'", "'.$time.'", "'.$reason.'", "'.$reported['post_author'].'", "")';
$wpdb->query($moderation_insert);
echo json_encode(array('moderation_report'=>true, 'msg'=>REPORT_REPORTED));exit;
}

}elseif($_REQUEST['moderation_report'] && !$auth){echo json_encode(array('moderation_report'=>false, 'msg'=>'Login Fail'));exit;}
############################################## TEST POST LISTING ####################################################################
if($_REQUEST['post_listing'] && $auth){/*?>
<form action="?api_submit=1&post_listing=1" method="post" enctype="multipart/form-data" name="test" >
<input name="user_name" type="text" value="admin@hebtech.co.uk" />
<input name="user_pass" type="text" value="pass" /> 
<input name="post_title" type="text" value="title" />
<input name="post_content" type="text" value="content" />
<input name="go" type="submit" />
</form>
<?php */}
if($_REQUEST['post_listing'] && $auth){
	
	$post_title = $_REQUEST['post_title'];
	$description = $_REQUEST['post_content'];
	$current_user_id = $user;

	
	
		$my_post['post_author'] = $current_user_id;
		$my_post['post_title'] = $post_title;
		$my_post['post_content'] = $description;
		$my_post['post_type'] = 'place';
		if($post_title){
		$last_postid = wp_insert_post($my_post);
		}
		if ( is_wp_error($last_postid) && $last_postid ){
  // echo $return->get_error_message();
   echo json_encode(array('post_listing'=>false, 'msg'=>'Insert post failed: '.$last_postid->get_error_message()));exit;
   }else{
	   echo json_encode(array('post_listing'=>true, 'msg'=>'Listing Inserted'));exit;
   }
	
}elseif($_REQUEST['post_listing'] && !$auth){echo json_encode(array('post_listing'=>false, 'msg'=>'Login Fail'));exit;}




$_SESSION['property_info'] =  $_POST;
########################################################################################################################################
############## ADD PLACE IMAGES START ##################################################################################################
########################################################################################################################################
if($_REQUEST['step']==2 && $auth){
			require_once(ABSPATH . 'wp-admin/includes/admin.php');
/* ?>
<form action="<?php echo home_url().'/?api_submit=1&step=2';?>" method="post" enctype="multipart/form-data">
  Send these files:<br />
  <input name="file[]" type="file"  multiple /><br />
  <input name="pid" type="text" /><br />
  <input type="hidden" name="user_name" value="<?php echo $_REQUEST['user_name'];?>" />
  <input type="hidden" name="user_pass" value="<?php echo $_REQUEST['user_pass'];?>" />
  <input type="submit" value="Send files" />
</form>
<?php //print_r($_FILES);echo '<br>';exit; */
if($_FILES && $_REQUEST['step']==2 && $auth && $_REQUEST['pid'])
		{
$pid = $_REQUEST['pid'];
$post_info = get_post($pid); 
//echo $post_info->post_author.'='.$current_user_id;exit;
if($post_info->post_author==$current_user_id){
$files = $_FILES['file'];
function rearrange( $arr ){
    foreach( $arr as $key => $all ){
        foreach( $all as $i => $val ){
            $new[$i][$key] = $val;    
        }    
    }
    return $new;
}
$files_re = rearrange( $files  );

if($files_re){
$i=1;	
foreach($files_re as $file){
$_FILES['file_up']=array();
$_FILES['file_up']=$file;
$i++;
$id = media_handle_upload( 'file_up', $pid );
//print_r($id);
}
}
if ( is_wp_error($id) ){
   echo json_encode(array('img_upload'=>false, 'msg'=>'Image upload failed: '.$id->get_error_message()));exit;
   }else{
	   echo json_encode(array('img_upload'=>true, 'msg'=>'Images uploaded'));exit;
   }

}else{echo json_encode(array('img_upload'=>false, 'msg'=>'You do not own this post'));exit;}
}
}
########################################################################################################################################
############## ADD PLACE IMAGES END ####################################################################################################
########################################################################################################################################

########################################################################################################################################
############## ADD PLACE START #########################################################################################################
########################################################################################################################################
if($_REQUEST['submit_place'] && !$_REQUEST['step'] && $auth){
require_once('submit_place_ios.php');	
}



if($_POST['post_type']=='place' && $_REQUEST['step']=='1' &&  $auth){

$payable_amount = 0;
$property_price_info = get_property_price_info($_SESSION['property_info']['price_select']);
$property_price_info = $property_price_info[0];
if($property_price_info['price']>0){
$payable_amount = $property_price_info['price'];
}
$price_capable_cat = $property_price_info['cat'];
if($property_price_info['price']>0){
$payable_amount = get_payable_amount_with_coupon($payable_amount,$_SESSION['property_info']['proprty_add_coupon']);
}
if($_REQUEST['pid']=='' && $payable_amount>0 && $_REQUEST['paymentmethod']=='')
{
	//wp_redirect(home_url().'/?ptype=preview&msg=nopaymethod');
	//exit;
}


global $wpdb;
if($_POST && $_POST['post_type']=='place')
{	
	
		$property_info = $_SESSION['property_info'];
		if($property_info){
			if($property_info['website'] && !strstr($property_info['website'],'http://'))
			{
				$property_info['website'] = 'http://'.$property_info['website'];
			}
			if($property_info['twitter'] && !strstr($property_info['twitter'],'http://'))
			{
				$property_info['twitter'] = 'http://'.$property_info['twitter'];
			}
			if($property_info['facebook'] && !strstr($property_info['facebook'],'http://'))
			{
				$property_info['facebook'] = 'http://'.$property_info['facebook'];
			}
		}
		if(!$property_info['post_city_id'])
		{
			$property_info['post_city_id'] = 1;	
		}
		//if(!$property_info['address']){$property_info['address']='&nbsp;';}
		$custom = array("address" 		=> $property_info['address'],
						"geo_latitude"	=> $property_info['geo_latitude'],
						"geo_longitude"	=> $property_info['geo_longitude'],
						"claimed"		=> $property_info['claimed'],
						"map_view"		=> $property_info['map_view'],
						"add_feature"	=> $property_info['proprty_add_feature'],
						"timing"		=> $property_info['timing'],
						"contact"		=> $property_info['contact'],
						"email"			=> $property_info['email'],
						"website"		=> $property_info['website'],
						"twitter"		=> $property_info['twitter'],
						"facebook"		=> $property_info['facebook'],
						"a_businesses"	=> $property_info['a_businesses'],
						"proprty_feature"=> $property_info['proprty_feature'],	
						"post_city_id"	=> $property_info['post_city_id'],
					);
		$custom_metaboxes = get_post_custom_fields_templ($property_price_info['pid']);
		foreach($custom_metaboxes as $key=>$val)
		{
			$name = $val['name'];
			$custom[$name] = $property_info[$name];
		}
		if($property_price_info['is_featured'])
		{
			$custom['is_featured'] = $property_price_info['is_featured'];
		}
		$post_title = $property_info['proprty_name'];
		$description = $property_info['proprty_desc'];
		
		$catids_arr = array();
		if($property_info['category'])
		{
			$catids_arr = $property_info['category'];
		}else
		{
			$catids_arr[] = 1;	
		}
		
		$my_post = array();
		if($_REQUEST['pid'] && $_REQUEST['renew']=='' && $_REQUEST['upgrade']=='')
		{
			$my_post['ID'] = $_POST['pid'];
			$my_post['post_status'] = get_post_status($_POST['pid']);
		}else
		{
			$custom['paid_amount'] = $payable_amount;
			$custom['package_pid'] = $property_price_info['pid'];
			$custom['alive_days'] = $property_price_info['alive_days'];
			$custom['paymentmethod'] = $_REQUEST['paymentmethod'];
			
			if($payable_amount>0)
			{
				$post_default_status = 'draft';
			}else
			{
				$post_default_status = get_property_default_status();
			}			
			$my_post['post_status'] = $post_default_status;
		}
		if($current_user_id)
		{
			$my_post['post_author'] = $current_user_id;
		}
		$my_post['post_title'] = $post_title;
		$my_post['post_content'] = $description;
		$my_post['post_type'] = 'place';
		if($property_info['category'])
		{
			$post_category = $property_info['category'];
		}else
		{
			$post_category = array(1);	
		}
		if($price_capable_cat)
		{
			$post_category[] = $price_capable_cat;
		}
		//$my_post['post_category'] = $post_category;
		if($property_info['kw_tags'])
		{
			$kw_tags = substr($property_info['kw_tags'],0,TAGKW_TEXT_COUNT);
			$tagkw = explode(',',$kw_tags);	
		}
		$my_post['tags_input'] = $tagkw;
		if($_REQUEST['pid'])
		{
			if($_REQUEST['renew'] || $_REQUEST['upgrade'])
			{
				$my_post['post_date'] = date('Y-m-d H:i:s');
				$custom['paid_amount'] = $payable_amount;
				$custom['package_pid'] = $property_price_info['pid'];
				$custom['alive_days'] = $property_price_info['alive_days'];
				$custom['paymentmethod'] = $_REQUEST['paymentmethod'];
				$my_post['ID'] = $_REQUEST['pid'];
				$last_postid = wp_insert_post($my_post);
				wp_set_object_terms($last_postid, $post_category, $taxonomy='placecategory');
				wp_set_object_terms($last_postid, $tagkw, $taxonomy='place_tags');
			}else
			{
				$last_postid = wp_update_post($my_post);
				wp_set_object_terms($last_postid, $post_category, $taxonomy='placecategory');
				wp_set_object_terms($last_postid, $tagkw, $taxonomy='place_tags');
			}
		}else
		{
			$last_postid = wp_insert_post( $my_post ); //Insert the post into the database
			wp_set_object_terms($last_postid, $post_category, $taxonomy='placecategory');
				wp_set_object_terms($last_postid, $tagkw, $taxonomy='place_tags');
		}
		$custom["paid_amount"] = $payable_amount;
		foreach($custom as $key=>$val)
		{				
			update_post_meta($last_postid, $key, $val);
		}
		
		$_SESSION['property_info'] = array();
		$_SESSION["file_info"] = array();
		if($_REQUEST['pid'] && $_REQUEST['renew']=='' && $_REQUEST['upgrade']=='')
		{
			wp_redirect(get_author_link($echo = false, $current_user->data->ID));
			exit;
		}else
		{

			///////EMAIL START//////
			$message_type='post_submited';
			if($_REQUEST['renew']){$message_type='renew';}
			elseif($_REQUEST['upgrade']){$message_type='upgrade';}
			
			adminEmail($last_postid,$current_user->data->ID,$message_type);  //send admin email
			clientEmail($last_postid,$current_user->data->ID,$message_type); //send client email
			//////EMAIL END////////
			
			
			
			if($last_postid){
				if($payable_amount>0){
				echo json_encode(array('post'=>true, 'msg'=>'Listing Saved, please pay to make it LIVE', 'pid'=>$last_postid,'pay' =>$payable_amount, 'url'=>get_bloginfo('url').'/?pay_mobile=1&pay='.$payable_amount.'&pid='.$last_postid.'&title='.$post_title.'&pkg='.$property_price_info['pid'] ));
				//include_once(TEMPLATEPATH.'/library/payment/paypal/paypal_mobile_response.php');
				exit;
				}else{
				echo json_encode(array('post'=>true, 'msg'=>'Listing Posted', 'pid'=>$last_postid,'pay' =>$payable_amount));exit;
				}
			}else{				
				echo json_encode(array('post'=>false, 'msg'=>'Listing NOT Posted: '));exit;
				}
						
			
			
			if($payable_amount <= 0)
			{
				$suburl .= "&pid=$last_postid";
				if($_REQUEST['renew'])
				{
					$suburl .= "&renew=1";
				}		
				if($_REQUEST['upgrade'])
					{
						$suburl = "&upgrade=1";
					}
				wp_redirect(home_url()."/?ptype=success$suburl");
				exit;
			}else
			{
				$paymentmethod = $_REQUEST['paymentmethod'];
				$paymentSuccessFlag = 0;
				if($paymentmethod == 'prebanktransfer' || $paymentmethod == 'payondelevary')
				{
					if($_REQUEST['renew'])
					{
						$suburl = "&renew=1";
					}
					if($_REQUEST['upgrade'])
					{
						$suburl = "&upgrade=1";
					}
					$suburl .= "&pid=$last_postid";
					wp_redirect(home_url().'/?ptype=success&paydeltype='.$paymentmethod.$suburl);
				}
				else
				{
					if(file_exists( TEMPLATEPATH.'/library/payment/'.$paymentmethod.'/'.$paymentmethod.'_response.php'))
					{
						include_once(TEMPLATEPATH.'/library/payment/'.$paymentmethod.'/'.$paymentmethod.'_response.php');
					}
				}
				exit;	
			}
		}
	
}
}// end if place
########################################################################################################################################
############## ADD PLACE END ###########################################################################################################
########################################################################################################################################


########################################################################################################################################
############## ADD EVENT START #########################################################################################################
########################################################################################################################################
if($_REQUEST['submit_event'] && !$_REQUEST['step'] && $auth){
require_once('submit_event_ios.php');	
}




if($_POST['post_type']=='event' &&  $auth){
$payable_amount = 0;
$property_price_info = get_property_price_info($_SESSION['property_info']['price_select']);		
$property_price_info = $property_price_info[0];
if($property_price_info['price']>0){
$payable_amount = $property_price_info['price'];
}
$price_capable_cat = $property_price_info['cat'];
if($property_price_info['price']>0){
$payable_amount = get_payable_amount_with_coupon($payable_amount,$_SESSION['property_info']['proprty_add_coupon']);
}

if($_REQUEST['pid']=='' && $payable_amount>0 && $_REQUEST['paymentmethod']=='')
{
	//wp_redirect(home_url().'/?ptype=preview_event&msg=nopaymethod');
	//exit;
}


global $wpdb;
if($_POST && $_POST['post_type']=='event')
{	
	
		$property_info = $_SESSION['property_info'];
		if($property_info){
			if($property_info['website'] && !strstr($property_info['website'],'http://'))
			{
				$property_info['website'] = 'http://'.$property_info['website'];
			}
			if($property_info['twitter'] && !strstr($property_info['twitter'],'http://'))
			{
				$property_info['twitter'] = 'http://'.$property_info['twitter'];
			}
			if($property_info['facebook'] && !strstr($property_info['facebook'],'http://'))
			{
				$property_info['facebook'] = 'http://'.$property_info['facebook'];
			}
		}
		if(!$property_info['post_city_id'])
		{
			$property_info['post_city_id'] = 1;	
		}
		$custom = array("address" 		=> $property_info['address'],
						"geo_latitude"	=> $property_info['geo_latitude'],
						"geo_longitude"	=> $property_info['geo_longitude'],
						"claimed"		=> $property_info['claimed'],
						"map_view"		=> $property_info['map_view'],
						"add_feature"	=> $property_info['proprty_add_feature'],
						"st_date"		=> $property_info['stdate'],
						"st_time"		=> $property_info['sttime'],
						"end_date"		=> $property_info['enddate'],
						"end_time"		=> $property_info['endtime'],
						"recurring"		=> $property_info['recurring'],
						"reg_desc"		=> $property_info['reg_desc'],
						"reg_fees"		=> $property_info['reg_fees'],						
						"contact"		=> $property_info['contact'],
						"email"			=> $property_info['email'],
						"website"		=> $property_info['website'],
						"twitter"		=> $property_info['twitter'],
						"facebook"		=> $property_info['facebook'],
						"a_businesses"	=> $property_info['a_businesses'],
						"proprty_feature"=> $property_info['proprty_feature'],
						"post_city_id"	=> $property_info['post_city_id'],
					);
		$custom_metaboxes = get_post_custom_fields_templ($property_price_info['pid']);
		foreach($custom_metaboxes as $key=>$val)
		{
			$name = $val['name'];
			$custom[$name] = $property_info[$name];
		}
		$post_title = $property_info['proprty_name'];
		$description = $property_info['proprty_desc'];
		
		$catids_arr = array();
		if($property_info['category'])
		{
			$catids_arr = $property_info['category'];
		}else
		{
			$catids_arr[] = 1;	
		}
		
		$my_post = array();
		if($_REQUEST['pid'] && $_REQUEST['renew']=='' && $_REQUEST['upgrade']=='')
		{
			$my_post['ID'] = $_POST['pid'];
			$my_post['post_status'] = get_post_status($_POST['pid']);
		}else
		{
			$custom['paid_amount'] = $payable_amount;
			$custom['package_pid'] = $property_price_info['pid'];
			$custom['alive_days'] = $property_price_info['alive_days'];
			$custom['paymentmethod'] = $_REQUEST['paymentmethod'];
			
			if($payable_amount>0)
			{
				$post_default_status = 'draft';
			}else
			{
				$post_default_status = get_property_default_status();
			}			
			$my_post['post_status'] = $post_default_status;
		}
		if($current_user_id)
		{
			$my_post['post_author'] = $current_user_id;
		}
		$my_post['post_title'] = $post_title;
		$my_post['post_content'] = $description;
		$my_post['post_type'] = 'event';
		if($property_info['category'])
		{
			$post_category = $property_info['category'];
		}else
		{
			$post_category = array(1);	
		}
		if($price_capable_cat)
		{
			$post_category[] = $price_capable_cat;
		}
		//$my_post['post_category'] = $post_category;
		$my_post['tax_input'] = $post_category;
		if($property_info['kw_tags'])
		{
			$kw_tags = substr($property_info['kw_tags'],0,TAGKW_TEXT_COUNT);
			$tagkw = explode(',',$kw_tags);	
		}
		$my_post['tags_input'] = $tagkw;
		
		if($_REQUEST['pid'])
		{
			if($_REQUEST['renew'] || $_REQUEST['upgrade'])
			{
				$my_post['post_date'] = date('Y-m-d H:i:s');
				$custom['paid_amount'] = $payable_amount;
				$custom['package_pid'] = $property_price_info['pid'];
				$custom['alive_days'] = $property_price_info['alive_days'];
				$custom['paymentmethod'] = $_REQUEST['paymentmethod'];
				$my_post['ID'] = $_REQUEST['pid'];
				$last_postid = wp_update_post($my_post);
				wp_set_object_terms($last_postid, $post_category, $taxonomy='eventcategory');
				wp_set_object_terms($last_postid, $tagkw, $taxonomy='event_tags');
			}else
			{
				$last_postid = wp_update_post($my_post);
				wp_set_object_terms($last_postid, $post_category, $taxonomy='eventcategory');
				wp_set_object_terms($last_postid, $tagkw, $taxonomy='event_tags');

			}
		}else
		{
			$last_postid = wp_insert_post( $my_post ); //Insert the post into the database
			//wp_set_post_terms( $last_postid, $post_category, $taxonomy = eventcategory');
			wp_set_object_terms($last_postid, $post_category, $taxonomy='eventcategory');
			wp_set_object_terms($last_postid, $tagkw, $taxonomy='event_tags');
		}
		$custom["paid_amount"] = $payable_amount;
		foreach($custom as $key=>$val)
		{				
			update_post_meta($last_postid, $key, $val);
		}
		if($_SESSION["file_info"])
		{
			
			$menu_order = 0;
			foreach($_SESSION["file_info"] as $image_id=>$val)
			{
				$src = get_image_tmp_phy_path().$image_id.'.jpg';
				if(file_exists($src))
				{
					$menu_order++;
					$dest_path = get_image_phy_destination_path().$image_id.'.jpg';
					$original_size = get_image_size($src);
					$thumb_info = image_resize_custom($src,$dest_path,get_option('thumbnail_size_w'),get_option('thumbnail_size_h'));
					$medium_info = image_resize_custom($src,$dest_path,get_option('medium_size_w'),get_option('medium_size_h'));
					$post_img = move_original_image_file($src,$dest_path);
					$post_img['post_status'] = 'attachment';
					$post_img['post_parent'] = $last_postid;
					$post_img['post_type'] = 'attachment';
					$post_img['post_mime_type'] = 'image/jpeg';
					$post_img['menu_order'] = $menu_order;
					
					$last_postimage_id = wp_insert_post( $post_img ); // Insert the post into the database
		
					$thumb_info_arr = array();
					if($thumb_info)
					{
						$sizes_info_array = array();
						if($thumb_info)
						{
						$sizes_info_array['thumbnail'] =  array(
																"file" =>	$thumb_info['file'],
																"height" =>	$thumb_info['height'],
																"width" =>	$thumb_info['width'],
																);
						}
						if($medium_info)
						{
						$sizes_info_array['medium'] =  array(
																"file" =>	$medium_info['file'],
																"height" =>	$medium_info['height'],
																"width" =>	$medium_info['width'],
																);
						}
						$hwstring_small = "height='".$thumb_info['height']."' width='".$thumb_info['width']."'";
					}else
					{
						$hwstring_small = "height='".$original_size['height']."' width='".$original_size['width']."'";
					}
					update_post_meta($last_postimage_id, '_wp_attached_file', get_attached_file_meta_path($post_img['guid']));
					$post_attach_arr = array(
										"width"	=>	$original_size['width'],
										"height" =>	$original_size['height'],
										"hwstring_small"=> $hwstring_small,
										"file"	=> get_attached_file_meta_path($post_img['guid']),
										"sizes"=> $sizes_info_array,
										);
					wp_update_attachment_metadata( $last_postimage_id, $post_attach_arr );
				}				
			}
		}
		$_SESSION['property_info'] = array();
		$_SESSION["file_info"] = array();
		if($_REQUEST['pid'] && $_REQUEST['renew']=='' && $_REQUEST['upgrade']=='')
		{
			wp_redirect(get_author_link($echo = false, $current_user->data->ID));
			exit;
		}else
		{

			///////EMAIL START//////
			$message_type='post_submited';
			if($_REQUEST['renew']){$message_type='renew';}
			elseif($_REQUEST['upgrade']){$message_type='upgrade';}
			
			adminEmail($last_postid,$current_user->data->ID,$message_type);  //send admin email
			clientEmail($last_postid,$current_user->data->ID,$message_type); //send client email
			//////EMAIL END////////
			
			
			
			if($last_postid){
				if($payable_amount>0){
				echo json_encode(array('post'=>true, 'msg'=>'Listing Saved, please pay to make it LIVE', 'pid'=>$last_postid,'pay' =>$payable_amount, 'url'=>get_bloginfo('url').'/?pay_mobile=1&pay='.$payable_amount.'&pid='.$last_postid.'&title='.$post_title ));
				//include_once(TEMPLATEPATH.'/library/payment/paypal/paypal_mobile_response.php');
				exit;
				}else{
				echo json_encode(array('post'=>true, 'msg'=>'Listing Posted', 'pid'=>$last_postid,'pay' =>$payable_amount));exit;
				}
			}else{				
				echo json_encode(array('post'=>false, 'msg'=>'Listing NOT Posted: '));exit;
				}
						
			
			
			if($payable_amount <= 0)
			{
				$suburl .= "&pid=$last_postid";
				if($_REQUEST['renew'])
				{
					$suburl .= "&renew=1";
				}		
				if($_REQUEST['upgrade'])
					{
						$suburl = "&upgrade=1";
					}
				wp_redirect(home_url()."/?ptype=success$suburl");
				exit;
			}else
			{
				$paymentmethod = $_REQUEST['paymentmethod'];
				$paymentSuccessFlag = 0;
				if($paymentmethod == 'prebanktransfer' || $paymentmethod == 'payondelevary')
				{
					if($_REQUEST['renew'])
					{
						$suburl = "&renew=1";
					}
					if($_REQUEST['upgrade'])
					{
						$suburl = "&upgrade=1";
					}
					$suburl .= "&pid=$last_postid";
					wp_redirect(home_url().'/?ptype=success&paydeltype='.$paymentmethod.$suburl);
				}
				else
				{
					if(file_exists( TEMPLATEPATH.'/library/payment/'.$paymentmethod.'/'.$paymentmethod.'_response.php'))
					{
						include_once(TEMPLATEPATH.'/library/payment/'.$paymentmethod.'/'.$paymentmethod.'_response.php');
					}
				}
				exit;	
			}
		}
	
}
} // end if event
########################################################################################################################################
############## ADD EVENT END ###########################################################################################################
########################################################################################################################################

########################################################################################################################################
############## ADD COMMENT IMAGE START #################################################################################################
########################################################################################################################################
if($_FILES['file']['size']){


        // Check upload against blacklist and return true unless it matches
        function filetype_blacklisted() {
            $blacklist = ecu_get_blacklist();
            return preg_match('/\\.((' . implode('|', $blacklist)
                . ')|~)([^a-z0-9]|$)/i', $_FILES['file']['name']);
        }

        // Check upload against whitelist and return true if it matches
        function filetype_whitelisted() {
            $whitelist = ecu_get_whitelist();
            return preg_match('/^[^\\.]+\\.(' . implode('|', $whitelist)
                . ')$/i', $_FILES['file']['name']);
        }

        // Write script as js to the page
        function write_js($script) {
            echo "<script type='text/javascript'>$script\n</script>\n";
        }

        // Send message to user in an alert
        function js_alert($msg) {
            write_js("alert('$msg');");
        }

        // Write html to the preview iframe
        function write_html_form ($html) {
            write_js("parent.parent.document.getElementById('ecu_preview')"
                . ".innerHTML = \"$html\""
                . "+ parent.parent.document.getElementById('ecu_preview')"
                . ".innerHTML");
        }

        // Find a unique filename similar to $prototype
        function find_unique_target ($prototype) {
            $prototype_parts = pathinfo ($prototype);
            $ext = $prototype_parts['extension'];
            $dir = $prototype_parts['dirname'];
            $name = sanitize_file_name(filter_var($prototype_parts['filename'], FILTER_SANITIZE_URL));
            $dot = $ext == '' ? '' : '.';
            if (!file_exists("$dir/$name.$ext")) {
                return "$dir/$name$dot$ext";
            } else {
                $i = 1;
                while (file_exists("$dir/$name-$i$dot$ext")) { ++$i; }
                return "$dir/$name-$i$dot$ext";
            }
        }

        // Get needed info
        $target_dir = ecu_upload_dir_path();
        $target_url = ecu_upload_dir_url();
        $images_only = get_option('ecu_images_only');
        $max_file_size = get_option('ecu_max_file_size');
        $max_post_size = (int)ini_get('post_max_size');
        $max_upload_size = (int)ini_get('upload_max_filesize');

        if (!file_exists($target_dir))
            mkdir ($target_dir);

        $target_path = find_unique_target($target_dir
            . basename($_FILES['file']['name']));
        $target_name = basename($target_path);

        /* Debugging info */
        // $error = (int) $_FILES['file']['error'];
        // write_js("alert('$error')");
        // sleep(2);

        // Default values
        $filecode = "";
        $filelink = "";

        // Detect whether the uploaded file is an image
        $is_image = preg_match ('/(jpeg|png|gif)/i', $_FILES['file']['type']);
        $type = ($is_image) ? "img" : "file";

        if (!is_writable($target_dir)) {
            $alert = "Files can not be written to $target_dir. Please make sure that the permissions are set correctly (mode 666)."; 
        } else if (!$is_image && $images_only) {
            $alert = "Sorry, you can only upload images.";
        } else if (filetype_blacklisted() && !filetype_whitelisted()) {
            $alert = "You are attempting to upload a file with a"
                . "disallowed/unsafe filetype!";
        } else if (!filetype_whitelisted() && ecu_get_whitelist()) {
            $alert = 'You may only upload files with the following extensions: '
                . implode(', ', ecu_get_whitelist());
        } else if ($max_file_size != 0
            && $_FILES['file']['size']/1024 > $max_file_size) {
            $alert = "The file you've uploaded is too large ("
                . round($_FILES['file']['size']/1024, 1)
                . "KiB).\nPlease choose a smaller file and try again (Uploads"
                . " are limited to $max_file_size KiB).";
        } else if (ecu_user_uploads_per_hour() != -1

            && ecu_user_uploads_in_last_hour()
            >= ecu_user_uploads_per_hour()) {
            $alert = "You are only permitted to upload "
                . (string)ecu_user_uploads_per_hour() . " files per hour.";
        } else if ($_FILES['file']['error'] == 1
            || $_FILES['file']['error'] == 2) {
            $alert = 'Your file has exceeded the php max_upload_size ('
                . "$max_upload_size MiB) or max_post_size ("
                . "$max_post_size MiB). Please choose a"
                . ' smaller file or ask the website administrator to'
                . ' increase the relevant settings in the php.ini file.';
        } else if (wp_verify_nonce($_REQUEST['_wpnonce'],
            'ecu_upload_form')) {
            // Check referer
            $alert = 'Invalid Referrer';
        } else if (move_uploaded_file($_FILES['file']['tmp_name'],
            $target_path)) {
            $filelink = $target_url . $target_name;
            $filecode = "[$type]$filelink" . "[/$type]";

            // Add the filecode to the comment form
            //write_js("write_comment('$filecode');");

            // Post info below upload form
           // write_html_form("<div class='ecu_preview_file'>"
               // . "<a href='$filelink'>$target_name</a><br />$filecode</div>");

            if ($is_image) { /*
                $thumbnail = ecu_thumbnail($filelink, 300);
                write_html_form("<a href='$filelink' rel='lightbox[new]'>"
                    . "<img class='ecu_preview_img' src='$thumbnail' /></a>"
                    . '<br />');
          */  }

            ecu_user_record_upload_time();
        } else {
            $alert = 'There was an error uploading the file, '
                . 'please try again!';
        }
        if( $alert ){echo json_encode(array('comment'=>true, 'msg'=>'Comment error'.$alert));exit;}
       // write_js('upload_end()');

        // Alert the user of any errors
       // if (isset($alert))
       //     js_alert($alert);

       
}
########################################################################################################################################
############## ADD COMMENT IMAGE END ###################################################################################################
########################################################################################################################################

########################################################################################################################################
############## ADD COMMENT START #######################################################################################################
########################################################################################################################################

if($_POST['post_type']=='comment' &&  $auth){

	
$comment_post_ID = isset($_POST['comment_post_ID']) ? (int) $_POST['comment_post_ID'] : 0;

$post = get_post($comment_post_ID);

if ( empty($post->comment_status) ) {
	do_action('comment_id_not_found', $comment_post_ID);
	exit;
}

// get_post_status() will get the parent status for attachments.
$status = get_post_status($post);

$status_obj = get_post_status_object($status);

if ( !comments_open($comment_post_ID) ) {
	echo json_encode(array('comment'=>false, 'msg'=>'Comment closed'));exit;
} elseif ( 'trash' == $status ) {
	echo json_encode(array('comment'=>false, 'msg'=>'Comment closed'));exit;
} elseif ( !$status_obj->public && !$status_obj->private ) {
	echo json_encode(array('comment'=>false, 'msg'=>'Comment closed'));exit;
} elseif ( post_password_required($comment_post_ID) ) {
	echo json_encode(array('comment'=>false, 'msg'=>'Comment closed'));exit;
} else {
	do_action('pre_comment_on_post', $comment_post_ID);
}

$comment_author       = ( isset($_POST['author']) )  ? trim(strip_tags($_POST['author'])) : null;
$comment_author_email = ( isset($_POST['email']) )   ? trim($_POST['email']) : null;
$comment_author_url   = ( isset($_POST['url']) )     ? trim($_POST['url']) : null;
$comment_content      = ( isset($_POST['comment']) ) ? trim($_POST['comment']) : null;

if($filelink){$comment_content = $comment_content.'<br />[img]'.$filelink.'[/img]';}

// If the user is logged in
$user = $user_info;
if ( $user->ID ) {
	if ( empty( $user->display_name ) )
		$user->display_name=$user->user_login;
	$comment_author       = $wpdb->escape($user->display_name);
	$comment_author_email = $wpdb->escape($user->user_email);
	$comment_author_url   = $wpdb->escape($user->user_url);
	if ( current_user_can('unfiltered_html') ) {
		if ( wp_create_nonce('unfiltered-html-comment_' . $comment_post_ID) != $_POST['_wp_unfiltered_html_comment'] ) {
			kses_remove_filters(); // start with a clean slate
			kses_init_filters(); // set up the filters
		}
	}
} else {
	if ( get_option('comment_registration') || 'private' == $status )
		wp_die( __('Sorry, you must be logged in to post a comment.') );
}

$comment_type = '';

if ( get_option('require_name_email') && !$user->ID ) {
	if ( 6 > strlen($comment_author_email) || '' == $comment_author )
		wp_die( __('Error: please fill the required fields (name, email).') );
	elseif ( !is_email($comment_author_email))
		wp_die( __('Error: please enter a valid email address.') );
}

if ( '' == $comment_content )
	wp_die( __('Error: please type a comment.') );

$comment_parent = isset($_POST['comment_parent']) ? absint($_POST['comment_parent']) : 0;

$commentdata = compact('comment_post_ID', 'comment_author', 'comment_author_email', 'comment_author_url', 'comment_content', 'comment_type', 'comment_parent', 'user_ID');
	//$comment_post_ID = $_REQUEST['comment_post_ID'];
	//$rating =  $_POST['post_'.$comment_post_ID.'_rating'];
//echo json_encode(array('comment'=>true, 'msg'=>'Comment posted,'.$rating));exit;

$comment_id = wp_new_comment( $commentdata );

$comment = get_comment($comment_id);
if ( !$user->ID ) {
	$comment_cookie_lifetime = apply_filters('comment_cookie_lifetime', 30000000);
	setcookie('comment_author_' . COOKIEHASH, $comment->comment_author, time() + $comment_cookie_lifetime, COOKIEPATH, COOKIE_DOMAIN);
	setcookie('comment_author_email_' . COOKIEHASH, $comment->comment_author_email, time() + $comment_cookie_lifetime, COOKIEPATH, COOKIE_DOMAIN);
	setcookie('comment_author_url_' . COOKIEHASH, esc_url($comment->comment_author_url), time() + $comment_cookie_lifetime, COOKIEPATH, COOKIE_DOMAIN);
}

$location = empty($_POST['redirect_to']) ? get_comment_link($comment_id) : $_POST['redirect_to'] . '#comment-' . $comment_id;
$location = apply_filters('comment_post_redirect', $location, $comment);



if ( is_wp_error($comment_id) ){
  // echo $return->get_error_message();
   echo json_encode(array('comment'=>false, 'msg'=>'Comment failed: '.$comment_id->get_error_message().$alert));exit;
   }else{
	   echo json_encode(array('comment'=>true, 'msg'=>'Comment posted'.$alert));exit;
   }


//wp_redirect($location);
exit;	
} // end if comment
########################################################################################################################################
############## ADD COMMENT END  ########################################################################################################
########################################################################################################################################




?>