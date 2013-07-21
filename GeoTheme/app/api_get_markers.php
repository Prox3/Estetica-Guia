<?php
global $wpdb;
if(get_option('gt_app_per_page')){$per_page = get_option('gt_app_per_page');}else{$per_page = '10';}
require_once(ABSPATH . WPINC . '/ms-functions.php');
$multicity_db_table_name = $wpdb->base_prefix."multicity"; // DATABASE TABLE  MULTY CITY
$multiregion_db_table_name = $wpdb->base_prefix."multiregion"; // DATABASE TABLE  MULTY CITY
############################################## ABOUT PAGE ####################################################################
if($_REQUEST['api']=='about'){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
body {background-color: transparent} 
</style>
</head>
<body>
<?php echo stripslashes (get_option('gt_app_about'));?>
</body>
</html>
<?php
}
############################################## END ABOUT PAGE ####################################################################
############################################## AUTHENTICATE USER ####################################################################

/* gets the data from a URL */
function curl_get_data($url) {
  $ch = curl_init();
  $timeout = 5;
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
  $data = curl_exec($ch);
  curl_close($ch);
  return $data;
}

if($_REQUEST['api']=='user_auth'){
global $wpdb;

$user = get_user_id_from_string($_REQUEST['user_name']);
if($user){
  // echo $user->ID;
   $current_user_id = $user; // set the user id
   $user_info = get_userdata($current_user_id); // get the users hashed password 
   $auth =  wp_check_password( $_REQUEST['user_pass'], $user_info->user_pass, $current_user_id); // check the users password is correct
   
// Check the current stored fb pass   
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
	$fbuser = json_decode(curl_get_data("https://graph.facebook.com/me?access_token=".$access_token));
	if($fbuser->email==$_REQUEST['user_name']){$auth = true;}
	//$auth = true;
	}
}
   
if($auth){ $result = array('auth'=>$auth, 'msg'=>'authoised'); echo json_encode($result);}
else{$result = array('auth'=>$auth, 'msg'=>'Login Fail'); echo json_encode($result);}exit;
}else{$result = array('auth'=>false, 'msg'=>'Login Fail.'); echo json_encode($result);}exit;
}
############################################## END AUTHENTICATE USER ####################################################################
############################################## REGISTER USER ####################################################################
if($_REQUEST['api']=='user_reg'){
global $wpdb;

$fbtrue = mysql_real_escape_string($_REQUEST['facebook']);

$name = get_user_id_from_string($_REQUEST['user_name']);
$email = get_user_id_from_string($_REQUEST['user_email']);
//if($name){echo json_encode(array('reg'=>false, 'msg'=>'username allready registered'));exit;}
if($email){echo json_encode(array('reg'=>false, 'msg'=>'email allready registered'));exit;}
else{
$name = mysql_real_escape_string($_REQUEST['user_name']);
$email= mysql_real_escape_string($_REQUEST['user_email']);
$pass = mysql_real_escape_string($_REQUEST['user_pass']);
$result = wp_insert_user(array('user_login' => $name, 'first_name' => $name, 'user_email' => $email, 'user_pass' => $pass));
if ( is_wp_error($result) ){
  // echo $return->get_error_message();
   echo json_encode(array('reg'=>false, 'msg'=>'registration failed: '.$result->get_error_message()));exit;
   }
if($fbtrue){
update_user_meta($result, 'app_facebook', true);
update_user_meta($result, 'app_facebook_pass', $_REQUEST['user_pass']);
}
$fromEmail = ''; // leave blank for default
$fromEmailName = ''; // leave blank for default
///////REGISTRATION EMAIL START//////
				
		$message  = '<p><b>'.__('Your login Information :').'</b></p>';
		$message  .= '<p>'.sprintf(__('Username: %s'), $email) . "</p>";
		$message .= '<p>'.sprintf(__('Password: %s'), $pass) . "</p>";
		
		/////////////customer email//////////////
		//sendEmail($fromEmail,$fromEmailName,$user_email,$userName,$subject,$client_message,$extra='');///To client email
		sendEmail($fromEmail,$fromEmailName,$email,$name,'',$message,$extra='','registration',$post_id='','');/// registration email
		//////REGISTRATION EMAIL END////////
echo json_encode(array('reg'=>true, 'msg'=>'user registered'));exit;	
}
}
############################################## END REGISTER USER ####################################################################
############################################## GET USER FAV ARRAY ####################################################################
if($_REQUEST['api']=='user_fav'){
$user = get_user_id_from_string($_REQUEST['user_name']);
if($user){
$user_fav_arr = get_user_meta($user, 'user_favourite_post', true);
if(is_array($user_fav_arr)){
echo json_encode($user_fav_arr);exit;
}else{echo json_encode(array('user_fav'=>false, 'msg'=>'No Favourites'));exit;}
}elseif($_REQUEST['api']=='user_fav' && !$auth){echo json_encode(array('user_fav'=>false, 'msg'=>'No Username'));exit;}

}


############################################## GET MODERATION REASONS ####################################################################
//?api=moderation_reasons
if($_REQUEST['api']=='moderation_reasons'){
global $wpdb;
$reason_arr = gt_moderation_reason('array');
echo json_encode($reason_arr);exit;

}elseif($_REQUEST['moderation_reasons'] && !$auth){echo json_encode(array('moderation_report'=>false, 'msg'=>'Login Fail'));exit;}


############################################## GET CITY INFO ####################################################################
if($_REQUEST['api']=='city'){
function api_get_city($lat, $lon){
global $wpdb,$multicity_db_table_name;

		if($_REQUEST['lat'] && $_REQUEST['lon']){
		$near_city_id = $wpdb->get_var("SELECT city_id, ( 3959 * acos( cos( radians($lat) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians($lon) ) + sin( radians($lat) ) * sin( radians( lat ) ) ) ) AS distance FROM $multicity_db_table_name  ORDER BY distance");
		$sql = "SELECT * FROM $multicity_db_table_name WHERE city_id=$near_city_id";
		$city_info = $wpdb->get_results($sql);
		echo json_encode($city_info);
		
			
		}elseif($_REQUEST['list']=='all'){
			$sort_option = get_option('gt_app_loc_ord');
			
			if($sort_option=='az'){$sort_sql = "order by cityname asc, is_default desc";}
			else{$sort_sql = "order by sortorder asc, is_default desc";}
			
			$near_city_id = $wpdb->get_var("select city_id from $multicity_db_table_name where is_default=1");
			$sql = "SELECT * FROM $multicity_db_table_name $sort_sql";
			$city_info = $wpdb->get_results($sql);
			echo json_encode($city_info);}
		else{
			$near_city_id = $wpdb->get_var("select city_id from $multicity_db_table_name where is_default=1");
			$sql = "SELECT * FROM $multicity_db_table_name WHERE is_default=1";
			$city_info = $wpdb->get_results($sql);
		
			echo json_encode($city_info);			
			}


} // end api_get_city function
$lat = mysql_real_escape_string($_REQUEST['lat']);	
$lon = mysql_real_escape_string($_REQUEST['lon']);
api_get_city($lat,$lon);
}
############################################## END GET CITY INFO ####################################################################

