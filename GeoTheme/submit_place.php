<?php
/*
Template Name: Add Listing Form
*/
?>
<?php
session_start();
ob_start();
//print_r($_SESSION);
if($_REQUEST['backandedit'])
{
}else
{
	$_SESSION['property_info'] = array();
}
if(!is_user_can_add_event())
{
	wp_redirect(home_url());
}
if($_REQUEST['pid'])
{
	if(!$current_user->data->ID)
	{
		wp_redirect(get_settings('home').'/index.php?ptype=login');
		exit;
	}
	$pid = $_REQUEST['pid'];
	$proprty_type = $catid_info_arr['type']['id'];
	$post_info = get_post_info($_REQUEST['pid']);
	$proprty_name = $post_info['post_title'];
	$proprty_desc = $post_info['post_content'];
	$post_meta = get_post_meta($_REQUEST['pid'], '',false);
	$address = $post_meta['address'][0];
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
	$package_pid = $post_meta['package_pid'][0];
	$post_hood_id = $post_meta['post_hood_id'][0];
	$video = $post_meta['video'][0];
	############################## FIX FOR TAGS
	$kw_tags = '';
	$tags = get_the_terms( $pid, 'place_tags' );
$xt = 1;
foreach ($tags as $tag) {
if ($xt <= 20) {
$kw_tags .= $tag->name.", ";
}
$xt++;
}
################
	//$kw_tags = $post_meta['kw_tags'][0];
	$proprty_feature =$post_meta['proprty_feature'][0];
	$post_city_id =$post_meta['post_city_id'][0];
	$cat_array = array();
	if($pid)
	{
		//$catinfoarr = get_the_category($post_info['ID']);
		$catinfoarr = get_the_terms($post_info['ID'], 'placecategory');
													
		$cat_array = array();
		
		foreach ($catinfoarr as $taxindex => $taxitem)
		{
		$cat_array[] = $taxitem->name;
		}
		/*for($c=0;$c<count($catinfoarr);$c++)
		{
			$cat_array[] = $catinfoarr[$c]->term_id;
		}*/
	}
	$thumb_img_arr = bdw_get_images($_REQUEST['pid'],'large');
}
if($_SESSION['property_info'] && $_REQUEST['backandedit'])
{
	$proprty_name = $_SESSION['property_info']['proprty_name'];
	$proprty_desc = $_SESSION['property_info']['proprty_desc'];
	$proprty_feature = $_SESSION['property_info']['proprty_feature'];
	$address = $_SESSION['property_info']['address'];
	$geo_latitude = $_SESSION['property_info']['geo_latitude'];
	$geo_longitude = $_SESSION['property_info']['geo_longitude'];
	$claimed = $_SESSION['property_info']['claimed'];
	$map_view = $_SESSION['property_info']['map_view'];
	$timing = $_SESSION['property_info']['timing'];
	$contact = $_SESSION['property_info']['contact'];
	$email = $_SESSION['property_info']['email'];
	$website = $_SESSION['property_info']['website'];
	$twitter = $_SESSION['property_info']['twitter'];
	$facebook = $_SESSION['property_info']['facebook'];
	$kw_tags = $_SESSION['property_info']['kw_tags'];
	$post_city_id = $_SESSION['property_info']['post_city_id'];
	$post_hood_id = $_SESSION['property_info']['post_hood_id'];
	if($_SESSION['property_info']['package_pid']){$package_pid = $_SESSION['property_info']['package_pid'];}
	
	$user_fname = $_SESSION['property_info']['user_fname'];
	$user_phone = $_SESSION['property_info']['user_phone'];
	$user_email = $_SESSION['property_info']['user_email'];
	$user_login_or_not = $_SESSION['property_info']['user_login_or_not'];
	$cat_array = $_SESSION['property_info']['category'];
	$proprty_add_coupon = $_SESSION['property_info']['proprty_add_coupon'];
	$price_select = $_SESSION['property_info']['price_select'];
	$video = $_SESSION['property_info']['video'];
}
################ LIMIT PACKAGE CODE ######################

if($_SESSION['property_info']['price_select']){$price_select = $_REQUEST['pkg'];}

