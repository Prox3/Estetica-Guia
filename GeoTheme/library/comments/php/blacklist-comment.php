<?php 
header('Content-Type: text/html');
$root = dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))));
if (file_exists($root.'/wp-load.php')) {
		// WP 2.6
		require_once($root.'/wp-load.php');
} else {
		// Before 2.6
		require_once($root.'/wp-config.php');
}
//Check the nonce
if (isset($_GET['c'])) {
	$result = wp_verify_nonce( $_GET['_wpnonce'],'blacklist_' . (int)$_GET['c']);
	if (!$result) { die(''); }
} else { die(''); };
$commentID = (int)$_GET['c'];
$postID = (int)$_GET['p'];
$commentAction = $_GET['action'];
$commentAction = addslashes(preg_replace("/[^a-z0-9]/i", '', strip_tags($commentAction))); 

$localization = $WPrapAjaxEditComments->localizationName;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php 
wp_deregister_script(array('jquery'));
wp_enqueue_script('jquery', get_bloginfo('template_directory') . '/library/comments/js/jquery-1.3.2.min.js'); 
wp_enqueue_script("wp-ajax-response");
wp_enqueue_script("wp_ajax_tabs_custom", get_bloginfo('template_directory') . '/library/comments/js/jquery-ui.js');
wp_enqueue_script('wp_ajax_blacklist_comment', get_bloginfo('template_directory') . '/library/comments/js/blacklist-comment.js', array("jquery", "wp-ajax-response", "wp_ajax_tabs_custom") , "1.0");
wp_localize_script( 'wp_ajax_blacklist_comment', 'wpajaxeditcommentblacklist', $WPrapAjaxEditComments->get_js_vars());
wp_print_scripts(array('wp_ajax_blacklist_comment'));
?>
<?php 
if (empty($WPrapAjaxEditComments->adminOptions['editor_style_url'])) {
	if ($WPrapAjaxEditComments->adminOptions['use_rtl'] == "true") {
		echo '<link rel="stylesheet" href="'.get_bloginfo('template_directory') . '/library/comments/css/themes/'.$WPrapAjaxEditComments->adminOptions['icon_set'].'/comment-editor-rtl.css" type="text/css" media="screen"  />'; 
	} else {
		echo '<link rel="stylesheet" href="'.get_bloginfo('template_directory') . '/library/comments/css/themes/'.$WPrapAjaxEditComments->adminOptions['icon_set'].'/comment-editor.css" type="text/css" media="screen"  />'; 
	}
} else {
	echo '<link rel="stylesheet" href="'.get_bloginfo('template_directory').$WPrapAjaxEditComments->adminOptions['editor_style_url'].'" type="text/css" media="screen"  />';
}
echo '<link rel="stylesheet" href="'.get_bloginfo('template_directory') . '/library/comments/css/jquery-ui.css" type="text/css" media="screen"  />';
do_action('add_wp_ajax_comments_css_editor');
?>
<title>WP Ajax Edit Comments Blacklist Comment</title>
</head>
<body class="hidden">
<?php 
$comment = get_comment(intval($_GET['c']));
?>
<?php 
/* Admin nonce */
	wp_nonce_field('wp-ajax-edit-comments_blacklist-comment');
?>
<div><input type="hidden" id="commentID" value="<?php echo $commentID;?>" />
  <input type="hidden" id="postID" value="<?php echo $postID;?>" />
  <input type="hidden" id="action" value="<?php echo $commentAction;?>" /></div>
