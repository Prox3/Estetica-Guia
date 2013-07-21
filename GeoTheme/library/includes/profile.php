<?php
if($_REQUEST['getfbpic']){get_facebook_pic();}
if($_REQUEST['gettwpic']){get_twitter_pic();}
global $current_user,$wpdb;
if($_POST)
{
	$user_id = $current_user->data->ID;
	$user_email = $_POST['user_email'];
	$userName = $_POST['user_fname'];
	$pwd = $_POST['pwd'];
	$cpwd = $_POST['cpwd'];
	
	if(isset($_POST['user_url'])){$user_url_sql = ', user_url="'.mysql_real_escape_string($_POST['user_url']).'"';}		

	
	if($user_email)
	{
		$check_users=$wpdb->get_var("select ID from $wpdb->users where user_email = \"$user_email\" AND ID!=\"$user_id\"");
		if($check_users)
		{
			wp_redirect(home_url().'/?ptype=profile&emsg=wemail');exit;	
		}
		
	}else
	{
			wp_redirect(home_url().'/?ptype=profile&emsg=empty_email');exit;
	}
	if($pwd!=$cpwd)
	{
		wp_redirect(home_url().'/?ptype=profile&emsg=pw_nomatch');exit;
	}
	if($userName)
	{
		if($pwd)
		{
			$pwd = md5($pwd);
			$subsql = " , user_pass=\"$pwd\"";	
		}
		//$user_nicename = get_user_nice_name($userName); //generate nice name
		$updateUsersql = "update $wpdb->users set user_email=\"$user_email\", display_name=\"$userName\" $user_url_sql $subsql  where ID=\"$user_id\"";
		$wpdb->query($updateUsersql);
#############################################
############# UPDATE USER META ##############
#############################################
if(isset($_POST['aim'])){update_user_meta($user_id, 'aim', mysql_real_escape_string($_POST['aim']));}		
if(isset($_POST['yim'])){update_user_meta($user_id, 'yim', mysql_real_escape_string($_POST['yim']));}		
if(isset($_POST['jabber'])){update_user_meta($user_id, 'jabber', mysql_real_escape_string($_POST['jabber']));}		
if(isset($_POST['description'])){update_user_meta($user_id, 'description', mysql_real_escape_string($_POST['description']));}		
if(isset($_POST['country'])){update_user_meta($user_id, 'country', mysql_real_escape_string($_POST['country']));}		
if(isset($_POST['facebook'])){update_user_meta($user_id, 'facebook', mysql_real_escape_string($_POST['facebook']));}		
if(isset($_POST['twitter'])){update_user_meta($user_id, 'twitter', mysql_real_escape_string($_POST['twitter']));}		
if(isset($_POST['gplus'])){update_user_meta($user_id, 'gplus', mysql_real_escape_string($_POST['gplus']));}		
if(isset($_POST['user_city'])){update_user_meta($user_id, 'user_city', mysql_real_escape_string($_POST['user_city']));}		
################ START PROFILE PIC UPLOAD	
if($_FILES) 
{
						$destination_path = ABSPATH.'/wp-content/uploads/profile_pics/';
						if (!file_exists(ABSPATH.'/wp-content/uploads/profile_pics/')){
						  mkdir(ABSPATH.'/wp-content/uploads/profile_pics/', 0777);
						} 
						$image_var = 'user_pic_url_upload';
						if ((($_FILES[$image_var]["type"] == "image/gif")
						|| ($_FILES[$image_var]["type"] == "image/png")
						|| ($_FILES[$image_var]["type"] == "image/jpeg")
						|| ($_FILES[$image_var]["type"] == "image/jpeg")
						|| ($_FILES[$image_var]["type"] == "image/pjpeg"))
						&& ($_FILES[$image_var]["size"] < 2097152 && $_FILES[$image_var]['name'] && $_FILES[$image_var]['size']>0))
						{
							
							$name = createRandomString().str_replace(',','_',$_FILES[$image_var]['name']);
							$tmp_name = $_FILES[$image_var]['tmp_name'];
							$target_path = $destination_path . $name;
							if(move_uploaded_file($tmp_name, $target_path)) 
							{
								### remove old pic start ###
								$old_pic_url = get_user_meta( $user_id, 'user_pic_url', true );
								$old_pic_path = str_replace(site_url(), "", $old_pic_url);
								@unlink(ABSPATH.$old_pic_path);
								### remove old pic end ###
								$imagepath1 = site_url() ."/wp-content/uploads/profile_pics/".$name;
								update_user_meta($user_id, 'user_pic_url', mysql_real_escape_string($imagepath1));
								//echo $imagepath1;exit;
							}
						}else{$pic_error = __('Only jpg, gif and png files less than 2MB allowed.');}
					}					
################ END PROFILE PIC UPLOAD					
		
		
		//wp_redirect(home_url().'/?ptype=profile&msg=success');exit;
	}

	
}
?>
<?php get_header(); ?>
  <div id="wrapper" class="clearfix">
    <div id="inner_pages" class="clearfix" >
        <h1><?php echo EDIT_PROFILE_TITLE; ?> </h1>   
       <div class="breadcrumb clearfix"><?php if ( get_option( 'ptthemes_breadcrumbs' )) {  ?>
        
            <div class="breadcrumb_in"><?php if(function_exists('bcn_display')){bcn_display();} ?></div>
       
    <?php } ?> </div>
        <div id="content" class="content_index clearfix">			 
