<?php
/*
Plugin Name: Easy Comment Uploads
Plugin URI: http://wordpress.org/extend/plugins/easy-comment-uploads/
Description: Allow your users to easily upload images and files with their comments.
Author: Tom Wright
Version: 0.71
Author URI: http://gplus.to/twright/
License: GPLv3
*/

// Take a image url and return a url to a thumbnail for height $h, width $w
// and using zoom/crop mode $zc
function ecu_thumbnail($url, $h='null', $w='null', $zc=3) {
	global $thumb_url; /// get the mutiuser id
    //return ecu_plugin_url() . "timthumb.php?src=$url&zc=$zc&h=$h&w=$w";
	return $url;
}
function ecu_bignail($url, $h='null', $w='null', $zc=3) {
	global $thumb_url; /// get the mutiuser id
    //return ecu_plugin_url() . "timthumb.php?src=$url&zc=$zc&h=$h&w=$w";
	return $url;
}

// Replaces [tags] with correct html
// Accepts either [img]image.png[/img] or [file]file.ext[/file] for other files
// Thanks to Trevor Fitzgerald's plugin (http://www.trevorfitzgerald.com/) for
// prompting the format used.
function ecu_insert_links($comment) {
    // Extract contents of tags
	$comment = str_replace("&#215;", "x", $comment);
    preg_match_all('/\[(img|file)\]([^\]]*)\[\/\\1\]/i', $comment, $matches,
        PREG_SET_ORDER);
		
    foreach($matches as $match) {
        // Validate tags contain links of the correct format
        if (filter_var($match[2], FILTER_VALIDATE_URL)) {
            // Insert correct code based on tag
            preg_match('/[^\/]*$/', $match[2], $filename);
            $name = get_option('ecu_show_full_file_path') ? $match[2]
                : $filename[0];
            if ($match[1] == 'img') {
                $thumbnail = ecu_thumbnail($match[2], 300);
                $bignail = ecu_bignail($match[2], 300);
                $html = "<a href='$bignail' rel='lightbox'>"
                    . (get_option('ecu_display_images_as_links') ? "Image: $name"
                    : "<img class='ecu_images' src='$thumbnail' />")
                    . '</a>';
            } elseif ($match[1] == 'file') {
                $html = "<a href='$match[2]'>File: $name</a>";
            }
            
            $comment = str_replace($match[0], $html, $comment);
        } else {
            echo $match[2];
        }
    }

    return $comment;
}

// Retrieve either a user created file extension blacklist or a default list of
// harmful extensions. This function allows the blacklist to be updated with
// the plugin if it has not been edited by the user.
function ecu_get_blacklist() {
    $default_blacklist = array('htm', 'html', 'shtml', 'mhtm', 'mhtml', 'js',
        'php', 'php3', 'php4', 'php5', 'php6', 'phtml',
        'cgi', 'fcgi', 'pl', 'perl', 'p6', 'asp', 'aspx',
        'htaccess',
        'py', 'python', 'exe', 'bat',  'sh', 'run', 'bin', 'vb', 'vbe', 'vbs');
    return get_option('ecu_file_extension_blacklist', $default_blacklist);
}

// A list of file extensions which should not be harmful
function ecu_get_whitelist() {
    $default_whitelist = array('bmp', 'gif', 'jpg', 'jpeg','png');
    return get_option('ecu_file_extension_whitelist', $default_whitelist);
}

// Get user ip address
function ecu_user_ip_address() {
    if ($_SERVER['HTTP_X_FORWARD_FOR'])
        return $_SERVER['HTTP_X_FORWARD_FOR'];
    else
        return $_SERVER['REMOTE_ADDR'];
}

// Record upload time in user metadata or ip based array
function ecu_user_record_upload_time() {
    $time = time();
    if (is_user_logged_in()) {
        $times = get_user_meta(get_current_user_id(), 'ecu_upload_times',
            true);
        update_user_meta(get_current_user_id(), 'ecu_upload_times',
            ($times ? array_merge(array($time), $times) : array($time)));
    } else {
        $ip_upload_times = get_option('ecu_ip_upload_times');
        $ip = ecu_user_ip_address();

        if (array_key_exists($ip, $ip_upload_times)) {
            array_push($ip_upload_times[$ip], $time);
        } else {
            $ip_upload_times[$ip] = array($time);
        }
        update_option('ecu_ip_upload_times', $ip_upload_times);
    }
}

