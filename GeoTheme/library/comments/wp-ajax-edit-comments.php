<?php
/*
Plugin Name: WP Ajax Edit Comments
Plugin URI: http://www.ajaxeditcomments.com/
Description:  Users can edit their own comments for a limited time, while admins can edit all comments.
Author:  Ronald Huereca
Version: 3.2.1.0
Requires at least: 2.8
Author URI: http://www.ajaxeditcomments.com/
Generated At: www.wp-fun.co.uk;
*/ 


if (!class_exists('WPrapAjaxEditComments')) {
    class WPrapAjaxEditComments	{		
		var $commentClassName = "edit-comment"; 
		var $authorClassName = "edit-author";
		var $cookieName = "WPAjaxEditCommentsComment"; /*Please do not edit these variables*/
		var $adminOptionsName = "WPAjaxEditComments20";
		var $userOptionsName = "WPAjaxEditAuthorUserOptions";
		var $localizationName = "ajaxEdit";
		var $minutes = 5;
		var $version = "3.2.1.0";
		/**
		* PHP 4 Compatible Constructor
		*/
		function WPrapAjaxEditComments(){$this->__construct();}
		
		/**
		* PHP 5 Constructor
		*/		
		function __construct(){
		
			$this->adminOptions = $this->get_admin_options();
			 $this->pluginDir = rtrim( plugin_dir_url(__FILE__), '/' );
			
			//If registered users can only comment and user is not logged in, skip loading the plugin.
			if (get_option('comment_registration') == '1'){
				include_once(ABSPATH . 'wp-includes/pluggable.php');
				if (!is_user_logged_in()) {
					return;
				}
			}
			
			$this->initialize_errors();
	
			$this->skip = false;
			//For blogs comments for registered users only, this small snippet only loads the plugin if a) comment registration is enabled. b) The user is logged in, and c) the user is not admin
			//todo - above description  (get_option('comment_registration'))
			//css
			add_action("wp_head", array(&$this,"add_css"));
			add_action('admin_head', array(&$this,"add_css")); 
			//JavaScript
			add_action('admin_print_scripts', array(&$this,'add_post_scripts'),1000); 
			add_action('wp_print_scripts', array(&$this,'add_post_scripts'),1000);

			//Custom actions for other plugin authors
			add_action('add_wp_ajax_comments_js_post', array(&$this,'add_post_scripts'));
			add_action('add_wp_ajax_comments_js_admin', array(&$this,'add_post_scripts'));
			add_action('wp_ajax_comments_comment_edited', array(&$this, 'edit_notification'),1,2);
			add_action('wp_ajax_comments_comment_edited', array(&$this, 'comment_edited'),2,2);
			add_action('wp_ajax_comments_remove_content_filter', array(&$this, 'comment_filter'));
			//Initialization stuff
			add_action('init', array(&$this, 'init'));
			//Admin options
			add_action('admin_menu', array(&$this,'add_admin_pages'));
			//When a comment is posted
			add_action('comment_post', array(&$this, 'comment_posted'),100,1);
			
			if (!is_feed()) {
				//Yay, filters.
				add_filter('comment_excerpt', array(&$this, 'add_edit_links'), '1000');
				add_filter('get_comment_date', array(&$this, 'add_date_spans'), '1000');
				add_filter('get_comment_time', array(&$this, 'add_time_spans'), '1000');
			//Check to see if admin allows comment editing
			if ($this->adminOptions['disable']=='true'){}else{
				add_filter('comment_text', array(&$this, 'add_edit_links'), '1000'); //Low priority so other HTML can be added first
			}
				add_filter('get_comment_author_link', array(&$this, 'add_author_spans'), '1000'); //Low priority so other HTML can be added first			
			}
			//echo '###';exit;
			
		}
		
		/* add_author_spans - Adds spans to author links */
		function add_author_spans($content) {
			global $comment;
			if (empty($comment)) { return $content; }
			if ($this->can_edit_quickcheck($comment) != 1) { return $content; } //--ag
			if ($this->can_edit($comment->comment_ID, $comment->comment_post_ID) != 1) { return $content; }
			$content = "<span id='$this->authorClassName" . "$comment->comment_ID'>$content</span>";
			return $content;
		}
		/* add_date_spans - Adds spans to date links */
		function add_date_spans($content) {
			global $comment;
			if (empty($comment)) { return $content; }
			if ($this->can_edit_quickcheck($comment) != 1) { return $content; } //--ag
			if ($this->can_edit($comment->comment_ID, $comment->comment_post_ID) != 1) { return $content; }
			$content = "<span id='aecdate$comment->comment_ID'>$content</span>";
			return $content;
		}
		/* add_edit_links - Adds edit links to post and admin panels */
		function add_edit_links($content) {
			global $comment;
			if ($this->skip) { $this->skip = false; return $content; }
			if (empty($comment)) { return $content; }
			if (is_page() && $this->adminOptions['show_pages'] != 'true') {
				return $content;
			}
			if ($this->can_edit_quickcheck($comment) != 1) { return $content; } //--ag
			if ($this->can_edit($comment->comment_ID, $comment->comment_post_ID) != 1) { return $content; }
			
			if ($this->adminOptions['comment_display_top'] == 'true') {
				$aec_top = true;
			}
			$tempContent = $content; //temporary variable to store content
			$edit_admin = "edit-comment-admin-links";
			$beginning=$seperator=$end=$clearfix=$timer_class='';
			if ($this->adminOptions['icon_display'] != 'classic' && $this->adminOptions['icon_display'] != 'dropdown') {
					$edit_admin = "edit-comment-admin-links-no-icon";	
					$timer_class = "ajax-edit-time-left-no-icon";
					$beginning = "[ ";
					$seperator = " | ";
					$end = " ]";
			}
			/*If you're wondering why the JS is inline, it's because people with 500+ comments were having their browsers lock up.  With inline, the JS is run as needed.  Not elegant, but the best solution.*/
			if (!isset($aec_top)) { //Test to see if user wants interface on top or bottom
				$content = '<div class="'.$this->commentClassName. '" id="' . $this->commentClassName . $comment->comment_ID . '" style="background: none">' . $content .  '</div>';
				$content .= "<div id='comment-undo-$comment->comment_ID' class='aec-undo' style='background: none'></div>";
			} else {
				$content = '';
			}
			if (!$this->is_comment_owner($comment->comment_post_ID)) {
				//For anonymous users
				$content .= "<div class='$edit_admin $clearfix' id='edit-comment-user-link-$comment->comment_ID' style='background:none'>";
				$content .= $this->build_admin_links($comment->comment_ID, $comment->comment_post_ID);
				$content .= "</div>";
				//End for anonymous users
			} else {
				$options = $this->get_user_options();
				if (is_admin() && $options['admin_editing'] == "false") { 
					//We're in the admin panel
					$content .= '<div class="' .$edit_admin. ' ' . $clearfix.'" id="' . $this->commentClassName . '-admin-links' . $comment->comment_ID . '">' . $beginning;
					$content .= $this->build_admin_links($comment->comment_ID, $comment->comment_post_ID);
					$content .= "$end</div>";
					//End in the admin panel
				} elseif ($options['comment_editing'] == "true") { 
					//We're in a post
					$content .= '<div class="' . $edit_admin . ' ' . $clearfix . '" id="' . $this->commentClassName . '-admin-links' . $comment->comment_ID . '" style="background: none">';
					$content .= $this->build_admin_links($comment->comment_ID, $comment->comment_post_ID);
					$content .= "</div>";
				}
				
			}
			if (isset($aec_top)) { //Test to see if user wants interface on top or bottom
				$content .= "<div id='comment-undo-$comment->comment_ID' class='aec-undo' style='background: none'></div>";
				$content .= '<div class="'.$this->commentClassName. '" id="' . $this->commentClassName . $comment->comment_ID . '" style="background: none">' . $tempContent .  '</div>';
			}
			
			return $content;
			
		} //end function add_edit_links
		/* add_date_spans - Adds spans to date links */
		function add_time_spans($content) {
			global $comment;
			if (empty($comment)) { return $content; }
			if ($this->can_edit_quickcheck($comment) != 1) { return $content; } //--ag
			if ($this->can_edit($comment->comment_ID, $comment->comment_post_ID) != 1) { return $content; }
			$content = "<span id='aectime$comment->comment_ID'>$content</span>";
			return $content;
		}
		/* approve_comment - Marks a comment as approved 
		Parameters - $commentID, $postID
		Returns - 1 if successful, a string error message if not */
		
		function approve_comment($commentID=0, $postID = 0) {
			if ($this->is_comment_owner($postID)) {
				$status = wp_set_comment_status($commentID, 'approve')? "1" : 'approve_failed';
				return $status;
			} else {
				return 'approve_failed_permission';
			}
		}
		function build_admin_links($commentID, $postID, $content = '') {
			$comment = get_comment($commentID);
			if (empty($comment->comment_author_url) || $comment->comment_author_url == "http://") {
				$delink = false;
			}
			$ajax_url = get_bloginfo('template_directory') . "/library/comments/php/AjaxEditComments.php";
			if (!$this->is_comment_owner($postID) || $this->adminOptions['show_advanced'] == "false") {
				$edit_url = clean_url(wp_nonce_url(get_bloginfo('template_directory') . "/library/comments/php/comment-editor.php" . "?action=editcomment&p=$postID&c=$commentID", "editcomment_$commentID")."&height=445&width=560");
			} else {
				$edit_url = clean_url(wp_nonce_url(get_bloginfo('template_directory') . "/library/comments/php/comment-editor.php" . "?action=editcomment&p=$postID&c=$commentID", "editcomment_$commentID")."&height=560&width=620");
			}
			$move_comment_url = clean_url(wp_nonce_url(get_bloginfo('template_directory') . "/library/comments/php/move-comment.php" . "?action=movecomment&p=$postID&c=$commentID", "movecomment_$commentID")."&height=500&width=560");
			$request_deletion_url = clean_url(wp_nonce_url(get_bloginfo('template_directory') . "/library/comments/php/request-deletion.php" . "?action=requestdeletion&p=$postID&c=$commentID", "requestdeletion_$commentID")."&height=425&width=560");
			$spam_url = clean_url( wp_nonce_url( $ajax_url . "?action=spamcomment&p=$postID&c=$commentID", "spamcomment_$commentID" ) );
			$blacklist_url = clean_url(wp_nonce_url(get_bloginfo('template_directory') . "/library/comments/php/blacklist-comment.php" . "?action=blacklist&p=$postID&c=$commentID", "blacklist_$commentID")."&height=550&width=600");
			$delete_url = clean_url( wp_nonce_url( $ajax_url . "?action=deletecomment&p=$postID&c=$commentID", "deletecomment_$commentID" ) );
			$restore_url = clean_url( wp_nonce_url( $ajax_url . "?action=undodelete&p=$postID&c=$commentID", "undodelete_$commentID" ) );
			$deleteperm_url = clean_url( wp_nonce_url( $ajax_url . "?action=deleteperm&p=$postID&c=$commentID", "deleteperm_$commentID" ) );
			$moderate_url = clean_url( wp_nonce_url( $ajax_url . "?action=unapprovecomment&p=$postID&c=$commentID", "unapprovecomment_$commentID" ) );
			$approve_url = clean_url( wp_nonce_url( $ajax_url . "?action=approvecomment&p=$postID&c=$commentID", "approvecomment_$commentID" ) );
			$delink_url = clean_url( wp_nonce_url( $ajax_url . "?action=delinkcomment&p=$postID&c=$commentID", "delinkcomment_$commentID" ) );
			//Icon Classes
			
			$spam_class=$moderate_class=$edit_class=$approve_class=$delete_class=$beginning=$seperator=$end=$clearfix=$timer_class='';
			$edit_admin = "edit-comment-admin-links";
			if ($this->adminOptions['icon_display'] == 'classic' || $this->adminOptions['icon_display'] == 'dropdown') {
					$spam_class = 'spam-comment';
					$moderate_class = 'moderate-comment';
					$edit_class = 'edit-comment';
					$request_deletion_class = "request-deletion-comment";
					$approve_class = 'approve-comment';
					$delete_class = 'delete-comment';
					$delink_class = 'delink-comment';
					$move_class = "move-comment";			
					$blacklist_class = "blacklist-comment";
			} else {
				$edit_admin = "edit-comment-admin-links-no-icon";
				$timer_class = "ajax-edit-time-left-no-icon";
				$beginning = "[ ";
				$seperator = " | ";
				$end = " ]";
			}
			if ($this->adminOptions['clear_after'] == 'true') {
				$clearfix = "clearfix";
			}
			//For anonymous users
			if (!$this->is_comment_owner($postID)) {
				$content .= "<a title='".__('Ajax Edit Comments')."' class='$edit_class' href='$edit_url' onclick='return jQuery.ajaxeditcomments.edit(this);' id='edit-$commentID'>";
				$content .= __("Click to Edit");
				$content .= "</a>";
				//check if deletion option is on
				if ($this->adminOptions['allow_deletion'] == "true") {
					$content .= "<a title='" . __('Request Deletion')."' class='$request_deletion_class' href='$request_deletion_url' onclick='return jQuery.ajaxeditcomments.request_deletion(this);' id='request-deletion-$commentID'>";
					$content .= __("Request Deletion");
					$content .= "</a>";
				}
				//Check to see if timer is on
				if ($this->adminOptions['show_timer'] == 'true') {
					//Check to see if user is logged in and admin can indefinitely edit
					if (!$this->can_indefinitely_edit($comment->user_id)) {
						$content .= " <span class='ajax-edit-time-left $timer_class' id='ajax-edit-time-left-$commentID'></span>";
					}
				}
				$content .= "<br />";
				return $content;
			}
			$options = $this->get_user_options();
			if (is_admin() && $options['admin_editing'] == "false") { //in the admin
				//Spans are used here instead of LIs because of style conflicts in the admin panel
				$content .= "<span class='aec-edit-$commentID'><a title='".__('Ajax Edit Comments')."' class='$edit_class' href='$edit_url' onclick='return jQuery.ajaxeditcomments.edit(this);' id='edit-$commentID'>";
				$content .= __('Edit');
				$content .= "</a></span>";
				if (isset($_GET['comment_status'])) {
					if ("trash" == $_GET['comment_status']) {
						$content .= "<span class='aec-delete-$commentID'>$seperator<a class='$approve_class' href='$restore_url' onclick='jQuery.ajaxeditcomments.restore_comment(this); return false;' id='restore-$commentID'>";
						$content .= __('Restore');
						$content .= "</a></span>";
						$content .= "<span class='aec-deleteperm-$commentID'>$seperator<a class='$delete_class' href='$deleteperm_url' onclick='jQuery.ajaxeditcomments.deleteperm_comment(this); return false;' id='deleteperm-$commentID'>";
						$content .= __('Delete Permanently');
						$content .= "</a></span>";
						return $content;
					}
				}
				if ($this->adminOptions['icon_display'] == "dropdown") {
					//begin dropdown
					$content .= "<span class='aec-dropdownarrow' id='aec-dropdownarrow-$commentID'>";
					$content .= "<a class='aec-dropdownlink' href='cid=$commentID' onclick='jQuery.ajaxeditcomments.dropdown(this); return false;' id='aec-dropdownlink-$commentID'>";
					$content .= __('More Options');
					$content .= "</a>";
					$content .= "<span class='aec-dropdown' id='aec-dropdown-$commentID'>";
				} //End if dropdown
				//$content .= "<span class='aec-move-$commentID'>$seperator<a title='" . __("Move Comments") . "' class='$move_class' href='$move_comment_url' onclick='return jQuery.ajaxeditcomments.move(this);' id='move-$commentID'>";
					//$content .= __('Move');
					//$content .= "</a></span>";
				if (!isset($delink)) { //don't delink a comment if it has no link
					$content .= "<span class='aec-delink-$commentID'>$seperator<a class='$delink_class' href='$delink_url' onclick='jQuery.ajaxeditcomments.delink(this); return false;' id='delink-$commentID'>";
					$content .= __('De-link');
					$content .= "</a></span>";
				} 
				if ($comment->comment_approved != "0") {
					$content .= "<span class='aec-moderate-$commentID'>$seperator<a class='$moderate_class' href='$moderate_url' onclick='jQuery.ajaxeditcomments.moderate(this); return false;' id='moderate-$commentID'>";
					$content .= __('Moderate');
					$content .= "</a></span>";
				}
				if ($comment->comment_approved == "0" || $comment->comment_approved == "spam") {
					$content .= "<span class='aec-approve-$commentID'>$seperator<a class='$approve_class' href='$approve_url' onclick='jQuery.ajaxeditcomments.approve(this); return false;' id='approve-$commentID'>";
					$content .= __('Approve');
					$content .= "</a></span>";
				}
				if ($comment->comment_approved != "spam") {
					$content .= "<span class='aec-spam-$commentID'>$seperator<a class='$spam_class' href='$spam_url' onclick='jQuery.ajaxeditcomments.spam(this); return false;' id='spam-$commentID'>";
					$content .= __('Spam');
					$content .= "</a></span>";
				}
				$content .= "<span class='aec-blacklist-$commentID'>$seperator<a title='".__('Blacklist Comment')."' class='$blacklist_class' href='$blacklist_url' onclick='jQuery.ajaxeditcomments.blacklist_comment(this); return false;' id='blacklist-$commentID'>";
					$content .= __('Blacklist');
					$content .= "</a></span>";
				$content .= "<span class='aec-delete-$commentID'>$seperator<a class='$delete_class' href='$delete_url' onclick='jQuery.ajaxeditcomments.delete_comment(this); return false;' id='delete-$commentID'>";
				$content .= __('Trash');
				$content .= "</a></span>";
				if ($this->adminOptions['icon_display'] == "dropdown") {
					$content .= "</span>"; //end dropdown
					$content .= "</span>"; //end more options
				}
				$content .= "<br />";
				return $content;
			} elseif ($options['comment_editing'] == "true") { //on a post
				
					$content .= "$beginning<a title='".__('Ajax Edit Comments')."' class='$edit_class' href='$edit_url' onclick='return jQuery.ajaxeditcomments.edit(this);' id='edit-$commentID'>";
					$content .= __('Edit');
					$content .= "</a>";
					if ($this->adminOptions['icon_display'] == "dropdown") {
						//begin dropdown
						$content .= "<span class='aec-dropdownarrow' id='aec-dropdownarrow-$commentID'>";
						$content .= "<a class='aec-dropdownlink' href='cid=$commentID' onclick='jQuery.ajaxeditcomments.dropdown(this); return false;' id='aec-dropdownlink-$commentID'>";
						$content .= __('More Options');
						$content .= "</a></span>";
						$content .= "<span class='aec-dropdown' id='aec-dropdown-$commentID'>";
					} //End dropdown
					//$content .= "$seperator<a title='" . __("Move Comments") . "' class='$move_class' href='$move_comment_url' onclick='return jQuery.ajaxeditcomments.move(this);' id='move-$commentID'>";
					//$content .= __('Move');
					//$content .= "</a>";
					if (!isset($delink)) { //don't delink a comment if it has no link
						$content .= "$seperator<a class='$delink_class' href='$delink_url' onclick='jQuery.ajaxeditcomments.delink(this); return false;' id='delink-$commentID'>";
						$content .= __('De-link');
						$content .= "</a>";
					}
					if ($comment->comment_approved == "0" || $comment->comment_approved == "spam") {
						$content .= "$seperator<a class='$approve_class' href='$approve_url' onclick='jQuery.ajaxeditcomments.approve(this); return false;' id='approve-$commentID'>";
						$content .= __('Approve');
						$content .= "</a>";
					}
					if ($comment->comment_approved != "0") {
						$content .= "$seperator<a class='$moderate_class' href='$moderate_url' onclick='jQuery.ajaxeditcomments.moderate(this); return false;' id='moderate-$commentID'>";
						$content .= __('Moderate');
						$content .= "</a>";
					}
					if ($comment->comment_approved != "spam") {
						$content .= "$seperator<a class='$spam_class' href='$spam_url' onclick='jQuery.ajaxeditcomments.spam(this); return false;' id='spam-$commentID'>";
						$content .= __('Spam');
						$content .= "</a>";
					}
					$content .= "$seperator<a title='".__('Blacklist Comment')."' class='$blacklist_class' href='$blacklist_url' onclick='jQuery.ajaxeditcomments.blacklist_comment(this); return false;' id='blacklist-$commentID'>";
					$content .= __('Blacklist');
					$content .= "</a>";
					$content .= "$seperator<a class='$delete_class' href='$delete_url' onclick='jQuery.ajaxeditcomments.delete_comment(this); return false;' id='delete-$commentID'>";
					$content .= __('Trash');
					$content .= "</a>";
					$content .= "$end";
					if ($this->adminOptions['icon_display'] == "dropdown") {
						$content .= "</span>" /* end Dropdown span */;
					}
					$content .= "<br />";
					return $content;
			}
			return $content;
		} //end build admin links
		//Builds an undo message
		
		function build_undo_url($action,$commentID,$postID, $message) {
				$undo_url = clean_url(wp_nonce_url(get_bloginfo('template_directory') . "/library/comments/php/AjaxEditComments.php" . "?action=$action&p=$postID&c=$commentID", $action . "_" . $commentID));
				$undo = "<em>$message<span class='aec-undo-span undo$commentID'> - <a href='$undo_url' class='aec-undo-link'>" . __('Undo') . "</a></em></span>";
				return $undo;
		}
		/*
		can_edit - Determines if a user can edit a particular comment on a particular post
		Parameters - commentID, postID
		Returns - Enumeration (0=unsuccessful,1=successful,or string error code)
		*/
		function can_edit($commentID = 0, $postID = 0) {
			global $wpdb;
			
			//Check if admin/editor/post author
			if ($this->is_comment_owner($postID)) {
				return 1;
			}
			
			//Check to see if admin allows comment editing
			if ($this->adminOptions['allow_editing'] == "false") {
				return 'no_user_editing';
			}
			//Get the current comment, if necessary
			$comment = $this->get_edit_comment($commentID); 
			if (!$comment) { return 'get_comment_failed'; }
			//Check to see if the comment is spam
			if ($comment['comment_approved'] === 'spam') { 
				return 'comment_spam';
			}
			//Check to see if the comment is spam
			/*if ($comment['comment_approved'] === '0') { 
				return 'comment_moderated';
			}
			*/
			
			//Check to see if the user is logged in and can indefinitely edit
			if ($this->can_indefinitely_edit($comment['user_id'])) {
			return 1;
			}
			//Now we check to see if there is any time remaining for comments
			$timestamp = $comment['time'];
			$time = current_time('timestamp',1)-$timestamp;
			$minutesPassed = round(((($time%604800)%86400)%3600)/60); 

			//Get the time the admin has set for minutes
			$minutes = $this->adminOptions['minutes'];
			if (!is_numeric($minutes)) {
				$minutes = $this->minutes; //failsafe
			}
			if ($minutes < 1) {
				$minutes = $this->minutes;
			}
			if (($minutesPassed - $minutes) > 0) {
				return 'comment_time_elapsed';
			}
			
			//Now check if options allow editing after an additional comment has been made
			if ($this->adminOptions['allow_editing_after_comment'] == "false") {
				//Admin doesn't want users to edit - so now check if any other comments have been left
				$query = "SELECT comment_ID from $wpdb->comments where comment_post_ID = $postID and comment_type <> 'pingback' and comment_type <> 'trackback' order by comment_ID DESC limit 1";
				$newComment = $wpdb->get_row($query, ARRAY_A); 
				if (!$newComment) { return 'new_comment_posted'; }
				//Check to see if there is a higher comment ID
				if ($commentID != $newComment['comment_ID']) { return 'new_comment_posted'; }
			}
			//Get post security key
			$postContent = $wpdb->get_row("SELECT meta_value FROM $wpdb->postmeta WHERE post_id = " . $comment['comment_post_ID'] . " and meta_key = '_" . $comment['comment_ID'] . "'", ARRAY_A);//$wpdb->get_row("SELECT post_content from $wpdb->posts WHERE post_type = 'ajax_edit_comments' and guid = $commentID order by ID desc limit 1", ARRAY_A);
			if (!$postContent) { return 'comment_edit_denied'; }
			
			$hash = md5($comment['comment_author_IP'] . $comment['comment_date_gmt']);
			
			//Now check to see if there's a valid cookie
			if ($GLOBALS[$this->cookieName . $commentID . $hash]=='' ){ //For compatability with CFORMS
				if (isset($_COOKIE[$this->cookieName . $commentID . $hash])) {
					if ($_COOKIE[$this->cookieName . $commentID . $hash] != $postContent['meta_value']) { return 'comment_edit_denied'; }
				} else {
					return 'comment_edit_denied';
				}
			} else {
				if ($GLOBALS[$this->cookieName . $commentID . $hash] != $postContent['meta_value']) { return 'comment_edit_denied'; }
			}
			return 1;  //Yay, user can edit
		} //End function can_edit
		/*
		can_edit_quickckech - Quick check without DB access before can_edit() --ag
		Parameters - comment
		Returns - Enumeration (0=unsuccessful,1=successful,or string error code)
		*/
		
		function can_edit_quickcheck($comment) {
			//Check if admin/editor/post author
			if ($this->is_comment_owner($comment->comment_post_ID)) {
				return 1;
			}
			//Check to see if the user is logged in and can indefinitely edit
			if ($this->can_indefinitely_edit($comment->user_id)) {
			return 1;
			}
			

			//Now we check to see if there is any time remaining for comments
			$timestamp = strtotime($comment->comment_date);
			$time = current_time('timestamp',get_option('gmt_offset'))-$timestamp;
						$minutesPassed = round(((($time%604800)%86400)%3600)/60); 

			//Get the time the admin has set for minutes
			$minutes = $this->adminOptions['minutes'];
			if (!is_numeric($minutes)) {
				$minutes = $this->minutes; //failsafe
			}
			if ($minutes < 1) {
				$minutes = $this->minutes;
			}
			if (($minutesPassed - $minutes) > 0) {
				return 'comment_time_elapsed';
			} else {
				return 1;  //Yay, user can edit
			}

		} //End function can_edit_quickcheck
		
		/* can_edit_name - Checks to see if a user can edit a name
		Parameters - $commentID, $postID
		Returns true if one can, false if not */
		function can_edit_name($commentID, $postID) {
			if ($this->is_comment_owner($postID)) { return true; }
			$comment = get_comment($commentID, ARRAY_A);
			if ($this->is_logged_in($comment['user_id'])) { //logged in
				if ($this->adminOptions['registered_users_name_edit'] == "true") { return true;}
			} else { //not logged in 
				if ($this->adminOptions['allow_name_editing'] == "true") { return true;}
			}
			return false;
		}
		/* can_edit_email - Checks to see if a user can edit an e-mail address
		Parameters - $commentID, $postID
		Returns true if one can, false if not */
		function can_edit_email($commentID, $postID) {
			$comment = get_comment($commentID, ARRAY_A);
			//Return false if comment is pingback or trackback
			if ($comment['comment_type'] == "pingback" || $comment['comment_type'] == 'trackback') { return false; }
			if ($this->is_comment_owner($postID)) { return true; }	
			
			if ($this->is_logged_in($comment['user_id'])) { //logged in
				if ($this->adminOptions['registered_users_email_edit'] == "true") { return true;}
			} else { //not logged in 
				if ($this->adminOptions['allow_email_editing'] == "true") { return true;}
			}
			return false;
		}
		/* can_edit_url - Checks to see if a user can edit a url
		Parameters - $commentID, $postID
		Returns true if one can, false if not */
		function can_edit_url($commentID, $postID) {
			if ($this->is_comment_owner($postID)) { return true; }
			$comment = get_comment($commentID, ARRAY_A);
			if ($this->is_logged_in($comment['user_id'])) { //logged in
				if ($this->adminOptions['registered_users_url_edit'] == "true") { return true;}
			} else { //not logged in 
				if ($this->adminOptions['allow_url_editing'] == "true") { return true;}
			}
			return false;
		}
		/* can_edit_options - Checks to see if a non-admin user can edit various options 
		Parameters - $commentID, $postID
		Returns true if one can, false if not */
		function can_edit_options($commentID, $postID) {
			if ($this->is_comment_owner($postID)) { return true; }
			$comment = get_comment($commentID, ARRAY_A);
			if ($this->is_logged_in($comment['user_id'])) { //logged in
				if ($this->adminOptions['registered_users_url_edit'] == "true" || $this->adminOptions['registered_users_email_edit'] == "true" || $this->adminOptions['registered_users_name_edit'] == "true" ) { return true;}
			} else { //not logged in 
				if ($this->adminOptions['allow_url_editing'] == "true" || $this->adminOptions['allow_email_editing'] == "true" || $this->adminOptions['allow_name_editing'] == "true") { return true;}
			}
			return false;
		}
		/* can_indefinitely_edit
		Parameters - $userID
		Returns - true if can, false if not */
		function can_indefinitely_edit($userID = 0) {
			if ($this->is_logged_in($userID)) {
				//User is logged in and this is the user's comment - Does admin allow indefinite editing?
				if ($this->adminOptions['registered_users_edit'] == "true") {
					return true; //Logged in user can indefinitely edit
				}
			}
			return false;
		}
		/* can_scroll 
		Checks to see if an admin can scroll to the comment or not 
		Returns - true if can, false if not*/
		function can_scroll() {
			if ($this->is_comment_owner()) {
				if ($this->adminOptions['javascript_scrolling'] == "true") {
					return "1";
				}
			}
			return "0";
		}
		/* check_spam - Checks an edited comment for spam 
		Parameters - $commentID, $postID
		Returns - True if spam, false if not */
		function check_spam($commentID = 0, $postID = 0) {
			$options = $this->adminOptions;
			//Check to see if spam protection is enabled
			if ($options['spam_protection'] == "none") { return false;} 
			//Return if user is post author or can edit posts
			if ($this->is_comment_owner($postID)) { return false; }
			
			if (function_exists("akismet_check_db_comment") && $options['spam_protection'] == 'akismet') { //Akismet
				//Check to see if there is a valid API key
				if (akismet_verify_key(get_option('wordpress_api_key')) != "failed") { //Akismet
					$response = akismet_check_db_comment($commentID);
					if ($response == "true") { //You have spam
						wp_set_comment_status($commentID, 'spam');
						return true;
					}
				}
			} elseif ($options['spam_protection'] == "defensio" && function_exists('defensio_post') ) { //Defensio
				global $defensio_conf, $wpdb;
				$comment = get_comment($commentID, ARRAY_A);
				if (!$comment) { return true; }
				$comment['owner-url'] = $defensio_conf['blog'];
				$comment['user-ip'] = $comment['comment_author_IP'];
				$comment['article-date'] = strftime("%Y/%m/%d", strtotime($wpdb->get_var("SELECT post_date FROM $wpdb->posts WHERE ID=" . $comment['comment_post_ID'])));
				$comment['comment-author'] = $comment['comment_author'];
				$comment['comment-author-email'] = $comment['comment_author_email'];
				$comment['comment-author-url'] = $comment['comment_author_url'];
				$comment['comment-content'] = defensio_unescape_string($comment['comment_content']);
				if (!isset($comment['comment_type']) or empty($comment['comment_type'])) {
					$comment['comment-type'] = 'comment';
				} else {
					$comment['comment-type'] = $comment['comment_type'];
				}
				if (defensio_reapply_wp_comment_preferences($comment) === "spam") {
					return true;
				}
				$results = defensio_post('audit-comment',$comment);
				$ar = Spyc :: YAMLLoad($results);
				if (isset($ar['defensio-result'])) {
					if ($ar['defensio-result']['spam']) {
						wp_set_comment_status($commentID, 'spam');
						return true;
					}
				}
			}
			return false;			
		} //end function check_spam
		/* - comment_edited - Run after a comment has successfully been edited 
		Parameters - $commentID, $postID*/
		function comment_edited($commentID = 0, $postID = 0) {
			//Clear the comment cache
			if (function_exists('clean_comment_cache')) { clean_comment_cache($commentID); }
			
			//For WP Cache and WP Super Cache
			if (function_exists('wp_cache_post_change')) {
				@wp_cache_post_change($postID);
			}
			//Get out if user is admin or post owner
			if ($this->is_comment_owner($postID)) { return; }
			
			//Increment the number of edited comments
			$this->increment_edit_count();
		} //end function comment_edited
		/* comment_posted - This function is run whenever a comment is posted - 
		Adds a cookie and security key for future editing
		Parameters - $commentID (the comment's ID)
		*/
		function comment_posted($commentID=0) {
			global $wpdb;
			//Get comment
			$comment = get_comment($commentID, ARRAY_A);
			//Some sanity checks
			if (!$comment) { return;}
			
			//if ($comment['comment_approved'] == "1") { return; }	
			if ($comment['comment_approved'] == "spam") { return; }	
			//If admin, exit since we don't want to add anything
			if ($this->is_comment_owner($comment['comment_post_ID'])) {
				return $commentID;
			}
			//Don't save data if user can indefinitely edit
			if ($this->can_indefinitely_edit($comment['user_id'])) { return; }
			//Check to see if admin allows comment editing 
			if ($this->adminOptions['allow_editing'] == "false") { return;}
			
			//Get hash and random security key
			$hash = md5($comment['comment_author_IP'] . $comment['comment_date_gmt']);
			$rand = 'wpAjax' . $hash . md5($this->random()) . md5($this->random());
			
			//Get the minutes allowed to edit
			$minutes = $this->adminOptions['minutes'];
			if (!is_numeric($minutes)) {
				$minutes = $this->minutes;
			}
			if ($minutes < 1) {
				$minutes = $this->minutes;
			}		
			//Insert the random key into the database
			$query = "INSERT INTO " . $wpdb->postmeta .
				"(post_id, meta_key, meta_value) " .
				"VALUES (" . $comment['comment_post_ID'] . ",'_" . $comment['comment_ID'] . "','" . $rand . "')";
			@$wpdb->query($query);
			
			//Set the cookie
			$cookieName = $this->cookieName . $commentID . $hash;
			$value = $rand;
			$expire = time()+60*$minutes;
			if (!isset($_COOKIE[$cookieName])) {
				setcookie($cookieName, $value, $expire, COOKIEPATH,COOKIE_DOMAIN);
				//setcookie($cookieName, $value, $expire, SITECOOKIEPATH,COOKIE_DOMAIN);
				$GLOBALS[$cookieName] = $value; //For compatability with CFORMS
			}
			
			//Read in security key count, delete keys if over 100
			$securityCount = get_option('ajax-edit-comments_security_key_count');
			if (!securityCount) {
				$securityCount = 1;  update_option('ajax-edit-comments_security_key_count', $securityCount);
			} else {
				$securityCount = (int)$securityCount;
			}
			//Delete keys if over a 100
			if ($securityCount >= 100) {
				$metakey = "_" . $comment['comment_ID'];
				@$wpdb->query("delete from $wpdb->postmeta where left(meta_value, 6) = 'wpAjax' and meta_key <> '$metakey'");
				$securityCount = 0;
			}
			$securityCount += 1;
			update_option('ajax-edit-comments_security_key_count', $securityCount);
			return $commentID;
		}//End function comment_posted
		/* delete_comment */
		function delete_comment($commentID = 0, $postID = 0) {
			if ($this->is_comment_owner($postID)) {
				$status = wp_delete_comment($commentID)? "1" : 'delete_failed';
				return $status;
			} else {
				return 'delete_failed_permission';
			}
		}
		/*Delinks a comment */
		function delink_comment($commentID = 0, $postID = 0, $comment = '') {
			if ($this->is_comment_owner($postID)) {
				wp_update_comment($comment);
				return "1";
			} else {
				return 'delink_failed_permission';
			}
		}
		//When a comment is edited, an e-mail notification is sent out
		//Parameters - $commentID (a comment ID) and $postID (a post ID)
		//Returns false if e-mail failed
		function edit_notification($commentID = 0, $postID = 0) {
			global $wpdb;
			$options = $this->adminOptions;
			//Check admin options and also if user editing is post author
			if ($options['email_edits'] == "false") { return false; }
			//Get the comment and post
			$comment = get_comment($commentID, ARRAY_A);
			if (empty($comment)) { return false; }
			$query = "SELECT * FROM $wpdb->posts WHERE ID=$postID";
			$post = $wpdb->get_row("SELECT * FROM $wpdb->posts WHERE ID=$postID", ARRAY_A);
			
			if (!$post) { return false; }
			if ($this->is_comment_owner($postID)) {  return false; }
			//Make sure the comment is approved and not a trackback/pingback
			if ( $comment['comment_approved'] == '1' && ($comment['comment_type'] != 'pingback' || $comment['comment_type'] != 'trackback')) { 
			//Put together the e-mail message
			$message  = sprintf(__("A comment has been edited on post %s") . ": \n%s\n\n", stripslashes($post['post_title']), get_permalink($comment['comment_post_ID']));
			$message .= sprintf(__("Author: %s\n"), $comment['comment_author']);
			$message .= sprintf(__("Author URL: %s\n"), stripslashes($comment['comment_author_url']));
			$message .= sprintf(__("Author E-mail: %s\n"), stripslashes($comment['comment_author_email']));
			$message .= __("Comment:\n") . stripslashes($comment['comment_content']) . "\n\n";
			$message .= __("See all comments on this post here:\n");
			$message .= get_permalink($comment['comment_post_ID']) . "#comments\n\n";
			$subject = sprintf(__('New Edited Comment On: %s'), stripslashes($post['post_title']));
			$subject = '[' . get_bloginfo('name') . '] ' . $subject;
			$email = get_bloginfo('admin_email');
			$site_name = str_replace('"', "'", get_bloginfo('name'));
			$charset = get_settings('blog_charset');
			$headers  = "From: \"{$site_name}\" <{$email}>\n";
			$headers .= "MIME-Version: 1.0\n";
			$headers .= "Content-Type: text/plain; charset=\"{$charset}\"\n";
			//Send the e-mail
			return wp_mail($email, $subject, $message, $headers);
			}
			return false;
		} //End function edit_notification
		/* encode - Encodes comment content to various charsets 
		Parameters - $content - The comment content 
		Returns the encoded content */ 
		function encode($content) {
			if ($this->adminOptions['use_mb_convert'] == "false" || !function_exists("mb_convert_encoding")) { return $content; }
			return mb_convert_encoding($content, ''.get_option('blog_charset').'', mb_detect_encoding($content, "UTF-8, ISO-8859-1, ISO-8859-15", true));
		}
		/* get_comment - Returns a comment ready for editing
		parameters - $commentID
		returns - a response object (WP_Ajax_Response) */
		function get_comment($commentID = 0) {
			$comment = get_comment($commentID);
			$response = new WP_Ajax_Response();
			if (!$comment) { 
				$response->add( array(
					'what' => 'error',
					'id' => $commentID,
					'data' => $this->get_error('get_comment_failed')
				));
				$response->send(); return;
			}
			//Check to see if the comment is spam if the user isn't admin or comment owner
			if (!$this->is_comment_owner($comment->comment_post_ID)) {
				if ($comment->comment_approved === 'spam') { 
					$response->add( array(
					'what' => 'error',
					'id' => $commentID,
					'data' => $this->get_error('comment_spam')
					));
					$response->send(); return;
				}
			}
			
			//Check to see if user can edit and return any appropriate error messages
			$message = $this->can_edit($commentID, $comment->comment_post_ID);
			if (is_string($message)) {
				$response->add( array(
					'what' => 'error',
					'id' => $commentID,
					'data' => $this->get_error($message)
				));
				$response->send(); return;
			}
			//Okay, user can edit - Let's prepare the comment for editing
			$comment->comment_content = format_to_edit( $comment->comment_content ,1);
			$comment->comment_content = apply_filters( 'comment_edit_pre', $comment->comment_content);
			$comment->comment_author = format_to_edit( $comment->comment_author );
			$comment->comment_author_email = format_to_edit( $comment->comment_author_email );
			$comment->comment_author_url = clean_url($comment->comment_author_url);
			$comment->comment_author_url = format_to_edit( $comment->comment_author_url );
			//Prepare the response
			$response->add( array(
					'what' => 'comment_content',
					'id' => $commentID,
					'data' => $comment->comment_content
				));
			$response->add( array(
					'what' => 'comment_author',
					'id' => $commentID,
					'data' => $comment->comment_author
				));
			$response->add( array(
					'what' => 'comment_author_email',
					'id' => $commentID,
					'data' => $comment->comment_author_email
				));
			$response->add( array(
					'what' => 'comment_author_url',
					'id' => $commentID,
					'data' => $comment->comment_author_url
				));
			if ($this->adminOptions['show_gravatar'] == "true") {
				$gravatar = get_avatar($comment, '40');
				if (!empty($gravatar)) {
					$response->add( array(
							'what' => 'gravatar',
							'id' => $commentID,
							'data' => $gravatar
						));
					}
			}
			$response = apply_filters('wp_ajax_comments_get_comment', $response, $comment);
			$response->send();
		}//End function get_comment
		/* get_comment_id - Returns an ID based on an incoming string */
		function get_comment_id($string) {
			preg_match('/([0-9]+)$/i', $string, $matches);
			if (is_numeric($matches[1])) {
				return $matches[1];
			} 
			return 0;
		} 
		/*
		get_can_comment - Get comment values, if necessary
		Parameters - commentID
		Returns - Array of values for comment if successfull
		*/
		function get_edit_comment($commentID) {
			global $comment, $wpdb;

			if ($comment->comment_ID == $commentID) {
				$c = get_object_vars($comment);
				$c['time'] = mysql2date('U', $c['comment_date']);
				return $c;
			}

			$query = "SELECT UNIX_TIMESTAMP(comment_date) time, comment_author_email, comment_author_IP, comment_date_gmt, comment_post_ID, comment_approved, comment_ID, user_id  FROM $wpdb->comments where comment_ID = $commentID";
			return($wpdb->get_row($query, ARRAY_A));
		}
		/* get_error - Returns an error message based on the passed code
		Parameters - $code (the error code as a string)
		Returns an error message */
		function get_error($code = '') {
			$errorMessage = $this->errors->get_error_message($code);
			if ($errorMessage == null) {
				return __("Unknown error.");
			}
			return __($errorMessage, $this->localizationName); 
		}
		/* get_time_left - Returns time remaining in seconds
		parameters - $commentID 
		Returns 1 if no time is necessary.  -1 if time is unavailable.  Time if available.
		*/
		function get_time_left($commentID = 0) {
			global $wpdb;
			$adminMinutes = (int)$this->adminOptions['minutes'];
			$query = "SELECT ($adminMinutes * 60 - (UNIX_TIMESTAMP('" . current_time('mysql') . "') - UNIX_TIMESTAMP(comment_date))) time, comment_author_email, user_id FROM $wpdb->comments where comment_ID = $commentID";
			
			//Get the Timestamp
			$comment = $wpdb->get_row($query, ARRAY_A);
			if (!$comment) { 
				$response->add( array(
					'what' => 'error',
					'id' => $commentID,
					'data' => "-1"
				));
				$response->send();
			}
			if ($this->can_indefinitely_edit($comment['user_id'])) {	
				$response->add( array(
					'what' => 'success',
					'id' => $commentID,
					'data' => "1"
				));			
			}
			//Get the time elapsed since making the comment
			if ((int)$comment['time'] <= 0) { return "-1"; }
			$timeleft = (int)$comment['time'];
			$minutes = floor($timeleft/60);
			$seconds = $timeleft - ($minutes*60);
			$response = new WP_Ajax_Response();
			$response->add( array(
				'what' => 'minutes',
				'id' => $commentID,
				'data' => $minutes
			));
			$response->add( array(
				'what' => 'seconds',
				'id' => $commentID,
				'data' => $seconds
			));
			$response->send();
		}//end function get_time_left
		/* get_posts - Returns five posts with an offset
		parameters - $offset 
		Returns five posts with an offset
		*/
		function get_posts($offset = 0) {
			global $wpdb;
			$response = new WP_Ajax_Response();
			$results = $wpdb->get_results("select ID, post_title from $wpdb->posts where post_type = 'post' and post_status = 'publish' order by ID desc limit $offset,5", ARRAY_A);
			foreach ($results as $r) {
				$response->add(array(
					'what' => 'title',
					'id' => $r['ID'],
					'data' => $r['post_title']
				));
			}
			return $response;
		}
		/* get_posts_by_title - Returns five posts with an offset
		parameters - $title 
		Returns five posts by title
		*/
		function get_posts_by_title($title) {
			global $wpdb;
			$response = new WP_Ajax_Response();
			$results = $wpdb->get_results("select ID, post_title from $wpdb->posts where post_type = 'post' and post_status = 'publish' and post_title like '%$title%' limit 6", ARRAY_A);
			foreach ($results as $r) {
				$response->add(array(
					'what' => 'title',
					'id' => $r['ID'],
					'data' => $r['post_title']
				));
			}
			return $response;
		}
		/* get_posts_by_id - Returns five posts with an offset
		parameters - $id 
		Returns five posts by id
		*/
		function get_posts_by_id($id) {
			global $wpdb;
			$response = new WP_Ajax_Response();
			$results = $wpdb->get_row("select * from $wpdb->posts where post_type = 'post' and post_status = 'publish' and ID = $id", ARRAY_A);
			if ($results) {
				$response->add(array(
					'what' => 'title',
					'id' => $results['ID'],
					'data' => $results['post_title']
				));
			}
			return $response;
		}
		/* increment_edit_count - Increments the number of edits */
		function increment_edit_count() {
			$numEdits = intval($this->adminOptions['number_edits']);
			$numEdits = number_format(intval($this->adminOptions['number_edits']));
			$numEdits += 1;
			
			$this->adminOptions['number_edits'] = $numEdits;
			$this->save_admin_options();
		}
		/* Initializes all the error messages */
		function initialize_errors() {
			$this->errors = new WP_Error();
			$this->errors->add('new_comment_posted', __('You cannot edit a comment after other comments have been posted.'));
			$this->errors->add('comment_time_elapsed', __('The time to edit your comment has elapsed.'));
			$this->errors->add('comment_edit_denied',__('You do not have permission to edit this comment.') );
			$this->errors->add('comment_marked_spam',$this->adminOptions['spam_text']);
			$this->errors->add('comment_spam',__('This comment cannot be edited because it is marked as spam.') );
			$this->errors->add('get_comment_failed',__('Comment loading failed.') );
			$this->errors->add('no_user_editing',__('Comment editing has been disabled.') );
			$this->errors->add('comment_spam_failed', __('Could not mark as spam.'));
			$this->errors->add('comment_spam_failed_permission', __('You do not have permission to mark this comment as Spam.'));
			$this->errors->add('delete_failed',__('Could not delete comment.') );
			$this->errors->add('delete_failed_permission',__('You do not have permission to delete this comment.') );
			$this->errors->add('approve_failed_permission', __('You do not have permission to approve this comment.'));
			$this->errors->add('approve_failed', __('Could not approve comment.'));
			$this->errors->add('moderate_failed', __('Could not mark this comment for moderation.'));
			$this->errors->add('moderate_failed_permission', __('You do not have permission to mark this comment for moderation.'));
			$this->errors->add('invalid_email', __('Please enter a valid email address.'));
			$this->errors->add('required_fields', __('Please fill in the required fields (Name, E-mail)'));
			$this->errors->add('content_empty',__('You cannot have an empty comment.') );
			$this->errors->add('delink_failed_permission',__('You do not have permission to delink this comment.') );
			$this->errors->add('comment_marked_moderated',__('Your comment was marked for moderation') );
			$this->errors->add('comment_moderated',__('This comment cannot be edited because it is marked for moderation.') );
			$this->errors->add('request_deletion_failed',__('Request failed.') );
			$this->errors->add('blacklist_empty',__('You have not selected anything to blacklist.') );
		} //end function initialize_errors
		/* init - Run upon WordPress initialization */
		function init() {
			//* Begin Localization Code */
			$wp_ajax_edit_comments_locale = get_locale();
			$wp_ajax_edit_comments_mofile = get_bloginfo('template_directory') . "/library/comments/languages/" . $this->localizationName . "-". $wp_ajax_edit_comments_locale.".mo";
			load_textdomain($this->localizationName, $wp_ajax_edit_comments_mofile);
			
		//* End Localization Code */
		}//end function init
		/* is_comment_owner - Checks to see if a user can edit a comment */
		/* Parameters - postID */
		/* Returns - true if user is comment owner, false if not*/
		function is_comment_owner($postID = 0) {
			if (!isset($this->admin)) { $this->admin = false; }
			if ($this->admin) { return true; }
			if (!function_exists("current_user_can")) {
				require_once(ABSPATH . '/wp-includes/pluggable.php');
			}
			//Check to see if user is admin of the blog
			if (current_user_can('edit_users')) {
				$this->admin = true;
				return true;
			} elseif( current_user_can( 'edit_page', $postID) || current_user_can( 'edit_post', $postID)) {
				$this->admin = false;
				return true;
			}
			return false;
		}
		/* is_logged_in - Checks to see if the user (non-admin) is logged in 
		Parameters - $userID
		Returns true if logged in, false if not */
		function is_logged_in($userID = 0) {
			if ($this->get_user_id() == $userID) {
				return true;
			} else { 
				return false;
			}
		}	
		/* moderate_comment - Marks a comment as unapproved 
		Parameters - $commentID, $postID
		Returns - 1 if successful, a string error message if not */
		function moderate_comment($commentID=0, $postID = 0) {
			if ($this->is_comment_owner($postID)) {
				$status = wp_set_comment_status($commentID, 'hold')? "1" : 'moderate_failed';
				return $status;
			} else {
				return 'moderate_failed_permission';
			}
		}
		/* move_comment - Moves a comment from an old post to a new post
		Parameters - $commentID, $oldPostID, $newPostID
		Returns nothing */
		function move_comment($commentID=0, $oldPostID=0, $newPostID=0) {
			global $wpdb, $post;
			$response = new WP_Ajax_Response();
			
			//Return if not comment owner and if posts are the same
			if ($oldPostID == $newPostID || !$this->is_comment_owner($newPostID)) { 
				$response->add(array(
				'what' => 'nochange',
				'data' => "nochange"
				));
				$response->send();
				return;
			}
			
			//Update the comment with the new post number
			$wpdb->update($wpdb->comments, array('comment_post_ID' => intval($newPostID)), array('comment_ID' => intval($commentID)));
			
			//Update the posts' comment count
			@wp_update_comment_count_now(intval($newPostID));
			@wp_update_comment_count_now(intval($oldPostID));
			
			$posts = get_posts("include=$oldPostID,$newPostID");
			foreach ($posts as $post) {
				if ($post->ID == $oldPostID) {
					$response->add(array(
						'what' => 'old_id',
						'id' => $newPostID,
						'old_id' => $oldPostID,
						'supplemental' => array(
							'title' => the_title('','',false),
							'permalink' => apply_filters('the_permalink', get_permalink()),
							'comments' => $post->comment_count
						)
					));
				} else {
					$response->add(array(
						'what' => 'new_id',
						'id' => $oldPostID,
						'old_id' => $newPostID,
						'supplemental' => array(
							'title' => the_title('','',false),
							'permalink' => apply_filters('the_permalink', get_permalink()),
							'comments' => $post->comment_count
						)
					));
				}
			}
			
			return $response;
		}
		/* request_Deletion - Sends a request to admin for comment removal
		Parameters - $commentID, $postID
		Returns error or response */
		function request_deletion($commentID = 0, $postID = 0, $message) {
			$canedit = $this->can_edit($commentID, $postID);
			if (is_string($canedit)) {
				return 'request_deletion_failed';
			}
			if (wp_set_comment_status($commentID, 'hold') || wp_get_comment_status($commentID) == "unapproved") {
				$this->request_deletion_message($commentID, $message);
				
				//Get the comment and remove the cookie
				$comment = get_comment($commentID);
				$hash = md5($comment->comment_author_IP . $comment->comment_date_gmt);
				$GLOBALS[$this->cookieName . $commentID . $hash] = ''; //for CFORMS compatibility
				setcookie($this->cookieName . $commentID . $hash, '', time() - 3600, COOKIEPATH,COOKIE_DOMAIN); //removes the cookie
				return 1;
			} else {
				return 'request_deletion_failed';
			}
		}
		function request_deletion_message($commentID = 0, $message) {
			$comment = get_comment($commentID);
			$post    = get_post($comment->comment_post_ID);
			$user    = get_userdata( $post->post_author );
			$notify_message  = sprintf( __('A commenter requests deletion of a comment on your post #%1$s "%2$s".  The comment has been moved to the moderation queue.'), $comment->comment_post_ID, $post->post_title ) . "\r\n";
			$notify_message  .= sprintf( __('The reason given is: ' . $message, $this->localizationName), $comment->comment_post_ID, $post->post_title ) . "\r\n\r\n";
			$notify_message .= sprintf( __('E-mail : %s'), $comment->comment_author_email ) . "\r\n";
			$notify_message .= sprintf( __('URL    : %s'), $comment->comment_author_url ) . "\r\n";
			$notify_message .= sprintf( __('Whois  : http://ws.arin.net/cgi-bin/whois.pl?queryinput=%s'), $comment->comment_author_IP ) . "\r\n";
			$notify_message .= get_permalink($comment->comment_post_ID) . "#comments\r\n\r\n";
			$notify_message .= sprintf( __('Delete it: %s'), admin_url("comment.php?action=cdc&c=$commentID") ) . "\r\n";
			$notify_message .= sprintf( __('Approve it: %s'),  admin_url("comment.php?action=mac&c=$commentID") ) . "\r\n";
			$notify_message .= sprintf( __('Spam it: %s'), admin_url("comment.php?action=cdc&dt=spam&c=$commentID") ) . "\r\n";
			$wp_email = 'wordpress@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));
			if ( '' == $comment->comment_author ) {
				$from = "From: \"$blogname\" <$wp_email>";
				if ( '' != $comment->comment_author_email )
					$reply_to = "Reply-To: $comment->comment_author_email";
			} else {
				$from = "From: \"$comment->comment_author\" <$wp_email>";
				if ( '' != $comment->comment_author_email )
					$reply_to = "Reply-To: \"$comment->comment_author_email\" <$comment->comment_author_email>";
			}
			
			$message_headers = "$from\n"
				. "Content-Type: text/plain; charset=\"" . get_option('blog_charset') . "\"\n";
			
			if ( isset($reply_to) )
				$message_headers .= $reply_to . "\n";
			
			$subject = sprintf( __('Request for Comment Deletion: "%2$s"'), $blogname, $post->post_title );
			@wp_mail($user->user_email, $subject, $notify_message, $message_headers);
		}
		/* save_comment - Saves a new comment
		Parameters - $commentID, $postID, $commentarr (comment array)
		Returns errors or response*/
		function save_comment($commentID, $postID, $commentarr) {
			global $wpdb;
			$response = new WP_Ajax_Response();
			//Save the old comment and build an undo spot
			$undoComment = get_comment($commentID, ARRAY_A);
			//Make sure the comment has something in it
			if ('' == $commentarr['comment_content'] || $commentarr['comment_content'] == "undefined") {
				$response->add( array(
					'what' => 'error',
					'id' => $commentID,
					'data' => $this->get_error('content_empty')
				));
				$response->send(); return;
			}
			//Check to see if user can edit
			$message = $this->can_edit($commentID, $postID);
			if (is_string($message)) {
				$response->add( array(
					'what' => 'error',
					'id' => $commentID,
					'data' => $this->get_error($message)
				));
				$response->send(); return;
			}
			
			
			//Sanity checks
			if (!$this->is_comment_owner($postID)) {
				//Make sure required fields are filled out
				if ( get_option('require_name_email') && ((6 > strlen($commentarr['comment_author_email']) && $this->can_edit_email($commentID, $postID)) || ('' == $commentarr['comment_author'] && $this->can_edit_name($commentID, $postID)))) {
					$response->add( array(
						'what' => 'error',
						'id' => $commentID,
						'data' => $this->get_error('required_fields')
					));
					$response->send(); return;
				}
			}// end comment_owner check
			//Make sure the e-mail is valid - Skip if pingback or trackback
			if (!($this->admin  && empty($commentarr['comment_author_email']))) {
				if (!is_email($commentarr['comment_author_email']) && $commentarr['comment_type'] != "pingback" && $commentarr['comment_type'] != "trackback") {
					if ($this->can_edit_email($commentID, $postID)) {
						$response->add( array(
							'what' => 'error',
							'id' => $commentID,
							'data' => $this->get_error('invalid_email')
						));
						$response->send(); return;
					}
				}
			}
			if (strtolower(get_option('blog_charset')) != 'utf-8') { @$wpdb->query("SET names 'utf8'");} //comment out if getting char errors
			
			//Save the comment
			$commentarr['comment_ID'] = (int)$commentID;
			$commentapproved = $commentarr['comment_approved'];
			//Do some comment checks before updating
			if (!$this->is_comment_owner($postID)) {
				//Preserve moderation/spam setting.  Only check approved comments
				if ($commentarr['comment_approved'] == 1) {
					// Everyone else's comments will be checked.
					if ( check_comment($commentarr['comment_author'], $commentarr['comment_author_email'], $commentarr['comment_author_url'], $commentarr['comment_content'], $commentarr['comment_author_IP'], $commentarr['comment_agent'], $commentarr['comment_type'])) 
						$commentarr['comment_approved'] = 1;
					else
						$commentarr['comment_approved'] = 0;
				}
					
				if ( wp_blacklist_check($commentarr['comment_author'], $commentarr['comment_author_email'], $commentarr['comment_author_url'], $commentarr['comment_content'], $commentarr['comment_author_IP'], $commentarr['comment_agent']) )
					$commentarr['comment_approved'] = 'spam';
			}
			
			
			//Update the comment
			wp_update_comment($commentarr);
			
			//If spammed, return error
			if (!$this->admin && $commentarr['comment_approved'] === 'spam') {
				$response->add( array(
						'what' => 'error',
						'id' => $commentID,
						'data' => $this->get_error('comment_marked_spam')
					));
				$response->send(); return;
			}
			
			//If moderated, return error
			if ($commentarr['comment_approved'] == 0 && $commentapproved != 0) {
				$response->add( array(
						'what' => 'error',
						'id' => $commentID,
						'data' => $this->get_error('comment_marked_moderated')
					));
				$response->send(); return;
			}
			
			//For security, get the new comment
			global $comment;
			$comment = get_comment($commentID);
			//Check for spam
			if (!$this->is_comment_owner($postID)) {
				if($this->check_spam($commentID, $postID)) {
					$response->add( array(
						'what' => 'error',
						'id' => $commentID,
						'data' => $this->get_error('comment_marked_spam')
					));
					$response->send(); return;
				};
			}
			//Do actions after a comment has successfully been edited
			do_action_ref_array('wp_ajax_comments_comment_edited', array(&$commentID, &$postID));
			//Condition the data for returning
			do_action('wp_ajax_comments_remove_content_filter');
			//Get undo data
			if ($this->admin) {
				$oldComment = $this->adminOptions['undo'];
				$undo = $this->build_undo_url("undoedit", $commentID, $postID, __('Comment successfully saved')); 				
			} else {
				$undo = '';
			}
			$approve_count = get_comment_count($postID);
			$comment_count = get_comment_count();
			$response->add(array(
					'what' => 'content',
					'id' => $commentID,
					'supplemental' => array(
						'content' => stripslashes(apply_filters('comment_text',apply_filters('get_comment_text',$this->encode($comment->comment_content)))),
						'comment_author' => stripslashes(apply_filters('comment_author', apply_filters('get_comment_author', $this->encode($comment->comment_author)))),
						'comment_author_url' => stripslashes(apply_filters('comment_url', apply_filters('get_comment_author_url', $comment->comment_author_url))),
						'comment_date' =>  get_comment_date('F jS, Y'),
						'comment_time' => get_comment_time(),
						'comment_approved' => $comment->comment_approved,
						'old_comment_approved' => $oldComment['comment_approved'],
						'undo_comment_approved' => $undoComment['comment_approved'],
						'approve_count' => $approve_count['approved'],
						'moderation_count' => $comment_count['awaiting_moderation'],
						'spam_count' => $comment_count['spam'],
						'comment_links' => $this->build_admin_links($commentID, $postID),
						'undo' => $undo
					)
			));
			return $response;
		} //save_comment
		/* show_affiliate_link - Returns true if affiliate links should be displayed.  False if not*/
		function show_affiliate_link() {
			$options = $this->get_admin_options();
			if (empty($options['affiliate_id']) || $options['affiliate_show'] == "false") 
				return false;
			return true;
		}
		/* spam_comment - Marks a comment as spam or de-spams a comment
		Parameters - $commentID, $postID
		Returns - 1 if successful, a string error message if not */
		function spam_comment($commentID = 0, $postID = 0) {
			if ($this->is_comment_owner($postID)) {
				$status = wp_set_comment_status($commentID, 'spam')? "1" : 'comment_spam_failed';
				return $status;
			} else {
				return 'comment_spam_failed_permission';
			}
		}
		
		/*BEGIN UTILITY FUNCTIONS - Grouped by function and not by name */
		function add_admin_pages(){
				//add_options_page('Ajax Edit Comments', 'Ajax Edit Comments', 9, basename(__FILE__), array(&$this, 'print_admin_page'));
				add_submenu_page('product_menu.php', __('Ajax Edit Comments'), __('Ajax Edit Comments'), 8, basename(__FILE__), array(&$this, 'print_admin_page'));
		}
		//Removes the div and various links from a comment 
		function comment_filter() {
			$this->skip = true;
		}
		//Provides the interface for the admin pages
		function print_admin_page() {
			include dirname(__FILE__) . '/php/admin-panel.php';
		}
		//Returns an array of admin options
		function get_admin_options() {
			//todo - possibly an array_merge here
			if (empty($this->adminOptions)) {
				$adminOptions = array(
					'disable' => 'false',
					'allow_editing' => 'true',
					'allow_editing_after_comment' => 'true',
					'minutes' => '5', 
					'edit_text' => '', 
					'show_timer' => 'true',
					'show_pages' => 'true',
					'spam_text' => __('Your edited comment was marked as spam.  If this is in error, please contact the admin.'),
					'email_edits' => 'false',
					'number_edits' => '0',
					'spam_protection' => 'akismet',
					'registered_users_edit' => 'false',
					'registered_users_name_edit' => 'true',
					'registered_users_email_edit' => 'false',
					'registered_users_url_edit' => 'true',
					'use_mb_convert' => 'true',
					'allow_name_editing' => 'true',
					'allow_email_editing' => 'false',
					'allow_url_editing' => 'true',
					'allow_css' => 'true',
					'allow_css_editor' => 'true',
					'show_options' => 'true',
					'clear_after' => 'true',
					'javascript_scrolling' => 'true',
					'post_style_url' => '',
					'editor_style_url' => '',
					'comment_display_top' => 'false',
					'allow_deletion' => 'true',
					'show_advanced' => 'true',
					'undo' => '',
					'icon_display' => 'dropdown',
					'icon_set' => 'circular',
					'use_rtl' => 'false',
					'last_update' => time(),
					'affiliate_id' => 0,
					'auth_key' => '',
					'affiliate_text' => __('Get your own comment editor for your WordPress blog.  Try [url]Ajax Edit Comments[/url] today!'),
					'affiliate_show' => 'false'
				);
				$options = get_option($this->adminOptionsName);
				if (!empty($options)) {
					foreach ($options as $key => $option)
						if (array_key_exists($key, $adminOptions)) {
							$adminOptions[$key] = $option;
						}
				}
				$this->adminOptions = $adminOptions;
				$this->save_admin_options();								
			}
			return $this->adminOptions;
		}
		//Returns an array of "all" user options
		function get_all_user_options() {
			if (!function_exists("get_currentuserinfo")) { return; }
			if (empty($this->userOptions)) {
				$user_email = $this->get_user_email(); 
				$defaults = array(
				'comment_editing' => 'true', 
				'admin_editing' => 'false'
				);
				$this->userOptions = get_option($this->userOptionsName);
				if (!isset($this->userOptions)) {
					$this->userOptions = array();
				}
				//See if an older version doesn't match the new defaults
				if (empty($this->userOptions[$user_email])) {
					$this->userOptions[$user_email] = $defaults;
				}	elseif(!is_array($this->userOptions[$user_email])) {
					$this->userOptions[$user_email] = $defaults;
				} else {
						foreach ($this->userOptions[$user_email] as $key => $option) {
							$defaults[$key] = $option;								
						}
						$this->userOptions[$user_email] = $defaults;
				}
				$this->save_admin_options();
			}
			return $this->userOptions;
		}
		//Returns a logged-in user's e-mail address
		function get_user_email() {
			global $user_email;
			if (!function_exists("get_currentuserinfo")) { return ''; }
			if (empty($user_email)) {get_currentuserinfo();} //try to get user info
			if (empty($user_email)) { return '0'; } //Can't get user info, so return empty string
			return $user_email;
		}
		// Returns a logged-in user's ID
		function get_user_id() {
			global $user_ID;
			if (!function_exists("get_currentuserinfo")) { return "-1"; }
			if (empty($user_ID)) {get_currentuserinfo();} //try to get user info
			if (empty($user_ID)) { return '-1'; } //Can't get user info, so return empty string
			return $user_ID;
		}
		
		//Returns an array of an individual's options
		function get_user_options() {
			if (empty($this->userOptions)) { $this->userOptions = $this->get_all_user_options(); }
			return $this->userOptions[$this->get_user_email()];
		}
		//Saves Ajax Edit Comments settings for admin and admin users
		function save_admin_options(){
			if (!empty($this->adminOptions)) {
				update_option($this->adminOptionsName, $this->adminOptions);
			}
			if (!empty($this->userOptions)) {
				update_option($this->userOptionsName, $this->userOptions);
			}
		}
		//Checks for script addition on single or page posts
		function add_post_scripts() {
			if (is_single()) {
				$this->add_scripts();
			} elseif (is_page() && $this->adminOptions['show_pages'] == 'true') {
				$this->add_scripts();
			} elseif (is_admin()) {
				$this->add_admin_scripts();
			} 
		}
		/* Private - Adds JavaScript in the admin panel if admin has enabled the option */
		function add_admin_scripts() {
			//Page detection for other plugin authors
			switch (basename($_SERVER['SCRIPT_FILENAME'])) {
				case "edit-comments.php";
					break;
				case "edit.php";
					if (isset($_GET['p'])) { break; }
				default:
					if (preg_match( '/wp-admin\/index\.php$/',$_SERVER['PHP_SELF'] )) {
						break;
					}
				return;
			}
			$options = $this->get_user_options();
			if ($options['admin_editing'] == 'true') { return; }
			$this->add_scripts();
		}
		//Adds the appropriate scripts to WordPress
		function add_scripts(){
			if (get_bloginfo('version') < "2.8") {
				wp_deregister_script(array('jquery'));
				wp_enqueue_script('jquery', get_bloginfo('template_directory') . '/library/comments/js/jquery-1.3.2.min.js');
			} else {
				//wp_enqueue_script('jquery'); 
			}
			wp_deregister_script(array('wp-ajax-response'));
			wp_enqueue_script("wp-ajax-response", get_bloginfo('wpurl') . '/wp-includes/js/wp-ajax-response.js');
			wp_enqueue_script('colorbox', get_bloginfo('template_directory') . '/library/comments/js/jquery.colorbox-min.js');
			wp_enqueue_script('wp_ajax_edit_comments_script', get_bloginfo('template_directory') . '/library/comments/js/wp-ajax-edit-comments.js', array( "wp-ajax-response", "colorbox") , 2.3);
			wp_localize_script( 'wp_ajax_edit_comments_script', 'wpajaxeditcomments', $this->get_js_vars());
		}
		//Echoes out various JavaScript vars needed for the scripts
		function get_js_vars() {
			return array(
				'AEC_PluginUrl' => get_bloginfo('template_directory').'/library/comments/',
				'AEC_CanScroll' => '1',
				'AEC_Minutes' => __('minutes'),
				'AEC_Minute' => __('minute'),
				'AEC_And' => __('and'),
				'AEC_Seconds' => __('seconds'),
				'AEC_Second' => __('second'),
				'AEC_Moderation' => __('Mark for Moderation?'), 
				'AEC_Approve' => __('Approve Comment?'),
				'AEC_Spam' => __('Mark as Spam?'), 
				'AEC_Delete' => __('Delete this comment?'), 
				'AEC_Anon' => __('Anonymous'), 
				'AEC_Loading' => __('Loading...'),
				'AEC_Ready' => __('Ready'),
				'AEC_Sending' => __('Sending...'),
				'AEC_Sent' => __('Message Sent'),
				'AEC_LoadSuccessful' => __('Comment Loaded Successfully'), 
				'AEC_Saving' => __('Saving...'), 
				'AEC_Blacklisting' => __('Blacklisting...'), 
				'AEC_Saved' => __('Comment Successfully Saved'), 
				'AEC_Delink' => __('De-link Successful'),
				'AEC_MoreOptions' => __('More Options'),
				'AEC_LessOptions' => __('Less Options'),
				'AEC_UseRTL' => $this->adminOptions['use_rtl'],
				'AEC_RequestDeletionSuccess' => __('Request has been sent successfully'),
				'AEC_RequestError' => __('Error sending request'),
				'AEC_approving' => __('Approving...'),
				'AEC_delinking' => __('De-linking...'),
				'AEC_moderating' => __('Moderating...'),
				'AEC_spamming' => __('Spamming...'),
				'AEC_deleting' => __('Deleting...'),
				'AEC_restoring' => __('Restoring...'),
				'AEC_undoing' => __('Undoing...'),
				'AEC_undosuccess' => __('Undo Successful'),
				'AEC_permdelete' => __('Comment Deleted Permanently')
				
			);
		} //end get_js_vars
		/**
		* Adds a link to the stylesheet to the header
		*/
		function add_css(){
				if (is_single() || is_page() || is_admin()) {
					if (is_page() && $this->adminOptions['show_pages'] != 'true') {
						return;
					}
				
					if (empty($this->adminOptions['post_style_url'])) {
						if ($this->adminOptions['use_rtl'] == "true") {
								echo '<link rel="stylesheet" href="'.get_bloginfo('template_directory').'/library/comments/css/themes/'.$this->adminOptions['icon_set'].'/edit-comments-rtl.css" type="text/css" media="screen"  />'; 
						} else {
								echo '<link rel="stylesheet" href="'.get_bloginfo('template_directory').'/library/comments/css/themes/'.$this->adminOptions['icon_set'].'/edit-comments.css" type="text/css" media="screen"  />'; 
						}
						/* From http://blue-anvil.com/archives/experiments-with-floats-whats-the-best-method-of-clearance */
							if ($this->adminOptions['clear_after'] == "true") { 
	?>
                <!-- Ajax Edit Comments -->
                <!--[if IE]>
                <style>
                  .clearfix {display: inline-block;}
                  /* Hides from IE-mac \*/
                  * html .clearfix {height: 1%;}
                  .clearfix {display: block;}
                  /* End hide from IE-mac */
                </style>
                <![endif]-->
<?php
							} /* clear after */
					} /* post_style_url */ else {
						echo '<link rel="stylesheet" href="'.get_bloginfo('template_directory').$this->adminOptions['post_style_url'].'" type="text/css" media="screen"  />';
					}
			echo '<link rel="stylesheet" href="'.get_bloginfo('template_directory').'/library/comments/css/colorbox/colorbox.css" type="text/css" media="screen"  />'; 
			}
		}
		//Returns a random security key
		function random() {
		 $chars = "%CDEF#cGHIJ\:ab!@defg9ABhijklmn<>;opqrstuvwxyz10234/+_-=5678MKL^&*NOP";
		 $pass = '';
		 for ($i = 0; $i < 50; $i++) {
			$pass .= $chars{rand(0, strlen($chars)-1)};
		 }
		 return $pass;
		}
		/*END UTILITY FUNCTIONS*/
    }
}
//instantiate the class
if (class_exists('WPrapAjaxEditComments')) {
	if (get_bloginfo('version') >= "2.5") {
		$WPrapAjaxEditComments = new WPrapAjaxEditComments();
	}
}




?>