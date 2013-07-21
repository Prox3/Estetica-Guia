<?php
session_start();
ob_start();
$payable_amount = 0;
if($_SESSION['property_info']['price_select']){$pkg_id=$_SESSION['property_info']['price_select'];}else{$pkg_id=get_post_meta($_REQUEST['pid'], 'package_pid', true);}
$property_price_info = get_property_price_info($pkg_id);		
$property_price_info = $property_price_info[0];
if($property_price_info['price']>0){
$payable_amount = $property_price_info['price'];
$sub_active = $property_price_info['sub_active'];
$sub_units = $property_price_info['sub_units'];
$sub_units_num = $property_price_info['sub_units_num'];
}
$price_capable_cat = $property_price_info['cat'];
if($property_price_info['price']>0){
$payable_amount = get_payable_amount_with_coupon($payable_amount,$_SESSION['property_info']['proprty_add_coupon']);
}

if($_REQUEST['pid']=='' && $payable_amount>0 && $_REQUEST['paymentmethod']=='')
{
	wp_redirect(home_url().'/?ptype=preview_event&msg=nopaymethod');
	exit;
}
global $current_user;
if($current_user->data->ID=='' && $_SESSION['property_info'])
{
	include_once(TEMPLATEPATH . '/library/includes/single_page_checkout_insertuser.php');
}
global $wpdb;
if($_POST)
{	
	if($_POST['paynow'])
	{
		$property_info = $_SESSION['property_info'];
		if($property_info){
			if($property_info['website'] && !strstr($property_info['website'],'//'))
			{
				$property_info['website'] = 'http://'.$property_info['website'];
			}
			if($property_info['twitter'] && !strstr($property_info['twitter'],'//'))
			{
				$property_info['twitter'] = 'http://'.$property_info['twitter'];
			}
			if($property_info['facebook'] && !strstr($property_info['facebook'],'//'))
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
						"post_hood_id"	=> $property_info['post_hood_id'],
						"video"			=> $property_info['video'],
						"submit_time"	=> $property_info['submit_time'],
						"submit_ip"		=> $property_info['submit_ip'],
						"coupon_used"	=> $_SESSION['property_info']['proprty_add_coupon'],
					);
		//$custom_metaboxes = get_post_custom_fields_templ();
		$custom_metaboxes = get_post_custom_fields_templ($property_price_info['pid']);
		//echo $property_price_info['pid'];
		//print_r($custom_metaboxes);exit;
		foreach($custom_metaboxes as $key=>$val)
		{
			$name = $val['name'];
			$custom[$name] = $property_info[$name];
		}
		if($property_price_info['is_featured'])
		{
			$custom['is_featured'] = $property_price_info['is_featured'];
		}else{$custom['is_featured'] = 0;}
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
		/*if($price_capable_cat)
		{
			$post_category[] = $price_capable_cat;
		}*/
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
				//$my_post['post_date'] = date('Y-m-d H:i:s');
				if($property_price_info['alive_days']){$custom['expire_date'] = date('Y-m-d', strtotime("+".$property_price_info['alive_days']." days"));}else{$custom['expire_date'] = 'Never'; }
				$custom['paid_amount'] = $payable_amount;
				$custom['package_pid'] = $property_price_info['pid'];
				$custom['alive_days'] = $property_price_info['alive_days'];
				$custom['paymentmethod'] = $_REQUEST['paymentmethod'];
				$my_post['ID'] = $_REQUEST['pid'];
				$last_postid = wp_update_post($my_post);
				wp_set_object_terms($last_postid, $post_category, $taxonomy='eventcategory');
				wp_set_object_terms($last_postid, $tagkw, $taxonomy='event_tags');
				
				############# INSERT TRANSCATION DETAILS START ###############
				$my_invoice['post_title'] = $last_postid;
				$my_invoice['post_type'] = 'invoice';
				$my_invoice['post_status'] = 'publish';
				$my_invoice['post_author'] = $current_user_id;
				$last_invoiceid = wp_insert_post( $my_invoice ); //Insert the post into the database
				// UPDATE THE META
				$invoice_status = 'Free';
				if($payable_amount > 0){$invoice_status = 'Unpaid';}
				$custom_invoice["paid_amount"] = $payable_amount;
				$custom_invoice['package_pid'] = $property_price_info['pid'];
				$custom_invoice['alive_days'] = $property_price_info['alive_days'];
				$custom_invoice['paymentmethod'] = $_REQUEST['paymentmethod'];
				$custom_invoice['post_city_id'] = $property_info['post_city_id'];
				update_post_meta($last_invoiceid, "_status", $invoice_status);
				foreach($custom_invoice as $key=>$val)
				{				
					update_post_meta($last_invoiceid, $key, $val);
				}
				############# INSERT TRANSCATION DETAILS END #################
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
			
		############# INSERT TRANSCATION DETAILS START ###############
		$my_invoice['post_title'] = $last_postid;
		$my_invoice['post_type'] = 'invoice';
		$my_invoice['post_status'] = 'publish';
		$my_invoice['post_author'] = $current_user_id;
		$last_invoiceid = wp_insert_post( $my_invoice ); //Insert the post into the database
		// UPDATE THE META
		$invoice_status = 'Free';
		if($payable_amount > 0){$invoice_status = 'Unpaid';}
		$custom_invoice["paid_amount"] = $payable_amount;
		$custom_invoice["coupon_used"] = $_SESSION['property_info']['proprty_add_coupon'];
		$custom_invoice['package_pid'] = $property_price_info['pid'];
		$custom_invoice['alive_days'] = $property_price_info['alive_days'];
		$custom_invoice['paymentmethod'] = $_REQUEST['paymentmethod'];
		$custom_invoice['post_city_id'] = $property_info['post_city_id'];
		update_post_meta($last_invoiceid, "_status", $invoice_status);
		foreach($custom_invoice as $key=>$val)
		{				
			update_post_meta($last_invoiceid, $key, $val);
		}
		############# INSERT TRANSCATION DETAILS END #################	
		$custom["paid_amount"] = $payable_amount;
		if($property_price_info['alive_days']){$custom['expire_date'] = date('Y-m-d', strtotime("+".$property_price_info['alive_days']." days"));}else{$custom['expire_date'] = 'Never'; }	
			
		}
		
		foreach($custom as $key=>$val)
		{				
			update_post_meta($last_postid, $key, $val);
		}
		if(isset($_SESSION["file_info"]))
		{ 
			$image_src=array();
			$tmpimgArr = explode(",", $_SESSION["file_info"]);
			foreach($tmpimgArr as $image)
			{		 
				if($image){
				 $image_src[] =  $image;
				}
			}
			gt_add_remove_images($last_postid,$image_src);
			
			/*
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
					$post_img['post_status'] = 'inherit';
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
			}*/
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
			if($current_user->data->ID=='' || $current_user->data->ID=='0' ){ // if new user registration get correct user ID
				global $current_user_id;
			adminEmail($last_postid,$current_user_id,$message_type);  //send admin email
			clientEmail($last_postid,$current_user_id,$message_type); //send client email
				}else{			
			adminEmail($last_postid,$current_user->data->ID,$message_type);  //send admin email
			clientEmail($last_postid,$current_user->data->ID,$message_type); //send client email
			//////EMAIL END//////// 
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
}
?>