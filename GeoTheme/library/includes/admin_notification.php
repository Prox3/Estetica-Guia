<?php
if($_POST)
{
	update_option('post_upgrade_success_email_subject',$_POST['post_upgrade_success_email_subject']);
	update_option('post_upgrade_success_email_content',$_POST['post_upgrade_success_email_content']);
	
	update_option('post_renew_success_email_subject',$_POST['post_renew_success_email_subject']);
	update_option('post_renew_success_email_content',$_POST['post_renew_success_email_content']);
	
	update_option('post_upgrade_success_email_subject_admin',$_POST['post_upgrade_success_email_subject_admin']);
	update_option('post_upgrade_success_email_content_admin',$_POST['post_upgrade_success_email_content_admin']);
	
	update_option('post_renew_success_email_subject_admin',$_POST['post_renew_success_email_subject_admin']);
	update_option('post_renew_success_email_content_admin',$_POST['post_renew_success_email_content_admin']);
	
	update_option('post_submited_success_email_subject_admin',$_POST['post_submited_success_email_subject_admin']);
	update_option('post_submited_success_email_content_admin',$_POST['post_submited_success_email_content_admin']);
	
	update_option('post_submited_success_email_subject',$_POST['post_submited_success_email_subject']);
	update_option('post_submited_success_email_content',$_POST['post_submited_success_email_content']);
	
	update_option('post_payment_success_client_email_subject',$_POST['post_payment_success_client_email_subject']);
	update_option('post_payment_success_client_email_content',$_POST['post_payment_success_client_email_content']);
	
	update_option('post_payment_success_admin_email_subject',$_POST['post_payment_success_admin_email_subject']);
	update_option('post_payment_success_admin_email_content',$_POST['post_payment_success_admin_email_content']);
	
	update_option('post_payment_fail_admin_email_subject',$_POST['post_payment_fail_admin_email_subject']);
	update_option('post_payment_fail_admin_email_content',$_POST['post_payment_fail_admin_email_content']);
	
	update_option('registration_success_email_subject',$_POST['registration_success_email_subject']);
	update_option('registration_success_email_content',$_POST['registration_success_email_content']);
	
	update_option('send_inquiry_email_subject',$_POST['send_inquiry_email_subject']);
	update_option('send_inquiry_email_content',$_POST['send_inquiry_email_content']);
	
	update_option('renew_email_subject',$_POST['renew_email_subject']);
	update_option('renew_email_content',$_POST['renew_email_content']);
	
	update_option('claim_email_subject',$_POST['claim_email_subject']);
	update_option('claim_email_content',$_POST['claim_email_content']);
	
	update_option('email_friend_subject',$_POST['email_friend_subject']);
	update_option('email_friend_content',$_POST['email_friend_content']);
	
	update_option('email_enquiry_subject',$_POST['email_enquiry_subject']);
	update_option('email_enquiry_content',$_POST['email_enquiry_content']);
	
	update_option('claim_email_subject_admin',$_POST['claim_email_subject_admin']);
	update_option('claim_email_content_admin',$_POST['claim_email_content_admin']);
	
	update_option('claim_approved_email_subject',$_POST['claim_approved_email_subject']);
	update_option('claim_approved_email_content',$_POST['claim_approved_email_content']);
	
	update_option('claim_rejected_email_subject',$_POST['claim_rejected_email_subject']);
	update_option('claim_rejected_email_content',$_POST['claim_rejected_email_content']);
	
	update_option('auto_claim_email_subject',$_POST['auto_claim_email_subject']);
	update_option('auto_claim_email_content',$_POST['auto_claim_email_content']);
	
	update_option('forgot_password_subject',$_POST['forgot_password_subject']);
	update_option('forgot_password_content',$_POST['forgot_password_content']);
	

	update_option('post_added_success_msg_content',$_POST['post_added_success_msg_content']);
	update_option('post_payment_success_msg_content',$_POST['post_payment_success_msg_content']);
	update_option('post_payment_cancel_msg_content',$_POST['post_payment_cancel_msg_content']);
	update_option('post_pre_bank_trasfer_msg_content',$_POST['post_pre_bank_trasfer_msg_content']);
	
	update_option('tiny_editor',$_POST['tiny_editor']);
	
	update_option('bcc_new_user',$_POST['bcc_new_user']);
	update_option('bcc_friend',$_POST['bcc_friend']);
	update_option('bcc_enquiry',$_POST['bcc_enquiry']);
}
?>
<style>
h2 {
	color:#464646;
	font-family:Georgia, "Times New Roman", "Bitstream Charter", Times, serif;
	font-size:24px;
	font-size-adjust:none;
	font-stretch:normal;
	font-style:italic;
	font-variant:normal;
	font-weight:normal;
	line-height:35px;
	margin:0;
	padding:14px 15px 3px 0;
	text-shadow:0 1px 0 #FFFFFF;
}
</style>
<h2><?php _e('Manage Notifications'); ?></h2>
<p><?php _e('Different emails and messages are displayed on the site or, being sent to your user at different times such as, when they post a listing, etc. You may customize the default messages, email messages as per your wish from here. ');?></p>
<?php if($_REQUEST['msg']=='success'){?>
<div class="updated fade below-h2" id="message" style="background-color: rgb(255, 251, 204);" >
<p><?php _e('updated successfully.'); ?></p>
</div>
<?php }?>

