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
	$yourname = $_POST['yourname'];
	$youremail = $_POST['youremail'];
	$frnd_subject = $_POST['frnd_subject'];
	$frnd_comments = $_POST['frnd_comments'];
	$pid = $_POST['pid'];
	$to_email = $_POST['to_email'];
	$to_name = $_POST['to_name'];
	if($_REQUEST['pid'])
	{
		$productinfosql = "select ID,post_title from $wpdb->posts where ID =".$_REQUEST['pid'];
		$productinfo = $wpdb->get_results($productinfosql);
		foreach($productinfo as $productinfoObj)
		{
			$post_title = $productinfoObj->post_title; 
		}
	}
	
	///////Inquiry EMAIL START//////
	global $General;
	global $upload_folder_path;
	
	sendEmail($youremail,$yourname,$to_email,$to_name,$frnd_subject,$frnd_comments,$extra='','send_friend',$_REQUEST['pid']);///To clidne email
	//////Inquiry EMAIL END////////	
	$url = get_permalink($post->ID);
	if(strstr($url,'?'))
	  {
		  $url = $url."&sendtofrnd=success";
	  }else
	  {
			$url = $url."?sendtofrnd=success";			  
	  }
	wp_redirect($url);
}
?>