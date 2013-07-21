<?php 
/* Admin Panel Code - Created on April 19, 2008 by Ronald Huereca 
Last modified on June 09, 2008
*/
if (empty($this)) { die(''); }
if (empty($this->adminOptionsName)) { die(''); }

global $wpdb,$user_email;
$WPAjaxEditComments = $this->get_admin_options(); //global settings
$author_options = $this->get_user_options(); //user settings
//Check to see if a user can access the panel
if ( function_exists('current_user_can') && !current_user_can('manage_options') )
			die("nope");
//Delete security keys 
if (isset($_POST['wpAJAXSecurityKeys'])) {
	if ($_POST['wpAJAXSecurityKeys'] == "true") {
		check_admin_referer('wp-ajax-edit-comments_admin-options');
		$query = "delete from $wpdb->postmeta where left(meta_value, 6) = 'wpAjax'";
		@$wpdb->query($query);
		$query = "delete from $wpdb->posts where post_type = 'ajax_edit_comments'";
		@$wpdb->query($query); 
		?>
			<div class="updated"><p><strong><?php _e('Security keys deleted') ?></strong></p></div>
		<?php
	}
}
//Update settings
if (isset($_POST['update_wp_ajaxEditCommentSettings'])) { 
	 check_admin_referer('wp-ajax-edit-comments_admin-options');
	$error = false;
	$updated = false;
	//Validate the comment time entered
	if (isset($_POST['wpAJAXCommentTime'])) {
		$commentTimeErrorMessage = '';
		$commentClass = 'error';
		if (!preg_match('/^\d+$/i', $_POST['wpAJAXCommentTime'])) {
			$commentTimeErrorMessage = __("Comment time must be a numerical value");
			$error = true;
		}	elseif($_POST['wpAJAXCommentTime'] < 1) {
			$commentTimeErrorMessage = __("Comment time must be greater than one minute.");
			$error = true;
		} else {
			$WPAjaxEditComments['minutes'] = $_POST['wpAJAXCommentTime'];
			$updated = true;
		}
		if (!empty($commentTimeErrorMessage)) {
		?>
<div class="<?php echo $commentClass;?>"><p><strong><?php _e($commentTimeErrorMessage, $this->localizationName);?></p></strong></div>
		<?php
		}
	}
	
		//Update global settings
		$WPAjaxEditComments['disable'] = $_POST['wpAJAXDisable'];
		$WPAjaxEditComments['allow_editing'] = $_POST['wpAJAXCommentAllowEdit'];
		$WPAjaxEditComments['allow_editing_after_comment'] = $_POST['wpAJAXEditAfterComment'];
		$WPAjaxEditComments['spam_text'] = apply_filters('pre_comment_content',apply_filters('comment_save_pre', $_POST['wpAJAXSpamText']));
		$WPAjaxEditComments['show_timer'] = $_POST['wpAJAXShowTimer'];
		$WPAjaxEditComments['show_pages'] = $_POST['wpAJAXShowOnPages'];
		$WPAjaxEditComments['email_edits'] = $_POST['wpAJAXEmailEdits'];
		$WPAjaxEditComments['spam_protection'] = $_POST['wpAJAXSpam'];
		$WPAjaxEditComments['use_mb_convert'] = $_POST['wpAJAXmbConvert'];
		$WPAjaxEditComments['registered_users_edit'] = $_POST['wpAJAXregisterEdit'];
		$WPAjaxEditComments['registered_users_name_edit'] = $_POST['wpAJAXregisterEditName'];
		$WPAjaxEditComments['registered_users_url_edit'] = $_POST['wpAJAXregisterEditURL'];
		$WPAjaxEditComments['registered_users_email_edit'] = $_POST['wpAJAXregisterEditEmail'];
		$WPAjaxEditComments['allow_email_editing'] = $_POST['wpAJAXCommentAllowEmailEdit'];
		$WPAjaxEditComments['allow_url_editing'] = $_POST['wpAJAXCommentAllowURLEdit'];
		$WPAjaxEditComments['allow_name_editing'] = $_POST['wpAJAXCommentAllowNameEdit'];
		$WPAjaxEditComments['allow_icons'] = $_POST['wpAJAXCommentAllowIcons'];
		$WPAjaxEditComments['show_options'] = $_POST['wpAJAXCommentShowOptions'];
		$WPAjaxEditComments['clear_after'] = $_POST['wpAJAXCommentAllowClear'];
		$WPAjaxEditComments['javascript_scrolling'] = $_POST['wpAJAXCommentAllowScrolling'];
		$WPAjaxEditComments['post_style_url'] = stripslashes_deep(trim($_POST['wpAJAXCommentPostCSS']));
		$WPAjaxEditComments['editor_style_url'] = stripslashes_deep(trim($_POST['wpAJAXCommentEditorCSS']));
		$WPAjaxEditComments['comment_display_top'] = stripslashes_deep(trim($_POST['wpAJAXCommentDisplayTop']));
		$WPAjaxEditComments['allow_deletion'] = $_POST['wpAJAXCommentAllowDeletion'];
		$WPAjaxEditComments['show_advanced'] = $_POST['wpAJAXShowAdvanced'];
		$WPAjaxEditComments['icon_display'] = $_POST['wpAJAXCommentIconDisplay'];
		$WPAjaxEditComments['icon_set'] = $_POST['wpAJAXCommentIconSet'];
		$WPAjaxEditComments['use_rtl'] = $_POST['wpAJAXCommentRTL'];
		$WPAjaxEditComments['affiliate_text'] = apply_filters('pre_comment_content',apply_filters('comment_save_pre', $_POST['wpAJAXAffText']));
		$WPAjaxEditComments['affiliate_show'] = $_POST['wpAJAXAffiliateShow'];
		
		//Update user setings
		$author_options['author_editing'] = $_POST['wpAJAXAuthor'];
		$author_options['comment_editing'] = $_POST['wpAJAXComment'];
		$author_options['admin_editing'] = $_POST['wpAJAXAdminEdits'];
		$author_options['inline_editing'] = $_POST['wpAJAXInlineEdits'];
		$author_options['show_links'] = $_POST['wpAJAXLinks'];
		$updated = true;
	}
	if ($updated && !$error) {
		$this->adminOptions = $WPAjaxEditComments;
		$this->userOptions[$this->get_user_email()] = $author_options;
		$this->save_admin_options();
	?>
<div class="updated"><p><strong><?php _e('Settings successfully updated.') ?></strong></p></div>
<?php
}
?>
<div class="wrap">
<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
<?php wp_nonce_field('wp-ajax-edit-comments_admin-options') ?>
<h2>Ajax Edit Comments</h2>
<p><?php _e("Your commentators have edited their comments ") ?><?php echo number_format(intval($WPAjaxEditComments['number_edits'])); ?> <?php _e("times") ?>.</p>
<h3><?php _e('Global Options - These Options Affect Everyone');?></h3>
<table class="form-table">
	<tbody>
  	<tr valign="top">
      <th scope="row"><?php _e('Disable Comment Editing:') ?></th>
      <td>
    <input type="radio" id="wpAJAXDisable_yes" name="wpAJAXDisable" value="true" <?php if ($WPAjaxEditComments['disable'] == "true") { echo('checked="checked"'); }?> /> <?php _e('Yes'); ?><input type="radio" id="wpAJAXDisable_no" name="wpAJAXDisable" value="false" <?php if ($WPAjaxEditComments['disable'] == "false") { echo('checked="checked"'); }?>/> <?php _e('No'); ?>
    </td>
    </tr>
    
    <tr valign="top">
      <th scope="row"><?php _e('Set comment time (minutes):') ?></th>
      <td><input type="text" name="wpAJAXCommentTime" value="<?php echo $WPAjaxEditComments['minutes'] ?>" id="comment_time"/></td>
    </tr>
    
  <tr valign="top">
  	<th scope="row"><?php _e('Spam notification text:') ?></th>
    <td>
    <p><?php _e('Please limit to one line if possible since this text will show up when editing the comment or author (Tags allowed: em, a, strong, blockquote):') ?></p>
    <p><textarea cols="100" rows="3" name="wpAJAXSpamText" id="spam_text"><?php _e(stripslashes(apply_filters('comment_edit_save', $WPAjaxEditComments['spam_text'])), $this->localizationName)?></textarea></p>
    </td>
  </tr>
  <tr valign="top">
  	<th scope="row"><?php _e('Anonymous Users') ?></th>
    <td>
    <p><strong><?php _e('Allow Anyone to Edit Their Own Comments?');?></strong></p><p><?php _e('Selecting "No" will turn off comment editing for everyone except admin types who have post and page editing permissions.') ?></p>
    <p><label for="wpAJAXCommentAllowEdit_yes"><input type="radio" id="wpAJAXCommentAllowEdit_yes" name="wpAJAXCommentAllowEdit" value="true" <?php if ($WPAjaxEditComments['allow_editing'] == "true") { echo('checked="checked"'); }?> /> <?php _e('Yes'); ?></label>&nbsp;&nbsp;&nbsp;&nbsp;<label for="wpAJAXCommentAllowEdit_no"><input type="radio" id="wpAJAXCommentAllowEdit_no" name="wpAJAXCommentAllowEdit" value="false" <?php if ($WPAjaxEditComments['allow_editing'] == "false") { echo('checked="checked"'); }?>/> <?php _e('No'); ?></label></p>
    <p><strong><?php _e('Allow editing after additional comments have been posted?');?></strong></p><p><?php _e('Selecting "No" will prevent users from editing their comments if another comment has been made on a post.') ?></p>
    <p><label for="wpAJAXEditAfterComment_yes"><input type="radio" id="wpAJAXEditAfterComment_yes" name="wpAJAXEditAfterComment" value="true" <?php if ($WPAjaxEditComments['allow_editing_after_comment'] == "true") { echo('checked="checked"'); }?> /> <?php _e('Yes'); ?></label>&nbsp;&nbsp;&nbsp;&nbsp;<label for="wpAJAXEditAfterComment_no"><input type="radio" id="wpAJAXEditAfterComment_no" name="wpAJAXEditAfterComment" value="false" <?php if ($WPAjaxEditComments['allow_editing_after_comment'] == "false") { echo('checked="checked"'); }?>/> <?php _e('No'); ?></label></p>
     <p><strong><?php _e('Allow Users to Edit Their Name?');?></strong></p><p><?php _e('Selecting "No" will turn off editing of Names') ?></p>
    <p><label for="wpAJAXCommentAllowNameEdit_yes"><input type="radio" id="wpAJAXCommentAllowNameEdit_yes" name="wpAJAXCommentAllowNameEdit" value="true" <?php if ($WPAjaxEditComments['allow_name_editing'] == "true") { echo('checked="checked"'); }?> /> <?php _e('Yes'); ?></label>&nbsp;&nbsp;&nbsp;&nbsp;<label for="wpAJAXCommentAllowNameEdit_no"><input type="radio" id="wpAJAXCommentAllowNameEdit_no" name="wpAJAXCommentAllowNameEdit" value="false" <?php if ($WPAjaxEditComments['allow_name_editing'] == "false") { echo('checked="checked"'); }?>/> <?php _e('No'); ?></label></p>
     <p><strong><?php _e('Allow Users to Edit Their E-mail Addresses?');?></strong></p><p><?php _e('Selecting "No" will turn off editing of e-mail addresses.  One of the reasons you may want this on is for users with Avatars.') ?></p>
    <p><label for="wpAJAXCommentAllowEmailEdit_yes"><input type="radio" id="wpAJAXCommentAllowEmailEdit_yes" name="wpAJAXCommentAllowEmailEdit" value="true" <?php if ($WPAjaxEditComments['allow_email_editing'] == "true") { echo('checked="checked"'); }?> /> <?php _e('Yes'); ?></label>&nbsp;&nbsp;&nbsp;&nbsp;<label for="wpAJAXCommentAllowEmailEdit_no"><input type="radio" id="wpAJAXCommentAllowEmailEdit_no" name="wpAJAXCommentAllowEmailEdit" value="false" <?php if ($WPAjaxEditComments['allow_email_editing'] == "false") { echo('checked="checked"'); }?>/> <?php _e('No'); ?></label></p>
     <p><strong><?php _e('Allow Users to Edit Their URLs?');?></strong></p><p><?php _e('Selecting "No" will turn off editing of URLs') ?></p>
    <p><label for="wpAJAXCommentAllowURLEdit_yes"><input type="radio" id="wpAJAXCommentAllowURLEdit_yes" name="wpAJAXCommentAllowURLEdit" value="true" <?php if ($WPAjaxEditComments['allow_url_editing'] == "true") { echo('checked="checked"'); }?> /> <?php _e('Yes'); ?></label>&nbsp;&nbsp;&nbsp;&nbsp;<label for="wpAJAXCommentAllowURLEdit_no"><input type="radio" id="wpAJAXCommentAllowURLEdit_no" name="wpAJAXCommentAllowURLEdit" value="false" <?php if ($WPAjaxEditComments['allow_url_editing'] == "false") { echo('checked="checked"'); }?>/> <?php _e('No'); ?></label></p>
    <p><strong><?php _e('Allow Users to Request Deletion of Comments?');?></strong></p><p><?php _e('Selecting "No" will turn off the deletion option.') ?></p>
    <p><label for="wpAJAXCommentAllowDeletion_yes"><input type="radio" id="wpAJAXCommentAllowDeletion_yes" name="wpAJAXCommentAllowDeletion" value="true" <?php if ($WPAjaxEditComments['allow_deletion'] == "true") { echo('checked="checked"'); }?> /> <?php _e('Yes'); ?></label>&nbsp;&nbsp;&nbsp;&nbsp;<label for="wpAJAXCommentAllowDeletion_no"><input type="radio" id="wpAJAXCommentAllowDeletion_no" name="wpAJAXCommentAllowDeletion" value="false" <?php if ($WPAjaxEditComments['allow_deletion'] == "false") { echo('checked="checked"'); }?>/> <?php _e('No'); ?></label></p>
    </td>
  </tr>
  <tr valign="top">
  	<th scope="row"><?php _e('Registered Users');?></th>
    <td><p><strong><?php _e('Allow Registered Users to Edit Comments Indefinitely?'); ?></strong></p>
    		<p><?php _e('Selecting "Yes" will allow users registered on your blog to edit comments without a time limit.');?></p>
        <p><label for="wpAJAXregisterEdit_yes"><input type="radio" id="wpAJAXregisterEdit_yes" name="wpAJAXregisterEdit" value="true" <?php if ($WPAjaxEditComments['registered_users_edit'] == "true") { echo('checked="checked"'); }?> /> <?php _e('Yes'); ?></label>&nbsp;&nbsp;&nbsp;&nbsp;<label for="wpAJAXregisterEdit_no"><input type="radio" id="wpAJAXregisterEdit_no" name="wpAJAXregisterEdit" value="false" <?php if ($WPAjaxEditComments['registered_users_edit'] == "false") { echo('checked="checked"'); }?>/> <?php _e('No'); ?></label></p>
    <p><strong><?php _e('Allow Registered Users to Edit Their Name?'); ?></strong></p>
    		<p><?php _e('Selecting "Yes" will allow users registered on your blog to edit their names.  This can prevent issues if a user wishes to impersonate others.');?></p>
        <p><label for="wpAJAXregisterEditName_yes"><input type="radio" id="wpAJAXregisterEditName_yes" name="wpAJAXregisterEditName" value="true" <?php if ($WPAjaxEditComments['registered_users_name_edit'] == "true") { echo('checked="checked"'); }?> /> <?php _e('Yes'); ?></label>&nbsp;&nbsp;&nbsp;&nbsp;<label for="wpAJAXregisterEditName_no"><input type="radio" id="wpAJAXregisterEditName_no" name="wpAJAXregisterEditName" value="false" <?php if ($WPAjaxEditComments['registered_users_name_edit'] == "false") { echo('checked="checked"'); }?>/> <?php _e('No'); ?></label></p>