<h3><?php _e('Notification Options');?></h3>
<form action="<?php echo site_url();?>/wp-admin/admin.php?page=notification" name="emails" method="post">
<table width="100%" cellpadding="5" class="widefat post fixed" >
<thead>
<tr>
<th width="150" align="left"><strong><?php _e('Editor on/off'); ?></strong></th>
<th align="left"><strong><?php _e('List of usable shortcodes'); ?></strong></th>
</tr>
</thead>

<td><?php _e('Use Advanced Editor?(slow loading)');?><br /><input type="radio" name="tiny_editor" <?php if(get_option('tiny_editor')=='1'){ echo 'checked="checked"';}?>  value="1" /> <?php _e('Yes');?>  <input type="radio" name="tiny_editor" <?php if(get_option('tiny_editor')=='0'){ echo 'checked="checked"';}?> value="0" /> <?php _e('No');?><br /><input type="submit" name="Submit" value="<?php _e('Submit')?>"> 
<td>[#client_name#],[#listing_link#],[#posted_date#],[#number_of_days#],[#number_of_grace_days#],[#login_url#],[#username#],[#user_email#],[#site_name_url#],[#renew_link#],[#post_id#],[#site_name#],[#approve_listing_link#]</td>

<!-- ########################### end table ################################## -->
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
</table>

<h3><?php _e('Site Bcc Options');?></h3>
<form action="<?php echo site_url();?>/wp-admin/admin.php?page=notification" name="emails" method="post">
<table width="100%" cellpadding="5" class="widefat post fixed" >
<thead>
<tr>
<th width="150" align="left"><strong><?php _e('Email Type'); ?></strong></th>
<th align="left"><strong><?php _e('Send Bcc to admin?'); ?></strong></th>
</tr>
</thead>

<tr>
<td><?php _e('New user registration');?>
<td><input type="radio" name="bcc_new_user" <?php if(get_option('bcc_new_user')=='1'){ echo 'checked="checked"';}?>  value="1" /> <?php _e('Yes');?>  <input type="radio" name="bcc_new_user" <?php if(get_option('bcc_new_user')=='0'){ echo 'checked="checked"';}?> value="0" /> <?php _e('No');?> </td>
</tr>
<tr>
<td><?php _e('Send to friend');?>
<td><input type="radio" name="bcc_friend" <?php if(get_option('bcc_friend')=='1'){ echo 'checked="checked"';}?>  value="1" /> <?php _e('Yes');?>  <input type="radio" name="bcc_friend" <?php if(get_option('bcc_friend')=='0'){ echo 'checked="checked"';}?> value="0" /> <?php _e('No');?> </td>
</tr>
<tr>
<td><?php _e('Send Enquiry');?>
<td><input type="radio" name="bcc_enquiry" <?php if(get_option('bcc_enquiry')=='1'){ echo 'checked="checked"';}?>  value="1" /> <?php _e('Yes');?>  <input type="radio" name="bcc_enquiry" <?php if(get_option('bcc_enquiry')=='0'){ echo 'checked="checked"';}?> value="0" /> <?php _e('No');?> </td>
</tr>
<!-- ########################### end table ################################## -->
<tr>
  <td>&nbsp;</td>
  <td><input type="submit" name="Submit" value="<?php _e('Submit')?>"></td>
</tr>
</table>



<h3><?php _e('Admin Emails');?></h3>
<form action="<?php echo site_url();?>/wp-admin/admin.php?page=notification" name="emails" method="post">
<table width="100%" cellpadding="5" class="widefat post fixed" >
<thead>
<tr>
<th width="150" align="left"><strong><?php _e('Email Type'); ?></strong></th>
<th  align="left"><strong><?php _e('Email Subject'); ?><br /><?php _e('Email Description'); ?></strong></th>
</tr>
</thead>

<?php
$subject = stripslashes(get_option('post_submited_success_email_subject_admin'));
$content = stripslashes(get_option('post_submited_success_email_content_admin'));
$subject_default = __('Post Submitted Successfully');
$content_default = __('<p>Dear Admin,</p>
<p>A new  listing has been published [#listing_link#]. This email is just for your information.</p>
<br>
<p>[#site_name#]</p>');
?>
<tr>
<td><?php _e('Post Submit Success to Admin Email');?></td>
<td>
<input type="text"  size="80" value="<?php if($subject){echo $subject;}else{ echo $subject_default;}?>" name="post_submited_success_email_subject_admin"><br />
<textarea cols="80" rows="6" name="post_submited_success_email_content_admin"><?php if($content){echo $content;}else{ echo $content_default;}?></textarea></td>
</tr>

<?php
$subject = stripslashes(get_option('post_renew_success_email_subject_admin'));
$content = stripslashes(get_option('post_renew_success_email_content_admin'));
$subject_default = __('Renewal of listing ID:#[#post_id#]');
$content_default = __('<p>Dear Admin,</p>
<p>Listing [#listing_link#] has been renewed. Please confirm payment and then update the listings published date to todays date. </p>
<p>NOTE: If payment was made by paypal the "published date" should be updated automatically. </p>
<br>
<p>[#site_name#]</p>');
?>
<tr>
<td><?php _e('Post Renewal Success to Admin Email');?></td>
<td>
<input type="text"  size="80" name="post_renew_success_email_subject_admin" value="<?php if($subject){echo $subject;}else{ echo $subject_default;}?>"><br />
<textarea cols="80" rows="6" name="post_renew_success_email_content_admin"><?php if($content){echo $content;}else{ echo $content_default;}?></textarea></td>
</tr>

<?php
$subject = stripslashes(get_option('post_upgrade_success_email_subject_admin'));
$content = stripslashes(get_option('post_upgrade_success_email_content_admin'));
$subject_default = __('Upgrade of listing ID:#[#post_id#]');
$content_default = __('<p>Dear Admin,</p>
<p>Listing [#listing_link#] has been upgraded. Please confirm payment and then update the listings published date to todays date. </p>
<p>NOTE: If payment was made by paypal the "published date" should be updated automatically. </p>
<br>
<p>[#site_name#]</p>');
?>
<tr>
<td><?php _e('Post Upgrade Success to Admin Email');?></td>
<td><input type="text"  size="80" name="post_upgrade_success_email_subject_admin" value="<?php if($subject){echo $subject;}else{ echo $subject_default;}?>" /><br />
<textarea cols="80" rows="6" name="post_upgrade_success_email_content_admin"><?php if($content){echo $content;}else{ echo $content_default;}?></textarea></td>
</tr>

<?php
$subject = stripslashes(get_option('post_payment_success_admin_email_subject'));
$content = stripslashes(get_option('post_payment_success_admin_email_content'));
$subject_default = __('Payment received successfully');
$content_default = __('<p>Dear Admin,</p>
<p>Payment has been received. Below are the transaction details.</p>
<p>[#transaction_details#]</p>
<br>
<p>[#site_name#]</p>');
?>
<tr>
<td><?php _e('Payment Success to Admin Email');?></td>
<td><input type="text"  size="80" name="post_payment_success_admin_email_subject" value="<?php if($subject){echo $subject;}else{ echo $subject_default;}?>" /><br />
<textarea cols="80" rows="6" name="post_payment_success_admin_email_content"><?php if($content){echo $content;}else{ echo $content_default;}?></textarea></td>
</tr>

<?php
$subject = stripslashes(get_option('post_payment_fail_admin_email_subject'));
$content = stripslashes(get_option('post_payment_fail_admin_email_content'));
$subject_default = __('IPN INVALID - Place Listing Submitted');
$content_default = __('<p>Dear Admin,</p>
<p>Paypal IPN Invaid for listing ID: #[#post_id#]</p>
<p>Please manually check your paypal logs, and if payment was received manually publish the listing.</p>
<p>[#listing_link#]</p>
<br>
<p>[#site_name#]</p>');
?>
<tr>
<td><?php _e('Payment Fail to Admin Email');?></td>
<td><input type="text"  size="80" name="post_payment_fail_admin_email_subject" value="<?php if($subject){echo $subject;}else{ echo $subject_default;}?>" /><br />
<textarea cols="80" rows="6" name="post_payment_fail_admin_email_content"><?php if($content){echo $content;}else{ echo $content_default;}?></textarea></td>
</tr>

<?php
$subject = stripslashes(get_option('claim_email_subject_admin'));
$content = stripslashes(get_option('claim_email_content_admin'));
$subject_default = __('Claim Listing Requested');
$content_default = __("<p>Dear Admin,<p>
<p>A user has requested to become the owner of the below lisitng.</p>
<p>[#listing_link#]</p>
<p>You may wish to login and check the claim details.</p> 
<p>Thank you,<br /><br />[#site_name#].</p>");
?>
<tr>
<td><?php _e('Admin Claim Listing Request Notice');?></td>
<td><input type="text"  size="80" name="claim_email_subject_admin" value="<?php if($subject){echo $subject;}else{ echo $subject_default;}?>" /><br />
<textarea cols="80" rows="6" name="claim_email_content_admin"><?php if($content){echo $content;}else{ echo $content_default;}?></textarea></td>
</tr>

<!-- ########################### end table ################################## -->
<tr>
  <td>&nbsp;</td>
  <td><input type="submit" name="Submit" value="<?php _e('Submit')?>"> 
</tr>
</table>






<h3><?php _e('Client Emails');?></h3>
<form action="<?php echo site_url();?>/wp-admin/admin.php?page=notification" name="emails" method="post">
<table width="100%" cellpadding="5" class="widefat post fixed" >
<thead>
<tr>
<th width="150" align="left"><strong><?php _e('Email Type'); ?></strong></th>
<th align="left"><strong><?php _e('Email Subject'); ?><br /><?php _e('Email Description'); ?></strong></th>
</tr>
</thead>

<?php
$subject = stripslashes(get_option('post_submited_success_email_subject'));
$content = stripslashes(get_option('post_submited_success_email_content'));
$subject_default = __('Post Submitted Successfully');
$content_default = __('<p>Dear [#client_name#],</p>
<p>You submitted the below listing information. This email is just for your information.</p>
<p>[#listing_link#]</p>
<br>
<p>Thank you for your contribution.</p>
<p>[#site_name#]</p>');
?>
<tr>
<td><?php _e('Post Submit Success to Client Email');?></td>
<td><input type="text"  size="80" name="post_submited_success_email_subject" value="<?php if($subject){echo $subject;}else{ echo $subject_default;}?>" /><br />
<textarea cols="80" rows="6" name="post_submited_success_email_content"><?php if($content){echo $content;}else{ echo $content_default;}?></textarea></td>
</tr>

<?php
$subject = stripslashes(get_option('post_renew_success_email_subject'));
$content = stripslashes(get_option('post_renew_success_email_content'));
$subject_default = __('Renewal of listing ID:#[#post_id#]');
$content_default = __('<p>Dear [#client_name#],</p>
<p>Your listing [#listing_link#] has been renewed.</p>
<p>NOTE: If your listing is not active yet your payment may be being checked by an admin and it will be activated shortly.</p>
<br>
<p>[#site_name#]</p>');
?>
<tr>
<td><?php _e('Post Renew Success to Client Email');?></td>
<td><input type="text"  size="80" name="post_renew_success_email_subject" value="<?php if($subject){echo $subject;}else{ echo $subject_default;}?>" /><br />
<textarea cols="80" rows="6" name="post_renew_success_email_content"><?php if($content){echo $content;}else{ echo $content_default;}?></textarea></td>
</tr>

<?php
$subject = stripslashes(get_option('post_upgrade_success_email_subject'));
$content = stripslashes(get_option('post_upgrade_success_email_content'));
$subject_default = __('Upgrade of listing ID:#[#post_id#]');
$content_default = __('<p>Dear [#client_name#],</p>
<p>Your listing [#listing_link#] has been upgraded.</p>
<p>NOTE: If your listing is not active yet your payment may be being checked by an admin and it will be activated shortly.</p>
<br>
<p>[#site_name#]</p>');
?>
<tr>
<td><?php _e('Post Upgrade Success to Client Email');?></td>
<td><input type="text"  size="80" name="post_upgrade_success_email_subject" value="<?php if($subject){echo $subject;}else{ echo $subject_default;}?>" /><br />
<textarea cols="80" rows="6" name="post_upgrade_success_email_content"><?php if($content){echo $content;}else{ echo $content_default;}?></textarea></td>
</tr>

<?php
$subject = stripslashes(get_option('post_payment_success_client_email_subject'));
$content = stripslashes(get_option('post_payment_success_client_email_content'));
$subject_default = __('Acknowledgment for your Payment ');
$content_default = __('<p>Dear [#client_name#],</p>
<p>Payment has been successfully received. Your details are below</p>
<p>[#transaction_details#]</p>
<br>
<p>We hope you enjoy. Thanks!</p>
<p>[#site_name#]</p>');
?>
<tr>
<td><?php _e('Payment Success to Client Email');?></td>
<td><input type="text"  size="80" name="post_payment_success_client_email_subject" value="<?php if($subject){echo $subject;}else{ echo $subject_default;}?>" /><br />
<textarea cols="80" rows="6" name="post_payment_success_client_email_content"><?php if($content){echo $content;}else{ echo $content_default;}?></textarea></td>
</tr>

<?php
$subject = stripslashes(get_option('renew_email_subject'));
$content = stripslashes(get_option('renew_email_content'));
$subject_default = __('Place listing expiration Notification');
$content_default = __("<p>Dear [#client_name#],<p>
<p>Your listing - [#listing_link#] posted on  <u>[#posted_date#]</u> for [#number_of_days#] days.</p>
<p>It's going to expiry after [#number_of_grace_days#] day(s). If the listing expire, it will no longer appear on the site.</p>
<p> If you want to renew, Please login to your member area of our site and renew it as soon as it expire.</p> 
<p>You may like to login the site from [#login_url#].</p>
<p>Your login ID is <b>[#username#]</b> and Email ID is <b>[#user_email#]</b>.</p>
<p>Thank you,<br />[#site_name_url#].</p>");
?>
<tr>
<td><?php _e('Listing Expiration Email');?></td>
<td><input type="text"  size="80" name="renew_email_subject" value="<?php if($subject){echo $subject;}else{ echo $subject_default;}?>" /><br />
<textarea cols="80" rows="6" name="renew_email_content"><?php if($content){echo $content;}else{ echo $content_default;}?></textarea></td>
</tr>
<!-- ################################### claim listing emails ########################### -->
<?php
$subject = stripslashes(get_option('claim_email_subject'));
$content = stripslashes(get_option('claim_email_content'));
$subject_default = __('Claim Listing Requested');
$content_default = __("<p>Dear [#client_name#],<p>
<p>You have requested to become the owner of the below listing.</p>
<p>[#listing_link#]</p>
<p>We may contact you to confirm your request is genuine.</p> 
<p>You will recive a email once your request has been verified</p>
<p>Thank you,<br /><br />[#site_name#].</p>");
?>
<tr>
<td><?php _e('Claim Listing Request');?></td>
<td><input type="text"  size="80" name="claim_email_subject" value="<?php if($subject){echo $subject;}else{ echo $subject_default;}?>" /><br />
<textarea cols="80" rows="6" name="claim_email_content"><?php if($content){echo $content;}else{ echo $content_default;}?></textarea></td>
</tr>
<!-- ################################### claim listing emails ########################### -->
<!-- ################################### claim listing approved emails ########################### -->
<?php
$subject = stripslashes(get_option('claim_approved_email_subject'));
$content = stripslashes(get_option('claim_approved_email_content'));
$subject_default = __('Claim Listing Approved');
$content_default = __("<p>Dear [#client_name#],<p>
<p>Your request to become the owner of the below listing has been APPROVED.</p>
<p>[#listing_link#]</p>
<p>You may now login and edit your listing.</p> 
<p>Thank you,<br /><br />[#site_name_url#].</p>");
?>
<tr>
<td><?php _e('Claim Listing Approval');?></td>
<td><input type="text"  size="80" name="claim_approved_email_subject" value="<?php if($subject){echo $subject;}else{ echo $subject_default;}?>" /><br />
<textarea cols="80" rows="6" name="claim_approved_email_content"><?php if($content){echo $content;}else{ echo $content_default;}?></textarea></td>
</tr>
<!-- ################################### claim listing approved emails ########################### -->
<!-- ################################### claim listing rejected emails ########################### -->
<?php
$subject = stripslashes(get_option('claim_rejected_email_subject'));
$content = stripslashes(get_option('claim_rejected_email_content'));
$subject_default = __('Claim Listing Rejected');
$content_default = __("<p>Dear [#client_name#],<p>
<p>Your request to become the owner of the below listing has been REJECTED.</p>
<p>[#listing_link#]</p>
<p>If you feel this is a wrong decision please reply to this email with your reasons.</p> 
<p>Thank you,<br /><br />[#site_name#].</p>");
?>
<tr>
<td><?php _e('Claim Listing Rejected');?></td>
<td><input type="text"  size="80" name="claim_rejected_email_subject" value="<?php if($subject){echo $subject;}else{ echo $subject_default;}?>" /><br />
<textarea cols="80" rows="6" name="claim_rejected_email_content"><?php if($content){echo $content;}else{ echo $content_default;}?></textarea></td>
</tr>
<!-- ################################### claim listing rejected emails ########################### -->
<!-- ################################### claim listing verification required emails ########################### -->
<?php
$subject = stripslashes(get_option('auto_claim_email_subject'));
$content = stripslashes(get_option('auto_claim_email_content'));
$subject_default = __('Claim Listing Verification Required');
$content_default = __("<p>Dear [#client_name#],<p>
<p>Your request to become the owner of the below listing needs to be verified.</p>
<p>[#listing_link#]</p>
<p><b>By clicking the VERIFY link below you are stating you are legally associated with this business and have the owners consent to edit the listing.</b></p> 
<p><b>If you are not associated with this business and edit the listing with malicious intent you will be solely liable for any legal action or claims for damages.</b></p> 
<p>[#approve_listing_link#]</p>
<p>Thank you,<br /><br />[#site_name_url#].</p>");
?>
<tr>
<td><?php _e('Claim Listing Verification Required');?></td>
<td><input type="text"  size="80" name="auto_claim_email_subject" value="<?php if($subject){echo $subject;}else{ echo $subject_default;}?>" /><br />
<textarea cols="80" rows="6" name="auto_claim_email_content"><?php if($content){echo $content;}else{ echo $content_default;}?></textarea></td>
</tr>

<?php
$subject = stripslashes(get_option('forgot_password_subject'));
$content = stripslashes(get_option('forgot_password_content'));
$subject_default = __('[#site_name#] - Your new password');
$content_default = __("<p>Dear [#client_name#],<p>
<p>You requested a new password for [#site_name_url#]</p>
<p>[#login_details#]</p>
<p>You can login here: [#login_url#]</p> 
<p>Thank you,<br /><br />[#site_name_url#].</p>");
?>
<tr>
<td><?php _e('User Forgot Password Email');?></td>
<td><input type="text"  size="80" name="forgot_password_subject" value="<?php if($subject){echo $subject;}else{ echo $subject_default;}?>" /><br />
<textarea cols="80" rows="6" name="forgot_password_content"><?php if($content){echo $content;}else{ echo $content_default;}?></textarea></td>
</tr>

<?php
$subject = stripslashes(get_option('registration_success_email_subject'));
$content = stripslashes(get_option('registration_success_email_content'));
$subject_default = __('Your Log In Details');
$content_default = __('<p>Dear [#client_name#],</p>
<p>You can log in  with the following information:</p>
<p>[#login_details#]</p>
<p>You can login here: [#login_url#]</p>
<p>Thank you,<br /><br />[#site_name_url#].</p>');
?>
<tr>
<td><?php _e('Registration  Success Email');?></td>
<td><input type="text"  size="80" name="registration_success_email_subject" value="<?php if($subject){echo $subject;}else{ echo $subject_default;}?>" /><br />
<textarea cols="80" rows="6" name="registration_success_email_content"><?php if($content){echo $content;}else{ echo $content_default;}?></textarea></td>
</tr>

<!-- ################################### claim listing verification required emails ########################### -->
<tr>
  <td>&nbsp;</td>
  <td><input type="submit" name="Submit" value="<?php _e('Submit')?>"> 
</tr>
</table>

<h3><?php _e('Other Emails');?></h3>
<form action="<?php echo site_url();?>/wp-admin/admin.php?page=notification" name="emails" method="post">
<table width="100%" cellpadding="5" class="widefat post fixed" >
<thead>
<tr>
<th width="150" align="left"><strong><?php _e('Email Type'); ?></strong></th>
<th align="left"><strong><?php _e('Email Subject'); ?><br /><?php _e('Email Description'); ?></strong></th>
</tr>
</thead>

<?php
$subject = stripslashes(get_option('email_friend_subject'));
$content = stripslashes(get_option('email_friend_content'));
$subject_default = __('[#from_name#] thought you might be interested in..');
$content_default = __("<p>Dear [#to_name#],<p>
<p>Your friend has sent you a message from <b>[#site_name#]</b> </p>
<p>===============================</p>
<p>Sender Email : <a href='mailto:[#sender_email#]'>[#sender_email#]</a></p>
<p><b>Subject : [#subject#]</b></p>
<p>[#comments#] [#listing_link#]</p> 
<p>===============================</p>
<p>Thank you,<br /><br />[#site_name#].</p>");
?>
<tr>
<td><?php _e('Send to Friend');?></td>
<td><input type="text"  size="80" name="email_friend_subject" value="<?php if($subject){echo $subject;}else{ echo $subject_default;}?>" /><br />
<textarea cols="80" rows="6" name="email_friend_content"><?php if($content){echo $content;}else{ echo $content_default;}?></textarea></td>
</tr>

<?php
$subject = stripslashes(get_option('email_enquiry_subject'));
$content = stripslashes(get_option('email_enquiry_content'));
$subject_default = __('Website Enquiry');
$content_default = __("<p>Dear [#to_name#],<p>
<p>An enquiry has been sent from <b>[#listing_link#]</b> </p>
<p>===============================</p>
<p>Sender Email : <a href='mailto:[#sender_email#]'>[#sender_email#]</a></p>
<p>[#comments#]</p>
<p>===============================</p>
<p>Thank you,<br /><br />[#site_name_url#].</p>");
?>
<tr>
<td><?php _e('Email Enquiry');?></td>
<td><input type="text"  size="80" name="email_enquiry_subject" value="<?php if($subject){echo $subject;}else{ echo $subject_default;}?>" /><br />
<textarea cols="80" rows="6" name="email_enquiry_content"><?php if($content){echo $content;}else{ echo $content_default;}?></textarea></td>
</tr>

<!-- ################################### claim listing verification required emails ########################### -->
<tr>
  <td>&nbsp;</td>
  <td><input type="submit" name="Submit" value="<?php _e('Submit')?>"> 
</tr>
</table>

<h3><?php _e('Messages')?></h3>
<table width="100%" cellpadding="5" class="widefat post fixed" >
<thead>
<tr>
  <th width="150"  align="left"><strong><?php _e('Title'); ?></strong></th>
  <th width="100%" align="left"><strong><?php _e('Description'); ?></strong></th>
</tr>
</thead>
<?php
$title = __('Post Submitted Success');
$content_default = __('<p>Thank you, your information has been successfully received.</p>
<p><a href="[#submited_information_link#]" >View your submitted information &raquo;</a></p>
<p>Thank you for visiting us at [#site_name#].</p>');
$content = stripslashes(get_option('post_added_success_msg_content'));
?>
<tr>
  <td><?php echo $title;?></td>
  <td><textarea cols="100" rows="6" name="post_added_success_msg_content"><?php if($content){echo $content;}else{ echo $content_default;}?></textarea></td>
</tr>

<?php
$title = __('Payment Success');
$content_default = __('<h4>Your payment received successfully and your information is published.</h4>
<p><a href="[#submited_information_link#]" >View your submitted information &raquo;</a></p>
<h5>Thank you for becoming a member at [#site_name#].</h5>');
$content = stripslashes(get_option('post_payment_success_msg_content'));
?>
<tr>
  <td><?php echo $title;?></td>
  <td><textarea cols="100" rows="6" name="post_payment_success_msg_content"><?php if($content){echo $content;}else{ echo $content_default;}?></textarea></td>
</tr>

<?php
$title = __('Payment Cancel');
$content_default = __('<h3>Your listing is cancelled. Sorry for cancellation.</h3>
<h5>Thank you for visiting us at [#site_name#].</h5>');
$content = stripslashes(get_option('post_payment_cancel_msg_content'));
?>
<tr>
  <td><?php echo $title;?></td>
  <td><textarea cols="100" rows="6" name="post_payment_cancel_msg_content"><?php if($content){echo $content;}else{ echo $content_default;}?></textarea></td>
</tr>

<?php
$title = __('Pre Bank Trasfer Payment Success');
$content_default = __('<p>Thank you, your request has been received successfully.</p>
<p>To publish the Listing please transfer the amount of <u>[#order_amt#] </u> to our bank with the following information :</p>
<p>Account Name : [#bank_name#]</p>
<p>Account Sort Code : [#account_sortcode#]</p>
<p>Account Number : [#account_number#]</p>
<br>
<p>Please include the ID as reference : [#orderId#]</p>
<p><a href="[#submited_information_link#]" >View your submitted listing &raquo;</a>
<br>
<p>Thank you for visiting us at [#site_name#].</p>');
$content = stripslashes(get_option('post_pre_bank_trasfer_msg_content'));
?>
<tr>
  <td><?php echo $title;?></td>
  <td><textarea cols="100" rows="6" name="post_pre_bank_trasfer_msg_content"><?php if($content){echo $content;}else{ echo $content_default;}?></textarea></td>
</tr>

<tr>
  <td>&nbsp;</td>
  <td><input type="submit" name="Submit" value="<?php _e('Submit')?>"> <td>
  </td>
</tr>
</table>
</form>
<!-- TinyMCE -->
<?php if ( get_option('tiny_editor')=='1' ) { echo get_option('tiny_editor');  ?>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/library/js/tiny_mce/tiny_mce.js"></script>

<script type="text/javascript">

	tinyMCE.init({

		// General options

		mode : "textareas",

		theme : "advanced",

		plugins :"advimage,advlink,emotions,iespell,",



		// Theme options

		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,bullist,numlist,blockquote,|,link,unlink,anchor,image,code",

		theme_advanced_buttons2 : "",

		theme_advanced_buttons3 : "",

		theme_advanced_buttons4 : "",

		theme_advanced_toolbar_location : "top",

		theme_advanced_toolbar_align : "left",

		theme_advanced_statusbar_location : "bottom",

		theme_advanced_resizing : true,



		// Example word content CSS (should be your site CSS) this one removes paragraph margins

		//content_css : "css/word.css",



		// Drop lists for link/image/media/template dialogs

		template_external_list_url : "lists/template_list.js",

		external_link_list_url : "lists/link_list.js",

		external_image_list_url : "lists/image_list.js",

		media_external_list_url : "lists/media_list.js",



		// Replace values for the template plugin

		template_replace_values : {

			username : "Some User",

			staffid : "991234"

		}

	});

</script>
<!-- /TinyMCE -->
<?php } ?>

<br /><br />