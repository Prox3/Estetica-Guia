<?php
global $wpdb;
// read the post from PayPal system and add 'cmd'
		$req = 'cmd=_notify-validate';
		
		foreach ($_POST as $key => $value) 
		{
			$value = urlencode(stripslashes($value));
			$value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i','${1}%0D%0A${3}',$value);// this fiexs paypals invalid IPN , STIOFAN #################################
			$req .= "&$key=$value";
		}
		
		// post back to PayPal system to validate
		$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
		$fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);
		//$fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);

		
		
		if (!$fp) 
		{
			// HTTP ERROR
		} 
		else 
		{
			fputs ($fp, $header . $req);
			
			while (!feof($fp)) 
			{
				$res = fgets ($fp, 1024);
				if (strcmp ($res, "VERIFIED") == 0) 
				{
		// yes valid recipt
		$postid               = $_POST['custom'];
		$item_name			  = $_POST['item_name'];
		$txn_id				  = $_POST['txn_id'];
		$payment_status       = $_POST['payment_status'];
		$payment_type         = $_POST['payment_type'];
		$payment_date         = $_POST['payment_date'];
		$txn_type             = $_POST['txn_type'];
		
		$mc_currency          = $_POST['mc_currency']; // get curancy code
		$mc_gross             = $_POST['mc_gross'];
		$mc_amount3           = $_POST['mc_amount3'];
		$receiver_email       = $_POST['receiver_email'];
		//$txn_type             = $_POST['txn_type'];
		
		$post_pkg = get_post_meta($postid, 'package_pid',true); // get the post price package ID
		
		global $price_db_table_name,$wpdb;
		$pricesql = "select * from $price_db_table_name where status=1 and pid=$post_pkg"; // Get the price package info
		$priceinfo = $wpdb->get_row($pricesql, ARRAY_A); // Get the price package info
		$pkg_price = $priceinfo['amount']; // get the price of the package		
		$currency_code = get_currency_type(); // get the actual curency code		
		$paymentOpts = get_payment_optins('paypal'); // Get the site paypal address
		$merchantid = $paymentOpts['merchantid']; // Get the site paypal address
		if($mc_gross){$paid_amt = $mc_gross;}else{$paid_amt = $mc_amount3;}
		
		$productinfosql = "select ID,post_title,guid,post_author from $wpdb->posts where ID = $postid";
		$productinfo = $wpdb->get_results($productinfosql);
		foreach($productinfo as $productinfoObj)
		{
			$post_link = home_url().'/?ptype=preview&alook=1&pid='.$postid;
			$post_title = '<a href="'.$post_link.'">'.$productinfoObj->post_title.'</a>'; 
			$aid = $productinfoObj->post_author;
			$userInfo = get_author_info($aid);
			$to_name = $userInfo->user_nicename;
			$to_email = $userInfo->user_email;
			$user_email = $userInfo->user_email;
		}
		
######################################
######## FRAUD CHECKS ################
######################################	
$fraud=0; // Set no fraude
$fraud_msg=''; //Set blank fraud message
if($receiver_email!=$merchantid){$fraud=1; $fraud_msg= __('### The PayPal reciver email address does not match the paypal address for this site ###<br />');}
if($paid_amt!=$pkg_price){$fraud=1; $fraud_msg.= __('### The paid amount does not match the price package selected ###<br />');}
if($mc_currency!=$currency_code){$fraud=1; $fraud_msg.= __('### The currency code returned does not match the code on this site. ###<br />');}
		
		
######################################
######## PAYMENT SUCCESSFUL ##########
######################################		
if($txn_type == 'web_accept' || $txn_type == 'subscr_payment' || $txn_type == 'recurring_payment' || $txn_type == 'express_checkout'){

		$post_default_status = get_property_default_status();
		if($post_default_status=='')
		{
			$post_default_status = 'publish';
		}
		if(!$fraud){set_property_status($postid,$post_default_status);}
		
		if($fraud){$transaction_details .= __('WARNING FRAUD DETECTED PLEASE CHECK THE DETAILS - (IF CORRECT, THEN PUBLISH THE POST)<br />');}
		$transaction_details .= $fraud_msg;
		$transaction_details .= "--------------------------------------------------<br />";
		$transaction_details .= "Payment Details for Place Listing ID #$postid<br />";
		$transaction_details .= "--------------------------------------------------<br />";
		$transaction_details .= " Place Listing Title: $item_name <br />";
		$transaction_details .= "--------------------------------------------------<br />";
		$transaction_details .= "  Trans ID: $txn_id<br />";
		$transaction_details .= "  Status: $payment_status<br />";
		$transaction_details .= "  Type: $payment_type<br />";
		$transaction_details .= "  Date: $payment_date<br />";
		$transaction_details .= "  Method: $txn_type<br />";
		$transaction_details .= "--------------------------------------------------<br />";		
		$transaction_details .= "Information Submitted URL<br />";
		$transaction_details .= "--------------------------------------------------<br />";
		$transaction_details .= "  $post_title<br />";
		
		############ SET THE INVOICE STATUS START ############
		if($txn_type == 'recurring_payment' || $txn_type == 'subscr_payment'){
		############# INSERT TRANSCATION DETAILS START ###############
		$my_invoice['post_title'] = $postid;
		$my_invoice['post_type'] = 'invoice';
		$my_invoice['post_status'] = 'publish';
		$my_invoice['post_content'] = str_replace("&", "\n", urldecode($req));
		$my_invoice['post_author'] = $aid;
		$last_invoiceid = wp_insert_post( $my_invoice ); //Insert the post into the database
		// UPDATE THE META
		$invoice_status = 'Subscription-Payment';
		$custom_invoice["paid_amount"] = $paid_amt;
		$custom_invoice['package_pid'] = $post_pkg;
		$custom_invoice['alive_days'] = $priceinfo['days'];
		$custom_invoice['paymentmethod'] = 'Paypal';
		$custom_invoice['post_city_id'] = get_post_meta($postid, 'post_city_id',true);
		update_post_meta($last_invoiceid, "_status", $invoice_status);
		foreach($custom_invoice as $key=>$val)
		{				
			update_post_meta($last_invoiceid, $key, $val);
		}
		############# INSERT TRANSCATION DETAILS END #################			
			
			}else{
		$pid_sql = "select p.ID from $wpdb->posts p join $wpdb->postmeta pm on pm.post_id=p.ID where p.post_title=\"$postid\" AND meta_key='_status' AND meta_value='Unpaid' ORDER BY p.ID desc";
		$invoice_id = $wpdb->get_var($pid_sql);
		update_post_meta($invoice_id, "_status", 'Paid');
		$my_post['post_content'] = str_replace("&", "\n", urldecode($req));
		$my_post['ID'] = $invoice_id;
		$my_post['post_author'] = $aid;
		$last_postid = wp_update_post($my_post);
		}
		############ SET THE INVOICE STATUS END ############
		
		adminEmail($postid,$aid,'payment_success',$transaction_details); // email to admin
		clientEmail($postid,$aid,'payment_success',$transaction_details); // email to client
}
######################################
######## SUBSCRIPTION FAILED #########
######################################
elseif($txn_type == 'subscr_cancel' || $txn_type == 'subscr_failed'){
// Set the subscription ac canceled
$pid_sql = "select p.ID, p.post_content, p.post_author from $wpdb->posts p join $wpdb->postmeta pm on pm.post_id=p.ID where p.post_title=\"$postid\" AND meta_key='_status' AND meta_value='Subscription-Active' ORDER BY p.ID desc";
		$invoice_id = $wpdb->get_row($pid_sql);
		update_post_meta($invoice_id->ID, "_status", 'Subscription-Canceled');
		$my_post['post_content'] = str_replace("&", "\n", urldecode($req));
		$my_post['post_content'] .= '\n############## ORIGINAL SUBSCRIPTION INFO BELOW ####################\n';
		$my_post['post_content'] .= $invoice_id->post_content;
		$my_post['ID'] = $invoice_id->ID;
		$my_post['post_author'] = $invoice_id->post_author;
		$last_postid = wp_update_post($my_post);
		
// Set the experation date
$pid_sql2 = "select p.ID, p.post_date from $wpdb->posts p join $wpdb->postmeta pm on pm.post_id=p.ID where p.post_title=\"$postid\" AND meta_key='_status' AND (meta_value='Subscription-Payment' OR meta_value='Paid') ORDER BY p.post_date desc";
		$invoice_id2 = $wpdb->get_row($pid_sql2);
		$d1 = $invoice_id2->post_date; // get past payment date
		$d2 = date('Y-m-d'); // get current date
		$date_diff = round(abs(strtotime($d1)-strtotime($d2))/86400); // get the differance in days
		// 
		if($priceinfo['sub_units']=='D'){$mult = 1;}
		if($priceinfo['sub_units']=='W'){$mult = 7;}
		if($priceinfo['sub_units']=='M'){$mult = 30;}
		if($priceinfo['sub_units']=='Y'){$mult = 365;}
		$pay_days = ($priceinfo['sub_units_num']*$mult);
		$days_left = ($pay_days-$date_diff); // Get days left
		$expire_date = date('Y-m-d', strtotime("+".$days_left." days"));
		update_post_meta($postid, "expire_date", $expire_date);


}
######################################
######## SUBSCRIPTION CREATED ########
######################################
elseif($txn_type == 'subscr_signup' ){
		############# INSERT TRANSCATION DETAILS START ###############
		$my_invoice['post_title'] = $postid;
		$my_invoice['post_type'] = 'invoice';
		$my_invoice['post_status'] = 'publish';
		$my_invoice['post_content'] = str_replace("&", "\n", urldecode($req));
		$my_invoice['post_author'] = $aid;
		$last_invoiceid = wp_insert_post( $my_invoice ); //Insert the post into the database
		// UPDATE THE META
		$invoice_status = 'Subscription-Active';
		$custom_invoice["paid_amount"] = $paid_amt;
		$custom_invoice['package_pid'] = $post_pkg;
		$custom_invoice['alive_days'] = $priceinfo['days'];
		$custom_invoice['paymentmethod'] = 'Paypal';
		$custom_invoice['post_city_id'] = get_post_meta($postid, 'post_city_id',true);
		update_post_meta($last_invoiceid, "_status", $invoice_status);
		foreach($custom_invoice as $key=>$val)
		{				
			update_post_meta($last_invoiceid, $key, $val);
		}
		############# INSERT TRANSCATION DETAILS END #################	


}
######################################
######## PAYMENT SUCCESSFUL ##########
######################################




	}
	else if (strcmp ($res, "INVALID") == 0) 
					
	{
		adminEmail($_POST['custom'],'1','payment_fail'); // email to admin

	}
}
		}

?>