############################################## GET CATEGORY INFO ####################################################################
if($_REQUEST['api']=='cat'){
global $wpdb;
function api_get_categorys($type,$cat_id,$city_id){
	global $wpdb;
	if($_REQUEST['list']=='all'){
		if($type=='blog'){$type='';}
	$args=array(
						  'orderby' => 'name',
						  'include' => $cat_id,
						  'hide_empty'=> 0,
						  //'parent'=>0,
						  'taxonomy'=> $type.'category',
						  
						  );
	$categories=get_categories($args);
	$data_arr=array();
	
				foreach($categories as $categories_obj)
				{ 
				//$term_icon = $categories_obj->term_icon;
				$term_icon_url = get_tax_meta($categories_obj->term_id,'ct_cat_icon');
				$term_icon = $term_icon_url['src'];
############### START STRIP ARRAY TO BASIC ################	
if($categories_obj->post_type=='post'){$categories_obj->post_type='blog';}
unset($categories_obj->term_icon);
unset($categories_obj->slug);
unset($categories_obj->term_group);
unset($categories_obj->term_taxonomy_id);
unset($categories_obj->taxonomy);
unset($categories_obj->cat_ID);
unset($categories_obj->category_count);
unset($categories_obj->cat_name);
unset($categories_obj->category_nicename);
unset($categories_obj->description);
###############  END STRIP ARRAY TO BASIC  ################	

$where ='';
if($type=='event'){
	
	$today = date('Y-m-d');
				$where .= " AND (p.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='end_date' and $wpdb->postmeta.meta_value>='".$today."')) ";
}

####### GET CAT COUNT #######
$post_count = '';
if($city_id)
			{
				$multi_city_id = mysql_real_escape_string ($city_id);
				if(!$cat_id){$cat_id=$categories_obj->term_id;}
				if($type==''){$type='post';}
				$term_id = mysql_real_escape_string ($cat_id);
								$sql = "select COUNT(*) from $wpdb->posts p join $wpdb->postmeta pm on pm.post_id=p.ID where p.post_status in ('publish') and p.post_type in ('$type') and (pm.meta_key='post_city_id' and (pm.meta_value in ($multi_city_id))) $search $where and p.ID in (select tr.object_id from $wpdb->term_relationships tr join $wpdb->term_taxonomy t on t.term_taxonomy_id=tr.term_taxonomy_id where t.term_id=\"$term_id\" )";
							//	echo $sql;
					$post_count = $wpdb->get_var($sql);
					$cat_id='';
				}else
			{
				$post_count = $categories_obj->count;
			}
			unset($categories_obj->count);
######### END CAT COUNT #####


	if($term_icon==''){$term_icon= get_bloginfo('template_directory').'/library/map/icons/pin.png';}
	 $new_arr = array('term_icon' => $term_icon, 'count' => $post_count );
	 $data_arr[] = array_merge((array)$categories_obj,(array)$new_arr);
				

				}
				
	echo json_encode($data_arr);			
	//print_r($categories);
	}
	
} // end api_get_categorys function
$type 	= mysql_real_escape_string($_REQUEST['type']);
$cat_id = mysql_real_escape_string($_REQUEST['cat_id']);
$city_id = mysql_real_escape_string($_REQUEST['city_id']);
api_get_categorys($type,$cat_id,$city_id);
}

############################################## END GET CATEGORY INFO ####################################################################

############################################## GET MARKER INFO ####################################################################
if($_REQUEST['api']=='mark'){
function api_get_markers($city_id,$cat_id,$post_type,$etype){
global $wpdb,$multicity_db_table_name;
$city_id = mysql_real_escape_string ($city_id);
	$i=0;
	if($cat_id != ''){	$map_cat_arr = $cat_id;}else{
if($post_type=='place'){$map_cat_arr = $wpdb->get_var("select categories from $multicity_db_table_name where city_id=$city_id");}
else{
	
	
	$categories=get_categories(array('orderby' => 'name','hide_empty'=> 0,'taxonomy'=> 'eventcategory'));
	$data_arr=array();
	
				foreach($categories as $categories_obj)
				{$data_arr[]=$categories_obj->term_id;}
				
				$map_cat_arr = implode(",", $data_arr);
				//print_r($map_cat_arr);
	
	}
	
	}
	//echo $map_cat_arr;exit;
	if(trim($map_cat_arr))
	{
		$map_cat_ids = $map_cat_arr;
		$catsql = "select c.*,tx.parent from $wpdb->terms c join $wpdb->term_taxonomy tx on tx.term_id=c.term_id  where c.term_id in ($map_cat_ids) and tx.taxonomy in ('placecategory','eventcategory') and count>0  order by tx.parent,c.name ";	
		//$catsql = "select c.* from $wpdb->terms c  where c.term_id in ($map_cat_ids) order by c.name";	
	}else
	{
		$catsql = "select c.* from $wpdb->terms c,$wpdb->term_taxonomy tt  where tt.term_id=c.term_id and tt.taxonomy in ('placecategory','eventcategory') and count>0  order by c.name";	
	}
	$catinfo = $wpdb->get_results($catsql);
	$cat_content_info = array();
	$cat_name_info = array();
	$post_type = "'$post_type'"; // set post tyle
	foreach ($catinfo as $catinfo_obj)
	{
		$term_id = $catinfo_obj->term_id;
		$name = $catinfo_obj->name;
		//$term_icon = $catinfo_obj->term_icon;
		$term_icon_url = get_tax_meta($term_id,'ct_cat_icon');
		$term_icon = $term_icon_url['src'];
		$parent = $catinfo_obj->parent;
		if(!$term_icon)
		{
			$term_icon = get_bloginfo('template_directory').'/library/map/icons/pin.png';
		}
		if($term_id)
		{		
##########################
$where ='';
if($_REQUEST['etype']=='past'){}else{$_REQUEST['etype']='upcoming';}
	if($_REQUEST['etype']=='upcoming')
			{
				$today = date('Y-m-d');
				$where .= " AND (p.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='end_date' and $wpdb->postmeta.meta_value>='".$today."')) ";
			}elseif($_REQUEST['etype']=='past')
			{
				$today = date('Y-m-d');
				$where .= " AND (p.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='end_date' and $wpdb->postmeta.meta_value<='".$today."')) ";
			}
			//echo $where;
############################
			$content_data = array();
			
			$search = '';
			if($_REQUEST['search']){$search = 'and p.post_title like"%'.mysql_real_escape_string($_REQUEST['search']).'%"';}
			//$post_type = "'post'";
			if($city_id)
			{
								$sql = "select p.* from $wpdb->posts p join $wpdb->postmeta pm on pm.post_id=p.ID where p.post_status in ('publish') and p.post_type in ($post_type) and (pm.meta_key='post_city_id' and pm.meta_value in ($city_id)) $search and p.ID in (select tr.object_id from $wpdb->term_relationships tr join $wpdb->term_taxonomy t on t.term_taxonomy_id=tr.term_taxonomy_id where t.term_id=\"$term_id\" ) $where";

				}else
			{
				$sql = "select p.* from $wpdb->posts p where p.post_type in ($post_type) and p.post_status in ('publish') and p.ID in (select tr.object_id from $wpdb->term_relationships tr join $wpdb->term_taxonomy t on t.term_taxonomy_id=tr.term_taxonomy_id where t.term_id=\"$term_id\" ) $where";
			}
			//echo $sql;exit;
			$postinfo = $wpdb->get_results($sql);
			//echo $sql;
		
			//echo json_encode($postinfo);
			//print_r($postinfo);
			$data_arr = array();
			if($postinfo)
			{
				$srcharr = array('"','\\');
				$replarr = array("&ldquo;",'');
				
				foreach($postinfo as $postinfo_obj)
				{ 
				$data_arr[] = $postinfo_obj;
					$ID = $postinfo_obj->ID;
					//$title = str_replace($srcharr,$replarr,htmlentities($postinfo_obj->post_title, ENT_COMPAT, 'UTF-8')); // fix by Stiofan
					$lat ='';
					$lng ='';
					$lat = htmlentities(get_post_meta($ID,'geo_latitude',true));
					$lng = htmlentities(get_post_meta($ID,'geo_longitude',true));
					$timing ='';
					##########################
						if($postinfo_obj->post_type=='event')
								{ //echo date('Y-m-d', strtotime($date));
										$timing = ' - '.date('D M j, Y', strtotime(get_post_meta($ID,'st_date',true)));			
										$timing .= ' - '.get_post_meta($ID,'st_time',true);			
								}
					############################
					
						
				
############### START STRIP ARRAY TO BASIC ################	
unset($postinfo_obj->post_date_gmt);
unset($postinfo_obj->post_excerpt);
unset($postinfo_obj->post_status);
unset($postinfo_obj->ping_status);
unset($postinfo_obj->post_password);
unset($postinfo_obj->post_name);
unset($postinfo_obj->to_ping);
unset($postinfo_obj->pinged);
unset($postinfo_obj->post_modified_gmt);
unset($postinfo_obj->post_content_filtered);
unset($postinfo_obj->post_parent);
unset($postinfo_obj->menu_order);
unset($postinfo_obj->post_mime_type);
unset($postinfo_obj->post_content);
unset($postinfo_obj->guid);
###############  END STRIP ARRAY TO BASIC  ################	
						
					
	 $new_arr = array( 'timing' => $timing, 'lat_pos' => $lat, 'long_pos' => $lng, 'icon' => $term_icon );
	 $post2[] = array_merge((array)$postinfo_obj,(array)$new_arr);
				//echo json_encode($post2);	
					
				}
				
			}
			
			
			}
			}// end foreach
			
echo json_encode($post2);	
} // end api_get_categorys function
$city_id= mysql_real_escape_string($_REQUEST['city_id']);
$cat_id = mysql_real_escape_string($_REQUEST['cat_id']);
$post_type = mysql_real_escape_string($_REQUEST['post_type']);
$etype= mysql_real_escape_string($_REQUEST['etype']);
api_get_markers($city_id,$cat_id,$post_type,$etype);
}