<p><strong><?php _e('Allow Registered Users to Edit Their E-mail Address?'); ?></strong></p>
    		<p><?php _e('Selecting "Yes" will allow users registered on your blog to edit their e-mail address.');?></p>
        <p><label for="wpAJAXregisterEditEmail_yes"><input type="radio" id="wpAJAXregisterEditEmail_yes" name="wpAJAXregisterEditEmail" value="true" <?php if ($WPAjaxEditComments['registered_users_email_edit'] == "true") { echo('checked="checked"'); }?> /> <?php _e('Yes'); ?></label>&nbsp;&nbsp;&nbsp;&nbsp;<label for="wpAJAXregisterEditEmail_no"><input type="radio" id="wpAJAXregisterEditEmail_no" name="wpAJAXregisterEditEmail" value="false" <?php if ($WPAjaxEditComments['registered_users_email_edit'] == "false") { echo('checked="checked"'); }?>/> <?php _e('No'); ?></label></p>
 <p><strong><?php _e('Allow Registered Users to Edit Their URL?'); ?></strong></p>
    		<p><?php _e('Selecting "Yes" will allow users registered on your blog to edit their URL.');?></p>
        <p><label for="wpAJAXregisterEditURL_yes"><input type="radio" id="wpAJAXregisterEditURL_yes" name="wpAJAXregisterEditURL" value="true" <?php if ($WPAjaxEditComments['registered_users_url_edit'] == "true") { echo('checked="checked"'); }?> /> <?php _e('Yes'); ?></label>&nbsp;&nbsp;&nbsp;&nbsp;<label for="wpAJAXregisterEditURL_no"><input type="radio" id="wpAJAXregisterEditURL_no" name="wpAJAXregisterEditURL" value="false" <?php if ($WPAjaxEditComments['registered_users_url_edit'] == "false") { echo('checked="checked"'); }?>/> <?php _e('No'); ?></label></p>
    </td>
	</tr>  
  <tr valign="top">
  	<th scope="row"><?php _e('Display Options') ?></th>
    <td>
    <p><strong><?php _e('Diplay on pages?') ?></strong></p><p><?php _e('Selecting "No" will turn off comment editing on pages.') ?></p>
    <p><label for="wpAJAXShowOnPages_yes"><input type="radio" id="wpAJAXShowOnPages_yes" name="wpAJAXShowOnPages" value="true" <?php if ($WPAjaxEditComments['show_pages'] == "true") { echo('checked="checked"'); }?> /> <?php _e('Yes'); ?></label>&nbsp;&nbsp;&nbsp;&nbsp;<label for="wpAJAXShowOnPages_no"><input type="radio" id="wpAJAXShowOnPages_no" name="wpAJAXShowOnPages" value="false" <?php if ($WPAjaxEditComments['show_pages'] == "false") { echo('checked="checked"'); }?>/> <?php _e('No'); ?></label></p>
    </td>
  </tr>
  <tr valign="top">
  	<th scope="row"><?php _e('Countdown Timer') ?></th>
    <td>
    <p><strong><?php _e('Show a Countdown Timer?') ?></strong></p><p><?php _e('Selecting "No" will turn off the countdown timer for non-admin commentators.') ?></p>
    <p><label for="wpAJAXShowTimer_yes"><input type="radio" id="wpAJAXShowTimer_yes" name="wpAJAXShowTimer" value="true" <?php if ($WPAjaxEditComments['show_timer'] == "true") { echo('checked="checked"'); }?> /> <?php _e('Yes'); ?></label>&nbsp;&nbsp;&nbsp;&nbsp;<label for="wpAJAXShowTimer_no"><input type="radio" id="wpAJAXShowTimer_no" name="wpAJAXShowTimer" value="false" <?php if ($WPAjaxEditComments['show_timer'] == "false") { echo('checked="checked"'); }?>/> <?php _e('No'); ?></label></p>
    </td>
  </tr>
  <tr valign="top">
  	<th scope="row"><?php _e('Edit E-mails') ?></th>
    <td>
    <p><strong><?php _e('Allow Edit E-mails?') ?></strong></p><p>  <?php _e('Selecting "Yes" will send you an email each time someone edits their comment.') ?></p>
    <p><label for="wpAJAXEmailEdits_yes"><input type="radio" id="wpAJAXEmailEdits_yes" name="wpAJAXEmailEdits" value="true" <?php if ($WPAjaxEditComments['email_edits'] == "true") { echo('checked="checked"'); }?> /> <?php _e('Yes'); ?></label>&nbsp;&nbsp;&nbsp;&nbsp;<label for="wpAJAXEmailEdits_no"><input type="radio" id="wpAJAXEmailEdits_no" name="wpAJAXEmailEdits" value="false" <?php if ($WPAjaxEditComments['email_edits'] == "false") { echo('checked="checked"'); }?>/> <?php _e('No'); ?></label></p>
    </td>
  </tr>
  <tr valign="top">
  	<th scope="row"><?php _e('Spam Protection'); ?></th>
    <td>
    <p><label for="wpAJAXAkismet"><input type="radio" id="wpAJAXAkismet" name="wpAJAXSpam" value="akismet" <?php if ($WPAjaxEditComments['spam_protection'] == "akismet") { echo('checked="checked"'); }?> /> <?php _e('Akismet'); ?></label><br /><label for="wpAJAXDefensio"><input type="radio" id="wpAJAXDefensio" name="wpAJAXSpam" value="defensio" <?php if ($WPAjaxEditComments['spam_protection'] == "defensio") { echo('checked="checked"'); }?>/> <?php _e('Defensio'); ?></label><br /><label for="wpAJAXNoSpam"><input type="radio" id="wpAJAXNoSpam" name="wpAJAXSpam" value="none" <?php if ($WPAjaxEditComments['spam_protection'] == "none") { echo('checked="checked"'); }?>/> <?php _e('None'); ?></label></p>
    </td>
  </tr>
  <tr valign="top">
    <th scope="row"><?php _e('Styles'); ?></th>
    <td>
    <p><strong><?php _e('Determine Icon Display') ?></strong></p>
    <p><?php _e('Select an option below to determine how the icons are displayed on your blog.') ?></p>
