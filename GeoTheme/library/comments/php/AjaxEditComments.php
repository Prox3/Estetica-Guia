<?php 
header('Content-Type: text/html; charset=UTF-8');
define('DOING_AJAX', true);
$root = dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))));
if (file_exists($root.'/wp-load.php')) {
		// WP 2.6
		require_once($root.'/wp-load.php');
} else {
		// Before 2.6
		require_once($root.'/wp-config.php');
}
if (isset($_POST['action']) && isset($WPrapAjaxEditComments)) {
	$commentID = isset($_POST['cid'])? (int) $_POST['cid'] : 0;
	$postID = isset($_POST['pid'])? (int) $_POST['pid'] : 0;
	$action = $_POST['action'];
	
	if (isset($_POST['comment_status'])) {
		$oldComment = get_comment($commentID,ARRAY_A); //Used in the undo portion
		$WPrapAjaxEditComments->adminOptions['undo'] = $oldComment;
		$WPrapAjaxEditComments->save_admin_options();
		
		switch($_POST['comment_status']) {
			case "1":
				if ($_POST['comment_status'] != $oldComment['comment_approved']) {
					$WPrapAjaxEditComments->approve_comment($commentID, $postID);
				}
				break;
			case "0":
				$WPrapAjaxEditComments->moderate_comment($commentID, $postID);
				break;
			case "spam":
				$WPrapAjaxEditComments->spam_comment($commentID, $postID);
				break;
		}
	}
	if ($action == "gettimeleft") {
		$WPrapAjaxEditComments->get_time_left($commentID);
		die('');
	} elseif ($action == "editcomment") {
		$WPrapAjaxEditComments->get_comment($commentID, $postID);
			check_admin_referer('wp-ajax-edit-comments_edit-comment');
		die('');
	} elseif ($action == "movecomment") {
			check_admin_referer('wp-ajax-edit-comments_move-comment');
			$message = '';
			$response = new WP_Ajax_Response();
			if (isset($_POST['post_offset'])) {
				$response = $WPrapAjaxEditComments->get_posts((int)$_POST['post_offset']);
			}
			if (isset($_POST['post_title'])) {
				$response = $WPrapAjaxEditComments->get_posts_by_title($_POST['post_title']);
			}
			if (isset($_POST['post_id'])) {
				$response = $WPrapAjaxEditComments->get_posts_by_id((int)$_POST['post_id']);
			}
			if (isset($_POST['newid'])) {
				$response = $WPrapAjaxEditComments->move_comment($commentID, $_POST['pid'],$_POST['newid']);
			}
			if (isset($_POST['approve'])) {
				if ($_POST['approve'] == "1") {
					@$WPrapAjaxEditComments->approve_comment($commentID, $postID);
					$approve_count = get_comment_count($postID);$comment_count = get_comment_count();
					$response->add(array(
						'what' => 'approved',
						'id' => $commentID,
						'supplemental' => array(
							'approve_count' => $approve_count['approved'],
							'moderation_count' => $comment_count['awaiting_moderation'],
							'spam_count' => $comment_count['spam']
						)
					));
					$message = __("Comment Approved. ", $WPrapAjaxEditComments->localizationName);
				}
			}
			$response->add(array(
						'what' => 'message',
						'id' => $commentID,
						'supplemental' => array(
							'message' => "<em>$message". __("Move Successful. ", $WPrapAjaxEditComments->localizationName) . "</em>"
						)
					));
		$response->send();
		die('');
	} elseif ($action == "savecomment") {
			check_admin_referer('wp-ajax-edit-comments_save-comment');
			$comment = get_comment($commentID, ARRAY_A);
			$comment['comment_content'] = trim(urldecode($_POST['comment_content']));
			if ($WPrapAjaxEditComments->can_edit_name($commentID, $postID)) {
				$comment['comment_author'] = trim(strip_tags(urldecode($_POST['comment_author'])));
			}
			if ($WPrapAjaxEditComments->can_edit_email($commentID, $postID)) {
				$comment['comment_author_email'] = trim(strip_tags(urldecode($_POST['comment_author_email'])));
			}
			if ($WPrapAjaxEditComments->can_edit_url($commentID, $postID)) {
				$comment['comment_author_url'] = trim(strip_tags(urldecode($_POST['comment_author_url'])));
			//Quick JS Test
			if ($comment['comment_author_email'] == "undefined") {$comment['comment_author_email']='';}
			if ($comment['comment_author_url'] == "undefined") {$comment['comment_author_url']='http://';}
			if ($comment['comment_author'] == "undefined") {$comment['comment_author']='';}
		}
		//For the date function
		if (isset($_POST['aa'])) {
			$aa = (int)urldecode($_POST['aa']);
			$mm = (int)urldecode($_POST['mm']);
			$jj = (int)urldecode($_POST['jj']);
			$hh = (int)urldecode($_POST['hh']);
			$mn = (int)urldecode($_POST['mn']);
			$ss = (int)urldecode($_POST['ss']);
			$jj = ($jj > 31 ) ? 31 : $jj;
			$hh = ($hh > 23 ) ? $hh -24 : $hh;
			$mn = ($mn > 59 ) ? $mn -60 : $mn;
			$ss = ($ss > 59 ) ? $ss -60 : $ss;
			$comment['comment_date'] = "$aa-$mm-$jj $hh:$mn:$ss";
		}
		
		$response = new WP_Ajax_Response();
		$response = @$WPrapAjaxEditComments->save_comment($commentID, $postID, $comment);
		$response = apply_filters('wp_ajax_comments_save_comment', $response, $comment, $_POST);
		$response->send();
		die('');
	} elseif ($action == "requestdeletion") {
			check_ajax_referer('wp-ajax-edit-comments_request-deletion');
	} elseif ($action == "blacklist") {
		check_ajax_referer('wp-ajax-edit-comments_blacklist-comment');
	} else {
		check_ajax_referer($action . "_" . $commentID);
			
	}
	//Get the delete options
	
	
	switch ($action) {
		case "blacklist":
			global $wpdb;
			$comment = get_comment($commentID, ARRAY_A);
			$spamCount = 0; $blacklisted = false;
			
			
			//Get the parameters
			$params = explode(',',$_POST['parameters']);
			$where = '';
			$blacklistparams = array();
			foreach ($params as $p) {
				switch($p) {
					case "name":
						$blacklistparams[$p] = $comment['comment_author'];
					break;
					case "email":
						$blacklistparams[$p] = $comment['comment_author_email'];
					break;
					case "ip":
						$blacklistparams[$p] = $comment['comment_author_IP'];
					break;
					case "url":
						$blacklistparams[$p] = $comment['comment_author_url'];
					break;
					case "spamname":
						$where .= "comment_author = '" . $comment['comment_author'] . "' and ";
					break;
					case "spamemail":
						$where .= "comment_author_email = '" . $comment['comment_author_email'] . "' and ";
					break;
					case "spamip":
						$where .= "comment_author_ip = '" . $comment['comment_author_IP'] . "' and ";
					break;
					case "spamurl":
						$where .= "comment_author_ip = '" . $comment['comment_author_url'] . "' and ";
					break;
				}
			} //end foreach
			
			//Do some error checking to make sure something was indeed selected
			if (empty($where) && sizeof($blacklistparams) == 0) {
				$response = new WP_Ajax_Response();
				$response->add(array(
						'what' => 'blacklist',
						'id' => $commentID,
						'supplemental' => array(
							'errors' => $WPrapAjaxEditComments->get_error('blacklist_empty')
						)
				));
				$response->send();
				die('');
			}
			if ($comment['comment_approved'] != "spam") {
				//Spam the comment
				$spamCount += 1;
				@$WPrapAjaxEditComments->spam_comment($commentID, $postID);
			}
			$blacklist = '';
			if (sizeof($blacklistparams) > 0) {
				//Retrieve the blacklist
				if (get_bloginfo('version') < "2.8") {
					$blacklist = attribute_escape(get_option('blacklist_keys'));
				} else {
					$blacklist = esc_attr(get_option('blacklist_keys'));
				}
				
				foreach ($blacklistparams as $b) {
					//Check to see if it's already in the blacklist so we can avoid duplicates
					if (!strpos($blacklist,$b)) {
						$blacklist .= "\n$b";
					}
				}
				$WPrapAjaxEditComments->save_admin_options();
				//Save the blacklist
				update_option('blacklist_keys', stripslashes_deep($blacklist));
			}
			
			$query = '';
			//Get comments to spam
			if (!empty($where)) {
				$where = preg_replace('/and $/','',$where); //strip out excessive ands
				$query .= "select * from $wpdb->comments where $where and comment_approved != 'spam'";
				$results = $wpdb->get_results($wpdb->prepare($query),ARRAY_A);
				if ($results) {
					foreach ($results as $r) {
						$spamCount += 1;
						@$WPrapAjaxEditComments->spam_comment(intval($r['comment_ID']), intval($r['comment_post_ID']));
					}
				}
			}
			//Build the results
			$comment_count = get_comment_count();
			$response = new WP_Ajax_Response();
				$response->add(array(
						'what' => 'blacklist',
						'id' => $commentID,
						'supplemental' => array(
							'errors' => '',
							'spam_count' => $spamCount,
							'query' => $query,
							'blacklist' => $blacklist,
							'message' => __("Successfully blacklisted.", $WPrapAjaxEditComments->localizationName) . " " . $spamCount . " " . __("comment(s) were marked as spam according to your advanced criteria.", $WPrapAjaxEditComments->localizationName),
							'comment_links' => $WPrapAjaxEditComments->build_admin_links($commentID, $postID),
							'moderation_count' => $comment_count['awaiting_moderation'],
							'spam_count' => $comment_count['spam']
						)
				));
				$response->send();
				die('');
		break;
		case "deletecomment":
			//Save the old comment for undo
			
			
			$comment = get_comment($commentID, ARRAY_A);
			$WPrapAjaxEditComments->adminOptions['undo'] = $comment;
			$WPrapAjaxEditComments->save_admin_options();
			
			$message = $WPrapAjaxEditComments->delete_comment($commentID, $postID); 
			//Get error messages
			$error = '';
			if ($message != "1") {
			 $error = $WPrapAjaxEditComments->get_error($message);
			} else { $error = "0"; }
			//Build the undo URL
			$undo = $WPrapAjaxEditComments->build_undo_url("undodelete", $commentID, $postID, __("Successfully Deleted",$WPrapAjaxEditComments->localizationName));
			//Send the response
			$approve_count = get_comment_count($postID);
			$comment_count = get_comment_count();
			global $wpdb;
			$trash_count = 0;
			$row = $wpdb->get_results("select comment_approved from $wpdb->comments where comment_approved = 'trash'", ARRAY_A);
			if ($row != NULL) {
				$trash_count = count($row);
			}
			
			$response = new WP_Ajax_Response();
			$response->add(array(
						'what' => 'delete',
						'id' => $commentID,
						'supplemental' => array(
							'errors' => $error,
							'undo' => $undo,
							'approve_count' => $approve_count['approved'],
							'moderation_count' => $comment_count['awaiting_moderation'],
							'spam_count' => $comment_count['spam'],
							'trash_count' => $trash_count,
							'comment_links' => $WPrapAjaxEditComments->build_admin_links($commentID, $postID)
						)
			));
			$response->send();
			break;
		case "deleteperm":
			$message = $WPrapAjaxEditComments->delete_comment($commentID, $postID); 
			//Get error messages
			$error = '';
			if ($message != "1") {
			 $error = $WPrapAjaxEditComments->get_error($message);
			} else { $error = "0"; }

			//Send the response
			$approve_count = get_comment_count($postID);
			$comment_count = get_comment_count();
			global $wpdb;
			$trash_count = 0;
			$row = $wpdb->get_results("select comment_approved from $wpdb->comments where comment_approved = 'trash'", ARRAY_A);
			if ($row != NULL) {
				$trash_count = count($row);
			}
			
			$response = new WP_Ajax_Response();
			$response->add(array(
						'what' => 'delete',
						'id' => $commentID,
						'supplemental' => array(
							'errors' => $error,
							'approve_count' => $approve_count['approved'],
							'moderation_count' => $comment_count['awaiting_moderation'],
							'spam_count' => $comment_count['spam'],
							'trash_count' => $trash_count
						)
			));
			$response->send();
			break;
		case "spamcomment":
			//Save the old comment for undo
			$comment = get_comment($commentID, ARRAY_A);
			$WPrapAjaxEditComments->adminOptions['undo'] = $comment['comment_approved'];
			$WPrapAjaxEditComments->save_admin_options();
			
			$message = $WPrapAjaxEditComments->spam_comment($commentID, $postID);
			//Get error messages
			$error = '';
			if ($message != "1") {
			 $error = $WPrapAjaxEditComments->get_error($message);
			} else { $error = "0"; }
			//Build the undo URL
			$undo = $WPrapAjaxEditComments->build_undo_url("undospam", $commentID, $postID, __("Successfully Marked as Spam",$WPrapAjaxEditComments->localizationName));
			//Send the response
			$approve_count = get_comment_count($postID);
			$comment_count = get_comment_count();
			$response = new WP_Ajax_Response();
			$response->add(array(
						'what' => 'spam',
						'id' => $commentID,
						'supplemental' => array(
							'errors' => $error,
							'undo' => $undo,
							'approve_count' => $approve_count['approved'],
							'moderation_count' => $comment_count['awaiting_moderation'],
							'spam_count' => $comment_count['spam'],
							'comment_links' => $WPrapAjaxEditComments->build_admin_links($commentID, $postID)
						)
			));
			$response->send();
			break;
		case "approvecomment":
			//Save the old comment for undo
			$comment = get_comment($commentID, ARRAY_A);
			$WPrapAjaxEditComments->adminOptions['undo'] = $comment['comment_approved'];
			$WPrapAjaxEditComments->save_admin_options();
			
			$message = $WPrapAjaxEditComments->approve_comment($commentID, $postID);
			//Get error messages
			$error = '';
			if ($message != "1") {
			 $error = $WPrapAjaxEditComments->get_error($message);
			} else { $error = "0"; }
			//Build the undo URL
			$undo = $WPrapAjaxEditComments->build_undo_url("undoapprove", $commentID, $postID, __("Successfully Approved",$WPrapAjaxEditComments->localizationName));
			//Send the response
			$approve_count = get_comment_count($postID);
			$comment_count = get_comment_count();
			$response = new WP_Ajax_Response();
			$response->add(array(
						'what' => 'approve',
						'id' => $commentID,
						'supplemental' => array(
							'errors' => $error,
							'undo' => $undo,
							'approve_count' => $approve_count['approved'],
							'moderation_count' => $comment_count['awaiting_moderation'],
							'spam_count' => $comment_count['spam'],
							'comment_links' => $WPrapAjaxEditComments->build_admin_links($commentID, $postID)
						)
			));
			$response->send();
			break;
		case "unapprovecomment":
			$message = $WPrapAjaxEditComments->moderate_comment($commentID, $postID);
			
			//send the response
			$response = new WP_Ajax_Response();
			//Get error messages
			$error = '';
			if ($message != "1") {
			 $error = $WPrapAjaxEditComments->get_error($message);
			} else { $error = "0"; }
			//Build the undo URL
			$undo = $WPrapAjaxEditComments->build_undo_url("undomoderate", $commentID, $postID, __("Successfully Marked for Moderation",$WPrapAjaxEditComments->localizationName));
			//Send the response
			$approve_count = get_comment_count($postID);
			$comment_count = get_comment_count();
			$response->add(array(
						'what' => 'content',
						'id' => $commentID,
						'supplemental' => array(
							'errors' => $error,
							'undo' => $undo,
							'approve_count' => $approve_count['approved'],
							'moderation_count' => $comment_count['awaiting_moderation'],
							'spam_count' => $comment_count['spam'],
							'comment_links' => $WPrapAjaxEditComments->build_admin_links($commentID, $postID)
						)
			));
			$response->send();
			break;
		case "delinkcomment":
			$comment = get_comment($commentID, ARRAY_A);
			$WPrapAjaxEditComments->adminOptions['undo'] = $comment['comment_author_url'];
			$WPrapAjaxEditComments->save_admin_options();
			$comment['comment_author_url'] = '';
			$response = new WP_Ajax_Response();
			$message = $WPrapAjaxEditComments->delink_comment($commentID, $postID, $comment);
			//Get error messages
			$error = '';
			if ($message != "1") {
			 $error = $WPrapAjaxEditComments->get_error($message);
			} else { $error = "0"; }
			//Build the undo URL
			$undo = $WPrapAjaxEditComments->build_undo_url("undodelink", $commentID, $postID, __("Successfully De-linked",$WPrapAjaxEditComments->localizationName));
			//Send the response
			$response->add(array(
						'what' => 'content',
						'id' => $commentID,
						'supplemental' => array(
							'comment_author_url' => stripslashes(apply_filters('comment_url', apply_filters('get_comment_author_url', $comment['comment_author_url']))),
							'errors' => $error,
							'undo' => $undo,
							'comment_links' => $WPrapAjaxEditComments->build_admin_links($commentID, $postID)
						)
			));
			$response->send();
			break;
		case "requestdeletion":
			$message = $WPrapAjaxEditComments->request_deletion($commentID, $postID, trim(strip_tags(urldecode($_POST['message']))));
			$message = ($message == 1 ? 1: $WPrapAjaxEditComments->get_error($message));
			die('' . $message);
			break;
		case "undoedit":
			$comment = $WPrapAjaxEditComments->adminOptions['undo'];
			$response = new WP_Ajax_Response();
			$response = @$WPrapAjaxEditComments->save_comment($commentID, $postID, $comment);
			$response = apply_filters('wp_ajax_comments_save_comment', $response, $comment, $_POST);
			$response->send();
		break;
		case "undodelink":
			$comment = get_comment($commentID, ARRAY_A);
			$comment['comment_author_url'] = $WPrapAjaxEditComments->adminOptions['undo'];
			$response = new WP_Ajax_Response();
			$message = $WPrapAjaxEditComments->delink_comment($commentID, $postID, $comment);
			//Get error messages
			$response->add(array(
						'what' => 'delink',
						'id' => $commentID,
						'supplemental' => array(
							'comment_author_url' => stripslashes(apply_filters('comment_url', apply_filters('get_comment_author_url', $comment['comment_author_url']))),
							'comment_links' => $WPrapAjaxEditComments->build_admin_links($commentID, $postID)
						)
			));
			$response->send();
		break;
		case "undomoderate":
			$message = $WPrapAjaxEditComments->approve_comment($commentID, $postID);
			$approve_count = get_comment_count($postID);
			$comment_count = get_comment_count();
			$response = new WP_Ajax_Response();
			
			//Get error messages
			$response->add(array(
						'what' => 'unapprove',
						'id' => $commentID,
						'supplemental' => array(
							'approve_count' => $approve_count['approved'],
							'moderation_count' => $comment_count['awaiting_moderation'],
							'spam_count' => $comment_count['spam'],
							'comment_links' => $WPrapAjaxEditComments->build_admin_links($commentID, $postID)
						)
			));
			$response->send();
		break;
		case "undoapprove":
			$approved_status = $WPrapAjaxEditComments->adminOptions['undo'];
			if ($approved_status == "spam") {
				$approved = $WPrapAjaxEditComments->spam_comment($commentID, $postID);
			} else { 
				$approved = $WPrapAjaxEditComments->moderate_comment($commentID, $postID);
			}
			$approve_count = get_comment_count($postID);
			$comment_count = get_comment_count();
			$response = new WP_Ajax_Response();
			//Get error messages
			$response->add(array(
						'what' => 'approve',
						'id' => $commentID,
						'supplemental' => array(
							'moderation_count' => $comment_count['awaiting_moderation'],
							'approve_count' => $approve_count['approved'],
							'spam_count' => $comment_count['spam'],
							'comment_links' => $WPrapAjaxEditComments->build_admin_links($commentID, $postID)
						)
			));
			$response->send();
		break;
		case "undospam":
			$approved_status = $WPrapAjaxEditComments->adminOptions['undo'];
			if ($approved_status == 1) {
				$approved = $WPrapAjaxEditComments->approve_comment($commentID, $postID);
			} else { 
				$approved = $WPrapAjaxEditComments->moderate_comment($commentID, $postID);
			}
			$approve_count = get_comment_count($postID);
			$comment_count = get_comment_count();
			$response = new WP_Ajax_Response();
			//Get error messages
			$response->add(array(
						'what' => 'spam',
						'id' => $commentID,
						'supplemental' => array(
							'moderation_count' => $comment_count['awaiting_moderation'],
							'approve_count' => $approve_count['approved'],
							'spam_count' => $comment_count['spam'],
							'comment_links' => $WPrapAjaxEditComments->build_admin_links($commentID, $postID)
						)
			));
			$response->send();
		break;
		case "undodelete":
			if (!function_exists("wp_untrash_comment")) {
				$comment = $WPrapAjaxEditComments->adminOptions['undo'];
				
				//Save the old comment
				extract($comment, EXTR_SKIP);
				$data = compact('comment_post_ID', 'comment_author', 'comment_author_email', 'comment_author_url', 'comment_author_IP', 'comment_date', 'comment_date_gmt', 'comment_content', 'comment_karma', 'comment_approved', 'comment_agent', 'comment_type', 'comment_parent', 'user_id'); 
				$wpdb->insert($wpdb->comments, $data);
				$id = (int) $wpdb->insert_id;
				
				//Update the new ID to the old one
				$wpdb->update( $wpdb->comments, array( 'comment_ID' => $comment_ID ), array( 'comment_ID' => $id ));
				if ( $comment_approved == 1 )
					wp_update_comment_count($comment_post_ID);
			} else {
				wp_untrash_comment($commentID);
			}
	
			$comment_count = get_comment_count();
			
			global $wpdb;
			$trash_count = 0;
			$row = $wpdb->get_results("select comment_approved from $wpdb->comments where comment_approved = 'trash'", ARRAY_A);
			if ($row != NULL) {
				$trash_count = count($row);
			}
			$response = new WP_Ajax_Response();
			//Get error messages
			$response->add(array(
						'what' => 'delete',
						'id' => $commentID,
						'supplemental' => array(
							'moderation_count' => $comment_count['awaiting_moderation'],
							'approve_count' => $approve_count['approved'],
							'spam_count' => $comment_count['spam'],
							'trash_count' => $trash_count,
							'comment_links' => $WPrapAjaxEditComments->build_admin_links($commentID, $postID)
						)
			));
			$response->send();
		break;
	}
}
die('');
?>
