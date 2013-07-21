<?php
function get_captch_id(){
	if(get_option('ptthemes_antispam_dislay')=='Yes'){$cap_num = ((strlen(get_option('admin_email')) * date("z"))) + date("z"); $cap_secure = 'cap_'.$cap_num;}else{$cap_secure='anti_captcha';}
	return $cap_secure;
}
function pt_get_captch($id='')
{
	global $captchaimagepath;
	$captchaimagepath = get_bloginfo('template_url').'/library/captcha/';
	$cap_secure = get_captch_id();
?>
<h5 class="form_title"><?php echo CAPTCHA_TITLE_TEXT;?></h5> 
<div class="form_row clearfix">
<label><?php _e(CAPTCHA);?></label>
<input type="text" id="<?php echo $cap_secure.$id; ?>" name="<?php echo $cap_secure.$id; ?>"  size="6" maxlength="6" class="captcha textfield textfield_m" /> 
<input type="text" name="go_captcha"  size="6" maxlength="6" class="captcha textfield textfield_m" style="display:none"/> 
<img src="<?php bloginfo('template_url');?>/library/captcha/captcha.php" alt="captcha image" />
<?php if(isset($_REQUEST['emsg']) && $_REQUEST['emsg']=='captch'){echo '<br /><span class="message_error2" id="category_span">'.__('Please enter valid Verification code.').'</span>';}?>
</div>
<?php
}
function pt_get_captch_app()
{
	global $captchaimagepath;
	$captchaimagepath = get_bloginfo('template_url').'/library/captcha/';
	$cap_secure = get_captch_id();
	
?>
<li>
    <div class="label-wide"><?php echo CAPTCHA_TITLE_TEXT;?></div>
    <div class="label label-img"><img src="<?php bloginfo('template_url');?>/library/captcha/captcha.php" alt="captcha image" /></div>
    <div class="field"><input type="text" id="<?php echo $cap_secure; ?>" name="<?php echo $cap_secure; ?>" autocorrect="off" autocapitalize="off" size="6" maxlength="6" class="captcha textfield textfield_m" /> 
<input type="text" name="go_captcha"  size="6" maxlength="6" class="captcha textfield textfield_m" style="display:none"/></div>
   

<?php if(isset($_REQUEST['emsg']) && $_REQUEST['emsg']=='captch'){echo '<br /><span class="message_error2" id="category_span">'.__('Please enter valid Verification code.').'</span>';}?>
 <div class="clear"></div>
</li>
<?php
}
function pt_check_captch_cond()
{
	$cap_secure = get_captch_id();
	if($_SESSION[$cap_secure]==$_POST[$cap_secure] && $_POST[$cap_secure]!='')
	{ 
		return true;
	}
	elseif($_SESSION[$cap_secure]==$_POST[$cap_secure.'-1'] && $_POST[$cap_secure.'-1']!='')
	{ 
		return true;
	}
	elseif($_SESSION[$cap_secure]==$_POST[$cap_secure.'-2'] && $_POST[$cap_secure.'-2']!='')
	{ 
		return true;
	}
	else
	{ 
		return false;
	}	
}
?>