<select name="wpAJAXCommentIconDisplay">
	<option value="noicons" <?php if ($WPAjaxEditComments['icon_display'] == "noicons") { echo('selected="Selected"'); }?>>No Icons</option>
  <option value="classic" <?php if ($WPAjaxEditComments['icon_display'] == "classic") { echo('selected="Selected"'); }?>>Classic</option>
  <option value="dropdown" <?php if ($WPAjaxEditComments['icon_display'] == "dropdown") { echo('selected="Selected"'); }?>>Dropdown</option>
</select>
<p><strong><?php _e('Determine Icon Set') ?></strong></p>
    <p><?php _e('Select an option below to display the icon set on your blog.') ?></p>
    <?php 
		// Files in wp-content/plugins directory
		//$path1 = WP_PLUGIN_DIR . '/wp-ajax-edit-comments/css/themes';
		$path = TEMPLATEPATH  . '/library/comments/css/themes';
		//echo $path1.'<br>'.$path;exit;
		$themedir = @ opendir($path);
		//echo $plugins_dir;
		echo "<select name='wpAJAXCommentIconSet'>";
		while (($file = readdir( $themedir ) ) !== false ) {
			
			if (is_dir($path.'/'.$file ) && substr_count($file, '.') == 0) {
				$selected = '';
				if ($file == $WPAjaxEditComments['icon_set']) {
					$selected = "selected";
				}
				echo "<option value='$file' $selected>$file</option>";
			}
		}
		echo "</select>";
		?>