<div id="tabs">
   <ul>
      <li><a href="#tabs-1">Main</a></li>
      <li><a href="#tabs-2">Advanced</a></li>
   </ul>
   <div id="comment-options">
   <div id="tabs-1">
  <h3><?php _e("Blacklist Comment", $localization); ?></h3>
  <p><?php _e("Select from the options below to add to your comment blacklist.", $localization); ?></p>
  	<table class="form inputs">
    <tbody>
    	<tr>
        <td><input type="checkbox" name="blacklist[]" id="name" value="name" /></td>
        <td>&nbsp;&nbsp;&nbsp;<label for="name"><?php _e('Name',$localization); ?><em><small class="name<?php echo $commentID;?>"> (<?php echo $comment->comment_author ?>)</small></em></label></td>
      </tr>
      <?php
				if ( $comment->comment_author_url != '' && $comment->comment_author_url != 'http://' ) {
			?>
      <tr>
        <td><input type="checkbox" name="blacklist[]" id="url" value="url" /></td>
        <td>&nbsp;&nbsp;&nbsp;<label for="url"><?php _e('URL',$localization); ?><em><small class="url<?php echo $commentID;?>"> (<?php echo $comment->comment_author_url ?>)</small></em></label></td>
      </tr>
      <?php
				}
			?>
      <tr>
        <td><input type="checkbox" name="blacklist[]" id="email" value="email" /></td>
        <td>&nbsp;&nbsp;&nbsp;<label for="email"><?php _e('E-mail Address',$localization); ?><em><small class="email<?php echo $commentID;?>"> (<?php echo $comment->comment_author_email ?>)</small></em></label></td>
      </tr>
      <tr>
        <td><input type="checkbox" name="blacklist[]" id="ip" value="ip" /></td>
        <td>&nbsp;&nbsp;&nbsp;<label for="ip"><?php _e('IP Address',$localization); ?><em><small class="ip<?php echo $commentID;?>"> (<?php echo $comment->comment_author_IP ?>)</small></em></label></td>
      </tr>
    </tbody>
    </table>
    </div><!-- end tabs 1 -->
    <div id="tabs-2">
    <h3><?php _e("Spam Matching Comments", $localization); ?></h3>
  <p><?php _e(" Example: Selecting 'email' and 'name' will spam all comments that match both the name and e-mail address.", $localization);?><?php _e("Please be careful with this feature.  There is no undo function.", $localization);?></p>
  	<table class="form inputs">
    <tbody>
    	<tr>
        <td><input type="checkbox" name="spam[]" id="spamname" value="spamname" /></td>
        <td>&nbsp;&nbsp;&nbsp;<label for="spamname"><?php _e('Name',$localization); ?><em><small class="name<?php echo $commentID;?>"> (<?php echo $comment->comment_author ?></small>)</em></label></td>
      </tr>
      <?php
				if ( $comment->comment_author_url != '' && $comment->comment_author_url != 'http://' ) {
			?>
      <tr>
        <td><input type="checkbox" name="blacklist[]" id="spamurl" value="spamurl" /></td>
        <td>&nbsp;&nbsp;&nbsp;<label for="spamurl"><?php _e('URL',$localization); ?><em><small class="spamurl<?php echo $commentID;?>"> (<?php echo $comment->comment_author_url ?>)</small></em></label></td>
      </tr>
      <?php
				}
			?>
      <tr>
        <td><input type="checkbox" name="spam[]" id="spamemail" value="spamemail" /></td>
        <td>&nbsp;&nbsp;&nbsp;<label for="spamemail"><?php _e('E-mail Address',$localization); ?><em><small class="email<?php echo $commentID;?>"> (<?php echo $comment->comment_author_email ?>)</small></em></label></td>
      </tr>
      <tr>
        <td><input type="checkbox" name="spam[]" id="spamip" value="spamip" /></td>
        <td>&nbsp;&nbsp;&nbsp;<label for="spamip"><?php _e('IP Address',$localization); ?><em><small class="ip<?php echo $commentID;?>"> (<?php echo $comment->comment_author_IP ?>)</small></em></label></td>
      </tr>
    </tbody>
    </table>
    </div> <!-- end tabs 2-->
   </div> <!-- end tabs -->
<div class="form" id="buttons">
	<div><input type="button" id="send-request" name="send-request" value="<?php _e('Blacklist',$localization); ?>" /></div>
  <div><input type="button" name="cancel" id="cancel" value="<?php _e('Cancel',$localization); ?>" /></div>
</div>
<div id="status"><span id="message"></span><span id="close-option">&nbsp;-&nbsp;<a href="#"><?php _e('Close',$localization); ?></a></span></div>
</div><!--end comment options -->
</body>
</html>
