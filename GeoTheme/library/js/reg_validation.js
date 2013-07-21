jQuery(document).ready(function(){

////////////LOGIN FORM START

//global vars

	var loginform = jQuery("#cus_loginform");

	var user_login = jQuery("#user_login");

	var user_loginInfo = jQuery("#user_loginInfo");

	var user_pass = jQuery("#user_pass");

	var user_passInfo = jQuery("#user_passInfo");

	

	//On blur

	//user_login.blur(validate_user_login);

	//user_pass.blur(validate_user_pass);



	//On key press

	//user_login.keyup(validate_user_login);

	//user_pass.keyup(validate_user_pass);

	

	//On Submitting

	loginform.submit(function(){

		if(validate_user_login() & validate_user_pass())

			return true

		else

			return false;

	});

////////////LOGIN FORM END



////////////REGISTRATION FORM START

	var registerform = jQuery("#cus_registerform");

	var user_login1reg = jQuery("#user_login1reg");

	var user_login1regInfo = jQuery("#user_login1regInfo");

	var user_email = jQuery("#user_email");

	var user_emailInfo = jQuery("#user_emailInfo");

	var user_fname = jQuery("#user_fname");

	var user_fnameInfo = jQuery("#user_fnameInfo");

	

		//On blur

	//user_login1reg.blur(validate_user_login1reg);

	//user_email.blur(validate_user_email);

	//user_fname.blur(validate_user_fname);



	//On key press

	//user_login1reg.keyup(validate_user_login1reg);

	//user_email.keyup(validate_user_email);

	//user_fname.keyup(validate_user_fname);

	

	//On Submitting

	registerform.submit(function(){

		if(validate_user_login1reg() & validate_user_email() & validate_user_fname())

			return true

		else

			return false;

	});



////////////REGISTRATION FORM END

	//validation functions

	function validate_user_login()

	{

		if(jQuery("#user_login").val() == '')

		{

			user_login.addClass("error");

			user_loginInfo.text("Please Enter Username");

			user_loginInfo.addClass("message_error2");

			return false;

		}

		else{

			user_login.removeClass("error");

			user_loginInfo.text("");

			user_loginInfo.removeClass("message_error2");

			return true;

		}

	}

	function validate_user_pass()

	{

		if(jQuery("#user_pass").val() == '')

		{

			user_pass.addClass("error");

			user_passInfo.text("Please Enter Password");

			user_passInfo.addClass("message_error2");

			return false;

		}

		else{

			user_pass.removeClass("error");

			user_passInfo.text("");

			user_passInfo.removeClass("message_error2");

			return true;

		}

	}

	



	function validate_user_login1reg()

	{

		if(jQuery("#user_login1reg").val() == '')

		{

			user_login1reg.addClass("error");

			user_login1regInfo.text("Please Enter Username");

			user_login1regInfo.addClass("message_error2");

			return false;

		}

		else{

			user_login1reg.removeClass("error");

			user_login1regInfo.text("");

			user_login1regInfo.removeClass("message_error2");

			return true;

		}

	}

	

	function validate_user_fname()

	{

		if(jQuery("#user_fname").val() == '')

		{

			user_fname.addClass("error");

			user_fnameInfo.text("Please Enter Name");

			user_fnameInfo.addClass("message_error2");

			return false;

		}

		else{

			user_fname.removeClass("error");

			user_fnameInfo.text("");

			user_fnameInfo.removeClass("message_error2");

			return true;

		}

	}

	

	function validate_user_email()

	{

		var isvalidemailflag = 0;

		if(jQuery("#user_email").val() == '')

		{

			isvalidemailflag = 1;

		}else

		if(jQuery("#user_email").val() != '')

		{

			var a = jQuery("#user_email").val();

			//var filter =  /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			var filter = /^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$/;

			//if it's valid email

			if(filter.test(a)){

				isvalidemailflag = 0;

			}else{

				isvalidemailflag = 1;	

			}

		}

		if(isvalidemailflag)

		{

			user_email.addClass("error");

			user_emailInfo.text("Please Enter valid E-mail");

			user_emailInfo.addClass("message_error2");

			return false;

		}else

		{

			user_email.removeClass("error");

			user_emailInfo.text("");

			user_emailInfo.removeClass("message_error");

			return true;

		}

		

	}

	
	var loginform = jQuery("#cus_loginform");

	var user_login = jQuery("#user_login");

	var user_loginInfo = jQuery("#user_loginInfo");

	var user_pass = jQuery("#user_pass");

	var user_passInfo = jQuery("#user_passInfo");

	

	//On blur

	//user_login.blur(validate_user_login);

	//user_pass.blur(validate_user_pass);



	//On key press

	//user_login.keyup(validate_user_login);

	//user_pass.keyup(validate_user_pass);

	

	//On Submitting

	loginform.submit(function(){

		if(validate_user_login() & validate_user_pass())

			return true

		else

			return false;

	});

////////////LOGIN FORM END



////////////EDIT PROFILE FORM START

	var profileform = jQuery("#profileform");
	var user_email = jQuery("#user_email");
	var user_emailInfo = jQuery("#user_emailInfo");
	var user_fname = jQuery("#user_fname");
	var user_fnameInfo = jQuery("#user_fnameInfo");
	var pwd = jQuery("#pwd");
	var pwdInfo = jQuery("#pwdInfo");
	var cpwd = jQuery("#cpwd");
	var cpwdInfo = jQuery("#cpwdInfo");

	//On blur
	//user_email.blur(validate_user_email);
	//user_fname.blur(validate_user_fname);
	//cpwd.blur(validate_cpwd);

	//On key press
	//user_email.keyup(validate_user_email);
	//user_fname.keyup(validate_user_fname);
	//cpwd.keyup(validate_cpwd);

	//On Submitting
	profileform.submit(function(){
		if(validate_user_email() & validate_user_fname() & validate_cpwd())
			return true
		else
			return false;
	});
////////////EDIT PROFILE FORM END
	//validation functions
	function validate_user_email()
	{
		var isvalidemailflag = 0;
		if(jQuery("#user_email").val() == '')
		{
			isvalidemailflag = 1;
		}else
		if(jQuery("#user_email").val() != '')
		{
			var a = jQuery("#user_email").val();
			//var filter =  /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			var filter =  /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			//if it's valid email
			if(filter.test(a)){
				isvalidemailflag = 0;
			}else{
				isvalidemailflag = 1;	
			}
		}
		if(isvalidemailflag)
		{
			user_email.addClass("error");
			user_emailInfo.text("Please Enter valid Email");
			user_emailInfo.addClass("message_error2");
			return false;
		}else
		{
			user_email.removeClass("error");
			user_emailInfo.text("");
			user_emailInfo.removeClass("message_error");
			return true;
		}
	}
	
	function validate_user_fname()
	{
		if(jQuery("#user_fname").val() == '')
		{
			user_fname.addClass("error");
			user_fnameInfo.text("Please Enter Name");
			user_fnameInfo.addClass("message_error2");
			return false;
		}
		else{
			user_fname.removeClass("error");
			user_fnameInfo.text("");
			user_fnameInfo.removeClass("message_error2");
			return true;
		}
	}
	function validate_cpwd()
	{
		if(jQuery("#pwd").val() != '' & jQuery("#cpwd").val() == '')
		{
			cpwd.addClass("error");
			cpwdInfo.text("Please Enter Confirm Password");
			cpwdInfo.addClass("message_error2");
			return false;
		}
		else if(jQuery("#pwd").val() != jQuery("#cpwd").val())
		{
			cpwd.addClass("error");
			cpwdInfo.text("Both Password should be same");
			cpwdInfo.addClass("message_error2");
			return false;
		}
		else{
			cpwd.removeClass("error");
			cpwdInfo.text("");
			cpwdInfo.removeClass("message_error2");
			return true;
		}
	}
});