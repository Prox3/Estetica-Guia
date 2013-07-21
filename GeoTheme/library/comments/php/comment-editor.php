<?php
function aec_touch_time( $edit = 1, $for_post = 1, $tab_index = 0, $commentID = 0) {
	global $wp_locale;
	$comment = get_comment($commentID);
	$tab_index_attribute = '';
	if ( (int) $tab_index > 0 )
		$tab_index_attribute = " tabindex=\"$tab_index\"";


	$time_adj = time() + (get_option( 'gmt_offset' ) * 3600 );
	$post_date = $comment->comment_date;
	$edit = true;
	$jj = ($edit) ? mysql2date( 'd', $post_date ) : gmdate( 'd', $time_adj );
	$mm = ($edit) ? mysql2date( 'm', $post_date ) : gmdate( 'm', $time_adj );
	$aa = ($edit) ? mysql2date( 'Y', $post_date ) : gmdate( 'Y', $time_adj );
	$hh = ($edit) ? mysql2date( 'H', $post_date ) : gmdate( 'H', $time_adj );
	$mn = ($edit) ? mysql2date( 'i', $post_date ) : gmdate( 'i', $time_adj );
	$ss = ($edit) ? mysql2date( 's', $post_date ) : gmdate( 's', $time_adj );
	$cur_jj = gmdate( 'd', $time_adj );
	$cur_mm = gmdate( 'm', $time_adj );
	$cur_aa = gmdate( 'Y', $time_adj );
	$cur_hh = gmdate( 'H', $time_adj );
	$cur_mn = gmdate( 'i', $time_adj );

	$month = "<select id='mm' " . "name=\"mm\"$tab_index_attribute>\n";
	for ( $i = 1; $i < 13; $i = $i +1 ) {
		$month .= "\t\t\t" . '<option value="' . zeroise($i, 2) . '"';
		if ( $i == $mm )
			$month .= ' selected="selected"';
		$month .= '>' . $wp_locale->get_month_abbrev( $wp_locale->get_month( $i ) ) . "</option>\n";
	}
	$month .= '</select>';
	$day = '<input type="text" ' . ( $multi ? '' : 'id="jj" ' ) . 'name="jj" value="' . $jj . '" size="2" maxlength="2"' . $tab_index_attribute . ' autocomplete="off" />';
	$year = '<input type="text" ' . ( $multi ? '' : 'id="aa" ' ) . 'name="aa" value="' . $aa . '" size="4" maxlength="5"' . $tab_index_attribute . ' autocomplete="off" />';
	$hour = '<input type="text" ' . ( $multi ? '' : 'id="hh" ' ) . 'name="hh" value="' . $hh . '" size="2" maxlength="2"' . $tab_index_attribute . ' autocomplete="off" />';
	$minute = '<input type="text" ' . ( $multi ? '' : 'id="mn" ' ) . 'name="mn" value="' . $mn . '" size="2" maxlength="2"' . $tab_index_attribute . ' autocomplete="off" />';
	global $WPrapAjaxEditComments;
	if ($WPrapAjaxEditComments->adminOptions['use_rtl'] == "true") {
		printf(_c('%1$s%2$s, %3$s @ %4$s : %5$s|1: minute input ,2: hour input,3: year input,4: day input,5: month input'), $minute, $hour, $year, $day, $month);
		//printf(_c('%5$s : %4$s @ %3$s ,%2$s%1$s|1: minute input ,2: hour input,3: year input,4: day input,5: month input'), $minute, $hour, $year, $day, $month));
	} else {
		printf(_c('%1$s%2$s, %3$s @ %4$s : %5$s|1: month input, 2: day input, 3: year input, 4: hour input, 5: minute input'), $month, $day, $year, $hour, $minute);
	}

	echo '<input type="hidden" id="ss" name="ss" value="' . $ss . '" />';
} //aec_touch_time
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
	$result = wp_verify_nonce( $_GET['_wpnonce'],'editcomment_' . (int)$_GET['c']);
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
wp_enqueue_script('jquery', get_bloginfo('template_directory') . '/library/comments/js/jquery-1.3.2.min.js'); 
wp_enqueue_script("wp-ajax-response");
wp_enqueue_script("wp_ajax_tabs_custom", get_bloginfo('template_directory') . '/library/comments/js/jquery-ui.js');
wp_enqueue_script('wp_ajax_comment_editor', get_bloginfo('template_directory') . '/library/comments/js/comment-editor.js', array("jquery", "wp-ajax-response", "wp_ajax_tabs_custom") , 2.3);
wp_localize_script( 'wp_ajax_comment_editor', 'wpajaxeditcommentedit', $WPrapAjaxEditComments->get_js_vars());
wp_print_scripts(array('wp_ajax_comment_editor'));
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
<title>WP Ajax Edit Comments Comment Editor</title>
</head>
<body class="hidden">
<div>
<?php
$WPrapAjaxEditComments->is_comment_owner($postID);
if ($WPrapAjaxEditComments->admin && $WPrapAjaxEditComments->adminOptions['show_advanced'] == "true") : 
?>
<div id="tabs">
   <ul>
      <li><a href="#tabs-1">Main</a></li>
      <li><a href="#tabs-2">Advanced</a></li>
   </ul>
   <div id="tabs-1">
<?php
endif;
/* Admin nonce */
	wp_nonce_field('wp-ajax-edit-comments_save-comment');