############################################## END GET MARKER INFO ####################################################################

############################################## GET SINGLE LISTING INFO ####################################################################
if($_REQUEST['api']=='single' && $_REQUEST['p_id'] ){
function api_single(){
global $wpdb,$wp_query,$post,$thumb_url;

$p_id = mysql_real_escape_string($_REQUEST['p_id']);

// The Query
$post_info = get_post( $p_id, ARRAY_A);
############### START STRIP ARRAY TO BASIC ################	
unset($post_info['post_date_gmt']);
unset($post_info['ancestors']); 
unset($post_info['filter']); 
unset($post_info['post_excerpt']); 
unset($post_info['post_status']); 
unset($post_info['ping_status']); 
unset($post_info['post_password']); 
unset($post_info['post_name']); 
unset($post_info['to_ping']); 
unset($post_info['pinged']); 
unset($post_info['post_modified_gmt']); 
unset($post_info['post_content_filtered']); 
unset($post_info['post_parent']); 
unset($post_info['menu_order']); 
unset($post_info['post_mime_type']); 
unset($post_info['guid']); 
###############  END STRIP ARRAY TO BASIC  ################ 
$post_info['post_content'] = strip_tags($post_info['post_content']);
$post_info['post_content'] = str_replace("&acute;","'",$post_info['post_content']);

	 // IMAGES
	 $thumb_url1 = $thumb_url.get_image_cutting_edge($args); 
	 $post_images = bdw_get_images($post_info['ID'],'large');
	   if(count($post_images)>0){
			for($im=0;$im<count($post_images);$im++){
					 $post_thumb[] =  get_bloginfo('template_url').'/thumb.php?src='.$post_images[$im].'&amp;w=300&amp;h=190&amp;zc=1&amp;q=80'.$thumb_url1;
			}}
				if(!$post_thumb){$post_thumb=get_bloginfo('template_url').'/images/no-image.jpg';}
	 
	// print_r($post_thumb);
		
	 // STAR RATING
	 $avg_rating = get_post_average_rating($post_info['ID']);
	 $star_rating = 0;
	if($avg_rating==0)							{$star_rating = 0;}
	if($avg_rating>=1 && $avg_rating<1.25 )		{$star_rating = 1;}
	if($avg_rating>=1.25 && $avg_rating<1.75 )	{$star_rating = 1.5;}
	if($avg_rating>=1.75 && $avg_rating<2.25 )	{$star_rating = 2;}
	if($avg_rating>=2.25 && $avg_rating<2.75 )	{$star_rating = 2.5;}
	if($avg_rating>=2.75 && $avg_rating<3.25 )	{$star_rating = 3;}
	if($avg_rating>=3.25 && $avg_rating<3.75 )	{$star_rating = 3.5;}
	if($avg_rating>=3.75 && $avg_rating<4.25 )	{$star_rating = 4;}
	if($avg_rating>=4.25 && $avg_rating<4.75 )	{$star_rating = 4.5;}
	if($avg_rating>=4.75 && $avg_rating<=5 )	{$star_rating = 5;}
	
	// IS POST FEATURED // returns 1 if featured
	$is_featured = get_post_meta($p_id,'is_featured',true);
	
	// ADDRESS
	$address = get_post_meta($post_info['ID'],'address',true);
	
	// LAT LON
	$lat= get_post_meta($post_info['ID'],'geo_latitude',true);
	$lon = get_post_meta($post_info['ID'],'geo_longitude',true);

	
	//WEBSITE
	if(get_post_meta($post_info['ID'],'website',true)){
			 $website = get_post_meta($post_info['ID'],'website',true);
			 if(!strstr($website,'http'))
			 {
				 $website = 'http://'.get_post_meta($post_info['ID'],'website',true);
			 }}else{ $website = '';}
	
	// TIMING
	$timing = get_post_meta($p_id,'timing',true);
	
	// PHONE NUMBER
	$phone = get_post_meta($post_info['ID'],'contact',true);
	
	// EMAIL 
	$email = get_post_meta($post_info['ID'],'email',true);
	
	// SOCIAL WEBSITES
	$twitter = get_post_meta($post_info['ID'],'twitter',true);
	$facebook = get_post_meta($post_info['ID'],'facebook',true);
	
	// OWNER VERIFIED
	$verified = get_post_meta($post_info['ID'],'claimed',true);
	
	// VIDEO
	$video = get_post_meta($post_info['ID'],'video',true);
	
	// LISTING SPECIAL
	$special = get_post_meta($post_info['ID'],'proprty_feature',true);

	$post_link = get_permalink( $post_info['ID'] );
	
	// POST CUSTOM FIELDS
	$custom_arr =array();
	$time_arr=array();
	$contact_arr=array();
	
	if($_REQUEST['custom']){
		$custom_arr =get_post_custom_fields_api($post_info['ID'],'{#TITLE#}: {#VALUE#}');
	}
	if($post_info['post_type']=='event'){
	$time_arr[]= __('Event Start').': '.date('D M j, Y', strtotime(get_post_meta($p_id ,'st_date',true))).' - '.get_post_meta($p_id ,'st_time',true);
	$time_arr[]= __('Event End').': '.date('D M j, Y', strtotime(get_post_meta($p_id ,'end_date',true))).' - '.get_post_meta($p_id ,'end_time',true);
	$custom_arr = array_merge((array)$time_arr,(array)$custom_arr);
	}
	
	//$contact_arr[]= __('Phone').': '.$phone;
	$contact_arr[]= __('Time').': '.$timing;
	$custom_arr = array_merge((array)$contact_arr,(array)$custom_arr);
	$custom_arr = array_filter($custom_arr);
	
	
	//print_r($custom_arr);
	// USER FAV
	if($_REQUEST['user_name']){
	$user = get_user_id_from_string($_REQUEST['user_name']);
	$user_fav_arr = get_user_meta($user, 'user_favourite_post', true);
	if(in_array($p_id, $user_fav_arr)){$fav = true;}else{$fav = false;}
	}else{$fav = false;}
	

	 $new_arr = array( 'post_link' => $post_link, 'images' => $post_thumb, 'star_rating' => $star_rating, 'featured' => $is_featured, 'address' => $address, 'website' => $website, 'lat' => $lat, 'lon' => $lon, 'timing' => $timing, 'phone' => $phone, 'email' => $email, 'twitter' => $twitter, 'facebook' => $facebook, 'verified' => $verified, 'video' => $video, 'special' => $special, 'custom' => $custom_arr, 'fav' => $fav );
	 $post_merge = array_merge((array)$post_info,(array)$new_arr);
if($_REQUEST['bla']){
//print_r($contact_arr);
print_r($post_merge);
}
		//print_r($post_merge);
	 echo json_encode($post_merge);




} // end api_listings function
api_single();
}
############################################## END SINGLE LISTING INFO ####################################################################
?>
<?php
############################################## GET COMMENTS INFO ####################################################################
if($_REQUEST['api']=='com' && $_REQUEST['p_id']){
function api_get_comments($type,$cat_id){
	global $post, $wp_query,$wpdb;
	$p_id = mysql_real_escape_string($_REQUEST['p_id']);

    $args = array(
        'post_id'       => $p_id,
        'status' => 'approve',
        'order'   => 'ASC'
    );
    $wp_comments = get_comments( $args );
	foreach ($wp_comments as $com_obj){
		 
		// AVATAR
		$avatar_raw = get_avatar( $com_obj->comment_author_email, 60, $template_path . ''.get_bloginfo('template_directory').'/images/gravatar.png' );
		$frst_image = preg_match_all( '|<img.*?src=[\'"](.*?)[\'"].*?>|i', $avatar_raw, $matches );
		$avatar = $matches[ 1 ][ 0 ];
		
		// COMMENT RATING
		$star_rating =  get_comment_rating_num($com_obj->comment_ID);
		
		// BUSINESS OWNER
		$post_auth_id = $wpdb->get_var("SELECT post_author FROM $wpdb->posts WHERE ID=$p_id");
		if($com_obj->user_id =$post_auth_id){$owner = 1;}else{$owner = '';}
		
		// REMOVE COMMENT IMAGE AND SEND TO ARRAY
		$com_cont = $com_obj->comment_content;
		unset($com_obj->comment_content);
		$com_img_arr='';
		$comment_image ='';
		$com_img_arr =  explode("[img]", $com_cont);
		if($com_img_arr[1]){$com_img_arr2 =  explode("[/img]", $com_img_arr[1]); $comment_image =  $com_img_arr2[0];}
		

		$comment_content = preg_replace('#(\\[img\\]).+(\\[\\/img\\])#', '', $com_cont);
		 
		 
		 
		 $new_arr = array( 'comment_content' => $comment_content,'avatar' => $avatar, 'star_rating' => $star_rating, 'owner' => $owner, 'comment_image' => $comment_image);
	   	 $comment_merge = array_merge((array)$com_obj,(array)$new_arr);
		 
		$comment_merge_arr[] = $comment_merge;
	
	}
	//print_r($comment_merge_arr);
	echo json_encode($comment_merge_arr);

	
} // end api_get_commentsfunction
api_get_comments();
}

