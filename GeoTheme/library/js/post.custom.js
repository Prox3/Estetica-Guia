/*
 * SimpleModal 1.4.3 - jQuery Plugin
 * http://simplemodal.com/
 * Copyright (c) 2011 Eric Martin
 * Licensed under MIT and GPL
 * Date: Sep 8 2012 
 */(function(e){if(typeof define==="function"&&define.amd){define(["jquery"],e)}else{e(jQuery)}})(function(e){var t=[],n=e(document),r=e.browser.msie&&parseInt(e.browser.version)===6&&typeof window["XMLHttpRequest"]!=="object",i=e.browser.msie&&parseInt(e.browser.version)===7,s=null,o=e(window),u=[];e.modal=function(t,n){return e.modal.impl.init(t,n)};e.modal.close=function(){e.modal.impl.close()};e.modal.focus=function(t){e.modal.impl.focus(t)};e.modal.setContainerDimensions=function(){e.modal.impl.setContainerDimensions()};e.modal.setPosition=function(){e.modal.impl.setPosition()};e.modal.update=function(t,n){e.modal.impl.update(t,n)};e.fn.modal=function(t){return e.modal.impl.init(this,t)};e.modal.defaults={appendTo:"body",focus:true,opacity:50,overlayId:"simplemodal-overlay",overlayCss:{},containerId:"simplemodal-container",containerCss:{},dataId:"simplemodal-data",dataCss:{},minHeight:null,minWidth:null,maxHeight:null,maxWidth:null,autoResize:false,autoPosition:true,zIndex:1e3,close:true,closeHTML:'<a class="modalCloseImg" title="Close"></a>',closeClass:"simplemodal-close",escClose:true,overlayClose:false,fixed:true,position:null,persist:false,modal:true,onOpen:null,onShow:null,onClose:null};e.modal.impl={d:{},init:function(t,n){var r=this;if(r.d.data){return false}s=e.browser.msie&&!e.support.boxModel;r.o=e.extend({},e.modal.defaults,n);r.zIndex=r.o.zIndex;r.occb=false;if(typeof t==="object"){t=t instanceof e?t:e(t);r.d.placeholder=false;if(t.parent().parent().size()>0){t.before(e("<span></span>").attr("id","simplemodal-placeholder").css({display:"none"}));r.d.placeholder=true;r.display=t.css("display");if(!r.o.persist){r.d.orig=t.clone(true)}}}else if(typeof t==="string"||typeof t==="number"){t=e("<div></div>").html(t)}else{alert("SimpleModal Error: Unsupported data type: "+typeof t);return r}r.create(t);t=null;r.open();if(e.isFunction(r.o.onShow)){r.o.onShow.apply(r,[r.d])}return r},create:function(n){var i=this;i.getDimensions();if(i.o.modal&&r){i.d.iframe=e('<iframe src="javascript:false;"></iframe>').css(e.extend(i.o.iframeCss,{display:"none",opacity:0,position:"fixed",height:u[0],width:u[1],zIndex:i.o.zIndex,top:0,left:0})).appendTo(i.o.appendTo)}i.d.overlay=e("<div></div>").attr("id",i.o.overlayId).addClass("simplemodal-overlay").css(e.extend(i.o.overlayCss,{display:"none",opacity:i.o.opacity/100,height:i.o.modal?t[0]:0,width:i.o.modal?t[1]:0,position:"fixed",left:0,top:0,zIndex:i.o.zIndex+1})).appendTo(i.o.appendTo);i.d.container=e("<div></div>").attr("id",i.o.containerId).addClass("simplemodal-container").css(e.extend({position:i.o.fixed?"fixed":"absolute"},i.o.containerCss,{display:"none",zIndex:i.o.zIndex+2})).append(i.o.close&&i.o.closeHTML?e(i.o.closeHTML).addClass(i.o.closeClass):"").appendTo(i.o.appendTo);i.d.wrap=e("<div></div>").attr("tabIndex",-1).addClass("simplemodal-wrap").css({height:"100%",outline:0,width:"100%"}).appendTo(i.d.container);i.d.data=n.attr("id",n.attr("id")||i.o.dataId).addClass("simplemodal-data").css(e.extend(i.o.dataCss,{display:"none"})).appendTo("body");n=null;i.setContainerDimensions();i.d.data.appendTo(i.d.wrap);if(r||s){i.fixIE()}},bindEvents:function(){var i=this;e("."+i.o.closeClass).bind("click.simplemodal",function(e){e.preventDefault();i.close()});if(i.o.modal&&i.o.close&&i.o.overlayClose){i.d.overlay.bind("click.simplemodal",function(e){e.preventDefault();i.close()})}n.bind("keydown.simplemodal",function(e){if(i.o.modal&&e.keyCode===9){i.watchTab(e)}else if(i.o.close&&i.o.escClose&&e.keyCode===27){e.preventDefault();i.close()}});o.bind("resize.simplemodal orientationchange.simplemodal",function(){i.getDimensions();i.o.autoResize?i.setContainerDimensions():i.o.autoPosition&&i.setPosition();if(r||s){i.fixIE()}else if(i.o.modal){i.d.iframe&&i.d.iframe.css({height:u[0],width:u[1]});i.d.overlay.css({height:t[0],width:t[1]})}})},unbindEvents:function(){e("."+this.o.closeClass).unbind("click.simplemodal");n.unbind("keydown.simplemodal");o.unbind(".simplemodal");this.d.overlay.unbind("click.simplemodal")},fixIE:function(){var t=this,n=t.o.position;e.each([t.d.iframe||null,!t.o.modal?null:t.d.overlay,t.d.container.css("position")==="fixed"?t.d.container:null],function(e,t){if(t){var r="document.body.clientHeight",i="document.body.clientWidth",s="document.body.scrollHeight",o="document.body.scrollLeft",u="document.body.scrollTop",a="document.body.scrollWidth",f="document.documentElement.clientHeight",l="document.documentElement.clientWidth",c="document.documentElement.scrollLeft",h="document.documentElement.scrollTop",d=t[0].style;d.position="absolute";if(e<2){d.removeExpression("height");d.removeExpression("width");d.setExpression("height",""+s+" > "+r+" ? "+s+" : "+r+' + "px"');d.setExpression("width",""+a+" > "+i+" ? "+a+" : "+i+' + "px"')}else{var v,m;if(n&&n.constructor===Array){var g=n[0]?typeof n[0]==="number"?n[0].toString():n[0].replace(/px/,""):t.css("top").replace(/px/,"");v=g.indexOf("%")===-1?g+" + (t = "+h+" ? "+h+" : "+u+') + "px"':parseInt(g.replace(/%/,""))+" * (("+f+" || "+r+") / 100) + (t = "+h+" ? "+h+" : "+u+') + "px"';if(n[1]){var y=typeof n[1]==="number"?n[1].toString():n[1].replace(/px/,"");m=y.indexOf("%")===-1?y+" + (t = "+c+" ? "+c+" : "+o+') + "px"':parseInt(y.replace(/%/,""))+" * (("+l+" || "+i+") / 100) + (t = "+c+" ? "+c+" : "+o+') + "px"'}}else{v="("+f+" || "+r+") / 2 - (this.offsetHeight / 2) + (t = "+h+" ? "+h+" : "+u+') + "px"';m="("+l+" || "+i+") / 2 - (this.offsetWidth / 2) + (t = "+c+" ? "+c+" : "+o+') + "px"'}d.removeExpression("top");d.removeExpression("left");d.setExpression("top",v);d.setExpression("left",m)}}})},focus:function(t){var n=this,r=t&&e.inArray(t,["first","last"])!==-1?t:"first";var i=e(":input:enabled:visible:"+r,n.d.wrap);setTimeout(function(){i.length>0?i.focus():n.d.wrap.focus()},10)},getDimensions:function(){var e=this,r=typeof window.innerHeight==="undefined"?o.height():window.innerHeight;t=[n.height(),n.width()];u=[r,o.width()]},getVal:function(e,t){return e?typeof e==="number"?e:e==="auto"?0:e.indexOf("%")>0?parseInt(e.replace(/%/,""))/100*(t==="h"?u[0]:u[1]):parseInt(e.replace(/px/,"")):null},update:function(e,t){var n=this;if(!n.d.data){return false}n.d.origHeight=n.getVal(e,"h");n.d.origWidth=n.getVal(t,"w");n.d.data.hide();e&&n.d.container.css("height",e);t&&n.d.container.css("width",t);n.setContainerDimensions();n.d.data.show();n.o.focus&&n.focus();n.unbindEvents();n.bindEvents()},setContainerDimensions:function(){var t=this,n=r||i;var s=t.d.origHeight?t.d.origHeight:e.browser.opera?t.d.container.height():t.getVal(n?t.d.container[0].currentStyle["height"]:t.d.container.css("height"),"h"),o=t.d.origWidth?t.d.origWidth:e.browser.opera?t.d.container.width():t.getVal(n?t.d.container[0].currentStyle["width"]:t.d.container.css("width"),"w"),a=t.d.data.outerHeight(true),f=t.d.data.outerWidth(true);t.d.origHeight=t.d.origHeight||s;t.d.origWidth=t.d.origWidth||o;var l=t.o.maxHeight?t.getVal(t.o.maxHeight,"h"):null,c=t.o.maxWidth?t.getVal(t.o.maxWidth,"w"):null,h=l&&l<u[0]?l:u[0],p=c&&c<u[1]?c:u[1];var d=t.o.minHeight?t.getVal(t.o.minHeight,"h"):"auto";if(!s){if(!a){s=d}else{if(a>h){s=h}else if(t.o.minHeight&&d!=="auto"&&a<d){s=d}else{s=a}}}else{s=t.o.autoResize&&s>h?h:s<d?d:s}var v=t.o.minWidth?t.getVal(t.o.minWidth,"w"):"auto";if(!o){if(!f){o=v}else{if(f>p){o=p}else if(t.o.minWidth&&v!=="auto"&&f<v){o=v}else{o=f}}}else{o=t.o.autoResize&&o>p?p:o<v?v:o}t.d.container.css({height:s,width:o});t.d.wrap.css({overflow:a>s||f>o?"auto":"visible"});t.o.autoPosition&&t.setPosition()},setPosition:function(){var e=this,t,n,r=u[0]/2-e.d.container.outerHeight(true)/2,i=u[1]/2-e.d.container.outerWidth(true)/2,s=e.d.container.css("position")!=="fixed"?o.scrollTop():0;if(e.o.position&&Object.prototype.toString.call(e.o.position)==="[object Array]"){t=s+(e.o.position[0]||r);n=e.o.position[1]||i}else{t=s+r;n=i}e.d.container.css({left:n,top:t})},watchTab:function(t){var n=this;if(e(t.target).parents(".simplemodal-container").length>0){n.inputs=e(":input:enabled:visible:first, :input:enabled:visible:last",n.d.data[0]);if(!t.shiftKey&&t.target===n.inputs[n.inputs.length-1]||t.shiftKey&&t.target===n.inputs[0]||n.inputs.length===0){t.preventDefault();var r=t.shiftKey?"last":"first";n.focus(r)}}else{t.preventDefault();n.focus()}},open:function(){var t=this;t.d.iframe&&t.d.iframe.show();if(e.isFunction(t.o.onOpen)){t.o.onOpen.apply(t,[t.d])}else{t.d.overlay.show();t.d.container.show();t.d.data.show()}t.o.focus&&t.focus();t.bindEvents()},close:function(){var t=this;if(!t.d.data){return false}t.unbindEvents();if(e.isFunction(t.o.onClose)&&!t.occb){t.occb=true;t.o.onClose.apply(t,[t.d])}else{if(t.d.placeholder){var n=e("#simplemodal-placeholder");if(t.o.persist){n.replaceWith(t.d.data.removeClass("simplemodal-data").css("display",t.display))}else{t.d.data.hide().remove();n.replaceWith(t.d.orig)}}else{t.d.data.hide().remove()}t.d.container.hide().remove();t.d.overlay.hide();t.d.iframe&&t.d.iframe.hide().remove();t.d.overlay.remove();t.d={}}}}})