<div id="sign_up">


<?php
if ( $_REQUEST['msg']=='success')
{
	echo "<p class=\"message\"> ".EDIT_PROFILE_SUCCESS_MSG." </p>";
}
if ( $_REQUEST['emsg']=='empty_email')
{
	echo "<p class=\"error_msg_fix\"> ".EMPTY_EMAIL_MSG." </p>";
}elseif ( $_REQUEST['emsg']=='wemail')
{
	echo "<p class=\"error_msg_fix\"> ".ALREADY_EXIST_MSG." </p>";
}elseif ( $_REQUEST['emsg']=='pw_nomatch')
{
	echo "<p class=\"error_msg_fix\"> ".PW_NO_MATCH_MSG." </p>";
}
?> 
<div class="registration_form_box">
<form name="profileform" id="profileform" action="<?php echo home_url().'/?ptype=profile'; ?>" method="post" enctype="multipart/form-data">
<?php
if($_POST)
{
	$user_email = $_POST['user_email'];	
	$user_fname = $_POST['user_fname'];	
}else
{
	$user_email = $current_user->data->user_email;	
	$user_fname = $current_user->data->display_name;
	$user_url = $current_user->data->user_url;
}
$user_id = $current_user->data->ID;
?>

<?php if(get_option('ptthemes_show_user_pic_url')){?>
<div class="form_row clearfix">
<?php echo get_avatar( $user_id, 60, $template_path . ''.get_bloginfo('template_directory').'/images/gravatar.png' ); ?> 
<label><?php echo USER_PIC; ?><span class="indicates">*</span></label>
<input type="text" name="user_pic_url" id="user_pic_url" class="textfield" value="<?php echo esc_attr(stripslashes(get_user_meta( $user_id, 'user_pic_url', true ))); ?>" size="25"  />
 <div class="form_row clearfix"></div>
<input type="file" name="user_pic_url_upload" id="user_pic_url_upload"  />
<input type="submit" value="<?php _e('Upload');?>" name="Upload"   />
<span id="user_fnameInfo"><?php if($pic_error){echo $pic_error;}?></span>

<?php if(get_user_meta($user_id, 'social_connect_facebook_id', true)){?>
<span id="get_fb_pic"><a href="<?php echo get_bloginfo('url').'/?ptype=profile&getfbpic=1';?>"><button type="button" class="get_fb_pic" ><?php _e('Get Facebook Pic');?></button></a>
</span>
<?php }?>

<?php if(get_user_meta($user_id, 'social_connect_twitter_id', true)){?>
<span id="get_tw_pic"><a href="<?php echo get_bloginfo('url').'/?ptype=profile&gettwpic=1';?>"><button type="button" class="get_tw_pic" ><?php _e('Get Twitter Pic');?></button></a>
</span>
<?php }?>

</div>
<?php }?>

<div class="form_row clearfix">
  <label><?php echo EMAIL_TEXT; ?><span class="indicates">*</span></label>
  <input type="text" name="user_email" id="user_email" class="textfield" value="<?php echo esc_attr(stripslashes($user_email)); ?>" size="25" />
    <div id="reg_passmail">
	  <?php echo REGISTRATION_MESSAGE; ?>
	</div>
    <span id="user_emailInfo"></span>
</div>

<div class="row_spacer_registration clearfix" >
<div class="form_row clearfix">
  <label>
  <?php echo FIRST_NAME_TEXT; ?>
  <span class="indicates">*</span></label>
  <input type="text" name="user_fname" id="user_fname" class="textfield" value="<?php echo esc_attr(stripslashes($user_fname)); ?>" size="25"  />
   <span id="user_fnameInfo"></span>
</div>

<?php if(get_option('ptthemes_show_user_url')){?>
<div class="form_row clearfix">
  <label>
  <?php echo USER_WEBSITE ?>
  </label>
  <input type="text" name="user_url" id="user_url" class="textfield" value="<?php echo esc_attr(stripslashes($user_url)); ?>" size="25"  />
   <span id="user_url"></span>
</div>
<?php }?>

<?php if(get_option('ptthemes_show_aim')){?>
<div class="form_row clearfix">
  <label>
  <?php echo USER_AIM ?>
  </label>
  <input type="text" name="aim" id="aim" class="textfield" value="<?php echo esc_attr(stripslashes(get_user_meta( $user_id, 'aim', true ))); ?>" size="25"  />
   <span id="aim"></span>
</div>
<?php }?>

