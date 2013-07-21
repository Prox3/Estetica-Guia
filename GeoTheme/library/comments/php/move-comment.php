<?php
header('Content-Type: text/html');
$root = dirname(dirname(dirname(dirname(dirname(__FILE__)))));
if (file_exists($root.'/wp-load.php')) {
		// WP 2.6
		require_once($root.'/wp-load.php');
} else {
		// Before 2.6
		require_once($root.'/wp-config.php');
}
//Check the nonce
if (isset($_GET['c'])) {
	$result = wp_verify_nonce( $_GET['_wpnonce'],'movecomment_' . (int)$_GET['c']);
	if (!$result) { die(''); }
} else { die(''); };
$commentID = (int)$_GET['c'];
$postID = (int)$_GET['p'];
$commentAction = $_GET['action'];
$commentAction = addslashes(preg_replace("/[^a-z0-9]/i", '', strip_tags($commentAction))); 
$localization = $WPrapAjaxEditComments->localizationName;
$comment = get_comment($commentID);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php 
wp_deregister_script(array('jquery'));
wp_enqueue_script('jquery', $WPrapAjaxEditComments->pluginDir . '/js/jquery-1.3.2.min.js'); 
wp_enqueue_script("wp-ajax-response");
wp_enqueue_script("wp_ajax_tabs_custom", $WPrapAjaxEditComments->pluginDir . '/js/jquery-ui.js');
wp_enqueue_script('wp_ajax_move_comment', $WPrapAjaxEditComments->pluginDir . '/js/move-comment.js', array("jquery", "wp-ajax-response", "wp_ajax_tabs_custom") , 2.3);
wp_localize_script( 'wp_ajax_move_comment', 'wpajaxeditcommentedit', $WPrapAjaxEditComments->get_js_vars());
wp_print_scripts(array('wp_ajax_move_comment'));
?>
<?php 
if (empty($WPrapAjaxEditComments->adminOptions['editor_style_url'])) {
	if ($WPrapAjaxEditComments->adminOptions['use_rtl'] == "true") {
		echo '<link rel="stylesheet" href="'.$WPrapAjaxEditComments->pluginDir.'/css/themes/'.$WPrapAjaxEditComments->adminOptions['icon_set'].'/comment-editor-rtl.css" type="text/css" media="screen"  />'; 
	} else {
		echo '<link rel="stylesheet" href="'.$WPrapAjaxEditComments->pluginDir.'/css/themes/'.$WPrapAjaxEditComments->adminOptions['icon_set'].'/comment-editor.css" type="text/css" media="screen"  />'; 
	}
} else {
	echo '<link rel="stylesheet" href="'.get_bloginfo('template_directory').$WPrapAjaxEditComments->adminOptions['editor_style_url'].'" type="text/css" media="screen"  />';
} 
	echo '<link rel="stylesheet" href="'.$WPrapAjaxEditComments->pluginDir.'/css/jquery-ui.css" type="text/css" media="screen"  />';