<p><strong><?php _e('Use RTL StyleSheet?') ?></strong></p>
<p><label for="wpAJAXCommentRTL_yes"><input type="radio" id="wpAJAXCommentRTL_yes" name="wpAJAXCommentRTL" value="true" <?php if ($WPAjaxEditComments['use_rtl'] == "true") { echo('checked="checked"'); }?> /> <?php _e('Yes') ?></label>&nbsp;&nbsp;&nbsp;&nbsp;<label for="wpAJAXCommentRTL_no"><input type="radio" id="wpAJAXCommentRTL_no" name="wpAJAXCommentRTL" value="false" <?php if ($WPAjaxEditComments['use_rtl'] == "false") { echo('checked="checked"'); }?>/> <?php _e('No') ?></label></p>
<p><strong><?php _e('Turn Off clearfix:after?') ?></strong></p>
    <p><?php _e('The clearfix is enabled by default for maximum compatibility with themes.') ?></p>
<p><label for="wpAJAXCommentAllowClear_yes"><input type="radio" id="wpAJAXCommentAllowClear_yes" name="wpAJAXCommentAllowClear" value="false" <?php if ($WPAjaxEditComments['clear_after'] == "false") { echo('checked="checked"'); }?> /> <?php _e('Yes') ?></label>&nbsp;&nbsp;&nbsp;&nbsp;<label for="wpAJAXCommentAllowClear_no"><input type="radio" id="wpAJAXCommentAllowClear_no" name="wpAJAXCommentAllowClear" value="true" <?php if ($WPAjaxEditComments['clear_after'] == "true") { echo('checked="checked"'); }?>/> <?php _e('No') ?></label></p>
<p><strong><?php _e('Turn Off Admin JavaScript Scrolling?') ?></strong></p>
    <p><?php _e('The plugin tries to correct incorrect offsets on a post if you are admin.') ?></p>