if($_REQUEST['pkg'] || $package_pid)
{	
if($_REQUEST['pkg']){$package_pid = $_REQUEST['pkg']; }
global $price_db_table_name,$wpdb;
$pricesql = "select * from $price_db_table_name where status=1 and pid=$package_pid and post_type='listing'";
$priceinfo = $wpdb->get_row($pricesql, ARRAY_A);
//echo $priceinfo['title'];
	
	
	
$html_editor = $priceinfo['html_editor'];
$property_feature_pkg = $priceinfo['property_feature_pkg'];
$property_desc_pkg = $priceinfo['property_desc_pkg'];
$video_pkg = $priceinfo['video_pkg'];
$listing_desc_pkg = $priceinfo['listing_desc_pkg'];
$timing_pkg = $priceinfo['timing_pkg'];
$contact_pkg = $priceinfo['contact_pkg'];
$email_pkg = $priceinfo['email_pkg'];
$website_pkg = $priceinfo['website_pkg'];
$twitter_pkg = $priceinfo['twitter_pkg'];
$facebook_pkg = $priceinfo['facebook_pkg'];
$kw_tags_pkg = $priceinfo['kw_tags_pkg'];
$image_limit = $priceinfo['image_limit'];
$cat_limit = $priceinfo['cat_limit'];
$cat_exclude = $priceinfo['cat'];
$lat_lng = $priceinfo['lat_lng'];
}
################## LIMIT PACKAGE CODE #####################
if($proprty_desc=='')
{
	$proprty_desc = __("Enter description for your listing.");
}
if($_REQUEST['renew'])
{
	$property_list_type = get_post_meta($_REQUEST['pid'],'list_type',true);
}
if($_REQUEST['ptype']=='post_event')
{
	if($_REQUEST['pid'])
	{
		if($_REQUEST['renew'])
		{
			$page_title = RENEW_EVENT_TEXT;
		}elseif($_REQUEST['upgrade'])
		{
			$page_title = UPGRADE_EVENT_TEXT;
		}else
		{
			$page_title = EDIT_EVENT_TEXT;
		}
	}else
	{
		$page_title = POST_EVENT_TITLE;
	}
}else
{
	if($_REQUEST['pid'])
	{
		if($_REQUEST['renew'])
		{
			$page_title = RENEW_LISING_TEXT;
		}elseif($_REQUEST['upgrade'])
		{
			$page_title = UPGRADE_LISING_TEXT;
		}else
		{
			$page_title = EDIT_LISING_TEXT;
		}
	}else
	{
		$page_title = POST_PLACE_TITLE;
	}
}
?>
<?php get_header(); ?>
<?php 
$isiPhone = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPhone');
$isiPod = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPod');
$isiPad = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPad');
if($isiPad || $isiPod || $isiPhone || $html_editor==0){echo '<!-- TinyMCE disabled for iPad, iPhone and iPod -->';}else{
?>
<!-- TinyMCE -->
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/library/js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "exact",
		elements : "proprty_desc<?php if($property_feature_pkg==1){ echo',proprty_feature';} ?>",
		theme : "advanced",
		plugins :"advimage,advlink,emotions,iespell,",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,bullist,numlist,blockquote,|,link,unlink,anchor,image,code",
		theme_advanced_buttons2 : "",
		theme_advanced_buttons3 : "",
		theme_advanced_buttons4 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example word content CSS (should be your site CSS) this one removes paragraph margins
		//content_css : "css/word.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script>
<!-- /TinyMCE -->
<?php } ?>
<div id="wrapper" class="clearfix">
<div id="inner_pages" class="clearfix" >
    <h1><?php echo $page_title;?></h1>   
    <div class="breadcrumb clearfix">  <?php if ( get_option( 'ptthemes_breadcrumbs' )) {  ?>
    
        <div class="breadcrumb_in"><?php if(function_exists('bcn_display')){bcn_display();}?></div>
  
<?php } ?>  </div>
<div class="clearfix"></div>
<div id="content" class="content_inner" >
<?php dynamic_sidebar('Add Listing Top Section'); ?>
<div class="clearfix"></div>
<?php if($current_user->ID!='0'){$user_login_or_not='existing_user';} ?>
 <?php if(is_allow_user_register()){?>
			 <p class="note "> <span class="required">*</span> <?php _e(INDICATES_MANDATORY_FIELDS_TEXT);?> </p>
           <?php if($_REQUEST['usererror']==1)
			{
				if($_SESSION['userinset_error'])
				{
					for($i=0;$i<count($_SESSION['userinset_error']);$i++)
					{
						echo '<div class="error_msg">'.$_SESSION['userinset_error'][$i].'</div>';
					}
					echo "<br>";
				}
			}
			?>   
             <?php
			if($_REQUEST['emsg']==1)
			{
			?>
			<div class="error_msg"><?php echo INVALID_USER_PW_MSG;?></div>
			<?php
			}
			if(!$current_user->ID)
			 {
			 ?>
			 
			 
			 <h5 class="form_title spacer_none"><?php _e(LOGINORREGISTER);?>  </h5>
			 
              <div class="form_row clearfix">
              <?php 
			  if($_REQUEST['user_val']=='existing'){$user_login_or_not='existing_user';}
			  if($_REQUEST['user_val']=='new'){$user_login_or_not='new_user';}
			  ?>
             	<label><?php _e(IAM_TEXT);?> </label>
             	 <span class=" user_define"> <input name="user_login_or_not" type="radio" value="existing_user" <?php if($user_login_or_not=='existing_user'){ echo 'checked="checked"';}?> onclick="set_login_registration_frm(this.value);" /> <?php _e(EXISTING_USER_TEXT);?> </span>  
				 <span class="user_define"> <input name="user_login_or_not" type="radio" value="new_user"  <?php if($user_login_or_not=='new_user'){ echo 'checked="checked"';}?> onclick="set_login_registration_frm(this.value);" /> <?php _e(NEW_USER_TEXT);?> </span>
                <span class="message_error2" id="user_login_or_not_span"></span>
              </div>
              <div class="login_submit clearfix" id="login_user_frm_id" <?php if($_REQUEST['user_val']!='existing'){echo 'style="display:none;"';} ?>>
              <form name="loginform" id="loginform" action="<?php echo get_ssl_normal_url(get_settings('home').'/index.php?ptype=login'); ?>" method="post" >
              <div class="form_row clearfix">
             	<label><?php _e(LOGIN_TEXT);?>  <span>*</span> </label>
             	<input type="text" class="textfield " id="user_login" name="log" />
              </div>
              
               <div class="form_row clearfix">
             	<label><?php _e(PASSWORD_TEXT);?>  <span>*</span> </label>
             	<input type="password" class="textfield " id="user_pass" name="pwd" />
              </div>
              
              <div class="form_row clearfix">
              <input name="submit" type="submit" value="<?php _e(SUBMIT_BUTTON);?>" class="b_submit" />
			  
			   </div>
			   
			  
			  <?php	$login_redirect_link = get_settings('home').'/?ptype=post_listing';?>
			  <input type="hidden" name="redirect_to" value="<?php echo $login_redirect_link; ?>" />
			  <input type="hidden" name="testcookie" value="1" />
			  <input type="hidden" name="pagetype" value="<?php echo $login_redirect_link; ?>" />
			  </form>
              </div>
              
               <?php if(!$current_user->ID && !$_REQUEST['user_val'] && !$_REQUEST['pkg']){?>
			   <div id="contact_detail_id" <?php if($_REQUEST['user_val']!='new'){echo 'style="display:none;"';} ?> > 
               <div class="form_row clearfix">
               <p><?php if($_REQUEST['pkg']){}else{echo NEW_USER_INFO;} ?> </p>
               </div>
			   </div>
			   <?php }?>
     
     		 <?php } if($current_user->ID!=''){$user_login_or_not='existing_user';} ?>
             <?php }elseif(!$current_user->ID){echo '<div class="error_msg">'.REGISTRATION_DESABLED_MSG.'</div>';}?>
			 
			  <?php
			 if($_REQUEST['pid'] || $_POST['renew'] || $_POST['upgrade']){
				$form_action_url = home_url().'/?ptype=preview';
			 }else
			 {
				 $form_action_url = get_ssl_normal_url(home_url().'/?ptype=preview',$_REQUEST['pid']);
			 }
			
			 ?>             
            <form name="propertyform" id="propertyform" action="<?php echo $form_action_url; ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="user_login_or_not" id="user_login_or_not" value="<?php echo $user_login_or_not;?>" />
            <input type="hidden" name="pid" value="<?php echo $_REQUEST['pid'];?>" />
            <input type="hidden" name="renew" value="<?php echo $_REQUEST['renew'];?>" />
            <input type="hidden" name="upgrade" value="<?php echo $_REQUEST['upgrade'];?>" />
            
            <?php if(!$current_user->ID && $_REQUEST['pkg']){ ?>
		<div id="contact_detail_id" <?php if($_REQUEST['pkg']==''){echo 'style="display:none;"';} ?> > 
            <h5 class="form_title"><?php echo CONTACT_DETAIL_TITLE; ?></h5>
             
               <div class="form_row clearfix">
             	<label><?php echo CONTACT_NAME_TEXT; ?> <span>*</span></label>
             	 <input name="user_fname" id="user_fname" value="<?php echo $user_fname;?>" type="text" class="textfield" />
              <span class="message_error2" id="user_fname_span"></span>
              </div>
              <div class="form_row clearfix">
             	<label><?php echo CONTACT_TEXT; ?></label>
             	 <input  name="user_phone" id="user_phone" value="<?php echo $user_phone;?>" type="tel" class="textfield" />
              </div>
              <div class="form_row clearfix">
             	<label><?php echo EMAIL_TEXT; ?> <span>*</span></label>
             	 <input name="user_email" id="user_email" value="<?php echo $user_email;?>" type="email" class="textfield" />
                 <span class="message_error2" id="user_email_span"></span>
              <span class="message_note"><?php echo EMAIL_TEXT_MSG;?></span>
              </div>
              
         <?php if(get_option('ptthemes_show_user_pass')){?>
              
              <div class="form_row clearfix">
             	<label><?php _e(PASSWORD_TEXT); ?> <span>*</span></label>
             	 <input name="user_pass1" id="user_pass1" value="" type="password" class="textfield" />
                 <span class="message_error2" id="user_pass1_span"></span>
              <span class="message_note"></span>
              </div>
              
              <div class="form_row clearfix">
             	<label><?php _e(CONFIRM_PASSWORD_TEXT); ?> <span>*</span></label>
             	 <input name="user_pass2" id="user_pass2" value="" type="password" class="textfield" />
                 <span class="message_error2" id="user_pass2_span"></span>
              <span class="message_note"><?php _e(PASSWORD_LENGTH_MSG);?></span>
              </div>
              
              <script type="text/javascript">
			  var passMatch = false;
			  var passLen = false;
			  jQuery("#user_pass1").change(function(){
				 if(jQuery(this).val().length < 7){
					jQuery("#user_pass1_span").html('<?php _e(PASSWORD_LENGTH_TEXT);?>');
					passLen = true;
				 }else{jQuery("#user_pass1_span").html('');}
			 });
			  
			  jQuery("#user_pass1").keyup(function(){
				if(passLen){
				 if(jQuery(this).val().length < 7){
					jQuery("#user_pass1_span").html('<?php _e(PASSWORD_LENGTH_TEXT);?>');
				 }else{jQuery("#user_pass1_span").html('');passLen=false;}
				}
			 });
			  
              jQuery("#user_pass2").change(function(){
				 if(jQuery(this).val() != jQuery("#user_pass1").val()){
					jQuery("#user_pass2_span").html('<?php _e(PASSWORD_MATCH_TEXT);?>');
					passMatch = true;
				 }else{jQuery("#user_pass2_span").html('');}
			 });
			  
			  jQuery("#user_pass2").keyup(function(){
				if(passMatch){							   
				 if(jQuery(this).val() != jQuery("#user_pass1").val()){
					jQuery("#user_pass2_span").html('<?php _e(PASSWORD_MATCH_TEXT);?>');
				 }else{jQuery("#user_pass2_span").html('');passMatch=false;}
				}
			 });
			  
			  
			 </script>
              
		<?php }?>
              
              
		</div>
		<?php }?>
              
             <h5 class="form_title spacer_none" <?php if(get_option('is_user_addevent')=='0' || get_option('is_user_eventlist')=='0'){ echo 'style="display:none"';} ?>> <?php _e(SELECT_LISTING_TYPE_TEXT);?></h5>
			 <div class="form_row clearfix" <?php if(get_option('is_user_addevent')=='0' || get_option('is_user_eventlist')=='0'){ echo 'style="display:none"';} ?>>
             	<label><?php echo SELECT_EVENT_TYPE_TEXT;?> </label>
             	<?php if(get_option('is_user_addevent')=='0'){}else{ ?>
                <span class=" user_define"> <input name="listing_type" id="place_listing" type="radio" value="post_listing" <?php if($_REQUEST['ptype']=='post_listing'){ echo 'checked="checked"';}?> onclick="window.location.href='<?php echo home_url();?>/?ptype=post_listing'" /> <?php echo POST_PLACE_TITLE;?> </span>  
				 <?php }?>
                <?php if(get_option('is_user_eventlist')=='0'){}else{ ?> 
                 <span class="user_define"> <input name="listing_type" id="event_listing" type="radio" value="post_event" <?php if($_REQUEST['ptype']=='post_event'){ echo 'checked="checked"';}?>  onclick="window.location.href='<?php echo home_url();?>/?ptype=post_event'" /> <?php echo POST_EVENT_TITLE;?> </span>
                  <?php }?>
             </div>
			 <!--  ##################################### PRICE DETAILS ################################################ -->
              <?php if($_REQUEST['pid']=='' || $_REQUEST['renew'] || $_REQUEST['upgrade']){?>
                   
              <?php 
			  
			$uri =  end(explode('?', $_SERVER['REQUEST_URI']));
			$uri = explode('&pkg=', $uri);
			//echo $uri[0];
			  	 $property_price_info = get_property_price_info();
				 if($property_price_info)
				 {
				 ?>
			  <h5 class="form_title"> <?php echo GENERAL_PROPERTY_INFO_TEXT;?></h5> 
			  <div class="form_row clearfix <?php if($_REQUEST['upgrade']){echo 'upgrade_highlight';} ?>" >
             	<label><?php echo SELECT_TYPE_TEXT; ?> </label>
                <?php get_price_info($price_select,$package_pid,$uri[0]);?> 
             	                
             </div>
			 
			 
			 <?php if(get_option('is_allow_coupon_code')){?>
			 <h5 class="form_title"><?php echo COUPON_CODE_TITLE_TEXT;?></h5> 
              <div class="form_row clearfix">
             	<label><?php echo PRO_ADD_COUPON_TEXT;?> </label>
				<input type="text" name="proprty_add_coupon" id="proprty_add_coupon" class="textfield" value="<?php echo esc_attr(stripslashes($proprty_add_coupon)); ?>" />
				 <span class="message_note"><?php echo COUPON_NOTE_TEXT; ?></span>				
             </div>
			 <?php }?>
			 <?php }?>
             <?php }
             if($_REQUEST['pkg'] || $package_pid || $_REQUEST['pid'] || $_REQUEST['backandedit']){
					?>
            <!--  ##################################### END PRICE DETAILS ############################################# -->
			  <h5 class="form_title "> <?php _e(LISTING_DETAILS_TEXT);?> </h5>
             <!-- ##################### CLAIM LISTING QUESTION ##################-->
             <?php if(get_option('claim_listing')==1){ ?>
             <div class="form_row clearfix">
             	<label><?php echo ADD_PLACE_CLAIM_LISTING;?> <span>*</span> </label>
<div class="category_label2">
             	   
             	<div class="form_cat2">                
                <input type="radio" class="checkbox" name="claimed" id="claimed1" <?php if($claimed=='1' ){echo 'checked="checked"';}?>  value="1" size="20"  /> <?php _e('Yes');?></div>
                
               <div class="form_cat2"  > <input type="radio" class="checkbox" name="claimed" id="claimed2" <?php if($claimed=='0'){echo 'checked="checked"';}?> value="0" size="20"  /> <?php _e('No');?></div>                
                
                </div>
		        <span class="message_error2" id="claimed_span"></span>
             </div>
             <?php }else{
		echo '<input type="radio" class="checkbox" name="claimed" id="claimed1" checked="checked"  value="" style="display:none;" />';		 
		echo '<input type="radio" class="checkbox" name="claimed" id="claimed2"  value="" style="display:none;" />';		 
				 } ?>
			 <!-- ##################### CLAIM LISTING QUESTION ##################-->

              <div class="form_row clearfix">
             	<label><?php echo EVENT_TITLE_TEXT;?> <span>*</span> </label>
             	<input type="text" name="proprty_name" id="proprty_name" class="textfield" value="<?php echo esc_attr(stripslashes($proprty_name)); ?>" size="25"  />
		        <span class="message_error2" id="proprty_name_span"></span>
             </div>
             
              <div class="form_row clearfix" <?php if(!get_option('ptthemes_enable_multicity_flag')){?>style="display:none;"<?php }?>>
             	<label><?php echo EVENT_CITY_TEXT;?> </label>
             	<?php if($post_city_id){}else{$post_city_id = $_SESSION['multi_city'];}  echo get_multicit_select_dl('post_city_id','post_city_id',$post_city_id,' class="textfield textfield_x" '); ?>
             </div>
             
			<?php if(get_option('ptthemes_enable_multihood_flag')){?>
             <div class="form_row clearfix">
             	<label><?php echo NEIGHBOURHOOD;?> </label>
<?php  
echo get_multihood_select_dl('post_hood_id','post_hood_id',$post_city_id,' class="textfield textfield_x" ','','',$post_hood_id); ?>		        
<span class="message_note"><?php echo NEIGHBOURHOOD_MSG;?></span>
             </div>
             <?php }?>
             
             
             <div class="form_row clearfix">
             	<label><?php echo EVENT_ADDRESS;?> </label>
             	<input type="text" name="address" id="address" class="textfield" value="<?php echo esc_attr(stripslashes($address)); ?>" size="25"  />
		       <span class="message_note"><?php echo ADDREDD_MSG;?></span>
                <span class="message_error2" id="address_span"></span>
             </div>
             
			 <div class="form_row clearfix"> 
			 <?php include_once(TEMPLATEPATH . "/library/map/location_add_map.php");?>
			 <span class="message_note"><?php echo GET_MAP_MSG;?></span></div>
			  
             
             <div class="form_row clearfix" <?php if($lat_lng==2){echo 'style="display:none;"';}?>>
             	<label><?php echo EVENT_ADDRESS_LAT;?> </label>
             	<input type="text" name="geo_latitude" id="geo_latitude" class="textfield" value="<?php echo esc_attr(stripslashes($geo_latitude)); ?>" size="25"  />
		        <span class="message_note"><?php echo GET_LATITUDE_MSG;?></span>
             </div>
             <div class="form_row clearfix" <?php if($lat_lng==2){echo 'style="display:none;"';}?>>
             	<label><?php echo EVENT_ADDRESS_LNG;?> </label>
             	<input type="text" name="geo_longitude" id="geo_longitude" class="textfield" value="<?php echo esc_attr(stripslashes($geo_longitude)); ?>" size="25"  />
		       <span class="message_note"><?php echo GET_LOGNGITUDE_MSG;?></span>
             </div>
             
			   <div class="form_row clearfix ">
               <label><?php echo EVENT_MAP_VIEW_LNG;?> </label>

               <div class="category_label2">
             	                <?php
                if($map_view=='')
				{
					$map_view = 'G_NORMAL_MAP';	
				}
				?>
             	<div class="form_cat2">
                
                <input type="radio" class="checkbox" name="map_view" id="map_view" <?php if($map_view=='G_NORMAL_MAP' ){echo 'checked="checked"';}?>  value="G_NORMAL_MAP" size="25"  /> <?php _e('Default Map');?></div>
               <div class="form_cat2"> <input type="radio"  class="checkbox" name="map_view" id="map_view1" <?php if($map_view=='G_SATELLITE_MAP'){echo 'checked="checked"';}?> value="G_SATELLITE_MAP" size="25"  /> <?php _e('Satellite Map');?></div>
                <div class="form_cat2"><input type="radio" class="checkbox"  name="map_view" id="map_view2" <?php if($map_view=='G_HYBRID_MAP'){echo 'checked="checked"';}?>  value="G_HYBRID_MAP" size="25"  /> <?php _e('Hybrid Map');?></div>
                
                </div>

             </div>
			 <?php if($property_desc_pkg!=2){?> 
			  <div class="form_row clearfix"  <?php if($property_desc_pkg==0){?> onclick="alert('<?php echo NOT_WITH_PACKAGE; ?>');return false" <?php } ?>>
             	<label><?php echo PRO_DESCRIPTION_TEXT;?> <span>*</span> </label>
				<textarea  name="proprty_desc" id="proprty_desc" class="textarea" rows=""  cols="" <?php if($property_desc_pkg==0){echo 'disabled="disabled"';} ?>  ><?php  echo esc_attr(stripslashes($proprty_desc)); ?></textarea> 
				<span class="message_note"><?php _e(HTML_TAGS_ALLOW_MSG);?></span>
				<span class="message_error2" id="proprty_desc_span"></span>
             </div>
			 <?php } ?>
             
             <?php if($property_feature_pkg!=2){?> 
			  <div class="form_row clearfix" <?php if($property_feature_pkg==0){?> onclick="alert('<?php echo NOT_WITH_PACKAGE; ?>');return false" <?php } ?>>
             	<label><?php echo PRO_FEATURE_TEXT;?> </label>
				<textarea  name="proprty_feature" id="proprty_feature" class="textarea" rows=""  cols=""  <?php if($property_feature_pkg==0){echo 'disabled="disabled"';} ?> ><?php  if($property_feature_pkg==1){ echo esc_attr(stripslashes($proprty_feature));} ?></textarea> 
				<?php /*?><span class="message_note"><?php _e(HTML_TAGS_ALLOW_MSG);?></span><?php */?>
				<span class="message_note"><?php _e(HTML_SPECIAL_TEXT);?></span>
				<span class="message_error2" id="proprty_feature_span"></span>
             </div>
             <?php } ?>
			 
			 
			 <?php if($timing_pkg!=2){?>
             <div class="form_row clearfix" <?php if($timing_pkg==0){?> onclick="alert('<?php echo NOT_WITH_PACKAGE; ?>');return false" <?php } ?>>
             	<label><?php echo EVENT_TIMING;?> </label>
             	<input type="text" name="timing" id="timing" class="textfield" value="<?php if($timing_pkg==1){ echo esc_attr(stripslashes($timing));} ?>" size="25"  <?php if($timing_pkg==0){echo 'disabled="disabled"';} ?>  />
		         <span class="message_note"><?php echo TIMING_MSG;?></span>
             </div>
             <?php } ?>
             
             <?php if($contact_pkg!=2){?>
             <div class="form_row clearfix"  <?php if($contact_pkg==0){?> onclick="alert('<?php echo NOT_WITH_PACKAGE; ?>');return false" <?php } ?>>
             	<label><?php echo EVENT_CONTACT_INFO;?> </label>
             	<input type="tel" name="contact" id="contact" class="textfield" value="<?php if($contact_pkg==1){ echo esc_attr(stripslashes($contact));} ?>" size="25"  <?php if($contact_pkg==0){echo 'disabled="disabled"';} ?>/>
		        <span class="message_error2" id="contact_span"></span>
                <span class="message_note"><?php echo CONTACT_MSG;?></span>
             </div>
             <?php } ?>
             
             <?php if($email_pkg!=2){?>
             <div class="form_row clearfix" <?php if($email_pkg==0){?> onclick="alert('<?php echo NOT_WITH_PACKAGE; ?>');return false" <?php } ?>>
             	<label><?php echo EVENT_CONTACT_EMAIL;?> </label>
             	<input type="email" name="email" id="email" class="textfield" value="<?php if($email_pkg==1){ echo esc_attr(stripslashes($email));} ?>" size="25"  <?php if($email_pkg==0){echo 'disabled="disabled"';} ?>/>
		        <span class="message_error2" id="email_span"></span>
             </div>
             <?php } ?>
             
             <?php if($website_pkg!=2){?>
              <div class="form_row clearfix" <?php if($website_pkg==0){?> onclick="alert('<?php echo NOT_WITH_PACKAGE; ?>');return false" <?php } ?>>
             	<label><?php echo EVENT_WEBSITE;?> </label>
             	<input type="url" name="website" id="website" class="textfield" value="<?php if($website_pkg==1){ echo esc_attr(stripslashes($website));} ?>" size="25" <?php if($website_pkg==0){echo 'disabled="disabled"';} ?> />
		         <span class="message_note"><?php echo WEBSITE_MSG;?></span>
             </div>
             <?php } ?>
             
             <?php if($twitter_pkg!=2){?>
              <div class="form_row clearfix" <?php if($twitter_pkg==0){?> onclick="alert('<?php echo NOT_WITH_PACKAGE; ?>');return false" <?php } ?>>
             	<label><?php echo TWITTER_TEXT; ?></label>
             	 <input name="twitter" id="twitter" value="<?php if($website_pkg==1){ echo esc_attr(stripslashes($twitter)); }?>" type="url" class="textfield" <?php if($twitter_pkg==0){echo 'disabled="disabled"';} ?> />
                 <span class="message_note"><?php echo TWITTER_MSG;?></span>
              </div>
              <?php } ?>
              
              <?php if($facebook_pkg!=2){?>
              <div class="form_row clearfix" <?php if($facebook_pkg==0){?> onclick="alert('<?php echo NOT_WITH_PACKAGE; ?>');return false" <?php } ?>>
             	<label><?php echo FACEBOOK_TEXT; ?></label>
             	 <input name="facebook" id="facebook" value="<?php if($website_pkg==1){ echo esc_attr(stripslashes($facebook)); }?>" type="url"  class="textfield" <?php if($facebook_pkg==0){echo 'disabled="disabled"';} ?> />
                 <span class="message_note"><?php echo FACEBOOK_MSG;?></span>
              </div>
              <?php } ?>
              
              
             <div class="form_row clearfix">
             	<label><?php echo EVENT_CATETORY_TEXT;?> <span>*</span> </label>
            	<div class="category_label"><?php require_once (TEMPLATEPATH . '/library/includes/places_category.php');?></div>
                <span class="message_note"><?php echo CATEGORY_MSG;  echo $cat_include;?></span>
                <span id="category_span" class="message_error2"></span>
            </div>
            
            <?php if($kw_tags_pkg!=2){?>
            <div class="form_row clearfix" <?php if($kw_tags_pkg==0){?> onclick="alert('<?php echo NOT_WITH_PACKAGE; ?>');return false" <?php } ?>>
             	<label><?php echo TAGKW_TEXT; ?></label>
             	 <input name="kw_tags" id="kw_tags" value="<?php if($kw_tags_pkg==1){ echo esc_attr(stripslashes($kw_tags)); } ?>" type="text" class="textfield" maxlength="<?php echo TAGKW_TEXT_COUNT;?>" <?php if($kw_tags_pkg==0){echo 'disabled="disabled"';} ?> />
                 <span class="message_note"><?php echo TAGKW_MSG;?></span>
              </div>
              <?php } ?>
              
     		<?php 
			$custom_metaboxes = get_post_custom_fields_templ($package_pid);
			foreach($custom_metaboxes as $key=>$val)
			{
				$name = $val['name'];
				$site_title = $val['site_title'];
				$type = $val['type'];
				$admin_desc = $val['desc'];
				$option_values = $val['option_values'];
				$value='';
				if($_REQUEST['pid'])
				{
					$value = get_post_meta($_REQUEST['pid'], $name,true);
				}else
				if($_SESSION['property_info'] && $_REQUEST['backandedit'])
				{
					$value = 	$_SESSION['property_info'][$name];
				}else{if($value=='' && $type!='checkbox'){$value= $val['default'];}}
			?>
            <div class="form_row clearfix">
			   <?php if($type=='text'){?>
               <label><?php echo $site_title; ?></label>
             <input name="<?php echo $name;?>" id="<?php echo $name;?>" value="<?php echo $value;?>" type="text" class="textfield" />
               <?php 
                }elseif($type=='link'){if($value== $val['default']){$value='';}?>
               <label><?php echo $site_title; ?></label>
             <input name="<?php echo $name;?>" id="<?php echo $name;?>" value="<?php echo $value;?>" type="text" class="textfield" />
               <?php 
                }elseif($type=='checkbox'){
                ?>     
                 <label><?php echo $site_title; ?></label>      
                <input name="<?php echo $name;?>" id="<?php echo $name;?>" <?php if($value){ echo 'checked="checked"';}?>  value="1" type="checkbox" /> 
                <?php
                }elseif($type=='textarea'){
                ?>
                <label><?php echo $site_title; ?></label>
                <textarea name="<?php echo $name;?>" id="<?php echo $name;?>"><?php echo $value;?></textarea>       
                <?php
                }elseif($type=='select'){
                ?>
                 <label><?php echo $site_title; ?></label>
                <select name="<?php echo $name;?>" id="<?php echo $name;?>" class="textfield textfield_x">
                <?php if($option_values){
				$option_values_arr = explode(',',$option_values);
				
				for($i=0;$i<count($option_values_arr);$i++)
				{
				?>
                <option value="<?php echo $option_values_arr[$i]; ?>" <?php if($value==$option_values_arr[$i]){ echo 'selected="selected"';}?>><?php 
				echo str_replace(array('/1', '/0'), '', $option_values_arr[$i]); ?></option>
                <?php	
				}
				?>
                <?php }?>
               
                </select>
                
                <?php
                }elseif($type=='multiselect'){
				?>
                 <label><?php echo $site_title; ?></label>
                <select name="<?php echo $name;?>[]" id="<?php echo $name;?>" multiple="multiple" class="textfield textfield_x">
                <?php if($option_values){
				$option_values_arr = explode(',',$option_values);
				for($i=0;$i<count($option_values_arr);$i++)
				{
				?>
                <option value="<?php echo $option_values_arr[$i]; ?>" <?php if(in_array($option_values_arr[$i],$value)){ echo 'selected="selected"';}?>><?php echo $option_values_arr[$i]; ?></option>
                <?php	
				}
				?>
                <?php }?>
               
                </select>
                
                <?php
                }
                ?>
             	 <span class="message_note"><?php echo $admin_desc;?></span>
              </div>
            <?php
			}
			?>
             
             
             <h5 class="form_title"> <?php _e(PRO_PHOTO_TEXT);?>
             <?php if($image_limit!='0' && $image_limit==1 ){echo '<br /><small>('.__('You can upload').' '.$image_limit.' '.__('image with this package').')</small>';} ?>
             <?php if($image_limit!='0' && $image_limit>1 ){echo '<br /><small>('.__('You can upload').' '.$image_limit.' '.__('images with this package').')</small>';} ?>
             <?php if($image_limit=='0'){echo '<br /><small>('.__('You can upload').' '.$image_limit.' '.__('images with this package').')</small>';} ?>
             </h5>
             
				<?php if($image_limit!='0'){ include (TEMPLATEPATH . "/library/includes/image_uploader.php"); }?>
             
             
            
			 <script type="text/javascript">
			 function show_value_hide(val)
			 {
			 	document.getElementById('property_submit_price_id').innerHTML = document.getElementById('span_'+val).innerHTML;
			 }
			 </script>
       
       
       <?php if($video_pkg!=2){?> 
			  <div class="form_row clearfix" <?php if($video_pkg==0){?> onclick="alert('<?php echo NOT_WITH_PACKAGE; ?>');return false" <?php } ?>>
             	<label><?php echo PRO_VIDEO_TEXT;?> </label>
				<textarea  name="video" id="video" class="textarea" rows=""  cols=""  <?php if($video_pkg==0){echo 'disabled="disabled"';} ?> ><?php  if($video_pkg==1){ echo esc_attr(stripslashes($video));} ?></textarea> 
				<span class="message_note"><?php _e(HTML_VIDEO_TEXT);?></span>
				<span class="message_error2" id="video_span"></span>
             </div>
             <?php } ?>
       
		
        
		<?php if(get_option('accept_term_condition')){	?>
        <div class="form_row clearfix">
             	<label>&nbsp;</label>
             	 <input name="term_and_condition" id="term_and_condition" value="" type="checkbox" class="chexkbox" />
                 <?php echo str_replace('\"','"',get_option('term_condition_content'));?>
              </div>
              <script type="text/javascript">
              function check_term_condition()
			  {
				if(eval(document.getElementById('term_and_condition')))  
				{
					if(document.getElementById('term_and_condition').checked)
					{	
						return true;
					}else
					{
						alert('<?php _e('Please accept Terms and Conditions');?>');
						return false;
					}
				}
			  }
              </script>
        <?php 
		$submit_button = 'onclick="return check_term_condition();"';
		}?>
		
		  <?php if(function_exists('pt_get_captch') && $_REQUEST['pid']==''){pt_get_captch(); }?>
			  <input type="submit" name="Update" value="<?php echo PRO_PREVIEW_BUTTON;?>" class="b_review" <?php echo $submit_button;?>/>
			  
			  <div class="form_row clear_both">
			  	 <span class="message_note"> <?php _e('Note: You will be able to see a preview in the next page');?>  </span>
			  </div>
              
           			 <?php }?>
           </form>  