############################################## END GET COMMENTS INFO ####################################################################



############################################## GET LISTINGS START ####################################################################
if($_REQUEST['api']=='list'){
function api_get_markers($city_id,$cat_id,$post_type,$etype){
global $wpdb,$multicity_db_table_name,$table_prefix,$per_page;
$city_id = mysql_real_escape_string ($city_id);
	$i=0;
	if($cat_id != ''){	$map_cat_arr = $cat_id;}else{
if($post_type=='place'){$map_cat_arr = $wpdb->get_var("select categories from $multicity_db_table_name where city_id=$city_id");}
elseif($post_type=='event'){
	
	
	$categories=get_categories(array('orderby' => 'name','hide_empty'=> 0,'taxonomy'=> 'eventcategory'));
	$data_arr=array();
	
				foreach($categories as $categories_obj)
				{$data_arr[]=$categories_obj->term_id;}
				
				$map_cat_arr = implode(",", $data_arr);
				//print_r($map_cat_arr);
	
	}elseif($post_type=='blog'){
	
	
	$categories=get_categories(array('orderby' => 'name','hide_empty'=> 0,'taxonomy'=> 'category'));
	$data_arr=array();
	
				foreach($categories as $categories_obj)
				{$data_arr[]=$categories_obj->term_id;}
				
				$map_cat_arr = implode(",", $data_arr);
				//print_r($map_cat_arr);
	
	}}
	//echo $map_cat_arr;exit;
	if(trim($map_cat_arr))
	{
		$map_cat_ids = $map_cat_arr;
		$catsql = "select c.*,tx.parent from $wpdb->terms c join $wpdb->term_taxonomy tx on tx.term_id=c.term_id  where c.term_id in ($map_cat_ids) and tx.taxonomy in ('placecategory','eventcategory','category') and count>0 GROUP BY c.term_id order by tx.parent,c.name ";	
		//$catsql = "select c.* from $wpdb->terms c  where c.term_id in ($map_cat_ids) order by c.name";	
	}else
	{
		$catsql = "select c.* from $wpdb->terms c,$wpdb->term_taxonomy tt  where tt.term_id=c.term_id and tt.taxonomy in ('placecategory','eventcategory','category') and count>0 GROUP BY c.term_id order by c.name";	
	}
	//echo $catsql.'###';
	$catinfo = $wpdb->get_results($catsql);
	$cat_content_info = array();
	$cat_name_info = array();
	if($post_type=='blog'){$post_type='post';}$post_type = "'$post_type'"; // SET POST TYPE
	//print_r($catinfo);
	foreach ($catinfo as $catinfo_obj)
	{   
		$term_id = $catinfo_obj->term_id;
		$name = $catinfo_obj->name;
		//$term_icon = $catinfo_obj->term_icon;
		$term_icon_url = get_tax_meta($term_id,'ct_cat_icon');
		$term_icon = $term_icon_url['src'];
		$parent = $catinfo_obj->parent;
		if(!$term_icon)
		{
			$term_icon = get_bloginfo('template_directory').'/library/map/icons/pin.png';
		}
		if($term_id)
		{		
##########################
$where ='';
if($_REQUEST['type']=='event'){
	
	$today = date('Y-m-d');
				$where .= " AND (p.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='end_date' and $wpdb->postmeta.meta_value>='".$today."')) ";
}


	if($_REQUEST['etype']=='upcoming')
			{
				$today = date('Y-m-d');
				$where .= " AND (p.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='end_date' and $wpdb->postmeta.meta_value>='".$today."')) ";
			}elseif($_REQUEST['etype']=='past')
			{
				$today = date('Y-m-d');
				$where .= " AND (p.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='end_date' and $wpdb->postmeta.meta_value<='".$today."')) ";
			}
			//echo $where;
############################
$join = " join $wpdb->postmeta pm on pm.post_id=p.ID ";

#########################################
############ ORDER BY ###################
#########################################

$orderby ="ORDER BY (select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=p.ID and $wpdb->postmeta.meta_key like \"is_featured\" )+0 desc, p.post_date DESC";
$ratings_table = $table_prefix.'ratings';
$sort_key = mysql_real_escape_string($_REQUEST['sort']);
if($sort_key=='rating'){								   
$orderby = "ORDER BY (select avg(rt.rating_rating) as rating_counter from $ratings_table as rt where rt.comment_id in (select cm.comment_ID from $wpdb->comments cm where cm.comment_post_ID=p.ID and cm.comment_approved=1)) desc, comment_count desc";}
elseif($sort_key=='review'){$orderby = "ORDER BY comment_count desc";}
elseif($sort_key=='distance'){
$dist =25000; //  Distance 
$mylat=mysql_real_escape_string($_REQUEST['lat']);//  Latatude 
$mylon=mysql_real_escape_string($_REQUEST['lon']);//  Distance	
$lon1 = $mylon- $dist/abs(cos(deg2rad($mylat))*69); 
$lon2 = $mylon+$dist/abs(cos(deg2rad($mylat))*69);
$lat1 = $mylat-($dist/69);
$lat2 = $mylat+($dist/69);

//$join .= " join (SELECT *, (3956 * 2 * ASIN(SQRT( POWER(SIN(($mylat - ABS(z.LAT)) * pi()/180 / 2), 2) +COS($mylat * pi()/180) * COS( ABS(z.LAT) * pi()/180) *POWER(SIN(($mylon - z.LON) * pi()/180 / 2), 2) )))as distance FROM (SELECT a.post_id , a.meta_key AS 'meta1', b.meta_key AS 'meta2' , a.meta_value AS 'LAT',b.meta_value AS 'LON' FROM $wpdb->postmeta a, $wpdb->postmeta b WHERE a.meta_key='geo_latitude' AND b.meta_key='geo_longitude' AND a.post_id=b.post_id AND b.meta_value between $lon1 and $lon2 AND a.meta_value between $lat1 and $lat2) z) AS z ON (z.post_id = p.ID)   ";
$join .= " join (SELECT *, (3956 * 2 * ASIN(SQRT( POWER(SIN(($mylat - z.LAT) * pi()/180 / 2), 2) +COS($mylat * pi()/180) * COS( z.LAT * pi()/180) *POWER(SIN(($mylon - z.LON) * pi()/180 / 2), 2) )))as distance FROM (SELECT a.post_id , a.meta_key AS 'meta1', b.meta_key AS 'meta2' , a.meta_value AS 'LAT',b.meta_value AS 'LON' FROM $wpdb->postmeta a, $wpdb->postmeta b WHERE a.meta_key='geo_latitude' AND b.meta_key='geo_longitude' AND a.post_id=b.post_id AND b.meta_value between $lon1 and $lon2 AND a.meta_value between $lat1 and $lat2) z) AS z ON (z.post_id = p.ID)   ";
	
	$orderby = "ORDER BY distance";}
	
#########################################
############ LIMIT ######################
#########################################
$limit ='';
$pageing = mysql_real_escape_string($_REQUEST['page']);
$on_page = $pageing * $per_page;
$limit =' LIMIT '.$on_page.', '.$per_page;
											  
#########################################
			$content_data = array();
			$search = '';
			if($_REQUEST['search']){$search = 'and p.post_title like"%'.mysql_real_escape_string($_REQUEST['search']).'%"';}
			//$post_type = "'post'";
			if($city_id)
			{
								$sql = "select p.* from $wpdb->posts p $join where p.post_status in ('publish') and p.post_type in ($post_type) and (pm.meta_key='post_city_id' and pm.meta_value in ($city_id)) $search and p.ID in (select tr.object_id from $wpdb->term_relationships tr join $wpdb->term_taxonomy t on t.term_taxonomy_id=tr.term_taxonomy_id where t.term_id=\"$term_id\" ) $where GROUP BY p.ID $orderby $limit"; 

				}else
			{
				$sql = "select p.* from $wpdb->posts p $join where p.post_type in ($post_type) and p.post_status in ('publish') $search and p.ID in (select tr.object_id from $wpdb->term_relationships tr join $wpdb->term_taxonomy t on t.term_taxonomy_id=tr.term_taxonomy_id where t.term_id=\"$term_id\" ) $where GROUP BY p.ID $orderby $limit";
			}
			//echo $sql;exit;
			$postinfo = $wpdb->get_results($sql);
			if($_REQUEST['debug']){echo $sql;}
		
			//echo json_encode($postinfo);
			//print_r($postinfo);
			$data_arr = array();
			if($postinfo)
			{
				$srcharr = array('"','\\');
				$replarr = array("&ldquo;",'');
				
				foreach($postinfo as $postinfo_obj)
				{ 
				$data_arr[] = $postinfo_obj;
					$ID = $postinfo_obj->ID;
					//$title = str_replace($srcharr,$replarr,htmlentities($postinfo_obj->post_title, ENT_COMPAT, 'UTF-8')); // fix by Stiofan
					$lat ='';
					$lng ='';
					$lat = htmlentities(get_post_meta($ID,'geo_latitude',true));
					$lng = htmlentities(get_post_meta($ID,'geo_longitude',true));
					$timing ='';
					##########################
						if($postinfo_obj->post_type=='event')
								{ //echo date('Y-m-d', strtotime($date));
										$timing = ' - '.date('D M j, Y', strtotime(get_post_meta($ID,'st_date',true)));			
										$timing .= ' - '.get_post_meta($ID,'st_time',true);			
								}
					############################
					
						
				
############### START STRIP ARRAY TO BASIC ################	
unset($postinfo_obj->post_date_gmt);
unset($postinfo_obj->post_excerpt);
unset($postinfo_obj->post_status);
unset($postinfo_obj->ping_status);
unset($postinfo_obj->post_password);
unset($postinfo_obj->post_name);
unset($postinfo_obj->to_ping);
unset($postinfo_obj->pinged);
unset($postinfo_obj->post_modified_gmt);
unset($postinfo_obj->post_content_filtered);
unset($postinfo_obj->post_parent);
unset($postinfo_obj->menu_order);
unset($postinfo_obj->post_mime_type);
unset($postinfo_obj->post_content);
unset($postinfo_obj->guid);
###############  END STRIP ARRAY TO BASIC  ################	
// IS POST FEATURED // returns 1 if featured
	$is_featured = get_post_meta($ID,'is_featured',true);
	
	// ADDRESS
	$address_raw ='';
	$address_raw = get_post_meta($ID,'address',true);
	if($postinfo_obj->post_type=='event'){
		$timing_raw = date('D M j, Y', strtotime(get_post_meta($ID,'st_date',true))).' - '.get_post_meta($ID,'st_time',true).'
'.$address_raw;
		$address_raw = $timing_raw; 
		}
	$address = str_replace("&acute;","'",$address_raw);
	
	// THUMB IMAGE
	 $thumb_url1 = $thumb_url.get_image_cutting_edge($args); 
	 $post_images = bdw_get_images($ID,'large');
	 //print_r($post_images);
	 if(!$post_images[0]){
		 $cat_default_img = get_tax_meta($term_id,'ct_cat_default_img');
		 $post_images[0] = $cat_default_img['src'];
		 if(!$post_images[0]){$post_images[0] = get_bloginfo('template_url').'/images/no-image.jpg';}
		 	 }
	 $post_thumb =  get_bloginfo('template_url').'/thumb.php?src='.$post_images[0].'&amp;w=158&amp;h=105&amp;zc=1&amp;q=80'.$thumb_url1;
	 // DISTANCE
	 $distance = '';
	 if($_REQUEST['sort']=='distance'){
		 $startPoint = array( 'latitude'=> $mylat,'longitude'=> $mylon);
		 $endPoint = array( 'latitude'	=> $lat,'longitude'	=> $lng);
		 //print_r($endPoint);
		 $uom = get_option('search_dist_1');
$distance = calculateDistanceFromLatLong ($startPoint,$endPoint,$uom);
//echo $distance.'###';
if (round($distance,2) == 0){
$uom = get_option('search_dist_2');
$distance = calculateDistanceFromLatLong ($startPoint,$endPoint,$uom);
$distance = round($distance).' '.$uom;
}else{
$distance = round($distance,2).' '.$uom;
}
	 }
	 
	 
	 
	 // STAR RATING
	 $avg_rating = get_post_average_rating($ID);
	 $star_rating = 0;
	if($avg_rating==0)							{$star_rating = 0;}
	if($avg_rating>=1 && $avg_rating<1.25 )		{$star_rating = 1;}
	if($avg_rating>=1.25 && $avg_rating<1.75 )	{$star_rating = 1.5;}
	if($avg_rating>=1.75 && $avg_rating<2.25 )	{$star_rating = 2;}
	if($avg_rating>=2.25 && $avg_rating<2.75 )	{$star_rating = 2.5;}
	if($avg_rating>=2.75 && $avg_rating<3.25 )	{$star_rating = 3;}
	if($avg_rating>=3.25 && $avg_rating<3.75 )	{$star_rating = 3.5;}
	if($avg_rating>=3.75 && $avg_rating<4.25 )	{$star_rating = 4;}
	if($avg_rating>=4.25 && $avg_rating<4.75 )	{$star_rating = 4.5;}
	if($avg_rating>=4.75 && $avg_rating<=5 )	{$star_rating = 5;}

						
	 $new_arr = array('thumb' => $post_thumb,'star_rating' => $star_rating,'timing' => $timing, 'lat_pos' => $lat, 'long_pos' => $lng, 'icon' => $term_icon, 'featured' => $is_featured, 'address' => $address, 'distance' => $distance );
	 $post2[] = array_merge((array)$postinfo_obj,(array)$new_arr);
				//echo json_encode($post2);	
					
				}
				
			}
			
			
			}
			}// end foreach
		
//echo json_encode($post2, JSON_UNESCAPED_UNICODE);	
echo json_encode($post2);	
} // end api_get_categorys function
$city_id= mysql_real_escape_string($_REQUEST['city_id']);
$cat_id = mysql_real_escape_string($_REQUEST['cat_id']);
$post_type = mysql_real_escape_string($_REQUEST['type']);
$etype= mysql_real_escape_string($_REQUEST['etype']);
api_get_markers($city_id,$cat_id,$post_type,$etype);
}

