<?php
global $General, $wpdb,$current_user;
if(get_option('claim_listing')==1){
if($_POST && $current_user->ID)
{
	if(function_exists('pt_check_captch_cond'))
	{
		if(!pt_check_captch_cond())
		{
			$url = get_permalink($post->ID);
			if(strstr($url,'?'))
			{
			  $url = $url."&emsg=captch";
			}else
			{
				$url = $url."?emsg=captch";			  
			}
			wp_redirect($url);
			exit;
		}
	}
	
	
	$pid = mysql_real_escape_string($_POST['pid']);
	$post_details = get_post($pid); // get post details
	
	$uid = $post_details->post_author;
	$claimsql = "select * from $wpdb->users where ID=\"$uid\"";
	$claiminfo = $wpdb->get_results($claimsql);
	
	
	$list_id = mysql_real_escape_string($_POST['pid']);
	$list_title = mysql_real_escape_string($post_details->post_title);
	$user_id = $current_user->ID;
	$user_name = $current_user->user_login;
	$user_email = $current_user->user_email;
	$user_fullname = mysql_real_escape_string($_POST['full_name']);
	$user_number = mysql_real_escape_string($_POST['user_number']);
	$user_position = mysql_real_escape_string($_POST['user_position']);
	$user_comments = mysql_real_escape_string($_POST['user_comments']);
	$claim_date = date("F j, Y, g:i a");
	$org_author = $claiminfo[0]->user_login;
	$org_authorid = $post_details->post_author;
	$rand_string = createRandomString();
	$user_ip = getenv("REMOTE_ADDR") ; 

	if($_REQUEST['pid'])
	{
		$wp_claim = $table_prefix.'claim';
		$claimsql = "INSERT INTO $wp_claim (list_id, list_title, user_id, user_name, user_email, user_fullname, user_number, user_position, user_comments, claim_date, org_author, org_authorid, rand_string, user_ip ) VALUES ('$list_id', '$list_title', '$user_id', '$user_name', '$user_email', '$user_fullname', '$user_number', '$user_position', '$user_comments', '$claim_date', '$org_author', '$org_authorid','$rand_string', '$user_ip' )";	
	
		$claim = $wpdb->query($claimsql);
	}
######################################## CLAIM EMAIL ######################################################
		adminEmail($list_id,$user_id,'claim_requested'); // email to admin
		clientEmail($list_id,$user_id,'claim_requested'); // email to client
###################################### CLAIM EMAIL END ####################################################
		
########## AUTO APPROVE EMAIL BELOW ###########
if(get_option('auto_claim')==1){
		clientEmail($list_id,$user_id,'auto_claim',$rand_string); // email to client
}
###################################### CLIENT EMAIL END ####################################################
	$url = get_permalink($post->ID);
	if(strstr($url,'?'))
	  {
		  $url = $url."&claim_request=success";
	  }else
	  {
			$url = $url."?claim_request=success";			  
	  }
	wp_redirect($url);
}
}
?>