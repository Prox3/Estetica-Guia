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
$j.ajaxrequestdeletion = {
	init: function() { initialize(); }
};
	//Initializes the edit links
	function initialize() {
  	//Read in cookie values and adjust the toggle box
    //Cancel button
    $j("#cancel,#status a, #close a").bind("click", function() {  parent.jQuery.fn.colorbox.close();
    return false; });
  	//Pre-process data
  	var cid = parseInt($j("#commentID").attr("value"));
    var pid = parseInt($j("#postID").attr("value"));
    var action = $j("#action").attr("value");
  	var s = {};
    s.element = cid
    s.nonce = $j("#_wpnonce").attr("value");
    s.response = 'ajax-response';
    s.cid = cid;
    s.pid = pid;
    s.action = action;
    s.type = "POST";
    s.url = wpajaxeditcommentedit.AEC_PluginUrl + "/php/AjaxEditComments.php";
    s.data = $j.extend(s.data, { action: s.action, cid: s.cid,pid:s.pid,_ajax_nonce: s.nonce,_wpnonce: s.nonce});
    s.global = false;
    s.timeout = 30000;
  	//Change the edit text and events
    $j("#status").show();
    $j("#status").attr("class", "success");
  	$j("#message").html(wpajaxeditcommentedit.AEC_Ready);
		//Send button event
  	$j("#send-request").bind("click", function() { send_request(s); return false; });
	}
  function send_request(data) {
  	//Update status message
		data.data = $j.extend(data.data, { message: encodeURIComponent($j("#deletion-reason").attr("value"))});
    $j("#status").attr("class", "success");
    $j("#message").html(wpajaxeditcommentedit.AEC_Sending);
    $j("#send-request").attr("disabled", "disabled");
    var error = false;
		
    //Read in dom value
		data.success = function(r) {
    	if (r == 1) { 
      	//Yay, comment deletion notice has been sent
				//remove comment
				$j("#message").html(wpajaxeditcommentedit.AEC_RequestDeletionSuccess);
				try {
					self.parent.jQuery.ajaxeditcomments.remove_comment(data.cid);
					//close thickbox
				  parent.jQuery.fn.colorbox.close();
				} catch(err) {}
        return;
     	}
			$j("#message").html(wpajaxeditcommentedit.AEC_RequestError);
      $j("#status").attr("class", "error");
    };
    $j.ajax(data);
  }
	$j.ajaxrequestdeletion.init();
});