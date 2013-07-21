jQuery(document).ready(function(){
//global vars
	var enquiryfrm =jQuery("#claim_form");
	var full_name =jQuery("#full_name");
	var full_nameInfo =jQuery("#full_nameInfo");
	var user_number =jQuery("#user_number");
	var user_numberInfo =jQuery("#user_numberInfo");
	var user_position =jQuery("#user_position");
	var user_positionInfo =jQuery("#user_positionInfo");
	var user_comments =jQuery("#user_comments");
	var user_commentsInfo =jQuery("#user_commentsInfo");

	//On blur
	full_name.blur(validate_full_name);
	user_number.blur(validate_user_number);
	user_position.blur(validate_user_position);
	user_comments.blur(validate_user_comments);

	//On key press
	full_name.keyup(validate_full_name);
	user_number.keyup(validate_user_number);
	user_position.keyup(validate_user_position);
	user_comments.keyup(validate_user_comments);

	//On Submitting
	enquiryfrm.submit(function(){
		if(validate_full_name() & validate_user_number() & validate_user_position() & validate_user_comments())
		{
			function reset_send_email_agent_form()
			{
				document.getElementById('full_name').value = '';
				document.getElementById('user_number').value = '';
				document.getElementById('user_position').value = '';
				document.getElementById('user_comments').value = '';	
				
			}
			return true
		}
		else
		{
			return false;
		}
	});
	
	//validation functions
	function validate_full_name()
	{
		if($("#full_name").val() == '')
		{
			full_name.addClass("error");
			full_nameInfo.text("Please Enter Your Full Name");
			full_nameInfo.addClass("message_error2");
			return false;
		}
		else{
			full_name.removeClass("error");
			full_nameInfo.text("");
			full_nameInfo.removeClass("message_error2");
			return true;
		}
	}
		function validate_user_number()
	{
		if($("#user_number").val() == '')
		{
			user_number.addClass("error");
			user_numberInfo.text("Please Enter A Valid Contact Number");
			user_numberInfo.addClass("message_error2");
			return false;
		}
		else{
			user_number.removeClass("error");
			user_numberInfo.text("");
			user_numberInfo.removeClass("message_error2");
			return true;
		}
	}
	/*function validate_user_number()
	{
		var isvalidemailflag = 0;
		if($("#user_number").val() == '')
		{
			isvalidemailflag = 1;
		}else
		if($("#user_number").val() != '')
		{
			var a =jQuery("#user_number").val();
			var filter = /^(1\s*[-\/\.]?)?(\((\d{3})\)|(\d{3}))\s*[-\/\.]?\s*(\d{3})\s*[-\/\.]?\s*(\d{4})\s*(([xX]|[eE][xX][tT])\.?\s*(\d+))*$/; 
			//if it's valid email
			if(filter.test(a)){
				isvalidemailflag = 0;
			}else{
				isvalidemailflag = 1;	
			}
		}
		if(isvalidemailflag)
		{
			user_number.addClass("error");
			user_numberInfo.text("Please Enter valid Contact Number");
			user_numberInfo.addClass("message_error2");
			return false;
		}else
		{
			user_number.removeClass("error");
			user_numberInfo.text("");
			user_numberInfo.removeClass("message_error");
			return true;
		}
	} */

	function validate_user_position()
	{
		if($("#user_position").val() == '')
		{
			user_position.addClass("error");
			user_positionInfo.text("Please Enter Your Position In The Business");
			user_positionInfo.addClass("message_error2");
			return false;
		}
		else{
			user_position.removeClass("error");
			user_positionInfo.text("");
			user_positionInfo.removeClass("message_error2");
			return true;
		}
	}

	
	function validate_user_comments()
	{
		if($("#user_comments").val() == '')
		{
			user_comments.addClass("error");
			user_commentsInfo.text("Please Enter Comments");
			user_commentsInfo.addClass("message_error2");
			return false;
		}
		else{
			user_comments.removeClass("error");
			user_commentsInfo.text("");
			user_commentsInfo.removeClass("message_error2");
			return true;
		}
	}

});