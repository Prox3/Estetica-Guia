<?php
if($_POST && !$userInfo)
{
	if (  $_SESSION['property_info']['user_email'] == '' )
	{
		$_SESSION['userinset_error'] = array();
		$_SESSION['userinset_error'][] = 'Email for Contact Details is Empty. Please enter Email, your all informations will sent to your Email.';
		wp_redirect(home_url().'?ptype=post_listing&backandedit=1&usererror=1');
		exit;
		//echo "<div class=error_msg>".__('Email for Contact Details is Empty. Please enter Email, your all informations will sent to your Email.')."</div>";	
		//echo '<h6><b><a href="'.home_url().'/?pytpe=post_listing&backandedit=1">Return to Add Listing</a></b></h6>';
		//exit;
	}
	
	require( 'wp-load.php' );
	require(ABSPATH.'wp-includes/registration.php');
	
	global $wpdb;
	$errors = new WP_Error();
	
	$user_email = $_SESSION['property_info']['user_email'];
	$user_login = $user_email;	
	$user_login = sanitize_user( $user_login );
	$user_email = apply_filters( 'user_registration_email', $user_email );
	
	if(get_option('ptthemes_show_user_pass')){
	$user_pass  = mysql_real_escape_string($_SESSION['property_info']['user_pass1'] );
	$user_pass2 = mysql_real_escape_string($_SESSION['property_info']['user_pass2'] );
	// Check the password
	if ( $user_pass != $user_pass2){
		$errors->add('pass_match', __('ERROR: Passwords do not match.'));
		}
	elseif(strlen($user_pass)<7){
	$errors->add('pass_match', __('ERROR: Password must be 7 characters or more.'));
	}}
	
	// Check the username
	if ( $user_login == '' )
		$errors->add('empty_username', __('ERROR: Please enter a username.'));
	elseif ( !validate_username( $user_login ) ) {
		$errors->add('invalid_username', __('<strong>ERROR</strong>: This username is invalid.  Please enter a valid username.'));
		$user_login = '';
	} elseif ( username_exists( $user_login ) )
		$errors->add('username_exists', __('<strong>ERROR</strong>: '.$user_email.' This username is already registered, please choose another one.'));

	// Check the e-mail address
	if ($user_email == '') {
		$errors->add('empty_email', __('<strong>ERROR</strong>: Please type your e-mail address.'));
	} elseif ( !is_email( $user_email ) ) {
		$errors->add('invalid_email', __('<strong>ERROR</strong>: The email address isn&#8217;t correct.'));
		$user_email = '';
	} elseif ( email_exists( $user_email ) )
		$errors->add('email_exists', __('<strong>ERROR</strong>: '.$user_email.' This email is already registered, please choose another one.'));

	do_action('register_post', $user_login, $user_email, $errors);	
	
	$errors = apply_filters( 'registration_errors', $errors );
	if($errors)
	{
		$_SESSION['userinset_error'] = array();
		foreach($errors as $errorsObj)
		{
			foreach($errorsObj as $key=>$val)
			{
				for($i=0;$i<count($val);$i++)
				{
					$_SESSION['userinset_error'][] = $val[$i];
					if($val[$i]){break;}
				}
			} 
		}
	}	
	if ( $errors->get_error_code() )
	{
		wp_redirect(home_url().'?ptype=post_listing&backandedit=1&usererror=1&pkg='.$_SESSION['property_info']['price_select'].'&user_val=new');
		exit;
	}
	
	if(!$user_pass){$user_pass = wp_generate_password(12,false);}
	$user_id = wp_create_user( $user_login, $user_pass, $user_email );
	
	if ( !$user_id ) {
		//$errors->add('registerfail', sprintf(__('<strong>ERROR</strong>: Couldn&#8217;t register you... please contact the <a href="mailto:%s">webmaster</a> !'), get_option('admin_email')));
		$_SESSION['userinset_error'][] = sprintf(__('<strong>ERROR</strong>: Couldn&#8217;t register you... please contact the <a href="mailto:%s">webmaster</a> !'), get_option('admin_email'));
		wp_redirect(home_url().'?ptype=post_listing&backandedit=1&usererror=1');
		exit;
	}
	
	$user_fname = $_SESSION['property_info']['user_fname'];
	$user_phone = $_SESSION['property_info']['user_phone'];
	$user_twitter = $_SESSION['property_info']['user_twitter'];
	$user_facebook = $_SESSION['property_info']['user_facebook'];
	$userName = $_SESSION['property_info']['user_fname'];
	$user_fname = sanitize_user($_SESSION['property_info']['user_fname']);
	$user_fname = str_replace(",", "", $user_fname);
	$user_nicename = strtolower(str_replace(array("'",'"',"?",".","!","@","#","$","%","^","&","*","(",")","-","+","+"," "),array('','','','-','','-','-','','','','','','','','','','-','-',''),$user_login));
	$user_nicename = get_user_nice_name($user_fname,''); //generate nice name
		
	$user_address_info = array(
							"user_phone" 	=> $user_phone,
							"user_twitter"	=> $user_twitter,	
							"user_facebook"	=> $user_facebook,	
							"first_name"	=>	$user_fname,					
							);
		foreach($user_address_info as $key=>$val)
		{
			update_usermeta($user_id, $key, $val); // User Address Information Here
		}
		$updateUsersql = "update $wpdb->users set user_nicename=\"$user_nicename\" , display_name=\"$user_fname\"  where ID=\"$user_id\"";
		$wpdb->query($updateUsersql);
	
	//wp_new_user_notification($user_id, $user_pass);
	if ( $user_id) 
	{
		//wp_new_user_notification($user_id, $user_pass);
		///////REGISTRATION EMAIL START//////
		$fromEmail = get_site_emailId();
		$fromEmailName = get_site_emailName();
			
		$message  = '<p><b>'.__('Your login Information :').'</b></p>';
		$message  .= '<p>'.sprintf(__('Username: %s'), $user_login) . "</p>";
		$message .= '<p>'.sprintf(__('Password: %s'), $user_pass) . "</p>";
		
		sendEmail($fromEmail,$fromEmailName,$user_email,$userName,'',$message,$extra='','registration',$post_id='','');/// registration email

		//////REGISTRATION EMAIL END////////
	}
	$current_user_id = $user_id;
}
?>