<p><label for="wpAJAXCommentAllowScrolling_yes"><input type="radio" id="wpAJAXCommentAllowScrolling_yes" name="wpAJAXCommentAllowScrolling" value="false" <?php if ($WPAjaxEditComments['javascript_scrolling'] == "false") { echo('checked="checked"'); }?> /> <?php _e('Yes') ?></label>&nbsp;&nbsp;&nbsp;&nbsp;<label for="wpAJAXCommentAllowScrolling_no"><input type="radio" id="wpAJAXCommentAllowScrolling_no" name="wpAJAXCommentAllowScrolling" value="true" <?php if ($WPAjaxEditComments['javascript_scrolling'] == "true") { echo('checked="checked"'); }?>/> <?php _e('No') ?></label></p>
		<p><strong><?php _e('Post/Admin CSS URL') ?></strong></p>
    <p><?php _e("Leaving a style empty will revert back to the default plugin styles.") ?><?php _e("The URL should be relative to: "); bloginfo('template_directory'); ?></p>
<p><input id="wpAJAXCommentPostCSS" type="text" size="40" value="<?php echo attribute_escape($WPAjaxEditComments['post_style_url']);?>" name="wpAJAXCommentPostCSS" /></p>
    <p><strong><?php _e('Editor CSS URL') ?></strong></p>
    <p><?php _e("Leaving a style empty will revert back to the default plugin styles.") ?><?php _e("The URL should be relative to: "); bloginfo('template_directory'); ?></p>
    <p><input id="wpAJAXCommentEditorCSS" type="text" size="40" value="<?php echo attribute_escape($WPAjaxEditComments['editor_style_url']);?>" name="wpAJAXCommentEditorCSS" /></p>
    <p><strong><?php _e('Comment Edit Interface On Bottom?') ?></strong></p>
