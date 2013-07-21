jQuery(document).ready(function(){
//global vars
	var propertyform = jQuery("#propertyform");
	var proprty_name = jQuery("#proprty_name");
	var category = jQuery("#category");
	var proprty_desc = jQuery("#proprty_desc");
	
	var proprty_name_span = jQuery("#proprty_name_span");
	var proprty_desc_span = jQuery("#proprty_desc_span");
	var category_span = jQuery("#category_span");
/////////////////////////////////////// ADDED BY STIOFAN HEBTECH.CO.UK /////////////////////////
	var user_email = jQuery("#user_email");
	var user_fname = jQuery("#user_fname");
	var claimed = jQuery("#claimed");
	var user_login_or_not = jQuery("#user_login_or_not");

	var user_email_span = jQuery("#user_email_span");
	var user_fname_span = jQuery("#user_fname_span");
	var claimed_span = jQuery("#claimed_span");
	var user_login_or_not_span = jQuery("#user_login_or_not_span");
/////////////////////////////////////////////////////////////////////////////////////////////////


//On blur
	proprty_name.blur(validate_title_name);
	proprty_desc.blur(validate_proprty_desc);
	category.blur(validate_category);

//On key press
	proprty_name.keyup(validate_title_name);
	category.keyup(validate_category);
//On Submitting
	propertyform.submit(function(){
		
		if(validate_title_name() & validate_proprty_desc() & validate_category() & validate_user_email()& validate_claimed()& validate_user_name()& validate_login()& event_time())
			return true
		else
			return false;
	});

//validation functions
/////////////////////////////////////// ADDED BY STIOFAN HEBTECH.CO.UK /////////////////////////
	function goToByScroll2(id){
			jQuery('html,body').animate({scrollTop: jQuery(id).closest("div").offset().top},'slow');
	}
	
	function signupPass(){
		var pass = true;
		passGo = '';
	if (jQuery("#user_pass1").length){	
	
	if(jQuery("#user_pass2_span").html() !=''){pass=false; passGo='#user_pass2';}
	if(jQuery("#user_pass1_span").html() !=''){pass=false; passGo='#user_pass1';}
	
	}
		
		if(pass){return true;}else{goToByScroll2(passGo);return false;}
	}
	
	function event_time(){
		var pass = true;
		passGo = '';
		
	 if (jQuery("#endtime").length){ 
	 		if(jQuery("#endtime").val()==''){pass=false; passGo='#endtime'; jQuery("#endtime").closest("div").addClass("errors");}
			else{jQuery("#endtime").closest("div").removeClass("errors");}
	 }
	 
	 if (jQuery("#enddate").length){ 
	 		if(jQuery("#enddate").val()==''){pass=false; passGo='#enddate'; jQuery("#enddate").closest("div").addClass("errors");}
			else{jQuery("#enddate").closest("div").removeClass("errors");}
	 }
	 
	 if (jQuery("#sttime").length){ 
	 		if(jQuery("#sttime").val()==''){pass=false; passGo='#sttime'; jQuery("#sttime").closest("div").addClass("errors");}
			else{jQuery("#sttime").closest("div").removeClass("errors");}
	 }
	 
	 if (jQuery("#stdate").length){ 
	 		if(jQuery("#stdate").val()==''){pass=false; passGo='#stdate'; jQuery("#stdate").closest("div").addClass("errors");}
			else{jQuery("#stdate").closest("div").removeClass("errors");}
	 }
	 
	 
	 
	 
	 
	
	 
	 if(pass){return true;}else{goToByScroll2(passGo);return false;}
		
	}


	function validate_user_email()
	{
		if(jQuery("#user_email").val() == '')
		{
			user_email.addClass("error");
			user_email_span.text(gt_local.email_string);
			user_email_span.addClass("message_error2");
			jQuery("#user_email").focus();
			return false;
		}
		else{
			user_email.removeClass("error");
			user_email_span.text("");
			user_email_span.removeClass("message_error2");
			return true;
		}
	}
////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////// ADDED BY STIOFAN HEBTECH.CO.UK /////////////////////////

	function validate_login()
	{
		if(jQuery("#user_login_or_not").val() == '')
		{
			user_login_or_not.addClass("error");
			user_login_or_not_span.text(gt_local.user_string);
			user_login_or_not_span.addClass("message_error2");
			document.getElementById('content').scrollIntoView();
			return false;
		}
		else{
			user_login_or_not.removeClass("error");
			user_login_or_not_span.text("");
			user_login_or_not_span.removeClass("message_error2");
			return true;
		}
	}
////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////// ADDED BY STIOFAN HEBTECH.CO.UK /////////////////////////

	function validate_user_name()
	{
		if(jQuery("#user_fname").val() == '')
		{
			user_fname.addClass("error");
			user_fname_span.text(gt_local.name_string);
			user_fname_span.addClass("message_error2");
			jQuery("#user_fname").focus();
			return false;
		}
		else{
			user_fname.removeClass("error");
			user_fname_span.text("");
			user_fname_span.removeClass("message_error2");
			return true;
		}
	}
////////////////////////////////////////////////////////////////////////////////////////////
		function validate_claimed()
	{ 
		if(document.propertyform.claimed[0].checked == false & document.propertyform.claimed[1].checked == false)
		{
			claimed.addClass("error");
			claimed_span.text(gt_local.owner_string);
			claimed_span.addClass("message_error2");
			document.getElementById('claimed1').scrollIntoView();
			return false;
		}
		else{
			claimed.removeClass("error");
			claimed_span.text("");
			claimed_span.removeClass("message_error2");
			return true;
		}
	}
/////////////////////////////////////// END ADDED BY STIOFAN HEBTECH.CO.UK /////////////////////////
	
	function validate_title_name()
	{
		if(jQuery("#proprty_name").val() == '')
		{
			proprty_name.addClass("error");
			proprty_name_span.text(gt_local.title_val_string);
			proprty_name_span.addClass("message_error2");
			jQuery("#proprty_name").focus();			
			return false;
		}
		else{
			proprty_name.removeClass("error");
			proprty_name_span.text("");
			proprty_name_span.removeClass("message_error2");
			return true;
		}
	}
	
	function validate_proprty_desc()
	{
		if(jQuery("#proprty_desc").val() == '')
		{
			proprty_desc.addClass("error");
			proprty_desc_span.text(gt_local.desc_val_string);
			proprty_desc_span.addClass("message_error2");
			jQuery("#proprty_desc").focus();
			return false;
		}
		else{
			proprty_desc.removeClass("error");
			proprty_desc_span.text("");
			proprty_desc_span.removeClass("message_error2");
			return true;
		}
	}
	
	function validate_category()
	{
		if(ptthemes_category_dislay=='checkbox')
		{
			var chklength = document.getElementsByName("category[]").length;
			var flag      = false;
			var temp	  ='';
			for(i=1;i<=chklength;i++)
			{
			   temp = document.getElementById("category_"+i+"").checked; 
			   if(temp == true)
			   {
					flag = true;
					break;
				}
			}
			if(flag == false)
			{
				category_span.text(gt_local.cat_val_string);
				category_span.addClass("message_error2");
				document.getElementById('category_1').scrollIntoView();
				return false;
			}
			else{			
				category_span.text("");
				category_span.removeClass("message_error2");
				return true;
			}
		}
		return true;
	}	

});