/*
 * SimpleModal Basic Modal Dialog
 * http://www.ericmmartin.com/projects/simplemodal/
 * http://code.google.com/p/simplemodal/
 *
 * Copyright (c) 2009 Eric Martin - http://ericmmartin.com
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Revision: $Id: basic.js 212 2009-09-03 05:33:44Z emartin24 $
 *
 */

jQuery(document).ready(function () {
	jQuery('a.b_sendtofriend').click(function (e) {
		e.preventDefault();
		jQuery('#basic-modal-content').modal({persist:true});
	});
	
	jQuery('a.b_claim_listing').click(function (e) {
		e.preventDefault();
		jQuery('#basic-modal-content4').modal({persist:true});
	});
	
		jQuery('a.b_send_inquiry' ).click(function (e) {
		e.preventDefault();
		jQuery('#basic-modal-content2').modal({persist:true});
	});
		
		jQuery('p.links a.a_image_sort').click(function (e) {
		e.preventDefault();
		jQuery('#basic-modal-content3').modal({persist:true});
	});
	
});


jQuery(document).ready(function(){
//global vars
	var enquiryfrm = jQuery("#send_to_frnd");
	var to_name = jQuery("#to_name");
	var to_nameInfo = jQuery("#to_nameInfo");
	var to_email = jQuery("#to_email");
	var to_emailInfo = jQuery("#to_emailInfo");
	var yourname = jQuery("#yourname");
	var yournameInfo = jQuery("#yournameInfo");
	var youremail = jQuery("#youremail");
	var youremailInfo = jQuery("#youremailInfo");
	var frnd_comments = jQuery("#frnd_comments");
	var frnd_commentsInfo = jQuery("#frnd_commentsInfo");
	
	var frnd_subject = jQuery("#frnd_subject");
	var frnd_subjectInfo = jQuery("#frnd_subjectInfo");

	//On blur
	to_name.blur(validate_to_name);
	to_email.blur(validate_to_email);
	yourname.blur(validate_yourname);
	youremail.blur(validate_youremail);
	frnd_comments.blur(validate_frnd_comments);
	frnd_subject.blur(validate_frnd_subject);

	//On key press
	to_name.keyup(validate_to_name);
	to_email.keyup(validate_to_email);
	yourname.keyup(validate_yourname);
	youremail.keyup(validate_youremail);
	frnd_comments.keyup(validate_frnd_comments);
	frnd_subject.keyup(validate_frnd_subject);

	//On Submitting
	enquiryfrm.submit(function(){
		if(validate_to_name() & validate_to_email() & validate_yourname() & validate_youremail() & validate_frnd_subject() & validate_frnd_comments())
		{
			function reset_send_email_agent_form()
			{
				document.getElementById('to_name').value = '';
				document.getElementById('to_email').value = '';
				document.getElementById('yourname').value = '';
				document.getElementById('youremail').value = '';	
				document.getElementById('frnd_subject').value = '';
				document.getElementById('frnd_comments').value = '';	
			}
			return true
		}
		else
		{
			return false;
		}
	});
	
	//validation functions
	function validate_to_name()
	{
		if(jQuery("#to_name").val() == '')
		{
			to_name.addClass("error");
			to_nameInfo.text("Please Enter To Name");
			to_nameInfo.addClass("message_error2");
			return false;
		}
		else{
			to_name.removeClass("error");
			to_nameInfo.text("");
			to_nameInfo.removeClass("message_error2");
			return true;
		}
	}
	function validate_to_email()
	{
		var isvalidemailflag = 0;
		if(jQuery("#to_email").val() == '')
		{
			isvalidemailflag = 1;
		}else
		if(jQuery("#to_email").val() != '')
		{
			var a = jQuery("#to_email").val();
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
			to_email.addClass("error");
			to_emailInfo.text("Please Enter valid Email Address");
			to_emailInfo.addClass("message_error2");
			return false;
		}else
		{
			to_email.removeClass("error");
			to_emailInfo.text("");
			to_emailInfo.removeClass("message_error");
			return true;
		}
	}

	function validate_yourname()
	{
		if(jQuery("#yourname").val() == '')
		{
			yourname.addClass("error");
			yournameInfo.text("Please Enter Your Name");
			yournameInfo.addClass("message_error2");
			return false;
		}
		else{
			yourname.removeClass("error");
			yournameInfo.text("");
			yournameInfo.removeClass("message_error2");
			return true;
		}
	}

	function validate_youremail()
	{
		var isvalidemailflag = 0;
		if(jQuery("#youremail").val() == '')
		{
			isvalidemailflag = 1;
		}else
		if(jQuery("#youremail").val() != '')
		{
			var a = jQuery("#youremail").val();
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
			youremail.addClass("error");
			youremailInfo.text("Please Enter valid Email Address");
			youremailInfo.addClass("message_error2");
			return false;
		}else
		{
			youremail.removeClass("error");
			youremailInfo.text("");
			youremailInfo.removeClass("message_error");
			return true;
		}
	}
	function validate_frnd_comments()

	{
		if(jQuery("#frnd_comments").val() == '')
		{
			frnd_comments.addClass("error");
			frnd_commentsInfo.text("Please Enter Comments");
			frnd_commentsInfo.addClass("message_error2");
			return false;
		}
		else{
			frnd_comments.removeClass("error");
			frnd_commentsInfo.text("");
			frnd_commentsInfo.removeClass("message_error2");
			return true;
		}
	}
	
	function validate_frnd_subject()
	{
		if(jQuery("#frnd_subject").val() == '')
		{
			frnd_subject.addClass("error");
			frnd_subjectInfo.text("Please Enter Subject");
			frnd_subjectInfo.addClass("message_error2");
			return false;
		}
		else{
			frnd_subject.removeClass("error");
			frnd_subjectInfo.text("");
			frnd_subjectInfo.removeClass("message_error2");
			return true;
		}
	}
});