<p><label for="wpAJAXCommentDisplayTop_no"><input type="radio" id="wpAJAXCommentDisplayTop_no" name="wpAJAXCommentDisplayTop" value="false" <?php if ($WPAjaxEditComments['comment_display_top'] == "false") { echo('checked="checked"'); }?> /> <?php _e('Yes') ?></label>&nbsp;&nbsp;&nbsp;&nbsp;<label for="wpAJAXCommentDisplayTop_yes"><input type="radio" id="wpAJAXCommentDisplayTop_yes" name="wpAJAXCommentDisplayTop" value="true" <?php if ($WPAjaxEditComments['comment_display_top'] == "true") { echo('checked="checked"'); }?>/> <?php _e('No') ?></label></p>
    </td>
  </tr>
  <tr valign="top">
    <th scope="row"><?php _e('Editor Options'); ?></th>
    <td>
    <p><?php _e('The following affects the editing interface.') ?></p>
    <p><strong><?php _e('Turn Off More Options?') ?></strong></p>
<p><label for="wpAJAXCommentShowOptions_no"><input type="radio" id="wpAJAXCommentShowOptions_no" name="wpAJAXCommentShowOptions" value="false" <?php if ($WPAjaxEditComments['show_options'] == "false") { echo('checked="checked"'); }?> /> <?php _e('Yes') ?></label>&nbsp;&nbsp;&nbsp;&nbsp;<label for="wpAJAXCommentShowOptions_yes"><input type="radio" id="wpAJAXCommentShowOptions_yes" name="wpAJAXCommentShowOptions" value="true" <?php if ($WPAjaxEditComments['show_options'] == "true") { echo('checked="checked"'); }?>/> <?php _e('No') ?></label></p>
    </td>
  </tr>
  <tr valign="top">
  	<th scope="row"><?php _e('Character Encoding') ?></th>
    <td>
    <p><strong><?php _e('Enable mb_convert_encoding?') ?></strong></p>
    <p><?php _e('Some servers do not have this installed.  If you disable this option, be sure to test out various characters.  The mb_convert_encoding function is necessary to convert from UTF-8 to various charsets.') ?></p>
    <p><label for="wpAJAXmbConvert_yes"><input type="radio" id="wpAJAXmbConvert_yes" name="wpAJAXmbConvert" value="true" <?php if ($WPAjaxEditComments['use_mb_convert'] == "true") { echo('checked="checked"'); }?> /> <?php _e('Yes'); ?></label>&nbsp;&nbsp;&nbsp;&nbsp;<label for="wpAJAXmbConvert_no"><input type="radio" id="wpAJAXmbConvert_no" name="wpAJAXmbConvert" value="false" <?php if ($WPAjaxEditComments['use_mb_convert'] == "false") { echo('checked="checked"'); }?>/> <?php _e('No'); ?></label></p>
    </td>
  </tr>
 </tbody>