?>
<div><input type="hidden" id="commentID" value="<?php echo $commentID;?>" />
  <input type="hidden" id="postID" value="<?php echo $postID;?>" />
  <input type="hidden" id="action" value="<?php echo $commentAction;?>" /></div>
<?php if ($WPrapAjaxEditComments->can_edit_options($commentID, $postID)): 
	$showicons = $WPrapAjaxEditComments->adminOptions['allow_icons'];
	$showoptions = $WPrapAjaxEditComments->adminOptions['show_options'];
	if ($showoptions == "true") :
?>

<div id="comment-options" class="postbox closed">
  <h3>
  <a class="togbox">+</a>
  <?php _e("More Options", $localization); ?>
  </h3>
	<div class="inside">
  <?php endif; /*options */ ?>
  	<table class="form inputs">
    <tbody>
    	<?php if ($WPrapAjaxEditComments->can_edit_name($commentID, $postID)): ?>
      <tr>
        <td><label for="name"><?php _e('Name',$localization); ?></label></td>
        <td><span> : </span><input type="text" size="35" name="name" id="name" /></td>
      </tr>
      <?php endif;?>
      <?php if ($WPrapAjaxEditComments->can_edit_email($commentID, $postID)): ?>
      <tr>
        <td><label for="e-mail"><?php _e('E-mail',$localization); ?></label></td>
        <td><span> : </span><input type="text" size="35" name="e-mail" id="e-mail" /></td>
      </tr>
      <?php endif;?>
      <?php if ($WPrapAjaxEditComments->can_edit_url($commentID, $postID)): ?>
      <tr>
        <td><label for="URL"><?php _e('URL',$localization); ?></label></td>
        <td><span> : </span><input type="text" size="35" name="URL" id="URL" /></td>
      </tr>
      <?php endif;?>
    </tbody>
    </table>
    <table><tbody>
    <?php do_action('wp_ajax_comments_editor'); ?>
    </tbody></table>
    <?php if ($showoptions == "true") : ?>
  </div>
</div> <!-- end comment-options -->
<?php endif; /*options*/ ?>
<?php endif; ?>
<div class="form"><textarea cols="50" rows="<?php echo ($showoptions == "true") ? "5" : "8";?>" name="comment" id="comment">&nbsp;</textarea></div>
<?php
if ($WPrapAjaxEditComments->admin && $WPrapAjaxEditComments->adminOptions['show_advanced'] == "true") : 
?>
				</div><!--tabs-1-->
        <div id="tabs-2">
        <div id="comment-options">
<?php
        
				if ($WPrapAjaxEditComments->adminOptions['use_rtl'] == "true") {
					$datef = _c( 'i:G @ Y , j M|Publish box date format');
					$stamp = __('<b>%1$s</b> :on Submitted', $localization);
				} else {
					$datef = _c( 'M j, Y @ G:i|Publish box date format');
					$stamp = __('Submitted on: <b>%1$s</b>', $localization);
				}

				$date = date_i18n( $datef, strtotime( $comment->comment_date));
?>			<h3><?php _e('Adjust Comment Time',$localization); ?></h3>
				<div><span id="timestamp"><?php printf($stamp, $date); ?></span><div><?php aec_touch_time(1, 0, 5, $commentID); ?></div><br /></div>
        <h3><?php _e('Adjust Comment Status', $localization); ?></h3>
        <?php 
				function aec_checked( $checked, $current) {
					if ( $checked == $current)
						echo ' checked="checked"';
				}
				?>
        <div class="misc-pub-section" id="comment-status-radio">
        <?php 
				if ($WPrapAjaxEditComments->adminOptions['use_rtl'] == "true") {
				?>
        	<label class="approved"><?php echo _e('Approved',$localization) ?><input type="radio"<?php aec_checked( $comment->comment_approved, '1' ); ?> name="comment_status" value="1" /></label><br />
          <label class="waiting"><?php echo _e('Pending', $localization) ?><input type="radio"<?php aec_checked( $comment->comment_approved, '0' ); ?> name="comment_status" value="0" /></label><br />
          <label class="spam"><?php echo _e('Spam', $localization); ?><input type="radio"<?php aec_checked( $comment->comment_approved, 'spam' ); ?> name="comment_status" value="spam" /></label>
        <?php
				} else {
				?>
          <label class="approved"><input type="radio"<?php aec_checked( $comment->comment_approved, '1' ); ?> name="comment_status" value="1" /><?php echo _e('Approved',$localization) ?></label><br />
          <label class="waiting"><input type="radio"<?php aec_checked( $comment->comment_approved, '0' ); ?> name="comment_status" value="0" /><?php echo _e('Pending', $localization) ?></label><br />
          <label class="spam"><input type="radio"<?php aec_checked( $comment->comment_approved, 'spam' ); ?> name="comment_status" value="spam" /><?php echo _e('Spam', $localization); ?></label>
				<?php } ?>
				</div>
        </div><!-- end comment options-->
      </div> <!--tabs-->
<?php
endif;
?>
<div class="form" id="buttons">
	<div><input type="button" id="save" name="save" disabled="true" value="<?php _e('Save',$localization); ?>" /></div>
  <div><input type="button" name="cancel" id="cancel" disabled="true" value="<?php _e('Cancel',$localization); ?>" /></div>
  <div id="timer<?php echo $commentID ?>"></div>
</div>
<div id="status"><span id="message"></span><span id="close-option">&nbsp;-&nbsp;<a href="#"><?php _e('Close',$localization); ?></a></span></div>
</div> <!-- end comment-edit-container-->
</body>
</html>
