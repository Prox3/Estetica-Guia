<?php
global $Cart,$General;
$req = '';
foreach ($_POST as $field=>$value)
{
	$ipnData["$field"] = $value;
	$req .= "&$field=$value";
}

$postid    = intval($ipnData['x_invoice_num']);
$pnref      = $ipnData['x_trans_id'];
$amount     = get_currency_sym().doubleval($ipnData['x_amount']);
$result     = intval($ipnData['x_response_code']);
$respmsg    = $ipnData['x_response_reason_text'];
$customer_email    = $ipnData['x_email'];
$customer_name = $ipnData['x_first_name'];

$fromEmail = get_option('site_email');
$fromEmailName = get_site_emailName();
$subject = "Acknowledge for Place Listing ID #$postid payment";

if ($result == '1')
{
	// Valid IPN transaction.
	$post_default_status = get_property_default_status();
	if($post_default_status=='')
	{
		$post_default_status = 'publish';
	}
	set_property_status($postid,$post_default_status);
	$productinfosql = "select ID,post_title,guid,post_author from $wpdb->posts where ID = $postid";
	$productinfo = $wpdb->get_results($productinfosql);
	foreach($productinfo as $productinfoObj)
	{
		$post_title = '<a href="'.$productinfoObj->guid.'">'.$productinfoObj->post_title.'</a>'; 
		$aid = $productinfoObj->post_author;
		$userInfo = get_author_info($aid);
		$to_name = $userInfo->user_nicename;
		$to_email = $userInfo->user_email;
	}
	$message = __('
			<p>
			payment for Place Listing ID #'.$postid.' confirmation.<br>
			</p>
			<p>
			<b>You may find the details below:</b>
			</p>
			<p>----</p>
			<p>Place Listing Id : '.$postid.'</p>
			<p>Place Listing Title : '.$post_title.'</p>
			<p>User Name : '.$to_name.'</p>
			<p>User Email : '.$to_email.'</p>
			<p>Paid Amount :       '.$amount.'</p>
			<p>Transaction ID :       '.$pnref.'</p>
			<p>Result Code : '.$result.'</p>
			<p>Response Message : '.$respmsg.'</p>
			<p>----</p><br><br>
			<p>Thank you.</p>
			');
	$subject = get_option('post_payment_success_admin_email_subject');
	if(!$subject)
	{
		$subject = "Place Listing Submitted and Payment Success Confirmation Email";
	}
	$content = get_option('post_payment_success_admin_email_content');
	$store_name = get_option('blogname');
	$fromEmail = get_option('site_email');
	$search_array = array('[#to_name#]','[#information_details#]','[#site_name#]');
	$replace_array = array($fromEmail,$message,$store_name);
	//$message = str_replace($search_array,$replace_array,$content);
	
	adminEmail($postid,$aid,'payment_success',$message); // email to admin
	clientEmail($postid,$aid,'payment_success',$message); // email to client
	//@wp_mail($fromEmail,$subject,$message,$headerarr); // email to admin
	
		############ SET THE INVOICE STATUS START ############
		$pid_sql = "select p.ID from $wpdb->posts p join $wpdb->postmeta pm on pm.post_id=p.ID where p.post_title=\"$postid\" AND meta_key='_status' AND meta_value='Unpaid' ORDER BY p.ID desc";
		$invoice_id = $wpdb->get_var($pid_sql);
		update_post_meta($invoice_id, "_status", 'Paid');
		//$my_post['post_content'] = str_replace("&", "\n", urldecode($req));
		$my_post['post_content'] = $req;
		$my_post['ID'] = $invoice_id;
		//$my_post['post_author'] = $aid;
		$last_postid = wp_update_post($my_post);
		
		############ SET THE INVOICE STATUS END ############
		
if($ct_on && file_exists($child_dir.'/library/includes/success.php')){include_once ($child_dir.'/library/includes/success.php');}
else{include_once (TEMPLATEPATH . '/library/includes/success.php');}
	exit;
	
	return true;
}
else if ($result != '1')
{
	$message = __('
			<p>
			payment for Place Listing ID #'.$postid.' incompleted.<br>
			because of '.$respmsg.'
			</p>
			<p>
			<b>You may find the details below:</b>
			</p>
			<p>----</p>
			<p>Place Listing Id : '.$postid.'</p>
			<p>Place Listing Title : '.$post_title.'</p>
			<p>User Name : '.$to_name.'</p>
			<p>User Email : '.$to_email.'</p>
			<p>Paid Amount :       '.$amount.'</p>
			<p>Transaction ID :       '.$pnref.'</p>
			<p>Result Code : '.$result.'</p>
			<p>Response Message : '.$respmsg.'</p>
			<p>----</p><br><br>
			<p>Thank you.</p>
			');
	$subject = get_option('post_payment_success_client_email_subject');
	if(!$subject)
	{
		$subject = "Place Listing Submitted and Payment Success Confirmation Email";
	}
	$content = get_option('post_payment_success_client_email_content');
	$store_name = get_option('blogname');
	$search_array = array('[#to_name#]','[#information_details#]','[#site_name#]');
	$replace_array = array($to_name,$message,$store_name);
	//$message = str_replace($search_array,$replace_array,$content);
	
	adminEmail($postid,$aid,'payment_success',$message); // email to admin
	clientEmail($postid,$aid,'payment_success',$message); // email to client
	//@wp_mail($to_email,$subject,$message,$headerarr); // email to client
	
		############ SET THE INVOICE STATUS START ############
		$pid_sql = "select p.ID from $wpdb->posts p join $wpdb->postmeta pm on pm.post_id=p.ID where p.post_title=\"$postid\" AND meta_key='_status' AND meta_value='Unpaid' ORDER BY p.ID desc";
		$invoice_id = $wpdb->get_var($pid_sql);
		//update_post_meta($invoice_id, "_status", 'Paid');
		//$my_post['post_content'] = str_replace("&", "\n", urldecode($req));
		$my_post['post_content'] = $req;
		$my_post['ID'] = $invoice_id;
		//$my_post['post_author'] = $aid;
		$last_postid = wp_update_post($my_post);
		
		############ SET THE INVOICE STATUS END ############
	
	if($ct_on && file_exists($child_dir.'/library/includes/success.php')){include_once ($child_dir.'/library/includes/success.php');}
else{include_once (TEMPLATEPATH . '/library/includes/success.php');}
	exit;
	
	return false;
}
?>