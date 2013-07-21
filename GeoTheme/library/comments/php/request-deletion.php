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
	$result = wp_verify_nonce( $_GET['_wpnonce'],'requestdeletion_' . (int)$_GET['c']);
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
wp_enqueue_script("wp-ajax-response");
wp_enqueue_script('jquery'); 
wp_enqueue_script('wp_ajax_request_deletion', get_bloginfo('template_directory') . '/library/comments/js/request-deletion.js', array("jquery", "wp-ajax-response") , 2.3);
wp_localize_script( 'wp_ajax_request_deletion', 'wpajaxeditcommentedit', $WPrapAjaxEditComments->get_js_vars());
wp_print_scripts(array('wp_ajax_request_deletion'));
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
do_action('add_wp_ajax_comments_css_editor');
?>
<title>WP Ajax Edit Comments Request Deletion</title>
</head>
<body>
<div id="comment-options">
<h3><?php _e("Request Deletion", $localization); ?></h3>
<?php 
/* Admin nonce */
	wp_nonce_field('wp-ajax-edit-comments_request-deletion');
?>
<div><input type="hidden" id="commentID" value="<?php echo $commentID;?>" />
  <input type="hidden" id="postID" value="<?php echo $postID;?>" />
  <input type="hidden" id="action" value="<?php echo $commentAction;?>" /></div>
  	<table class="form inputs">
    <tbody>
    	<tr>
      <td>
      <?php _e('Please explain why the comment should be deleted.  After sending the request, your comment will be marked as moderated and will no longer be viewable publicly.',$localization); ?>
      </td>
      <tr>
        <td><textarea cols="70" rows="8" name="deletion-reason" id="deletion-reason">&nbsp;</textarea></td>
      </tr>
    </tbody>
    </table>
<div class="form" id="buttons">
	<div><input type="button" id="send-request" name="send-request" value="<?php _e('Send Request',$localization); ?>" /></div>
  <div><input type="button" name="cancel" id="cancel" value="<?php _e('Cancel',$localization); ?>" /></div>
</div>
<div id="status"><span id="message"></span><span id="close-option">&nbsp;-&nbsp;<a href="#"><?php _e('Close',$localization); ?></a></span></div>
</div> <!-- end comment options-->
</body>
</html>