############################################## END GET LISTINGS ####################################################################

/*
############################################## GET HOME LISTING INFO ####################################################################
if($_REQUEST['api']=='home'){
function api_home_listings($city_id,$cat_id,$post_type,$etype){
global $wpdb,$multicity_db_table_name,$table_prefix,$per_page;
$city_id = mysql_real_escape_string ($city_id);
	$i=0;
	$post_type='place';
	if($cat_id != ''){	$map_cat_arr = $cat_id;}else{
if($post_type=='place'){$map_cat_arr = $wpdb->get_var("select categories from $multicity_db_table_name where city_id=$city_id");}
else{
	
	
	$categories=get_categories(array('orderby' => 'name','hide_empty'=> 0,'taxonomy'=> 'eventcategory'));
	$data_arr=array();
	
				foreach($categories as $categories_obj)
				{$data_arr[]=$categories_obj->term_id;}
				
				$map_cat_arr = implode(",", $data_arr);
				//print_r($map_cat_arr);
	
	}
	
	}
	//echo $map_cat_arr;exit;
	if(trim($map_cat_arr))
	{
		$map_cat_ids = $map_cat_arr;
		$catsql = "select c.*,tx.parent from $wpdb->terms c join $wpdb->term_taxonomy tx on tx.term_id=c.term_id  where c.term_id in ($map_cat_ids) and tx.taxonomy in ('placecategory','eventcategory') and count>0 GROUP BY c.term_id order by tx.parent,c.name ";	
		//$catsql = "select c.* from $wpdb->terms c  where c.term_id in ($map_cat_ids) order by c.name";	
	}else
	{
		$catsql = "select c.* from $wpdb->terms c,$wpdb->term_taxonomy tt  where tt.term_id=c.term_id and tt.taxonomy in ('placecategory','eventcategory') and count>0 GROUP BY c.term_id order by c.name";	
	}
	$catinfo = $wpdb->get_results($catsql);
	$cat_content_info = array();
	$cat_name_info = array();
	$post_type = "'$post_type'"; // SET POST TYPE
	foreach ($catinfo as $catinfo_obj)
	{
		$term_id = $catinfo_obj->term_id;
		$name = $catinfo_obj->name;
		//$term_icon = $catinfo_obj->term_icon;
		$term_icon_url = get_tax_meta($term_id,'ct_cat_icon');
		$term_icon = $term_icon_url['src'];
		$parent = $catinfo_obj->parent;
		if(!$term_icon)
		{
			$term_icon = get_bloginfo('template_directory').'/library/map/icons/pin.png';
		}
		if($term_id)
		{		
##########################
$where ='';
	if($_REQUEST['etype']=='upcoming')
			{
				$today = date('Y-m-d');
				$where .= " AND (p.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='end_date' and $wpdb->postmeta.meta_value>='".$today."')) ";
			}elseif($_REQUEST['etype']=='past')
			{
				$today = date('Y-m-d');
				$where .= " AND (p.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='end_date' and $wpdb->postmeta.meta_value<='".$today."')) ";
			}
			//echo $where;
############################
$join = " join $wpdb->postmeta pm on pm.post_id=p.ID ";

#########################################
############ ORDER BY ###################
#########################################
$orderby ='';
$ratings_table = $table_prefix.'ratings';
$sort_key = mysql_real_escape_string($_REQUEST['sort']);
if($sort_key=='rating'){								   
$orderby = "ORDER BY (select avg(rt.rating_rating) as rating_counter from $ratings_table as rt where rt.comment_id in (select cm.comment_ID from $wpdb->comments cm where cm.comment_post_ID=p.ID and cm.comment_approved=1)) desc, comment_count desc";}
elseif($sort_key=='review'){$orderby = "ORDER BY comment_count desc";}
elseif($sort_key=='distance'){
$dist =25000; //  Distance 
$mylat=mysql_real_escape_string($_REQUEST['lat']);//  Latatude 
$mylon=mysql_real_escape_string($_REQUEST['lon']);//  Distance	
$lon1 = $mylon- $dist/abs(cos(deg2rad($mylat))*69); 
$lon2 = $mylon+$dist/abs(cos(deg2rad($mylat))*69);
$lat1 = $mylat-($dist/69);
$lat2 = $mylat+($dist/69);

$join .= " join (SELECT *, (3956 * 2 * ASIN(SQRT( POWER(SIN(($mylat - ABS(z.LAT)) * pi()/180 / 2), 2) +COS($mylat * pi()/180) * COS( ABS(z.LAT) * pi()/180) *POWER(SIN(($mylon - z.LON) * pi()/180 / 2), 2) )))as distance FROM (SELECT a.post_id , a.meta_key AS 'meta1', b.meta_key AS 'meta2' , a.meta_value AS 'LAT',b.meta_value AS 'LON' FROM $wpdb->postmeta a, $wpdb->postmeta b WHERE a.meta_key='geo_latitude' AND b.meta_key='geo_longitude' AND a.post_id=b.post_id AND b.meta_value between $lon1 and $lon2 AND a.meta_value between $lat1 and $lat2) z) AS z ON (z.post_id = p.ID)   ";
	
	$orderby = "ORDER BY distance";}
	
#########################################
############ LIMIT ######################
#########################################
$limit ='';
$pageing = mysql_real_escape_string($_REQUEST['page']);
$on_page = $pageing * $per_page;
$limit =' LIMIT '.$on_page.', '.$per_page;
											  
#########################################
			$content_data = array();
			
			$search = '';
			if($_REQUEST['search']){$search = 'and p.post_title like"%'.mysql_real_escape_string($_REQUEST['search']).'%"';}
			//$post_type = "'post'";
			if($city_id)
			{
								$sql = "select p.* from $wpdb->posts p $join where p.post_status in ('publish') and p.post_type in ($post_type) and (pm.meta_key='post_city_id' and pm.meta_value in ($city_id)) $search and p.ID in (select tr.object_id from $wpdb->term_relationships tr join $wpdb->term_taxonomy t on t.term_taxonomy_id=tr.term_taxonomy_id where t.term_id=\"$term_id\" ) $where $orderby $limit";

				}else
			{
				$sql = "select p.* from $wpdb->posts p $join where p.post_type in ($post_type) and p.post_status in ('publish') and p.ID in (select tr.object_id from $wpdb->term_relationships tr join $wpdb->term_taxonomy t on t.term_taxonomy_id=tr.term_taxonomy_id where t.term_id=\"$term_id\" ) $where $orderby $limit";
			}
			//echo $sql;exit;
			$postinfo = $wpdb->get_results($sql);
			//echo $sql;
		
			//echo json_encode($postinfo);
			//print_r($postinfo);
			$data_arr = array();
			if($postinfo)
			{
				$srcharr = array('"','\\');
				$replarr = array("&ldquo;",'');
				
				foreach($postinfo as $postinfo_obj)
				{ 
				$data_arr[] = $postinfo_obj;
					$ID = $postinfo_obj->ID;
					//$title = str_replace($srcharr,$replarr,htmlentities($postinfo_obj->post_title, ENT_COMPAT, 'UTF-8')); // fix by Stiofan
					$lat ='';
					$lng ='';
					$lat = htmlentities(get_post_meta($ID,'geo_latitude',true));
					$lng = htmlentities(get_post_meta($ID,'geo_longitude',true));
					$timing ='';
					##########################
						if($postinfo_obj->post_type=='event')
								{ //echo date('Y-m-d', strtotime($date));
										$timing = ' - '.date('D M j, Y', strtotime(get_post_meta($ID,'st_date',true)));			
										$timing .= ' - '.get_post_meta($ID,'st_time',true);			
								}
					############################
					
						
				
############### START STRIP ARRAY TO BASIC ################	
unset($postinfo_obj->post_date_gmt);
unset($postinfo_obj->post_excerpt);
unset($postinfo_obj->post_status);
unset($postinfo_obj->ping_status);
unset($postinfo_obj->post_password);
unset($postinfo_obj->post_name);
unset($postinfo_obj->to_ping);
unset($postinfo_obj->pinged);
unset($postinfo_obj->post_modified_gmt);
unset($postinfo_obj->post_content_filtered);
unset($postinfo_obj->post_parent);
unset($postinfo_obj->menu_order);
unset($postinfo_obj->post_mime_type);
unset($postinfo_obj->post_content);
unset($postinfo_obj->guid);
###############  END STRIP ARRAY TO BASIC  ################	
// IS POST FEATURED // returns 1 if featured
	$is_featured = get_post_meta($ID,'is_featured',true);
	
	// ADDRESS
	$address = get_post_meta($ID,'address',true);
	
	// THUMB IMAGE
	 $thumb_url1 = $thumb_url.get_image_cutting_edge($args); 
	 $post_images = bdw_get_images($ID,'large');
	 $post_thumb =  get_bloginfo('template_url').'/thumb.php?src='.$post_images[0].'&amp;w=158&amp;h=105&amp;zc=1&amp;q=80'.$thumb_url1;
	 
	 // DISTANCE
	 $distance = '';
	 if($_REQUEST['sort']=='distance'){
		 $startPoint = array( 'latitude'=> $mylat,'longitude'=> $mylon);
		 $endPoint = array( 'latitude'	=> $lat,'longitude'	=> $lng);
		 $uom = get_option('search_dist_1');
$distance = calculateDistanceFromLatLong ($startPoint,$endPoint,$uom);
if (round($distance,2) == 0){
$uom = get_option('search_dist_2');
$distance = calculateDistanceFromLatLong ($startPoint,$endPoint,$uom);
$distance = round($distance).' '.$uom;
}else{
$distance = round($distance,2).' '.$uom;
}
	 }
	 
	 // STAR RATING
	 $avg_rating = get_post_average_rating($ID);
	 $star_rating = 0;
	if($avg_rating==0)							{$star_rating = 0;}
	if($avg_rating>=1 && $avg_rating<1.25 )		{$star_rating = 1;}
	if($avg_rating>=1.25 && $avg_rating<1.75 )	{$star_rating = 1.5;}
	if($avg_rating>=1.75 && $avg_rating<2.25 )	{$star_rating = 2;}
	if($avg_rating>=2.25 && $avg_rating<2.75 )	{$star_rating = 2.5;}
	if($avg_rating>=2.75 && $avg_rating<3.25 )	{$star_rating = 3;}
	if($avg_rating>=3.25 && $avg_rating<3.75 )	{$star_rating = 3.5;}
	if($avg_rating>=3.75 && $avg_rating<4.25 )	{$star_rating = 4;}
	if($avg_rating>=4.25 && $avg_rating<4.75 )	{$star_rating = 4.5;}
	if($avg_rating>=4.75 && $avg_rating<=5 )	{$star_rating = 5;}

						
					
	 $new_arr = array('thumb' => $post_thumb,'star_rating' => $star_rating,'timing' => $timing, 'lat_pos' => $lat, 'long_pos' => $lng, 'icon' => $term_icon, 'featured' => $is_featured, 'address' => $address, 'distance' => $distance );
	 $post2[] = array_merge((array)$postinfo_obj,(array)$new_arr);
				//echo json_encode($post2);	
					
				}
				
			}
			
			
			}
			}// end foreach
			
echo json_encode($post2);	
} // end api_get_categorys function
$city_id= mysql_real_escape_string($_REQUEST['city_id']);
$cat_id = mysql_real_escape_string($_REQUEST['cat_id']);
$post_type = mysql_real_escape_string($_REQUEST['type']);
$etype= mysql_real_escape_string($_REQUEST['etype']);
api_home_listings($city_id,$cat_id,$post_type,$etype);
}
############################################## END HOME2 LISTING INFO ####################################################################
*/



