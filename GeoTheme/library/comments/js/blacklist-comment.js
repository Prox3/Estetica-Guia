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
$j.ajaxblacklistcomment = {
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
    s.url = wpajaxeditcommentblacklist.AEC_PluginUrl + "/php/AjaxEditComments.php";
		s.global = false;
    s.timeout = 30000;
  	//Change the edit text and events
		//Send button event
  	$j("#send-request").bind("click", function() { submit_blacklist(s); return false; });
		$j("#status").show();
		$j("#status").attr("class", "success");
		$j("#message").html(wpajaxeditcommentblacklist.AEC_Ready);
	}
  function submit_blacklist(data) {
  	//Update status message
    $j("#status").attr("class", "success");
    $j("#message").html(wpajaxeditcommentblacklist.AEC_Blacklisting);
    $j("#send-request").attr("disabled", "disabled");
		parameters = '';
		var length = $j("input:checked").length;
    $j.each($j("input:checked"), function() {
				length -= 1;
				parameters += $j(this).attr("value");
				if (length > 0) { parameters += ",";}
		});
		data.data = $j.extend({}, { parameters: parameters,action: data.action, cid: data.cid,pid:data.pid,_ajax_nonce: data.nonce,_wpnonce: data.nonce});
    //Read in dom value
		data.success = function(r) {
			$j("#send-request").removeAttr("disabled");
    	var res = wpAjax.parseAjaxResponse(r, data.response,data.element);
			$j.each( res.responses, function() {
				if (this.supplemental.errors != '') {
					$j("#status").attr("class", "error");
					$j("#message").html(this.supplemental.errors);
				} else {
					self.parent.jQuery("#edit-comment-admin-links" + data.cid).html(this.supplemental.comment_links);
					self.parent.jQuery(".spam-count").html(this.supplemental.spam_count);
					self.parent.jQuery(".pending-count").html(this.supplemental.moderation_count);
					$j("#send-request,#cancel").remove();
					$j("#message").html(this.supplemental.message);
				}
			return;
			});
    };
    $j.ajax(data);
  }
	$j('#tabs').tabs(); 
	$j("body").attr("style", "display: block;");
	$j.ajaxblacklistcomment.init();
});