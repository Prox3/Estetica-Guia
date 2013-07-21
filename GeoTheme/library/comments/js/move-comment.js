/*WP Ajax Edit Move Comments Script
--Created by Ronald Huereca
--Created on: 09/14/2009
--Last modified on: 10/23/2009
--Relies on jQuery, wp-ajax-edit-comments, wp-ajax-response, thickbox
	
	Copyright 2007-2009  Ronald Huereca  (email : ron alfy [a t ] g m ail DOT com)

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
$j.ajaxmovecomment = {
	init: function() { initialize_events(); load_posts(); }
};
	//Initializes the edit links
	function initialize_events() {
    //Cancel button
    $j("#cancel,#status a, #close a").bind("click", function() {  parent.jQuery.fn.colorbox.close();
    return false; });
    //Title for new window
    $j("#title a").bind("click", function() { window.open(this.href); return false; } );
    
		//Title Search button
		$j("#title_search").bind("click", function() {
			$j("#post_title_move").attr("disabled", "disabled");																				 
			load_title_ajax();
		});
		
		//ID Search button
		$j("#id_search").bind("click", function() {
			$j("#post_id_move").attr("disabled", "disabled");
			s = pre_process();	
			s.data = $j.extend(s.data, { action: s.action, cid: s.cid,_wpnonce: s.nonce,pid:s.pid, post_id: $j("#post_id").attr("value")});
			//Show and hide certain elements
			$j("#post_id_buttons").addClass("hidden");
			$j("#post_id_loading").removeClass("hidden");
			$j("#id_search").attr("disabled", "disabled");
			$j("#post_id_radio").html("");
			s.success = function(r) {
				var res = wpAjax.parseAjaxResponse(r, s.response);
				count = 0; radio = '';
				$j("#id_search").removeAttr("disabled");
				$j("#post_id_loading").addClass("hidden");
				$j.each( res.responses, function() {
						if (this.data != '') {
							count += 1;
							radio += "<input type='radio' name='posts_id' id='posts_id_" + this.id + "' value='" + this.id + "' />&nbsp;&nbsp;<label for='posts_id_" + this.id + "'>" + this.data + "</label><br />";	
						}
				});
				if (count >= 1) {
					$j("#post_id_buttons").removeClass("hidden");
				}
				//write to screen
				$j("#post_id_radio").html(radio);
				
				//Setup Events for ID
				$j("input[name='posts_id']").click(function() { 
					$j("#post_id_move").removeAttr("disabled");
					id = $j(this).attr("value");
					$j("#post_id_move").bind("click", function() {
						$j("#post_id_move").attr("disabled", "disabled");
						s = pre_process();	
						s.data = $j.extend(s.data, { action: s.action, cid: s.cid,_wpnonce: s.nonce,pid:s.pid, newid: parseInt(id)});						s.data = check_approve(s.data);
						s.success = function(r) {
							//for the admin panel
							update_admin_panel(r,s);
							parent.jQuery.fn.colorbox.close();
						}
					$j.ajax(s);
					});																			 
				});
		}
		$j.ajax(s);
		});
  }
	//Checks to see if the approve button is available and only adds it if the value is one
	function check_approve(data) {
		if ($j("#approved:checked").length > 0) {
				data = $j.extend(data, { approve: "1"});
		}
		return data;
	}
	function load_title_ajax() {
		s = pre_process();	
			s.data = $j.extend(s.data, { action: s.action, cid: s.cid,_wpnonce: s.nonce,pid:s.pid, post_title: $j("#move_title").attr("value")});
			//Show and hide certain elements
			$j("#post_title_buttons").addClass("hidden");
			$j("#post_title_loading").removeClass("hidden");
			$j("#title_search").attr("disabled", "disabled");
			$j("#post_title_radio").html("");
			s.success = function(r) {
				var res = wpAjax.parseAjaxResponse(r, s.response);
				count = 0; radio = '';
				$j("#title_search").removeAttr("disabled");
				$j("#post_title_loading").addClass("hidden");
				$j.each( res.responses, function() {
						if (this.data != '') {
							count += 1;
							if (wpajaxeditcommentedit.AEC_UseRTL == "true") {
								radio += "<label for='post_title_" + this.id + "'>" + this.data + "</label>&nbsp;&nbsp;<input type='radio' name='posts_title' id='post_title_" + this.id + "' value='" + this.id + "' /><br />";
							} else {
								radio += "<input type='radio' name='posts_title' id='post_title_" + this.id + "' value='" + this.id + "' />&nbsp;&nbsp;<label for='post_title_" + this.id + "'>" + this.data + "</label><br />";
							}
						}
				});
				if (count >= 1) {
					$j("#post_title_buttons").removeClass("hidden");
				}
				//write to screen
				$j("#post_title_radio").html(radio);
				
				//Setup events for title
				$j("input[name='posts_title']").click(function() { 
					$j("#post_title_move").removeAttr("disabled");
					id = $j(this).attr("value");
					$j("#post_title_move").bind("click", function() { 
						$j("#post_title_move").attr("disabled", "disabled");
						s = pre_process();	
						s.data = $j.extend(s.data, { action: s.action, cid: s.cid,_wpnonce: s.nonce,pid:s.pid, newid: parseInt(id)});						s.data = check_approve(s.data);
						s.success = function(r) {
							//for the admin panel
							update_admin_panel(r,s);
							parent.jQuery.fn.colorbox.close();
						}
					$j.ajax(s);
					});																			 
				});
		}
		$j.ajax(s);
	}
	//Loads a group of posts in the Posts tab.
	//post_offset and direction (true, or false)
	function load_posts_ajax(post_offset, dir) {
		if (post_offset < 0) { 
			post_offset = 0;
		}
		s = pre_process();
    s.data = $j.extend(s.data, { action: s.action, cid: s.cid,pid:s.pid, post_offset: post_offset, _wpnonce: s.nonce });
		s.success = function(r) {
    	var res = wpAjax.parseAjaxResponse(r, s.response);
      //Add event for save button
      var error = false;
			var radio = "";
			var count = 0;
      $j.each( res.responses, function() {
					count += 1;
					if (count < 6 && this.data != '') {
						if (wpajaxeditcommentedit.AEC_UseRTL == "true") {
							radio += "<label for='post_" + this.id + "'>" + this.data + "</label>&nbsp;&nbsp;<input type='radio' name='posts' id='post_" + this.id + "' value='" + this.id + "' /><br />";		
						} else {
							radio += "<input type='radio' name='posts' id='post_" + this.id + "' value='" + this.id + "' />&nbsp;&nbsp;<label for='post_" + this.id + "'>" + this.data + "</label><br />";		
						}
					}
      });
			//Show and hide certain elements
			$j("#post_loading").addClass("hidden");
			$j("#post_buttons").removeClass("hidden");
			//write to screen
			$j("#post_radio").html(radio);
			
			//Setup events for posts
			$j("input[name='posts']").click(function() { 
				$j("#post_move").removeAttr("disabled");
				id = $j(this).attr("value");
				$j("#post_move").bind("click", function() { 
					$j("#post_move").attr("disabled", "disabled");
					s = pre_process();	
					s.data = $j.extend(s.data, { action: s.action, cid: s.cid,_wpnonce: s.nonce,pid:s.pid, newid: parseInt(id)});					
					s.data = check_approve(s.data);
					s.success = function(r) {
						//for the admin panel
						update_admin_panel(r,s);
						parent.jQuery.fn.colorbox.close();
					}
				$j.ajax(s);
				});																			 
			});
				
			//Write the offset
			//$j("#post_offset").attr("value", count);
			if (count == 6 && dir == "true") {
				//Show next button
				$j("#post_next").removeClass("hidden");
				if (post_offset >= 5) {
					$j("#post_previous").removeClass("hidden");
				}
			} else if (count > 0 && count < 6 && dir == "true") {
				$j("#post_previous").removeClass("hidden");
			}
			if (post_offset >= 5 && dir == "false") {
				$j("#post_offset").attr("value", post_offset);
				$j("#post_previous").removeClass("hidden");
				$j("#post_next").removeClass("hidden");
			} else if (post_offset == 0) {
					$j("#post_next").removeClass("hidden");
			}
		}
		$j.ajax(s);
	}
	function load_posts() {
		load_posts_ajax(parseInt($j("#post_offset").attr("value")), "true");
		$j("#post_next").bind("click", function() {
			$j("#post_loading").removeClass("hidden");
			$j("#post_radio").html("");
			$j("#post_previous").addClass("hidden");
			$j("#post_next").addClass("hidden");
			$j("#post_buttons").addClass("hidden");
			$j("#post_move").attr("disabled", "disabled");
			p = pre_process();
			var post_offset = parseInt($j("#post_offset").attr("value")) + 5;
			$j("#post_offset").attr("value", post_offset);
			load_posts_ajax(post_offset, "true");
			return false;
		});
		$j("#post_previous").bind("click", function() { 
			$j("#post_loading").removeClass("hidden");
			$j("#post_radio").html("");
			$j("#post_previous").addClass("hidden");
			$j("#post_next").addClass("hidden");
			$j("#post_buttons").addClass("hidden");
			$j("#post_move").attr("disabled", "disabled");
			p = pre_process();
			var post_offset = parseInt($j("#post_offset").attr("value")) - 5;
			$j("#post_offset").attr("value", post_offset);
			load_posts_ajax(post_offset, "false");
			return false;
		});
	}
	//Updates the admin panel when someone moves a comment
	function update_admin_panel(r,s) {
		var res = wpAjax.parseAjaxResponse(r, s.response);
		$j.each( res.responses, function() {
			if (this.what == "nochange") { return; }
			if (this.what == "new_id") {
				newID = this.oldId;
				oldID = this.id;
				title = this.supplemental.title;
				comments = this.supplemental.comments;
				permalink = this.supplemental.permalink;
				
				//Update the edit post link
				if (self.parent.jQuery("#comment-" + s.cid + " .post-com-count-wrapper a:first").length != 0) {
					new_edit_url = self.parent.jQuery("#comment-" + s.cid + " .post-com-count-wrapper a:first").attr("href");
					new_edit_url = new_edit_url.replace(/[0-9]+$/,newID);
					self.parent.jQuery("#comment-" + s.cid + " .post-com-count-wrapper a:first").attr("href", new_edit_url);
					self.parent.jQuery("#comment-" + s.cid + " .post-com-count-wrapper a:first").html(title);
					
					//Update the edit comment link
					new_comment_url = self.parent.jQuery("#comment-" + s.cid + " .post-com-count").attr("href");
					new_comment_url = new_comment_url.replace(/[0-9]+$/,newID);
					self.parent.jQuery("#comment-" + s.cid + " .post-com-count-wrapper a:last").attr("href",new_comment_url);
					
					//Update the permalink
					self.parent.jQuery("#comment-" + s.cid + " .response-links a:last").attr("href",permalink);
					
					
					//Update the comments count
					$j.each(self.parent.jQuery(".response:contains(" + title + ")"), function() {
						$j(this).find(".comment-count").html(comments);																																																																											
						}
					);
				}
			} else if (this.what == "old_id") {
				comments = this.supplemental.comments;
				title = this.supplemental.title;
				//Update the comments count
				$j.each(self.parent.jQuery(".response:contains(" + title + ")"), function() {
					$j(this).find(".comment-count").html(comments);																																																																											
					}
				);
			} else if (this.what == "approved") {
				self.parent.jQuery(".spam-count").html(this.supplemental.spam_count);
				self.parent.jQuery(".pending-count").html(this.supplemental.moderation_count);
				self.parent.jQuery(".aec-approve-" + s.cid + ",#approve-comment-" + s.cid).hide();
				self.parent.jQuery(".aec-spam-" + s.cid + ",#spam-comment-" + s.cid).show();
				self.parent.jQuery(".aec-moderate-" + s.cid + ",#moderate-comment-" + s.cid).show();
			} else if (this.what == "message") {
				self.parent.jQuery("#comment-undo-" + s.cid).html(this.supplemental.message);
			}
    });
	}
	function pre_process() {
		var cid = parseInt($j("#commentID").attr("value"));
    var pid = parseInt($j("#postID").attr("value"));
		var action = $j("#action").attr("value");
		var s = {};
		s.response = 'ajax-response';
		s.cid = cid;
    s.pid = pid;
    s.action = action;
    s.type = "POST";
    s.url = wpajaxeditcommentedit.AEC_PluginUrl + "/php/AjaxEditComments.php";
		s.global = false;
		s.timeout = 30000;
		s.nonce = $j("#_wpnonce").attr("value");
		return s;
	}
	$j.ajaxmovecomment.init();
	$j('#tabs').tabs(); 
	$j('body').show();
	$j("body").attr("style", "display: block;");
});