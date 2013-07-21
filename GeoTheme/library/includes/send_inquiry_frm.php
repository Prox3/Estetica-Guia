<?php
if($_POST)
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
	$yourname = $_POST['inq_name'];
	$youremail = $_POST['inq_email'];
	$inq_phone = $_POST['inq_phone'];
	$frnd_comments = $_POST['inq_msg'];
	$pid = $_POST['pid'];

	$post_title = '<a href="'.get_permalink($post->ID).'">'.$post->post_title.'</a>'; 
	//$to_name = get_post_meta($post->ID,'email',true);
	$to_email = get_post_meta($post->ID,'email',true);
	
	$author_id=$post->post_author;
	$user_info = get_userdata($author_id);
	$to_name = $user_info->first_name;
	if($to_email=='')
	{
		$to_email = get_option('admin_email');	
	}
	///////Inquiry EMAIL START//////
	$client_message = $frnd_comments;
	$client_message .= __('<br>From : ').$yourname.__('<br>Phone : ').$inq_phone.'<br><br>Send from - <b><a href="'.get_option('siteurl').'">'.get_option('blogname').'</a></b>.';
	/////////////customer email//////////////

	if($to_email)
	{
		//sendEmail($youremail,$yourname,$to_email,$to_name,$subject,$client_message,$extra='');
	sendEmail($youremail,$yourname,$to_email,$to_name,'',$client_message,$extra='','send_enquiry',$_REQUEST['pid']);///To clidne email
	}
	//////Inquiry EMAIL END////////	
	$url = get_permalink($post->ID);
	if(strstr($url,'?'))
	  {
		  $url = $url."&send_inquiry=success";
	  }else
	  {
			$url = $url."?send_inquiry=success";			  
	  }
	wp_redirect($url);
}
?>