############################################## GET HOME LISTING INFO ####################################################################
//?api=home&city_id=1&sort=&search=&page=0&user_name=admin
if($_REQUEST['api']=='home'){
function api_home_listings($city_id,$cat_id,$post_type,$etype){
global $wpdb,$multicity_db_table_name,$table_prefix,$per_page;

// GET USER ID
$user_id = get_user_id_from_string($_REQUEST['user_name']);
if(!$user_id){echo json_encode(array('user_fav'=>false, 'msg'=>'You must login / register'));exit;}

// GET USER FAV ARRAY
$user_fav_arr = get_user_meta($user_id, 'user_favourite_post', true);
if(!is_array($user_fav_arr)){echo json_encode(array('user_fav'=>false, 'msg'=>'No Favourites'));exit;}

// CONVERT ARRAY TO CSV
$user_fav = implode(",", $user_fav_arr);


$city_id = mysql_real_escape_string ($city_id);


//	foreach ($catinfo as $catinfo_obj){
		//$term_id = $catinfo_obj->term_id;
		//$name = $catinfo_obj->name;
		//$term_icon = $catinfo_obj->term_icon;
		///$term_icon_url = get_tax_meta($term_id,'ct_cat_icon');
		//$term_icon = $term_icon_url['src'];
		//$parent = $catinfo_obj->parent;
		
		if(!$term_icon)
		{
			$term_icon = get_bloginfo('template_directory').'/library/map/icons/pin.png';
		}
	//	if($term_id){		
##########################
$where ='';
	if($_REQUEST['etype']=='upcoming')
			{
				$today = date('Y-m-d');
				$where .= " AND (p.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='end_date' and $wpdb->postmeta.meta_value>='".$today."')) ";
			}elseif($_REQUEST['etype']=='past')
			{
				$today = date('Y-m-d');
				$where .= " AND (p.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='end_date' and $wpdb->postmeta.meta_value<='".$today."')) ";
			}
			//echo $where;
############################
$join = " join $wpdb->postmeta pm on pm.post_id=p.ID ";

#########################################
############ ORDER BY ###################
#########################################
$orderby ='';
$ratings_table = $table_prefix.'ratings';
$sort_key = mysql_real_escape_string($_REQUEST['sort']);
if($sort_key=='rating'){								   
$orderby = "ORDER BY (select avg(rt.rating_rating) as rating_counter from $ratings_table as rt where rt.comment_id in (select cm.comment_ID from $wpdb->comments cm where cm.comment_post_ID=p.ID and cm.comment_approved=1)) desc, comment_count desc";}
elseif($sort_key=='review'){$orderby = "ORDER BY comment_count desc";}
elseif($sort_key=='distance'){
$dist =25000; //  Distance 
$mylat=mysql_real_escape_string($_REQUEST['lat']);//  Latatude 
$mylon=mysql_real_escape_string($_REQUEST['lon']);//  Distance	
$lon1 = $mylon- $dist/abs(cos(deg2rad($mylat))*69); 
$lon2 = $mylon+$dist/abs(cos(deg2rad($mylat))*69);
$lat1 = $mylat-($dist/69);
$lat2 = $mylat+($dist/69);

$join .= " join (SELECT *, (3956 * 2 * ASIN(SQRT( POWER(SIN(($mylat - ABS(z.LAT)) * pi()/180 / 2), 2) +COS($mylat * pi()/180) * COS( ABS(z.LAT) * pi()/180) *POWER(SIN(($mylon - z.LON) * pi()/180 / 2), 2) )))as distance FROM (SELECT a.post_id , a.meta_key AS 'meta1', b.meta_key AS 'meta2' , a.meta_value AS 'LAT',b.meta_value AS 'LON' FROM $wpdb->postmeta a, $wpdb->postmeta b WHERE a.meta_key='geo_latitude' AND b.meta_key='geo_longitude' AND a.post_id=b.post_id AND b.meta_value between $lon1 and $lon2 AND a.meta_value between $lat1 and $lat2) z) AS z ON (z.post_id = p.ID)   ";
	
	$orderby = "ORDER BY distance";}
	
#########################################
############ LIMIT ######################
#########################################
$limit ='';
$pageing = mysql_real_escape_string($_REQUEST['page']);
$on_page = $pageing * $per_page;
$limit =' LIMIT '.$on_page.', '.$per_page;
											  
#########################################
			$content_data = array();
			
			$search = '';
			if($_REQUEST['search']){$search = 'and p.post_title like"%'.mysql_real_escape_string($_REQUEST['search']).'%"';}
			//$post_type = "'post'";
			if($city_id)
			{
								$sql = "select p.* from $wpdb->posts p $join where p.post_status in ('publish')  AND p.ID in ($user_fav) and (pm.meta_key='post_city_id' and pm.meta_value in ($city_id)) $search  $where GROUP BY p.ID $orderby $limit";

				}else
			{
				$sql = "select p.* from $wpdb->posts p $join where  p.ID in ($user_fav)  and p.post_status in ('publish')  $where GROUP BY p.ID $orderby $limit";
			}
			//echo $sql;exit;
			$postinfo = $wpdb->get_results($sql);
			//echo $sql;
		
			//echo json_encode($postinfo);
			//print_r($postinfo);
			$data_arr = array();
			if($postinfo)
			{	
				$srcharr = array('"','\\');
				$replarr = array("&ldquo;",'');
				//$postinfo  = array_unique($postinfo);
				foreach($postinfo as $postinfo_obj)
				{ 
				
				if (!in_array($postinfo_obj->ID, $post_id_arr)) {
				$post_id_arr[]=$postinfo_obj->ID;
				$data_arr[] = $postinfo_obj;
					$ID = $postinfo_obj->ID;
					//$title = str_replace($srcharr,$replarr,htmlentities($postinfo_obj->post_title, ENT_COMPAT, 'UTF-8')); // fix by Stiofan
					$lat ='';
					$lng ='';
					$lat = htmlentities(get_post_meta($ID,'geo_latitude',true));
					$lng = htmlentities(get_post_meta($ID,'geo_longitude',true));
					$timing ='';
					##########################
						if($postinfo_obj->post_type=='event')
								{ //echo date('Y-m-d', strtotime($date));
										$timing = ' - '.date('D M j, Y', strtotime(get_post_meta($ID,'st_date',true)));			
										$timing .= ' - '.get_post_meta($ID,'st_time',true);			
								}
					############################
					
					// get cat icon
					//$term_icon = get_post_cat_icon($ID,  $postinfo_obj->post_type);
					
					$cat_id_arr = get_the_terms( $ID,  $postinfo_obj->post_type.'category' );
					$term_icon = get_cat_icon($cat_id_arr[0]->term_id);
					
				
############### START STRIP ARRAY TO BASIC ################	
unset($postinfo_obj->post_date_gmt);
unset($postinfo_obj->post_excerpt);
unset($postinfo_obj->post_status);
unset($postinfo_obj->ping_status);
unset($postinfo_obj->post_password);
unset($postinfo_obj->post_name);
unset($postinfo_obj->to_ping);
unset($postinfo_obj->pinged);
unset($postinfo_obj->post_modified_gmt);
unset($postinfo_obj->post_content_filtered);
unset($postinfo_obj->post_parent);
unset($postinfo_obj->menu_order);
unset($postinfo_obj->post_mime_type);
unset($postinfo_obj->post_content);
unset($postinfo_obj->guid);
###############  END STRIP ARRAY TO BASIC  ################	
// IS POST FEATURED // returns 1 if featured
	$is_featured = get_post_meta($ID,'is_featured',true);
		
	// ADDRESS
	$address_raw ='';
	$address_raw = get_post_meta($ID,'address',true);
	if($postinfo_obj->post_type=='event'){
		$timing_raw = date('D M j, Y', strtotime(get_post_meta($ID,'st_date',true))).' - '.get_post_meta($ID,'st_time',true).'
'.$address_raw;
		$address_raw = $timing_raw; 
		}
	$address = str_replace("&acute;","'",$address_raw);
	
	
	 // THUMB IMAGE
	 $thumb_url1 = $thumb_url.get_image_cutting_edge($args); 
	 $post_images = bdw_get_images($ID,'large');
	 if(!$post_images[0]){
		 $cat_default_img = get_tax_meta($cat_id_arr[0]->term_id,'ct_cat_default_img');
		 $post_images[0] = $cat_default_img['src'];
		 if(!$post_images[0]){$post_images[0] = get_bloginfo('template_url').'/images/no-image.jpg';}
		 	 }
	 $post_thumb =  get_bloginfo('template_url').'/thumb.php?src='.$post_images[0].'&amp;w=158&amp;h=105&amp;zc=1&amp;q=80'.$thumb_url1;
	 
	 // DISTANCE
	 $distance = '';
	 if($_REQUEST['sort']=='distance'){
		 $startPoint = array( 'latitude'=> $mylat,'longitude'=> $mylon);
		 $endPoint = array( 'latitude'	=> $lat,'longitude'	=> $lng);
		 $uom = get_option('search_dist_1');
$distance = calculateDistanceFromLatLong ($startPoint,$endPoint,$uom);
if (round($distance,2) == 0){
$uom = get_option('search_dist_2');
$distance = calculateDistanceFromLatLong ($startPoint,$endPoint,$uom);
$distance = round($distance).' '.$uom;
}else{
$distance = round($distance,2).' '.$uom;
}
	 }
	 
	 // STAR RATING
	 $avg_rating = get_post_average_rating($ID);
	 $star_rating = 0;
	if($avg_rating==0)							{$star_rating = 0;}
	if($avg_rating>=1 && $avg_rating<1.25 )		{$star_rating = 1;}
	if($avg_rating>=1.25 && $avg_rating<1.75 )	{$star_rating = 1.5;}
	if($avg_rating>=1.75 && $avg_rating<2.25 )	{$star_rating = 2;}
	if($avg_rating>=2.25 && $avg_rating<2.75 )	{$star_rating = 2.5;}
	if($avg_rating>=2.75 && $avg_rating<3.25 )	{$star_rating = 3;}
	if($avg_rating>=3.25 && $avg_rating<3.75 )	{$star_rating = 3.5;}
	if($avg_rating>=3.75 && $avg_rating<4.25 )	{$star_rating = 4;}
	if($avg_rating>=4.25 && $avg_rating<4.75 )	{$star_rating = 4.5;}
	if($avg_rating>=4.75 && $avg_rating<=5 )	{$star_rating = 5;}

						
					
	 $new_arr = array('thumb' => $post_thumb,'star_rating' => $star_rating,'timing' => $timing, 'lat_pos' => $lat, 'long_pos' => $lng, 'icon' => $term_icon, 'featured' => $is_featured, 'address' => $address, 'distance' => $distance );
	 $post2[] = array_merge((array)$postinfo_obj,(array)$new_arr);
				//echo json_encode($post2);	
				//$post2 = array_unique($post2);
					
				}
				}
				
			}
			
			
			//}
		//	}// end foreach
	//$post2 = array_unique($post2);		
echo json_encode($post2);	
} // end api_get_categorys function
$city_id= mysql_real_escape_string($_REQUEST['city_id']);
$cat_id = mysql_real_escape_string($_REQUEST['cat_id']);
$post_type = mysql_real_escape_string($_REQUEST['type']);
$etype= mysql_real_escape_string($_REQUEST['etype']);
api_home_listings($city_id,$cat_id,$post_type,$etype);
}
############################################## END HOME LISTING INFO ####################################################################
?>