</div> <!-- content #end -->

<div id="sidebar">
<?php dynamic_sidebar(6);  ?>
</div>
</div>


<script language="javascript" type="text/javascript">
/*<![CDATA[*/
<?php if(function_exists('pt_get_captch') && $_REQUEST['emsg']=='captch'){ ?>
jQuery("#<?php $cap_secure = get_captch_id(); echo $cap_secure;?>").focus();
<?php } ?>
var ptthemes_category_dislay = '<?php echo get_option('ptthemes_category_dislay');?>';
var user_val = '';
function set_login_registration_frm(val)
{
	if(val=='existing_user')
	{	user_val = '&user_val=existing';
		document.getElementById('login_user_frm_id').style.display = 'block';
		document.getElementById('contact_detail_id').style.display = 'none';
		document.getElementById('user_login_or_not').value = val;
	}else  //new_user
	{	user_val = '&user_val=new';
		document.getElementById('contact_detail_id').style.display = 'block';
		document.getElementById('login_user_frm_id').style.display = 'none';
		document.getElementById('user_login_or_not').value = val;
	}
}
<?php if($user_login_or_not)
{
?>
set_login_registration_frm('<?php echo $user_login_or_not;?>');
<?php
}
?>
/*]]>*/
</script>
 <?php get_footer(); ?>
<?php //record time to submit
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$_SESSION['submit_start'] = '';
$_SESSION['submit_start'] = $time;
?>