// Get the users hourly upload quota
function ecu_user_uploads_per_hour() {
    $uploads_per_hour = get_option('ecu_uploads_per_hour');
    foreach (get_option('ecu_uploads_per_hour') as $role => $x)
        if ($role == 'none' || current_user_can($role))
            return $x;
}

// Calculate the number of times which occured during the last hour
function ecu_user_uploads_in_last_hour() {
    // Get times either for current user or ip as available
    $ip_upload_times = get_option('ecu_ip_upload_times');
    $times = (is_user_logged_in()
        ? get_user_meta(get_current_user_id(), 'ecu_upload_times', true)
        : $ip_upload_times[ecu_user_ip_address()]);
    $i = 0; // Counter for uploads
    $now = time();
    foreach($times as $time)
        // If time passed less than or equal to 3600 s (1 hour), increment i
        if ($now - $time <= 3600) $i++;
    return $i;
}

// Get url of plugin
function ecu_plugin_url() {
    //return plugins_url('easy-comment-uploads/');
	return get_bloginfo('template_directory').'/library/comment-uploads/';
}

// Get the full path to the wordpress root directory
function ecu_wordpress_root_path() {
    $path = dirname(__FILE__);
    
    while (!file_exists($path . '/wp-config.php'))
        $path = dirname($path);

    return str_replace("\\", "/", $path) . '/';
}

// Placeholder for preview of uploaded files
function ecu_upload_form_preview($display=true) {
    echo "<p id='ecu_preview' " . ($display ? "" : "style='display:none'")
        . "></p>";
}

// An iframe containing the upload form
function ecu_upload_form_iframe() {
    echo "<iframe class='ecu_upload_frame ' scrolling='no' frameborder='0'"
       // . "allowTransparency='true'"
        . " src='" . ecu_plugin_url () . "upload-form.php"
        . "' name='upload_form'></iframe>";
}