</table>
<?php
		$comment = $author_options['comment_editing'];
		$adminEdits = $author_options['admin_editing'];
?>
<div class="submit">
  <input type="submit" name="update_wp_ajaxEditCommentSettings" value="<?php _e('Update Settings') ?>" />
</div>
<h3><?php _e('Individual Options - These Options Only Affect You');?></h3>
<table class="form-table">
	<tbody>
  <tr valign="top">
  	<th scope="row"><?php _e('Admin Panel Editing') ?></th>
    <td>
    <p><strong><?php _e('Turn Off Comment Editing in Admin Panel?') ?></strong></p>
<p><?php _e('Selecting "Yes" will disable comment editing in the Admin Comments Panel.') ?></p>
<p><label for="wpAJAXAdminEdits_yes"><input type="radio" id="wpAJAXAdminEdits_yes" name="wpAJAXAdminEdits" value="true" <?php if ($adminEdits == "true") { echo('checked="checked"'); }?> /> <?php _e('Yes') ?></label>&nbsp;&nbsp;&nbsp;&nbsp;<label for="wpAJAXAdminEdits_no"><input type="radio" id="wpAJAXAdminEdits_no" name="wpAJAXAdminEdits" value="false" <?php if ($adminEdits == "false") { echo('checked="checked"'); }?>/> <?php _e('No') ?></label></p>
    </td>
  </tr>
  <tr valign="top">
  	<th scope="row"><?php _e('Post Editing') ?></th>
    <td>
    <p><strong><?php _e('Turn On Comment Editing?') ?></strong></p>
    <p><?php _e('Selecting "Yes" will enable your ability to edit a user\'s comment.  Selecting "No" will disable your ability to edit comments on a post') ?></p>