?>
<title>WP Ajax Edit Comments Move Comment</title>
</head>
<body class="hidden">
<div>
<?php
/* Admin nonce */
if ($WPrapAjaxEditComments->is_comment_owner($postID)) {
	wp_nonce_field('wp-ajax-edit-comments_move-comment');
}
?>
<div id="tabs">
   <ul>
      <li><a href="#tabs-1">Move by Post</a></li>
      <li><a href="#tabs-2">Move by Title</a></li>
      <li><a href="#tabs-3">Move by ID</a></li>
   </ul>
 <input type="hidden" id="commentID" value="<?php echo $commentID;?>" />
  <input type="hidden" id="postID" value="<?php echo $postID;?>" />
  <input type="hidden" id="action" value="<?php echo $commentAction;?>" />
  <input type="hidden" id="selectedID" value="0" />
   <div id="tabs-1">
    	<div id="post_loading" class="loading hidden"></div>
    	<div id="post_radio"></div>
    <input type="hidden" id="post_offset" name="post_offset" value="0" />
    <br /><br /><br />
    	<div style="clear: both;"><a class="previous hidden" id="post_previous" href="#"><?php _e('Previous',$localization); ?></a><a class="next hidden" id="post_next" href="#"><?php _e('Next',$localization); ?></a></div>
  <div class="form" id="post_buttons"><br /> 
    <div><input type="button" id="post_move" name="post_move" disabled="true" value="<?php _e('Move',$localization); ?>" /></div>
  </div><!--buttons-->
    </div><!--tabs-1-->
   <div id="tabs-2">
  	<table class="form inputs">
    <tbody>
      <tr>
      	<?php if ($WPrapAjaxEditComments->adminOptions['use_rtl'] == "true") {
				?>
        <td><input type="button" id="title_search" name="title_search" value="<?php _e('Search',$localization); ?>" /></td>
        <td>&nbsp;&nbsp;<input type="text" size="25" name="move_title" id="move_title" /><span> : </span></td>
        <td><label for="move_title"><?php _e('Title',$localization); ?></label></td>
        <?php 
				} else {
				?>
        <td><label for="move_title"><?php _e('Title',$localization); ?></label></td>
        <td><span> : </span><input type="text" size="25" name="move_title" id="move_title" /></td>
        <td>&nbsp;<input type="button" id="title_search" name="title_search" value="<?php _e('Search',$localization); ?>" /></td>
        <?php } ?>
      </tr>
    </tbody>
    </table>
    <div id="post_title_loading" class="loading hidden"></div>
    <div id="post_title_radio"></div>
    <div class="form hidden" id="post_title_buttons"><br />
			<div><input type="button" id="post_title_move" name="post_title_move" disabled="true" value="<?php _e('Move',$localization); ?>" /></div>
		</div><!--buttons-->
		</div><!--tabs-2-->
    <div id="tabs-3">
    <table class="form inputs">
    <tbody>
      <tr>
      	<?php if ($WPrapAjaxEditComments->adminOptions['use_rtl'] == "true") {
				?>
        <td><input type="button" id="id_search" name="id_search" value="<?php _e('Search',$localization); ?>" /></td>
        <td>&nbsp;&nbsp;<input type="text" size="25" name="post_id" id="post_id" /><span> : </span></td>
        <td><label for="post_id"><?php _e('Post ID',$localization); ?></label></td>			
        <?php
				} else {
				?>
        <td><label for="post_id"><?php _e('Post ID',$localization); ?></label></td>
        <td><span> : </span><input type="text" size="25" name="post_id" id="post_id" /></td>
        <td>&nbsp;<input type="button" id="id_search" name="id_search" value="<?php _e('Search',$localization); ?>" /></td>			
        <?php } ?>
      </tr>
    </tbody>
    </table>
    <div id="post_id_loading" class="loading hidden"></div>
    <div id="post_id_radio"></div>
    <div class="form hidden" id="post_id_buttons">
      <div><input type="button" id="post_id_move" name="post_id_move" disabled="true" value="<?php _e('Move',$localization); ?>" /></div>
		</div><!-- end buttons -->
    </div> <!--tabs-3-->
<?php 
	$comment = get_comment($commentID);
	if ($comment->comment_approved != "1") {
		?>
    <div>
      <table class="form inputs">
      <tbody>
        <tr>
        <?php
					if ($WPrapAjaxEditComments->adminOptions['use_rtl'] == "true") {
					?>
					<td><input id="approved" type="checkbox" name="approved" value="1" checked="checked" /></td>
          <td><span> : </span><label for="approved"><?php _e('Mark as Approved',$localization); ?></label></td>
					<?php } else {
					?>
          <td><label for="approved"><?php _e('Mark as Approved',$localization); ?></label></td>
          <td><span> : </span><input id="approved" type="checkbox" name="approved" value="1" checked="checked" /></td>
          <?php
					}?>
        </tr>
      </tbody>
      </table>
		</div>   
    <?php
	}
?>
<div id="status"><span id="message"></span><span id="close-option">&nbsp;-&nbsp;<a href="#"><?php _e('Close',$localization); ?></a></span></div>
</div> <!-- end comment-edit-container-->
</body>
</html>
