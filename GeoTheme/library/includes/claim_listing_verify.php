<?php //global $current_user; if($current_user->ID){wp_redirect(get_author_link($echo = false, $current_user->data->ID));}?>
<?php
include_once( 'wp-load.php' );
//include_once(ABSPATH.'wp-includes/claim_listing_verify.php');
			
?>
<?php

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'login';
$errors = new WP_Error();

if ( isset($_GET['key']) )
	$action = 'resetpass';

// validate action so as to default to the login screen
if ( !in_array($action, array('logout', 'lostpassword', 'retrievepassword', 'resetpass', 'rp', 'register', 'login')) && false === has_filter('login_form_' . $action) )
	$action = 'login';

nocache_headers();

//header('Content-Type: '.get_bloginfo('html_type').'; charset='.get_bloginfo('charset'));

if ( defined('RELOCATE') ) { // Move flag is set
	if ( isset( $_SERVER['PATH_INFO'] ) && ($_SERVER['PATH_INFO'] != $_SERVER['PHP_SELF']) )
		$_SERVER['PHP_SELF'] = str_replace( $_SERVER['PATH_INFO'], '', $_SERVER['PHP_SELF'] );

	$schema = ( isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on' ) ? 'https://' : 'http://';
	if ( dirname($schema . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']) != site_url() )
		update_option('siteurl', dirname($schema . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']) );
}

//Set a cookie now to see if they are supported by the browser.
//setcookie(TEST_COOKIE, 'WP Cookie check', 0, COOKIEPATH, COOKIE_DOMAIN);
if ( SITECOOKIEPATH != COOKIEPATH )
	setcookie(TEST_COOKIE, 'WP Cookie check', 0, SITECOOKIEPATH, COOKIE_DOMAIN);

// allow plugins to override the default actions, and to add extra actions if they want
do_action('login_form_' . $action);

$http_post = ('POST' == $_SERVER['REQUEST_METHOD']);

switch ($action) {

case 'logout' :
	//check_admin_referer('log-out');
	wp_logout();

	$redirect_to =  $_SERVER['HTTP_REFERER'];
	//$redirect_to = home_url().'/?ptype=login&loggedout=true';
	if ( isset( $_REQUEST['redirect_to'] ) )
		$redirect_to = $_REQUEST['redirect_to'];
	$redirect_to = home_url();
	wp_safe_redirect($redirect_to);
	exit();

break;

case 'lostpassword' :
case 'retrievepassword' :
	if ( $http_post ) {
		$errors = retrieve_password();
		$error_message = $errors->errors['invalid_email'][0];
		if ( !is_wp_error($errors) ) {
			wp_redirect(home_url().'/?ptype=login&page1=sign_in&checkemail=confirm');
			exit();
		}else
		{
			wp_redirect(home_url().'/?ptype=login&page1=sign_in&emsg=fw');
			exit();
		}
	}
	if ( isset($_GET['error']) && 'invalidkey' == $_GET['error'] ) $errors->add('invalidkey', __('Sorry, that key does not appear to be valid.'));
	do_action('lost_password');
	$message = '<div class="sucess_msg">'.ENTER_USER_EMAIL_NEW_PW_MSG.'</div>';
	$user_login = isset($_POST['user_login']) ? stripslashes($_POST['user_login']) : '';

break;

case 'resetpass' :
case 'rp' :
	$errors = reset_password($_GET['key'], $_GET['login']);

	if ( ! is_wp_error($errors) ) {
		wp_redirect(home_url().'/?ptype=login&action=login&checkemail=newpass');
		exit();
	}

	wp_redirect(home_url().'/?ptype=login&action=lostpassword&page1=sign_in&error=invalidkey');
	exit();

break;

case 'register' :
############################### fix by Stiofan -  HebTech.co.uk ### SECURITY FIX ##############################
	if ( !is_allow_user_register() ) {
		wp_redirect(home_url().'?ptype=login&page1=sign_up&emsg=regnewusr');
		exit();
	}
############################### fix by Stiofan -  HebTech.co.uk ### SECURITY FIX ##############################
	
	$user_login = '';
	$user_email = '';
	if ( $http_post ) {
		$user_login = $_POST['user_email'];
		$user_email = $_POST['user_email'];
		$user_fname = $_POST['user_fname'];
		
		$errors = register_new_user($user_login, $user_email);
	
		if ( !is_wp_error($errors) ) 
		{
			$_POST['log'] = $user_login;
			$_POST['pwd'] = $errors[1];
			$_POST['testcookie'] = 1;
			
			$secure_cookie = '';
			// If the user wants ssl but the session is not ssl, force a secure cookie.
			if ( !empty($_POST['log']) && !force_ssl_admin() )
			{
				$user_name = sanitize_user($_POST['log']);
				if ( $user = get_userdatabylogin($user_name) )
				{
					if ( get_user_option('use_ssl', $user->ID) )
					{
						$secure_cookie = true;
						force_ssl_admin(true);
					}
				}
			}
			if($_REQUEST['reg_redirect_link']=='')
			{
				$_REQUEST['reg_redirect_link']=get_author_link($echo = false, $errors[0]);
			}
			$redirect_to = $_REQUEST['reg_redirect_link'];
			if ( !$secure_cookie && is_ssl() && force_ssl_login() && !force_ssl_admin() && ( 0 !== strpos($redirect_to, 'https') ) && ( 0 === strpos($redirect_to, 'http') ) )
				$secure_cookie = false;
		
			$user = wp_signon('', $secure_cookie);
		
			/*$redirect_to = apply_filters('login_redirect', $redirect_to, isset( $_REQUEST['reg_redirect_link'] ) ? $_REQUEST['reg_redirect_link'] : '', $user);*/
		
			if ( !is_wp_error($user) ) 
			{
				wp_safe_redirect($redirect_to);
				exit();
			}
			exit();
		}
	}

break;

case 'login' :
default:
	$secure_cookie = '';

	if ( !empty($_POST['log']) && !force_ssl_admin() ) {
		$user_name = sanitize_user($_POST['log']);
		if ( $user = get_userdatabylogin($user_name) ) {
			if ( get_user_option('use_ssl', $user->ID) ) {
				$secure_cookie = true;
				force_ssl_admin(true);
			}
		}
	}
	///////////////////////////
	
	if($_REQUEST['redirect_to']=='')
	{
		$_REQUEST['redirect_to']=get_author_link($echo = false, $user->ID);
	}
	if ( isset( $_REQUEST['redirect_to'] ) ) {
		$redirect_to = $_REQUEST['redirect_to'];
		// Redirect to https if user wants ssl
		if ( $secure_cookie && false !== strpos($redirect_to, 'wp-admin') )
			$redirect_to = preg_replace('|^http://|', 'https://', $redirect_to);
	} else {
		$redirect_to = admin_url();
	}

	if ( !$secure_cookie && is_ssl() && force_ssl_login() && !force_ssl_admin() && ( 0 !== strpos($redirect_to, 'https') ) && ( 0 === strpos($redirect_to, 'http') ) )
		$secure_cookie = false;

	$user = wp_signon('', $secure_cookie);

	$redirect_to = apply_filters('login_redirect', $redirect_to, isset( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '', $user);

	if(is_wp_error($user))
	{
		if(strstr($_SERVER['HTTP_REFERER'],'ptype=property_submit') && $_POST['log']!='' && $_POST['pwd']!='')
		{
			wp_redirect($_SERVER['HTTP_REFERER'].'&emsg=1');
		}
	}
	if ( !is_wp_error($user) ) {
		if($redirect_to)
		{
			wp_redirect($redirect_to);
		}else
		{
			wp_redirect(get_author_link($echo = false, $user->data->ID));
		}	exit();
	}

	$errors = $user;
	// Clear errors if loggedout is set.
	if ( !empty($_GET['loggedout']) )
		$errors = new WP_Error();
	// If cookies are disabled we can't log in even with a valid user+pass
	if ( isset($_POST['testcookie']) && empty($_COOKIE[TEST_COOKIE]) )
		$errors->add('test_cookie', __("<strong>ERROR</strong>: Cookies are blocked or not supported by your browser. You must <a href='http://www.google.com/cookies.html'>enable cookies</a> to use WordPress."));

	// Some parts of this script use the main login form to display a message
	if( isset($_GET['loggedout']) && TRUE == $_GET['loggedout'] )
	{
		$successmsg = '<div class="sucess_msg">'.YOU_ARE_LOGED_OUT_MSG.'</div>';
	}
	elseif( isset($_GET['registration']) && 'disabled' == $_GET['registration'] )
	{
		$successmsg = USER_REG_NOT_ALLOW_MSG;
	}
	elseif( isset($_GET['checkemail']) && 'confirm' == $_GET['checkemail'] )
	{
		$successmsg = EMAIL_CONFIRM_LINK_MSG;
	}
	elseif( isset($_GET['checkemail']) && 'newpass' == $_GET['checkemail'] )
	{
		$successmsg = NEW_PW_EMAIL_MSG;
	}
	elseif( isset($_GET['checkemail']) && 'registered' == $_GET['checkemail'] )
	{
		$successmsg = REG_COMPLETE_MSG;
	}
	
	if(($_POST['log'] && $errors) || ($_POST['log']=='' && $_REQUEST['testcookie']))
	{
		if($_REQUEST['pagetype'])
		{
			wp_redirect($_REQUEST['pagetype'].'&emsg=1');
		}else
		{
			wp_redirect(home_url().'?ptype=login&page1=sign_in&logemsg=1');
		}
		exit;
	}
break;
} // end action switch
?>
<?php get_header(); ?>
<script type="text/javascript" >
<?php if ( $user_login ) { ?>
setTimeout( function(){ try{
d = document.getElementById('user_pass');
d.value = '';
d.focus();
} catch(e){}
}, 200);
<?php } else { ?>
try{document.getElementById('user_login').focus();}catch(e){}
<?php } ?>
</script>
<script type="text/javascript" >
<?php if ( $user_login ) { ?>
setTimeout( function(){ try{
d = document.getElementById('user_pass');
d.value = '';
d.focus();
} catch(e){}
}, 200);
<?php } else { ?>
try{document.getElementById('user_login').focus();}catch(e){}
<?php } ?>
</script>
<div id="wrapper" class="clearfix">
<div id="inner_pages" class="clearfix" >
    <h1><?php echo VERIFY_PAGE_TITLE;?></h1>   
    <?php if ( get_option( 'ptthemes_breadcrumbs' )) {  ?>
    <div class="breadcrumb clearfix">
        <div class="breadcrumb_in"><?php if(function_exists('bcn_display')){bcn_display();} ?></div>
    </div>
<?php } ?>
<div id="content" class="full_page" >
<?php

if($current_user->ID)
{
?>
<div class="login_form">
<?php 
############## VERIFY LISITNG CODE ###############
if(get_option('auto_claim')==1){
if($_REQUEST['rs']==''){
	echo '<h2>Verification code does not exist.</h2>';
	
	}else{
####
	$rand_string = $_REQUEST['rs'];	
	$approvesql = "select * from $claim_db_table_name where rand_string=\"$rand_string\"";
	$approveinfo = $wpdb->get_results($approvesql);
	
	if($approveinfo){
	
	
	$pid = $approveinfo[0]->pid;
	$post_id = $approveinfo[0]->list_id;
	$author_id = $approveinfo[0]->user_id;
	$user_id = $current_user->ID;
	$status = $approveinfo[0]->status;
	
	if($author_id==$user_id){
		
		if($status==1){echo '<h2>Listing already verified.</h2>';} elseif($status==2){echo '<h2>Listing verification rejected.</h2>';}else{
	
	$wpdb->query("update $wpdb->posts set post_author=\"$author_id\" where ID=\"$post_id\""); // set new author
	$wpdb->query("update $claim_db_table_name set status='1' where pid=\"$pid\""); // set claim to approved
	$wpdb->query("update $wpdb->postmeta set meta_value='1' where post_id=\"$post_id\" AND meta_key='claimed'"); // make listing caimed
######################################## CLIENT EMAIL ######################################################
		clientEmail($post_id,$author_id,'claim_approved'); // email to client
		
		echo '<h2>Listing Successfully verified, visit listing: <a href="'.get_option('siteurl').'/?p='.$post_id.'">'.$approveinfo[0]->list_title.'</a> </h2>';
###################################### CLIENT EMAIL END ####################################################
		}}else{echo '<h2>Verification code does not match user.</h2>';}}else{echo '<h2>Verification code does not exist.</h2>';}
####
}}else{echo '<h2>Auto verification has been disabled.</h2>';}
##################################################
 	?>
    </div> 
<?php
}else
{
?>
<div class="login_form_l">
<h4>You must be logged in to verify your listing, please login and then re-click the verify link in your email.</h4>
<?php include (TEMPLATEPATH . "/library/includes/login_frm.php");?>
</div>

<?php }?>
</div> <!-- content #end -->
<script type="text/javascript">
try{document.getElementById('user_login').focus();}catch(e){}
</script>
	
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/library/js/reg_validation.js"></script> 
<?php
if($errors->errors['invalidcombo'] || $errors->errors['empty_username'])
{
?>
<script language="javascript">document.getElementById('lostpassword_form').style.display = '';</script>
<?php
}
?>
 <?php get_footer(); ?>