<?php if(get_option('ptthemes_show_yim')){?>
<div class="form_row clearfix">
  <label>
  <?php echo USER_YIM ?>
  </label>
  <input type="text" name="yim" id="yim" class="textfield" value="<?php echo esc_attr(stripslashes(get_user_meta( $user_id, 'yim', true ))); ?>" size="25"  />
   <span id="yim"></span>
</div>
<?php }?>

<?php if(get_option('ptthemes_show_jabber')){?>
<div class="form_row clearfix">
  <label>
  <?php echo USER_JABBER ?>
  </label>
  <input type="text" name="jabber" id="jabber" class="textfield" value="<?php echo esc_attr(stripslashes(get_user_meta( $user_id, 'jabber', true ))); ?>" size="25"  />
   <span id="jabber"></span>
</div>
<?php }?>

<?php if(get_option('ptthemes_show_description')){?>
<div class="form_row clearfix">
  <label>
  <?php echo USER_BIO ?>
  </label>
  <textarea name="description" id="description" rows="5" cols="30"><?php echo esc_attr(stripslashes(get_user_meta( $user_id, 'description', true ))); ?></textarea>
   <span id="bio"></span>
</div>
<?php }?>

<?php if(get_option('ptthemes_show_country')){?>
<div class="form_row clearfix">
  <label>
  <?php echo USER_COUNTRY ?>
  <?php $user_country = get_user_meta( $user_id, 'country', true ); $u_country = explode("->", $user_country);?>
  <div class="flag flag-<?php echo $u_country[0];?>" title="<?php echo $u_country[1];?>"><div class="city"><?php echo $u_country[1];?></div></div>
  </label>
  <select name="country" id="country">
  <option value=""><?php _e('Select Country');?></option>
  <?php $user_countries = get_option('user_countries');
  $user_countries_arr = explode(",", $user_countries);
  $user_country = get_user_meta( $user_id, 'country', true );
  foreach($user_countries_arr as $country){
	  $co = explode("->", $country);
	  $selected ='';
	  if($user_country==$country){$selected ='selected="selected"';}
	  echo  '<option '.$selected.' value="'.$country.'">'.$co[1].'</option>';
}
  ?>
  </select>
   <span id="country"></span>
</div>
<?php }?>

<?php if(get_option('ptthemes_show_city')){?>
<div class="form_row clearfix">
  <label>
  <?php echo USER_CITY ?>
  </label>
  <input type="text" name="user_city" id="user_city" class="textfield" value="<?php echo esc_attr(stripslashes(get_user_meta( $user_id, 'user_city', true ))); ?>" size="25"  />
   <span id="city"></span>
</div>
<?php }?>

<?php if(get_option('ptthemes_show_facebook')){?>
<div class="form_row clearfix">
  <label>
  <?php echo USER_FACEBOOK ?>
  </label>
  <input type="text" name="facebook" id="facebook" class="textfield" value="<?php echo esc_attr(stripslashes(get_user_meta( $user_id, 'facebook', true ))); ?>" size="25"  />
   <span id="facebook"></span>
</div>
<?php }?>

<?php if(get_option('ptthemes_show_twitter')){?>
<div class="form_row clearfix">
  <label>
  <?php echo USER_TWITTER ?>
  </label>
  <input type="text" name="twitter" id="twitter" class="textfield" value="<?php echo esc_attr(stripslashes(get_user_meta( $user_id, 'twitter', true ))); ?>" size="25"  />
   <span id="twitter"></span>
</div>
<?php }?>

<?php if(get_option('ptthemes_show_gplus')){?>
<div class="form_row clearfix">
  <label>
  <?php echo USER_GPLUS ?>
  </label>
  <input type="text" name="gplus" id="gplus" class="textfield" value="<?php echo esc_attr(stripslashes(get_user_meta( $user_id, 'gplus', true ))); ?>" size="25"  />
   <span id="gplus"></span>
</div>
<?php }?>

<div class="form_row clearfix">
  <label>
  <?php echo PASSWORD_TEXT; ?>
  </label>
  <input type="password" name="pwd" id="pwd" class="textfield" value="" size="25"  />
  <span id="pwdInfo"></span>
</div>
<div class="form_row clearfix">
  <label>
  <?php echo CONFIRM_PASSWORD_TEXT; ?>
  </label>
  <input type="password" name="cpwd" id="cpwd" class="textfield" value="" size="25"  />
  <span id="cpwdInfo"></span>
</div>
</div> 
<input type="submit" name="registernow" value="<?php echo EDIT_BUTTON;?>" class="b_registernow" />
</form>
</div>
</div>
</div> <!-- content #end -->
<div id="sidebar">
<?php dynamic_sidebar('Author Pages Sidebar'); ?>
</div>
</div>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/library/js/reg_validation.js"></script> 
<?php get_footer(); ?>