jQuery(document).ready(function(){

//global vars

	var enquiryfrm = jQuery("#agt_mail_agent");

	var yourname = jQuery("#agt_mail_name");

	var yournameInfo = jQuery("#span_agt_mail_name");

	var youremail = jQuery("#agt_mail_email");

	var youremailInfo = jQuery("#span_agt_mail_email");

	var frnd_comments = jQuery("#agt_mail_msg");

	var frnd_commentsInfo = jQuery("#span_agt_mail_msg");

	

	//On blur

	yourname.blur(validate_yourname);

	youremail.blur(validate_youremail);

	frnd_comments.blur(validate_frnd_comments_author);

	//On key press

	yourname.keyup(validate_yourname);

	youremail.keyup(validate_youremail);

	frnd_comments.keyup(validate_frnd_comments_author);

	

	//On Submitting

	enquiryfrm.submit(function(){

		if(validate_yourname() & validate_youremail() & validate_frnd_comments_author())

		{
			//hideform();
			return true
		}
		else
		{
			return false;
		}
	});



	//validation functions

	function validate_yourname()

	{

		if(jQuery("#agt_mail_name").val() == '')

		{

			yourname.addClass("error");

			yournameInfo.text("Please Enter Your Name");

			yournameInfo.addClass("message_error2");

			return false;

		}

		else{

			yourname.removeClass("error");

			yournameInfo.text("");

			yournameInfo.removeClass("message_error2");

			return true;

		}

	}

	function validate_youremail()

	{

		var isvalidemailflag = 0;

		if(jQuery("#agt_mail_email").val() == '')

		{

			isvalidemailflag = 1;

		}else

		if(jQuery("#agt_mail_email").val() != '')

		{

			var a = jQuery("#agt_mail_email").val();

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

			youremail.addClass("error");

			youremailInfo.text("Please Enter valid Email Address");

			youremailInfo.addClass("message_error2");

			return false;

		}else

		{

			youremail.removeClass("error");

			youremailInfo.text("");

			youremailInfo.removeClass("message_error");

			return true;

		}

		

	}

	

	function validate_frnd_comments_author()
	{				
		if(jQuery("#agt_mail_msg").val() == '')
		{
			frnd_comments.addClass("error");
			frnd_commentsInfo.text("Please Enter Comments");
			frnd_commentsInfo.addClass("message_error2");
			return false;
		}else{
			frnd_comments.removeClass("error");
			frnd_commentsInfo.text("");
			frnd_commentsInfo.removeClass("message_error2");
			return true;
		}

	}	
function reset_email_agent_form()
{
	document.getElementById('agt_mail_name').value = '';
	document.getElementById('agt_mail_email').value = '';
	document.getElementById('agt_mail_phone').value = '';
	document.getElementById('agt_mail_msg').value = '';	
}
});





jQuery(document).ready(function(){
//global vars
	var enquiryfrm = jQuery("#claim_form");
	var full_name = jQuery("#full_name");
	var full_nameInfo = jQuery("#full_nameInfo");
	var user_number = jQuery("#user_number");
	var user_numberInfo = jQuery("#user_numberInfo");
	var user_position = jQuery("#user_position");
	var user_positionInfo = jQuery("#user_positionInfo");
	var user_comments = jQuery("#user_comments");
	var user_commentsInfo = jQuery("#user_commentsInfo");

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
		if(jQuery("#full_name").val() == '')
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
		if(jQuery("#user_number").val() == '')
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
		if(jQuery("#user_number").val() == '')
		{
			isvalidemailflag = 1;
		}else
		if(jQuery("#user_number").val() != '')
		{
			var a = jQuery("#user_number").val();
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
		if(jQuery("#user_position").val() == '')
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
		if(jQuery("#user_comments").val() == '')
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