<p><label for="wpAJAXComment_yes"><input type="radio" id="wpAJAXComment_yes" name="wpAJAXComment" value="true" <?php if ($comment == "true") { echo('checked="checked"'); }?> /> <?php _e('Yes') ?></label>&nbsp;&nbsp;&nbsp;&nbsp;<label for="wpAJAXComment_no"><input type="radio" id="wpAJAXComment_no" name="wpAJAXComment" value="false" <?php if ($comment == "false") { echo('checked="checked"'); }?>/> <?php _e('No') ?></label></p>
    </td>
  </tr>
  <tr valign="top">
  	<th scope="row"><?php _e('Advanced Options') ?></th>
    <td>
    <p><strong><?php _e('Show Advanced Options in Editor?') ?></strong></p>
    <p><?php _e('Selecting "Yes" will show advanced options in the editor window') ?></p>
<p><label for="wpAJAXShowAdvanced_yes"><input type="radio" id="wpAJAXShowAdvanced_yes" name="wpAJAXShowAdvanced" value="true" <?php if ($WPAjaxEditComments['show_advanced'] == "true") { echo('checked="checked"'); }?> /> <?php _e('Yes') ?></label>&nbsp;&nbsp;&nbsp;&nbsp;<label for="wpAJAXShowAdvanced_no"><input type="radio" id="wpAJAXShowAdvanced_no" name="wpAJAXShowAdvanced" value="false" <?php if ($WPAjaxEditComments['show_advanced'] == "false") { echo('checked="checked"'); }?>/> <?php _e('No') ?></label></p>
    </td>
  </tr>
  </tbody>
</table>
<div class="submit">
  <input type="submit" name="update_wp_ajaxEditCommentSettings" value="<?php _e('Update Settings') ?>" />
</div>
<h3><?php _e('Ajax Edit Comments Cleanup');?></h3>
<table class="form-table">
	<tbody>
  <tr valign="top">
  	<th scope="row"><?php _e('Delete all security keys') ?></th>
    <td>
    <p><?php _e("Each time a user leaves a comment, a security key is stored as a custom key.  Periodically you may want to delete this information.  Please backup your database first.") ?></p>
    <p><label for="wpAJAXSecurityKeys_yes"><input type="radio" id="wpAJAXSecurityKeys_yes" name="wpAJAXSecurityKeys" value="true" /> <?php _e('Yes') ?></label>&nbsp;&nbsp;&nbsp;&nbsp;<label for="wpAJAXSecurityKeys_no"><input type="radio" id="wpAJAXSecurityKeys_no" name="wpAJAXSecurityKeys" value="false" checked="checked"/> <?php _e('No') ?></label></p>
		</td>
	</tr>
  </tbody>
</table>  
<div class="submit">
  <input type="submit" name="update_wp_ajaxEditCommentSettings" value="<?php _e('Update Settings') ?>" />
</div>
</form>
</div>
