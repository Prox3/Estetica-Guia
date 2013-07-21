<?php 
global $wp_query,$post;
$post = $wp_query->post;
?>
<div id="basic-modal-content" class="clearfix">
<form name="send_to_frnd" id="send_to_frnd" action="<?php echo get_permalink($post->ID); ?>" method="post" >
<input type="hidden" id="send_to_Frnd_pid" name="pid" value="<?php echo $post->ID;?>" />
<input type="hidden" name="sendact" value="email_frnd" />
	<h3><?php echo SEND_TO_FRIEND;?></h3>
    <p id="reply_send_success" class="sucess_msg" style="display:none;"></p>
	<div class="row clearfix" ><label><?php _e('Friend Name');?> : <span>*</span></label><input name="to_name" id="to_name" type="text"  /><span id="to_nameInfo"></span></div>
 	<div class="row  clearfix" ><label> <?php _e('Email');?> : <span>*</span></label><input name="to_email" id="to_email" type="text"  /><span id="to_emailInfo"></span></div>
	<div class="row  clearfix" ><label><?php _e('Your Name');?> : <span>*</span></label><input name="yourname" id="yourname" type="text"  /><span id="yournameInfo"></span></div>
 	<div class="row  clearfix" ><label> <?php _e('Email');?> : <span>*</span></label><input name="youremail" id="youremail" type="text"  /><span id="youremailInfo"></span></div>
	<div class="row  clearfix" ><label><?php _e('Subject');?> : <span>*</span></label><input name="frnd_subject" value="<?php echo __('About ').$post->post_title;?>" id="frnd_subject" type="text"  /><span id="frnd_subjectInfo"></span></div>
	<div class="row  clearfix" ><label><?php _e('Comments');?> : <span>*</span></label>
     <textarea name="frnd_comments" id="frnd_comments" cols="" rows="" ><?php echo SEND_TO_FRIEND_SAMPLE_CONTENT;?></textarea>
     <span id="frnd_commentsInfo"></span></div>
    <?php if(function_exists('pt_get_captch')){pt_get_captch('-1'); }?>
	<input name="Send" type="submit" value="<?php _e('Send')?> " class="button " />
</form>
</div>
		
<div id="basic-modal-content2" class="clearfix">
 <form method="post" name="agt_mail_agent" id="agt_mail_agent" action="<?php echo get_permalink($post->ID); ?>" >
  <input type="hidden" name="pid" id="agt_mail_agent_pid" value="<?php echo $post->ID;?>" />
  <input type="hidden" name="sendact" value="send_inqury" />
	<h3><?php echo SEND_INQUIRY;?> </h3>
    <p id="inquiry_send_success" class="sucess_msg" style="display:none;"></p>
	<div class="row  clearfix" ><label><?php _e('Your Name');?> :  <span>*</span></label><input name="inq_name" id="agt_mail_name" type="text"  /><span id="span_agt_mail_name"></span></div>
 	<div class="row  clearfix" ><label><?php _e('Email');?> :  <span>*</span></label><input name="inq_email" id="agt_mail_email" type="text"  /><span id="span_agt_mail_email"></span></div>
	<div class="row  clearfix" ><label><?php _e('Contact Info');?> :</label><input name="inq_phone" id="agt_mail_phone" type="text"  /></div>
	<div class="row  clearfix" ><label><?php _e('Comments');?> :  <span>*</span></label>
     <textarea name="inq_msg" id="agt_mail_msg" cols="" rows="" ><?php echo SEND_INQUIRY_SAMPLE_CONTENT;?></textarea>
     <span id="span_agt_mail_msg"></span>
    </div>
     <?php if(function_exists('pt_get_captch')){pt_get_captch('-2'); }?>
	<input name="Send" type="submit"  value="<?php _e('Send');?>" class="button clearfix" />
 </form>
</div>
<!-- here -->
<!-- claim listing emial code below -->
<script type="text/javascript">
function claimtoggle() {
	
	var ele = document.getElementById("claimtoggleText");
	var text = document.getElementById("claimdisplayText");
	if(ele.style.display == "block" || ele.style.display == "" ) {
			jQuery("#claimtoggleText").hide('slow');
		text.innerHTML = "<?php echo CLAIM_LISTING_PROCESS_SHOW; ?>";
  	}
	if(ele.style.display == "none") {
		jQuery("#claimtoggleText").show('slow');
		text.innerHTML = "<?php echo CLAIM_LISTING_PROCESS_HIDE; ?>";
	}
}
</script>
<div id="basic-modal-content4" class="clearfix">
<form name="claim_form" id="claim_form" action="<?php echo get_permalink($post->ID); ?>" method="post" >
<input type="hidden" id="claim_form_pid" name="pid" value="<?php echo $post->ID;?>" />
<input type="hidden" name="sendact" value="claim_listing" />
	<h3><?php echo CLAIM_LISTING;?></h3>
    <h4><a id="claimdisplayText" href="javascript:claimtoggle();"><?php echo CLAIM_LISTING_PROCESS_SHOW; ?></a></h4>
<div id="claimtoggleText"  style="display: none"><p><?php echo CLAIM_LISTING_PROCESS; ?></p><hr /></div>
    <p id="reply_send_success2" class="sucess_msg" style="display:none;"></p>
	<div class="row clearfix" ><label><?php _e('Full Name');?> : <span>*</span></label><input name="full_name" id="full_name" type="text"  /><span id="full_nameInfo"></span></div>
 	<div class="row  clearfix" ><label> <?php _e('Contact Number');?> : <span>*</span></label><input name="user_number" id="user_number" type="text"  /><span id="user_numberInfo"></span></div>
	<div class="row  clearfix" ><label><?php _e('Position in Business');?> : <span>*</span></label><input name="user_position" id="user_position" type="text"  /><span id="user_positionInfo"></span></div>
	<div class="row  clearfix" ><label><?php _e('Comments');?> : <span>*</span></label>
     <textarea name="user_comments" id="user_comments" cols="" rows="" ><?php echo CLAIM_LISTING_SAMPLE_CONTENT;?></textarea>
     <span id="user_commentsInfo"></span></div>
    <?php if(function_exists('pt_get_captch')){pt_get_captch(); }?>
	<input name="Send" type="submit" value="<?php _e('Send')?> " class="button " />
</form>
</div>