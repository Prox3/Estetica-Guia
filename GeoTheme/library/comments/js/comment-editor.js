/*WP Ajax Edit Comments Editor Interface Script
--Created by Ronald Huereca
--Created on: 05/04/2008
--Last modified on: 10/25/2008
--Relies on jQuery, wp-ajax-edit-comments, wp-ajax-response, thickbox
	
	Copyright 2007,2008  Ronald Huereca  (email : ron alfy [a t ] g m ail DOT com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/
jQuery(document).ready(function() {
var $j = jQuery;
$j.ajaxcommenteditor = {
	init: function() { initialize_events(); load_comment(); }
};
	//Initializes the edit links
	function initialize_events() {
  	//Read in cookie values and adjust the toggle box
  	var cookieValue = readCookie('ajax-edit-comments-options');
    if (cookieValue) {
    	$j("#comment-options").attr("class", cookieValue);
    }
    
    //The "more options" button
  	$j("#comment-options h3").bind("click", function() { 
    	$j("#comment-options").toggleClass("closed"); 
      createCookie('ajax-edit-comments-options', $j("#comment-options").attr("class"), 365);
      return false; 
    });
    //Cancel button
    $j("#cancel,#status a, #close a").bind("click", function() {  parent.jQuery.fn.colorbox.close();
    return false; });
    //Title for new window
    $j("#title a").bind("click", function() { window.open(this.href); return false; } );
    //Save button event
  }
	function load_comment() {
  	//Pre-process data
  	var cid = parseInt($j("#commentID").attr("value"));
    var pid = parseInt($j("#postID").attr("value"));
    var action = $j("#action").attr("value");
  	var s = {};
    s.element = cid;
    s.response = 'ajax-response';
    s.cid = cid;
    s.pid = pid;
    s.action = action;
    s.type = "POST";
    s.url = wpajaxeditcommentedit.AEC_PluginUrl + "/php/AjaxEditComments.php";
    s.data = $j.extend(s.data, { action: s.action, cid: s.cid,pid:s.pid });
    s.global = false;
    s.timeout = 30000;
  	//Change the edit text and events
    $j("#status").show();
    $j("#status").attr("class", "success");
  	$j("#message").html(wpajaxeditcommentedit.AEC_Loading);
  	//todo - Possibly do something on failure here
    s.success = function(r) {
    	var res = wpAjax.parseAjaxResponse(r, s.response,s.element);
      //Add event for save button
      var error = false;
      $j("#save").bind("click", function() { save_comment(s); return false; });
      $j.each( res.responses, function() {
        	if (this.what == "error") { //error
          	error = true;
          	$j("#status").attr("class", "error");
            $j("#message").html(this.data);
            $j("#close-option").show();
            //remove event for save button
            $j("#save").unbind("click");
          } else { //success
            //Load content
            switch(this.what) {
              case "comment_content":
               	$j("#comment").html(this.data); //For everyone else
                $j("#comment").attr("value",this.data); //For Opera
                break;
              case "comment_author":
                $j("#name").attr("value", this.data);
                break;
              case "comment_author_email":
                $j("#e-mail").attr("value", this.data);
                break;
              case "comment_author_url":
                $j("#URL").attr("value", this.data);
                break;
              case "gravatar":
                $j("#gravatar").html(this.data).show();
                break;
          	}
          }
      });
      if (!error) {
      	//Enable the buttons
        $j("#save, #cancel").removeAttr("disabled");
      	//Update status message
        $j("#status").attr("class", "success");
        $j("#message").html(wpajaxeditcommentedit.AEC_LoadSuccessful);
      }
     
    }
    $j.ajax(s);
  } //end load_comment
  function save_comment(data) {
  	//Update status message
    $j("#status").attr("class", "success");
    $j("#message").html(wpajaxeditcommentedit.AEC_Saving);
    $j("#save").attr("disabled", "disabled");
  	data.action = "savecomment";
    var error = false;
    //Read in dom values
    var name = encodeURIComponent($j("#name").attr("value"));
    var email = encodeURIComponent($j("#e-mail").attr("value"));
    var url = encodeURIComponent($j("#URL").attr("value"));
    var comment = encodeURIComponent($j("#comment").attr("value")); 
    var nonce = $j("#_wpnonce").attr("value");
    data.data = $j.extend({ comment_content: comment, comment_author: name, comment_author_email: email, comment_author_url: url,action: data.action, cid: data.cid,pid:data.pid, _wpnonce: nonce },'');
		
		//Comment Status
		if ($j("#comment-status-radio").length > 0) {
			var comment_status = $j("#comment-status-radio :checked").attr("value");
			data.data = $j.extend(data.data, { comment_status: comment_status});
		}
		//Timestamp
		if ($j("#timestamp").length > 0) {
			var month = encodeURIComponent($j("#mm").attr("value")); 
			var day = encodeURIComponent($j("#jj").attr("value"));
			var year = encodeURIComponent($j("#aa").attr("value"));
			var hour = encodeURIComponent($j("#hh").attr("value"));
			var minute = encodeURIComponent($j("#mn").attr("value"));
			var ss = encodeURIComponent($j("#ss").attr("value"));
			data.data = $j.extend(data.data, { mm: month, jj: day, aa: year, hh: hour,mn: minute,ss:ss});
		}
    //data.data = $j.extend(data.data, {mycode: "value", mycode2: "value"}); //Extend example
    //todo - possibly do something with failure also
    data.success = function(r) {
    	var res = wpAjax.parseAjaxResponse(r, data.response,data.element);
			//if (r == "") {  parent.jQuery.fn.colorbox.close();return;  } /* Commented out for IE7/8 problems*/
			try {
				$j.each( res.responses, function() {
						if (this.what == "error") { //error
							error = true;
							$j("#save").removeAttr("disabled");
							$j("#status").attr("class", "error");
							$j("#message").html(this.data);
							$j("#close-option").show();
						} else if (this.what == "content") { //success 
							comment = this.supplemental.content;
							name = this.supplemental.comment_author;
							url = this.supplemental.comment_author_url;
							date = this.supplemental.comment_date;
							time = this.supplemental.comment_time;
							undo = this.supplemental.undo;
							comment_approved = this.supplemental.comment_approved;
							old_comment_approved = this.supplemental.old_comment_approved;
							spam_count = this.supplemental.spam_count;
							moderation_count = this.supplemental.moderation_count;
							comment_links = this.supplemental.comment_links;
						}
				});
			} catch(err) {}
      if (!error) {
      	try {
        	self.parent.jQuery.ajaxeditcomments.update_comment("edit-comment" + data.cid,comment);
          self.parent.jQuery.ajaxeditcomments.update_author("edit-author" + data.cid,name, url);
					self.parent.jQuery.ajaxeditcomments.update_date_or_time("aecdate" + data.cid,date);
					self.parent.jQuery.ajaxeditcomments.undo_message(data.cid, undo);
					self.parent.jQuery(".spam-count").html(spam_count);
					self.parent.jQuery("#edit-comment-admin-links" + data.cid).html(comment_links);
					self.parent.jQuery(".pending-count").html(moderation_count);
					
	
					
        } catch (err) {}
      	$j("#status").attr("class", "success");
        $j("#message").html(wpajaxeditcommentedit.AEC_Saved);
         parent.jQuery.fn.colorbox.close();
      }
    };
    $j.ajax(data);
  }
  //Cookie code conveniently stolen from http://www.quirksmode.org/js/cookies.html
	function createCookie(name,value,days) {
    if (days) {
      var date = new Date();
      date.setTime(date.getTime()+(days*24*60*60*1000));
      var expires = "; expires="+date.toGMTString();
    }
    else var expires = "";
    document.cookie = name+"="+value+expires+"; path=/";
	}
  function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
      var c = ca[i];
      while (c.charAt(0)==' ') c = c.substring(1,c.length);
      if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
  }
	$j.ajaxcommenteditor.init();
	$j('#tabs').tabs(); 
	$j("body").attr("style", "display: block;");
});