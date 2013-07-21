 

<div id="sign_up">



<div class="login_content">
<?php echo stripslashes(get_option('ptthemes_reg_page_content'));?>
</div>
<div class="registration_form_box">



 <h4><?php 
			 if($_REQUEST['page']=='login' && $_REQUEST['page1']=='sign_up')
			{
				_e(REGISTRATION_NOW_TEXT);
			}else
			{
				_e(REGISTRATION_NOW_TEXT);
			}
			 ?></h4> 
             
              <?php
if ( $_REQUEST['emsg']==1)
{
	echo "<p class=\"error_msg\"> ".EMAIL_USERNAME_EXIST_MSG." </p>";
}elseif($_REQUEST['emsg']=='regnewusr')
{
	echo "<p class=\"error_msg\"> ".REGISTRATION_DESABLED_MSG." </p>";
}
?>

 <form name="cus_registerform" id="cus_registerform" action="<?php echo get_ssl_normal_url(home_url().'/?ptype=login&amp;action=register'); ?>" method="post">
 <input type="hidden" name="reg_redirect_link" value="<?php echo $_SERVER['HTTP_REFERER'];?>" />	 
   
<div class="form_row clearfix">
  <label><?php _e(EMAIL_TEXT) ?><span class="indicates">*</span></label>
  <input type="text" name="user_email" id="user_email" class="textfield" value="<?php echo esc_attr(stripslashes($user_email)); ?>" size="25" />
    <div id="reg_passmail">
	  <?php _e(REGISTRATION_MESSAGE) ?>
	</div>
    <span id="user_emailInfo"></span>
</div>
<div class="row_spacer_registration clearfix" >
<div class="form_row clearfix">
  <label>
  <?php _e(FIRST_NAME_TEXT) ?>
  <span class="indicates">*</span></label>
  <input type="text" name="user_fname" id="user_fname" class="textfield" value="<?php echo esc_attr(stripslashes($user_fname)); ?>" size="25"  />
   <span id="user_fnameInfo"></span>
</div>
</div>
<?php if(get_option('ptthemes_show_user_pass')){?>
<div class="row_spacer_registration clearfix" >
<div class="form_row clearfix">
  <label>
  <?php _e(PASSWORD_TEXT) ?>
  <span class="indicates">*</span></label>
  <input type="password" name="user_pass" id="user_pass" class="textfield" value="" size="25"  />
   <span id="user_fnameInfo"></span>
</div>
</div>

<div class="row_spacer_registration clearfix" >
<div class="form_row clearfix">
  <label>
  <?php _e(CONFIRM_PASSWORD_TEXT) ?>
  <span class="indicates">*</span></label>
  <input type="password" name="user_pass2" id="user_pass2" class="textfield" value="" size="25"  />
   <span id="user_fnameInfo"></span>
</div>
</div>
<?php }?>
<?php do_action( 'social_connect_form' ); ?>
<input type="submit" name="registernow" value="<?php _e(REGISTER_NOW_TEXT);?>" class="b_registernow" />
</form>

</div>
</div>