// Complete upload form
function ecu_upload_form($title, $msg, $check=true) {
	$post_type = get_post_type();
    if ( !ecu_allow_upload() && $check) return;
	if($post_type!='post' && $post_type!='page'){

    echo "
    <!-- Easy Comment Uploads for Wordpress by Tom Wright: http://wordpress.org/extend/plugins/easy-comment-uploads/ -->

    <div id='ecu_uploadform'>
    <h3 class='title'>$title</h3>
    <div class='message'>$msg</div>
    ";

    ecu_upload_form_iframe();

    ecu_upload_form_preview();

    echo "
    </div>

    <!-- End of Easy Comment Uploads -->
    ";}
}

// Default comment form
function ecu_upload_form_default($check=true) {
    ecu_upload_form (
       /* __('Upload Files', 'easy-comment-uploads'), // $title
        '<p>' . ecu_message_text() . '</p>', // $msg
        $check // $check*/
		 UPLOAD_IMAGE, // $title
        '<p>' . ATTACH_IMAGE . '</p>', // $msg
        $check // $check
    );
}

// Get message text
function ecu_message_text() {
    if (get_option('ecu_message_text'))
        return get_option('ecu_message_text');
    else
        return __('Attach a image to your review.', 'easy-comment-uploads');
}

// Add options menu item (restricted to level_10 users)
function ecu_options_menu() {
    if (current_user_can("level_10"))
        add_submenu_page('product_menu.php', __('Easy Comment Uploads options'),__('Comment Uploads'), 8, __FILE__, 'ecu_options_page');
}
 
// Provide an options page in wp-admin
function ecu_options_page() {
    // Handle changed options
    if (isset($_POST['submitted'])) {
        check_admin_referer('easy-comment-uploads');

        // Update options
        update_option ('ecu_images_only', $_POST['images_only'] != null);
        if (isset($_POST['permission_required']))
            update_option ('ecu_permission_required',
                $_POST['permission_required']);
        update_option ('ecu_hide_comment_form',
            (int) ($_POST['hide_comment_form'] != null));
        update_option ('ecu_show_full_file_path',
            (int) ($_POST['show_full_file_path'] != null));
        update_option ('ecu_display_images_as_links',
            (int) ($_POST['display_images_as_links'] != null));
        if (isset($_POST['max_file_size'])
            && preg_match ('/[0-9]+/', $_POST['max_file_size'])
            && $_POST['max_file_size'] >= 0)
            update_option ('ecu_max_file_size', $_POST['max_file_size']);
        if (isset($_POST['upload_files_uploads_per_hour'])
            && preg_match ('/[-]?[0-9]+/', $_POST['upload_files_uploads_per_hour'])
            && $_POST['upload_files_uploads_per_hour'] >= -1)
            $uploads_per_hour = get_option('ecu_uploads_per_hour');
            $uploads_per_hour['upload_files'] = $_POST['upload_files_uploads_per_hour'];
            update_option('ecu_uploads_per_hour', $uploads_per_hour);
        if (isset($_POST['edit_posts_uploads_per_hour'])
            && preg_match ('/[-]?[0-9]+/', $_POST['edit_posts_uploads_per_hour'])
            && $_POST['edit_posts_uploads_per_hour'] >= -1)
            $uploads_per_hour = get_option('ecu_uploads_per_hour');
            $uploads_per_hour['edit_posts'] = $_POST['edit_posts_uploads_per_hour'];
            update_option('ecu_uploads_per_hour', $uploads_per_hour);
        if (isset($_POST['read_uploads_per_hour'])
            && preg_match ('/[-]?[0-9]+/', $_POST['read_uploads_per_hour'])
            && $_POST['read_uploads_per_hour'] >= -1)
            $uploads_per_hour = get_option('ecu_uploads_per_hour');
            $uploads_per_hour['read'] = $_POST['read_uploads_per_hour'];
            update_option('ecu_uploads_per_hour', $uploads_per_hour);
        if (isset($_POST['none_uploads_per_hour'])
            && preg_match ('/[-]?[0-9]+/', $_POST['none_uploads_per_hour'])
            && $_POST['none_uploads_per_hour'] >= -1)
            $uploads_per_hour = get_option('ecu_uploads_per_hour');
            $uploads_per_hour['none'] = $_POST['none_uploads_per_hour'];
            update_option('ecu_uploads_per_hour', $uploads_per_hour);
        if (isset($_POST['enabled_pages'])
            && preg_match('/^(all)|(([0-9]+ )*[0-9]+)$/', $_POST['enabled_pages']))
            update_option('ecu_enabled_pages', $_POST['enabled_pages']);
        if (isset($_POST['enabled_pages'])
            && preg_match('/^([1-9][0-9]*)?$/', $_POST['enabled_category']))
            update_option('ecu_enabled_category', $_POST['enabled_category']);
        if (isset($_POST['file_extension_blacklist'])
            && $_POST['file_extension_blacklist'] != implode(', ',
                ecu_get_blacklist())
            && preg_match('/^[a-z0-9]+([, ][ ]*[a-z0-9]+)*$/i',
            $_POST['file_extension_blacklist']))
            if ($_POST['file_extension_blacklist'] == 'default')
                delete_option('ecu_file_extension_blacklist');
            else if ($_POST['file_extension_blacklist'] == 'none')
                update_option('ecu_file_extension_blacklist', array());
            else update_option('ecu_file_extension_blacklist',
                preg_split("/[, ][ ]*/", $_POST['file_extension_blacklist']));
        if (isset($_POST['file_extension_whitelist'])
            && preg_match('/^[a-z0-9]+([, ][ ]*[a-z0-9]+)*$/i',
            $_POST['file_extension_whitelist']))
            if ($_POST['file_extension_whitelist'] == 'default')
                delete_option('ecu_file_extension_whitelist');
            else if ($_POST['file_extension_whitelist'] == 'ignore')
                update_option('ecu_file_extension_whitelist', array());
            else update_option('ecu_file_extension_whitelist',
                preg_split("/[, ][ ]*/", $_POST['file_extension_whitelist']));
        if (isset($_POST['upload_form_text']))
            update_option('ecu_message_text', $_POST['upload_form_text']);
        if (isset($_POST['upload_dir_path']))
            if ($_POST['upload_dir_path'] == '')
                delete_option('ecu_upload_dir_path');
            else
                update_option('ecu_upload_dir_path', $_POST['upload_dir_path']);

        // Inform user
        echo '<div id="message" class="updated fade"><p>'
            . 'Comment Uploads options saved.'
            . '</p></div>';
    }

    update_user_meta(get_current_user_id(), 'ecu_test', 'test');

    // Store current values for fields
    $images_only = (get_option('ecu_images_only')) ? 'checked' : '';
    $hide_comment_form = (get_option('ecu_hide_comment_form') ? 'checked' : '');
    $show_full_file_path = (get_option('ecu_show_full_file_path') ? 'checked' : '');
    $display_images_as_links = (get_option('ecu_display_images_as_links') ? 'checked' : '');
    $premission_required = array();
    foreach (array('none', 'read', 'edit_posts', 'upload_files') as $elem)
        $permission_required[] =
            ((get_option('ecu_permission_required') == $elem) ? 'checked' : '');
    $max_file_size = get_option('ecu_max_file_size');
    $enabled_pages = get_option('ecu_enabled_pages');
    $enabled_category = get_option('ecu_enabled_category');
    $file_extension_blacklist = ecu_get_blacklist() ?
        implode(', ', ecu_get_blacklist()) : 'none';
    $file_extension_whitelist = ecu_get_whitelist() ?
        implode(', ', ecu_get_whitelist()) : 'ignore';
    $uploads_per_hour = get_option('ecu_uploads_per_hour');
    $upload_form_text = ecu_message_text();
    $upload_dir_path = get_option('ecu_upload_dir_path');

    // Info for form
    $actionurl = $_SERVER['REQUEST_URI'];
    $nonce_field = wp_nonce_field('easy-comment-uploads');
	
	//translations
	$translation_1 = __("Only allow images to be uploaded.");
	$translation_2 = __("Limit the size of uploaded files:");
	$translation_3 = __("Limit the size of uploaded files:");
	$translation_4 = __("Blacklist the following file extensions:");
	$translation_5 = __("Allow only the following file extensions:");
	$translation_6 = __("Store uploads in folder:");
	$translation_7 = __("User Permissions");
	$translation_8 = __("(KiB, 0 = unlimited)");
	$translation_9 = __("(extensions seperated with spaces, 'none' to allow all (not recommended), or 'default' to restore the default list)");
	$translation_10 = __("(extensions seperated with spaces, 'ignore' to disable the whitelist, or 'default' to restore the default list)");
	$translation_11 = __("(path relative to the Wordpress installation directory or leave blank for default location)");
	$translation_12 = __("Allow all users to upload files with their comments.");
	$translation_13 = __("Only allow registered users to upload files.");
	$translation_14 = __("Require 'Contributor' rights to upload files.");
	$translation_15 = __("Require 'Upload' rights to uploads files (e.g. only admin, editors and authors).");
	$translation_16 = __("Uploads allowed per hour <br /><em>(-1 = unlimited)</em>");
	$translation_17 = __("users with upload rights <br /><em>(e.g. only admin, editors and authors)</em>");
	$translation_18 = __("contributors");
	$translation_19 = __("registered users");
	$translation_20 = __("unregistered users");
	$translation_21 = __("Upload Form");
	$translation_22 = __("Text moved to language.php");
	$translation_23 = __("Hide from comment forms");
	$translation_24 = __("(<a href= 'http://www.wprecipes.com/how-to-find-wordpress-category-id'>category id</a> or leave blank to enable globally)");
	$translation_25 = __("Only allow uploads on these pages:");
	$translation_26 = __("(<a href='http://www.techtrot.com/wordpress-page-id/'>page_ids</a> seperated with spaces or 'all' to enable globally)");
	$translation_27 = __("Show full url in links to files");
	$translation_28 = __("Replace images with links");
	$translation_29 = __("Save Changes");
	$translation_30 = __("<h2>Easy Comment Uploads</h2><a href='http://goo.gl/WFJP6' target='_blank' style='text-decoration: none'><p id='ecu_donate' style='background-color: #757575; padding: 0.5em; color: white; font-weight: bold; text-align: center; font-size: 11pt; border-radius: 10px'>If you find this plugin useful and want to support its future development, please consider donating.<input type='submit' class='button-primary' style='margin-left: 1em' name='donate' value='Donate' /></p></a>");
	
	

    echo <<<END
        <div class="wrap" style="max-width:950px !important;">
       $translation_30

        <form name="ecuform" action="$action_url" method="post">
            <input type="hidden" name="submitted" value="1" />
            $nonce_field

            <h3>Files</h3>

            <ul>$translation_2
            <li><input id="images_only" type="checkbox" name="images_only" $images_only />
            <label for="images_only">$translation_1</label></li>
            </p>

            <li>$translation_3
            <input id="max_file_size" type="text" name="max_file_size" value="$max_file_size" />
            <label for="max_file_size">$translation_8</label></li>

            <li>$translation_4 
            <input id="file_extenstion_blacklist" type="text" name="file_extension_blacklist" value="$file_extension_blacklist" />
            <br />
            <label for="file_extenstion_blacklist">$translation_9</label>
            </li>

            <li>$translation_5 
            <input id="file_extenstion_whitelist" type="text" name="file_extension_whitelist" value="$file_extension_whitelist" />
            <br />
            <label for="file_extension_whitelist">$translation_10</label>
            </li>
            
            <li>$translation_6 
            <input id="upload_dir_path" type="text" name="upload_dir_path" value="$upload_dir_path" />
            <br />
            <label for="file_extension_whitelist">$translation_11</label>
            </li>
            </ul>

            <h3>$translation_7</h3>
            <ul>
            <li><input id="all_users" type="radio" name="permission_required" value="none" $permission_required[0] />
            <label for="all_users">$translation_12</label></li>

            <li><input id="registered_users_only" type="radio" name="permission_required"
                value="read" $permission_required[1] />
            <label for="registered_users_only">$translation_13</label></li>

            <li><input id="edit_rights_only" type="radio" name="permission_required"
                value="edit_posts" $permission_required[2] />
            <label for="edit_rights_only">$translation_14</label></li>

            <li><input id="upload_rights_only" type="radio" name="permission_required"
                value="upload_files" $permission_required[3] />
            <label for="upload_rights_only">$translation_15</label></li>
                
            <br />

            <li><table class="widefat">
                <tr>
                    <th></th>
                    <th>$translation_16</th>
                </tr>
                <tr>
                    <th>$translation_17</th>
                    <td><input id="upload_files_uploads_per_hour" type="text" name="upload_files_uploads_per_hour" value="$uploads_per_hour[upload_files]" /></td>
                </tr>
                <tr>
                    <th>$translation_18</th>
                    <td><input id="edit_posts_uploads_per_hour" type="text" name="edit_posts_uploads_per_hour" value="$uploads_per_hour[edit_posts]" /></td>
                </tr>
                <tr>
                    <th>$translation_19</th>
                    <td><input id="read_uploads_per_hour" type="text" name="read_uploads_per_hour" value="$uploads_per_hour[read]" /></td>
                </tr>
                <tr>
                    <th>$translation_20</th>
                    <td><input id="none_uploads_per_hour" type="text"
                    name="none_uploads_per_hour"
                    value="$uploads_per_hour[none]" /></td>
                </tr>
            </table></li>
            </ul>

            <h3>$translation_21</h3>
            <ul>
            <li>
                <label for="upload_form_text">
                    Text explaining use of the upload form (leave blank for
                    default text):
                </label>
                <br />
                <textarea id="upload_form_text" disabled="disabled" name="upload_form_text"
                    style="width : 100%; height : 65pt"
                    >$translation_22</textarea>
            </li>

            <li>
                <input id="hide_comment_form" type="checkbox"
                name="hide_comment_form" $hide_comment_form />
                <label for="hide_comment_form">$translation_23
            </li>
            
            <li>
                Only allow uploads in this category:
                <input id="enabled_category" type="text"
                name="enabled_category" value="$enabled_category" />
                <br />
                <label for="enabled_category">$translation_24
                
                </label>
            </li>
            
            <li>
                $translation_25
                <input id="enabled_pages" type="text" name="enabled_pages"
                value="$enabled_pages" />
                <br />
                <label for="enabled_pages">$translation_26
                </label>
            </li>
            </ul>

            <h3>Comments</h3>
            <ul>
            <li>
                <input id="show_full_file_path" type="checkbox"
                name="show_full_file_path" $show_full_file_path />
                <label for="show_full_file_path">
                    $translation_27
                </label>
            </li>
            
            <li>
                <input id="display_images_as_links" type="checkbox"
                name="display_images_as_links" $display_images_as_links />
                <label for="display_images_as_links">
                    $translation_28
                </label>
            </li>
            </ul>

            <p class="submit"><input type="submit" class="button-primary"
            name="Submit" value="$translation_29" /></p>
        </form>
END;

    // Sample upload form
    echo "
    <div style='margin : auto auto auto 2em; width : 40em;
     background-color : ghostwhite; border : 1px dashed gray;
     padding : 0 1em 0em 1em'>
    ";
    ecu_upload_form_default(false);
    echo "</div>";
}

function ecu_upload_dir_path() {
    if (get_option('ecu_upload_dir_path')) {
        return ecu_wordpress_root_path() . get_option('ecu_upload_dir_path')  . '/';
    } else {
        $upload_dir = wp_upload_dir();
        return $upload_dir['path'] . '/';                
    }
}

function ecu_upload_dir_url() {
    if (get_option('ecu_upload_dir_path')) {
        return get_option('siteurl') . '/' . get_option('ecu_upload_dir_path') . '/';
    } else {
        $upload_dir = wp_upload_dir();
        return $upload_dir['url'] . '/';        
    }
}

// Seperate function as closures were not supported before 5.3.0
function ecu_extract_cat_ID($category) {
    return $category->cat_ID;
}

// Are uploads allowed?
function ecu_allow_upload() {
    global $post;
    $permission_required = get_option('ecu_permission_required');
    $enabled_pages = get_option('ecu_enabled_pages');
    $enabled_category = get_option('ecu_enabled_category');
    $categories = array_map('ecu_extract_cat_ID', get_the_category());

    return ($permission_required == 'none'
        || current_user_can($permission_required))
        && (in_array($post->ID, explode(' ', $enabled_pages))
            || $enabled_pages == 'all')
        && (in_array($enabled_category, $categories)
            || $enabled_category == '');
}

// Set options to defaults, if not already set
function ecu_initial_options() {
    ecu_textdomain();
    
    wp_enqueue_style('ecu', ecu_plugin_url () . 'style.css');
    if (get_option('ecu_permission_required') === false)
        update_option('ecu_permission_required', 'none');
    if (get_option('ecu_show_full_file_path') === false)
        update_option('ecu_show_full_file_path', 0);
    if (get_option('ecu_display_images_as_links') === false)
        update_option('ecu_display_images_as_links', 0);
    if (get_option('ecu_hide_comment_form') === false)
        update_option('ecu_hide_comment_form', 0);
    if (get_option('ecu_images_only') === false)
        update_option('ecu_images_only', 0);
    if (get_option('ecu_max_file_size') === false)
        update_option('ecu_max_file_size', 0);
    if (get_option('ecu_enabled_pages') === false)
        update_option('ecu_enabled_pages', 'all');
    if (get_option('ecu_enabled_category') === false)
        update_option('ecu_enabled_category', '');
    if (get_option('ecu_ip_upload_times') === false)
        update_option('ecu_ip_upload_times', array());
    if (get_option('ecu_message_text') === false)
        update_option('ecu_message_text', '');
    if (get_option('ecu_uploads_per_hour') === false)
        update_option('ecu_uploads_per_hour', array(
                'upload_files' => -1,
                'edit_posts' => 50,
                'read' => 10,
                'none' => 5,
            ));
}

// Set textdomain for translations (i18n)
function ecu_textdomain() {
    load_plugin_textdomain('easy-comment-uploads', false,
        basename(dirname(__FILE__)) . '/languages');
}

// Register code with wordpress
add_action('admin_menu', 'ecu_options_menu');
add_filter('comment_text', 'ecu_insert_links');
if (!get_option('ecu_hide_comment_form'))
    add_action('comment_form', 'ecu_upload_form_default');
add_action('init', 'ecu_initial_options');
