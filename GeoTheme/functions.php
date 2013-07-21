<?php 
function gt_check_sessions(){
// Set error reporting to display all errors and notices
error_reporting(E_ALL);
// Start a session
session_start();
// Check for the existence of a known session variable
if ( $_SESSION['test_value'] ) {
  echo 'Found a session';
} else {
  echo 'No session exists - writing to test_value, refresh to check.';
  $_SESSION['test_value'] = true;
}
// Close and write session
session_write_close();
$foldername = session_save_path();
if (is_writable($foldername)) {
    echo '<br>The Sessions folder is writable';
} else {
    echo '<br>The Sessions folder is not writable';
}
exit;	
}
if($_REQUEST['gt_check_sessions']){gt_check_sessions();}
//print_r(wp_get_schedules());
//echo wp_get_schedule( 'my_task_hook' );
$child_dir =  get_stylesheet_directory();
$child_fn_dir = get_stylesheet_directory() . '/library/functions/';
if (file_exists($child_dir.'/child.txt')) {
    $ct_on=1;
} else{$ct_on=0;}
/*************************************************************
* Do not modify unless you know what you're doing, SERIOUSLY!
*************************************************************/
//error_reporting(E_ALL);
error_reporting(E_ERROR);
//date_default_timezone_set('Europe/London'); // Use this to set your tiem zone if wordpress is messing it up, STIOFAN
define('TAGKW_TEXT_COUNT',40);
load_theme_textdomain('default');
//load_textdomain( 'default', TEMPLATEPATH.'/en_US.mo' );
// This theme uses post thumbnails
if(!strstr($_SERVER['REQUEST_URI'],'/wp-admin/')){
if($ct_on && file_exists($child_dir.'/library/js/add_js.php')){include_once ($child_dir.'/library/js/add_js.php');}
else{include_once (TEMPLATEPATH . '/library/js/add_js.php');}// add javascript to the head
}
add_theme_support( 'post-thumbnails' );
// Add default posts and comments RSS feed links to head
add_theme_support( 'automatic-feed-links' );
global $blog_id;
if(get_option('upload_path') && !strstr(get_option('upload_path'),'wp-content/uploads'))
{
$upload_folder_path = "wp-content/blogs.dir/$blog_id/files/";
}else
{
$upload_folder_path = "wp-content/uploads/";
}
global $blog_id;
if($blog_id){ $thumb_url = "&amp;bid=$blog_id";}
if ( function_exists( 'add_theme_support' ) ){
add_theme_support( 'post-thumbnails' );
}
##############################	WEE FUNCTION TO GET FEATURED IMAGE URL
function get_the_post_thumbnail_src($img)
{
  return (preg_match('~\bsrc="([^"]++)"~', $img, $matches)) ? $matches[1] : '';
}

function get_cat_icon($cat_id)
{
  $term_icon_url = get_tax_meta($cat_id,'ct_cat_icon');
if($term_icon_url){return $term_icon_url['src'];}else{return get_bloginfo('template_directory').'/library/map/icons/pin.png';}
}

if (!function_exists('get_post_default_img')) {
function get_post_default_img($pots_id,  $taxonomy)
{	$cat_id_arr = get_the_terms( $post_id, $taxonomy.'category' );
$cat_id ='';
$cat_default_img = '';
foreach($cat_id_arr as $cats){
	$cat_id = $cats->term_id;
	if(get_tax_meta($cat_id,'ct_cat_default_img') && $cats->parent!='0'){$cat_default_img = get_tax_meta($cat_id,'ct_cat_default_img');}
	elseif(!$cat_default_img && get_tax_meta($cat_id,'ct_cat_default_img')){$cat_default_img = get_tax_meta($cat_id,'ct_cat_default_img');}
}
	if($cat_default_img){return $cat_default_img['src'];}else{return get_bloginfo('template_url').'/images/no-image.jpg';}
	
}}

if (!function_exists('get_post_cat_icon')) {
function get_post_cat_icon($pots_id,  $taxonomy)
{	$cat_id_arr = get_the_terms( $post_id, $taxonomy.'category' );
$cat_id ='';
$cat_default_img = '';
foreach($cat_id_arr as $cats){
	$cat_id = $cats->term_id;
	if(get_tax_meta($cat_id,'ct_cat_icon') && $cats->parent!='0'){$cat_default_img = get_tax_meta($cat_id,'ct_cat_icon');}
	elseif(!$cat_default_img && get_tax_meta($cat_id,'ct_cat_icon')){$cat_default_img = get_tax_meta($cat_id,'ct_cat_icon');}
}
	if($cat_default_img){return $cat_default_img['src'];}else{return get_bloginfo('template_directory').'/library/map/icons/pin.png';}
	
}}

##############################	WEE FUNCTION TO GET FEATURED IMAGE URL
### Rating Logs Table Name
global $wpdb;
$price_db_table_name = $wpdb->prefix . "price";
$rating_table_name = $wpdb->prefix.'ratings';
if($ct_on && file_exists($child_dir."/product_menu.php")){require ($child_dir. "/product_menu.php");}
else{require (TEMPLATEPATH . "/product_menu.php");}
if(get_option('ptthemes_captcha_dislay')=='No'){}else
{
if($ct_on && file_exists($child_dir.'/library/captcha/captcha_function.php')){include_once ($child_dir. '/library/captcha/captcha_function.php');}
else{include_once (TEMPLATEPATH . '/library/captcha/captcha_function.php');}
}
if($ct_on && file_exists($child_dir.'/language.php')){include_once ($child_dir.'/language.php');}
else{include_once (TEMPLATEPATH . '/language.php');}
if($ct_on && file_exists($child_dir.'/library/includes/post_custom_settings.php')){include_once ($child_dir.'/library/includes/post_custom_settings.php');}
else{include_once (TEMPLATEPATH . '/library/includes/post_custom_settings.php');}// custom fields settings + database settings
if($ct_on && file_exists($child_dir.'/library/includes/post_custom_fields.php')){include_once ($child_dir.'/library/includes/post_custom_fields.php');}
else{include_once (TEMPLATEPATH . '/library/includes/post_custom_fields.php');}// custom fields HTML Tag coding
// Theme variables
if($ct_on && file_exists($child_dir.'/library/functions/theme_variables.php')){include_once ($child_dir.'/library/functions/theme_variables.php');}
else{include_once (TEMPLATEPATH . '/library/functions/theme_variables.php');}
// DB Checks First
if($ct_on && file_exists($child_fn_dir.'db_checks.php')){include_once ($child_fn_dir.'db_checks.php');}
else{include_once ($functions_path . 'db_checks.php');}
//** ADMINISTRATION FILES **//
if($ct_on && file_exists($child_fn_dir.'multi_city_functions.php')){include_once ($child_fn_dir.'multi_city_functions.php');}
else{include_once ($functions_path . 'multi_city_functions.php');}


//custom post type
### START FUNCTION FO GET CLEAN CITY NAME
if (!function_exists('city_name_url')) {
function city_name_url($city_id) {
	global $wpdb,$multicity_db_table_name;
		$spec_arr = array(
    'Š'=>'S', 'š'=>'s', 'Ð'=>'Dj','Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 
    'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 
    'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 
    'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss','à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 
    'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 
    'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 
    'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', 'ƒ'=>'f'
);
		if($wpdb->get_var("select city_slug from $multicity_db_table_name where  city_id=\"$city_id\""))
	    {$city = $wpdb->get_var("select city_slug from $multicity_db_table_name where  city_id=\"$city_id\"");}else
	    {$city = $wpdb->get_var("select cityname from $multicity_db_table_name where  city_id=\"$city_id\"");}
		$city = utf8_decode($city);
		$city = strtr($city, $spec_arr);
		$city = strtolower ($city);
		$city = str_replace(" ", "-", $city);
		return $city;
		
			}}
### END FUNCTION FO GET CLEAN CITY NAME
if($ct_on && file_exists($child_dir.'/library/functions/custom_post_type.php')){include_once ($child_dir.'/library/functions/custom_post_type.php');}
else{include_once (TEMPLATEPATH . '/library/functions/custom_post_type.php');}
// Theme admin functions
if($ct_on && file_exists($child_fn_dir.'admin_functions.php')){include_once ($child_fn_dir.'admin_functions.php');}
else{include_once ($functions_path . 'admin_functions.php');}
if(strstr($_SERVER['REQUEST_URI'],'/wp-admin/')){ // hide all the code we dont need on the front end.
// Theme admin options
if($ct_on && file_exists($child_fn_dir.'admin_options.php')){include_once ($child_fn_dir.'admin_options.php');}
else{include_once ($functions_path . 'admin_options.php');}
// User Profiles Options
if($ct_on && file_exists($child_fn_dir.'user_profile.php')){include_once ($child_fn_dir.'user_profile.php');}
else{include_once ($functions_path . 'user_profile.php');}
// Theme Activation Setup
if($ct_on && file_exists($child_fn_dir.'activation_function.php')){include_once ($child_fn_dir.'activation_function.php');}
else{include_once ($functions_path . 'activation_function.php');}
// App setting page
//if($ct_on && file_exists($child_dir.'/app/admin_settings.php')){include_once ($child_dir.'/app/admin_settings.php');}
//else{include_once (TEMPLATEPATH . '/app/admin_settings.php');}
}/////////////////////////////////////////////////////////////// END HIDE FRONT END
// Code to add meta info to categories
if($ct_on && file_exists($child_dir.'/library/cat-meta/cat_meta.php')){include_once ($child_dir.'/library/cat-meta/cat_meta.php');}
else{include_once (TEMPLATEPATH . '/library/cat-meta/cat_meta.php');}// custom fields HTML Tag coding
// Theme admin Settings
if($ct_on && file_exists($child_fn_dir.'admin_settings.php')){include_once ($child_fn_dir.'admin_settings.php');}
else{include_once ($functions_path . 'admin_settings.php');}
//** FRONT-END FILES **//
// Widgets
if($ct_on && file_exists($child_fn_dir.'widgets_functions.php')){include_once ($child_fn_dir.'widgets_functions.php');}
else{include_once ($functions_path . 'widgets_functions.php');}
// Custom
if($ct_on && file_exists($child_fn_dir.'custom_functions.php')){include_once ($child_fn_dir.'custom_functions.php');}
else{include_once ($functions_path . 'custom_functions.php');}
// Comments
if($ct_on && file_exists($child_fn_dir.'comments_functions.php')){include_once ($child_fn_dir.'comments_functions.php');}
else{include_once ($functions_path . 'comments_functions.php');}
if($ct_on && file_exists($child_dir.'/library/breadcrumb-navxt/breadcrumb_navxt_admin.php')){include_once ($child_dir.'/library/breadcrumb-navxt/breadcrumb_navxt_admin.php');}
else{include_once (TEMPLATEPATH . '/library/breadcrumb-navxt/breadcrumb_navxt_admin.php');}
if($ct_on && file_exists($child_fn_dir.'image_resizer.php')){include_once ($child_fn_dir.'image_resizer.php');}
else{include_once ($functions_path . 'image_resizer.php');}
if($ct_on && file_exists($child_dir.'/library/rating/post_rating.php')){include_once ($child_dir.'/library/rating/post_rating.php');}
else{include_once (TEMPLATEPATH . '/library/rating/post_rating.php');}
//Listing filters type
if($ct_on && file_exists($child_dir.'/library/functions/listing_filters.php')){include_once ($child_dir.'/library/functions/listing_filters.php');}
else{include_once (TEMPLATEPATH . '/library/functions/listing_filters.php');}
//** CUSTOM ADDED FUNTIONS **//
// RSS Images 
if($ct_on && file_exists($child_fn_dir.'rss_images.php')){include_once ($child_fn_dir.'rss_images.php');}
else{include_once ($functions_path . 'rss_images.php');}

// LINK EVENT TO BUSINESS
if($ct_on && file_exists($child_fn_dir.'link_event.php')){include_once ($child_fn_dir.'link_event.php');}
else{include_once ($functions_path . 'link_event.php');}
// RECURRING EVENTS
if($ct_on && file_exists($child_fn_dir.'recurring_event.php')){include_once ($child_fn_dir.'recurring_event.php');}
else{include_once ($functions_path . 'recurring_event.php');}
// COMMENTS EDITOR
if($ct_on && file_exists($child_dir.'/library/comments/wp-ajax-edit-comments.php')){include_once ($child_dir.'/library/comments/wp-ajax-edit-comments.php');}
else{include_once (TEMPLATEPATH . '/library/comments/wp-ajax-edit-comments.php');}
// COMMENTS UPLOAD
if($ct_on && file_exists($child_dir.'/library/comment-uploads/main.php')){include_once ($child_dir.'/library/comment-uploads/main.php');}
else{include_once (TEMPLATEPATH . '/library/comment-uploads/main.php');}
//theme.php
if (!function_exists('autoinstall_admin_header')) {
function autoinstall_admin_header()
{
global $wpdb,$ct_on;
if(strstr($_SERVER['REQUEST_URI'],'themes.php') && $_REQUEST['template']=='' && $_GET['page']=='') 
{
if($_REQUEST['dummy']=='del')
{
delete_dummy_data();	
$dummy_deleted = '<p><b>All Dummy data has been removed from your database successfully!</b></p>';
}
if($_REQUEST['dummy_insert'])
{
if($ct_on && file_exists($child_dir.'/auto_install.php')){include_once ($child_dir.'/auto_install.php');}
else{include_once (TEMPLATEPATH . '/auto_install.php');}
}
if($_REQUEST['activated']=='true')
{
$theme_actived_success = '<p class="message">Theme activated successfully.</p>';	
}
$post_counts = $wpdb->get_var("select count(post_id) from $wpdb->postmeta where (meta_key='pt_dummy_content' || meta_key='tl_dummy_content') and meta_value=1");
if($post_counts>0)
{
$dummy_data_msg = '<p> <b>Sample data has been populated on your site. Wish to delete sample data?</b><br />If you have problem with image, please copy images/dummy folder to wp-content/uploads <br />  <a class="button_delete" href="#" onclick="return delete_dummy();">Yes Delete Please!</a><p>';
?>
<script type='text/javascript'>
function delete_dummy()
{
	if(confirm('<?php _e('Are you sure you want to delete dummy data? You will lose your current widget setup.');?>'))
	{
		window.location.href="<?php echo site_url().'/wp-admin/themes.php?dummy=del'?>";
		return true;
	}else
	{
		return false;
	}
}
</script>
<?php
}else
{
$dummy_data_msg = '<p> <b>Would you like to auto install this theme and populate sample data on your site?</b> <br />  <a class="button_insert" href="'.site_url().'/wp-admin/themes.php?dummy_insert=1">Yes, insert sample data please</a></p>';
}
define('THEME_ACTIVE_MESSAGE','
<style>
.highlight { width:60% !important; background:#FFFFE0 !important; overflow:hidden; display:table; border:2px solid #558e23 !important; padding:15px 20px 0px 20px !important; -moz-border-radius:11px  !important;  -webkit-border-radius:11px  !important; } 
.highlight p { color:#444 !important; font:15px Arial, Helvetica, sans-serif !important; text-align:center;  } 
.highlight p.message { font-size:13px !important; }
.highlight p a { color:#ff7e00; text-decoration:none !important; } 
.highlight p a:hover { color:#000; }
.highlight p a.button_insert 
{ display:block; width:230px; margin:10px auto 0 auto;  background:#5aa145; padding:10px 15px; color:#fff; border:1px solid #4c9a35; -moz-border-radius:5px;  -webkit-border-radius:5px;  } 
.highlight p a:hover.button_insert { background:#347c1e; color:#fff; border:1px solid #4c9a35;   } 
.highlight p a.button_delete 
{ display:block; width:140px; margin:10px auto 0 auto; background:#dd4401; padding:10px 15px; color:#fff; border:1px solid #9e3000; -moz-border-radius:5px;  -webkit-border-radius:5px;  } 
.highlight p a:hover.button_delete { background:#c43e03; color:#fff; border:1px solid #9e3000;   } 
#message0 { display:none !important;  }
</style>
<div class="updated highlight fade"> '.$theme_actived_success.$dummy_deleted.$dummy_data_msg.'</div>');
echo THEME_ACTIVE_MESSAGE;
if($ct_on && get_option('ptthemes_alt_stylesheet')!='none'){
	echo '<div class="updated highlight fade">Looks like you have a child theme running, you should set your skin to "none" <a href="'.site_url().'/wp-admin/admin.php?page=theme_settings"> HERE</a></div>';}

}
}
}
add_action("admin_head", "autoinstall_admin_header"); // please comment this line if you wish to DEACTIVE SAMPLE DATA INSERT.
#####################################################################################################################################################
if (!function_exists('user_warning_msg')) {
function user_warning_msg()
{
global $wpdb;
if(is_allow_user_register())
{
if($wpdb->get_var("select option_value from $wpdb->options  WHERE option_name='default_role'") != 'author')
{
echo '<br><br><div style="background-color:#F00;color:#FFF;font-size:18px;height:60px;width:100%; text-align:center;">User role must be set to Author for correct user permissions to apply!<br />Settings>General>New User Default Role> SET TO "Author"<br />Please also check your current user roles</div>';
}
}	
}
}
if (!function_exists('user_check')) {
function user_check()
{
global $wpdb;
if(get_option('is_allow_user') == '0')
{
if ( is_user_logged_in() ) 
{ 
if( current_user_can( 'manage_options' ) ) {}
else{  wp_redirect( home_url() ); exit; }			
}
}
}
}
add_action("admin_head", "user_warning_msg"); // check if default user is set to Author
add_action("admin_head", "user_check"); // check user is admin
###########################################################################################################################################
if (!function_exists('delete_dummy_data')) {
function delete_dummy_data()
{
global $wpdb;
//delete_option('sidebars_widgets'); //delete widgets
$productArray = array();
$pids_sql = "select p.ID from $wpdb->posts p join $wpdb->postmeta pm on pm.post_id=p.ID where (meta_key='pt_dummy_content' || meta_key='tl_dummy_content') and meta_value=1";
$pids_info = $wpdb->get_results($pids_sql);
foreach($pids_info as $pids_info_obj)
{
wp_delete_post($pids_info_obj->ID);
}
}
}



############create random string ##################
if (!function_exists('createRandomString')) {
function createRandomString() { 
$chars = "abcdefghijkmlnopqrstuvwxyz1023456789"; 
srand((double)microtime()*1000000); 
$i = 0; 
$rstring = '' ; 
while ($i <= 25) { 
$num = rand() % 33; 
$tmp = substr($chars, $num, 1); 
$rstring = $rstring . $tmp; 
$i++; 
} 
return $rstring; 
} 
}
############ End create random string ###############

/////////////////PLACE EXPIRY SETTINGS CODING START/////////////////
if (!function_exists('place_expire_check')) {
function place_expire_check(){
global $table_prefix, $wpdb,$price_db_table_name;
$table_name = $table_prefix . "place_expire_session";
$current_date = date('Y-m-d');
if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name)
{
//global $table_prefix, $wpdb,$table_name;
//$sql = 'DROP TABLE `' . $table_name . '`';  // drop the existing table
$wpdb->query($sql);
$sql = 'CREATE TABLE `'.$table_name.'` (
`session_id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`execute_date` DATE NOT NULL ,
`is_run` TINYINT( 4 ) NOT NULL DEFAULT "0"
) ENGINE = MYISAM ;';
$wpdb->query($sql);
$wpdb->query("insert into $table_name (session_id,execute_date,is_run) values ('1',\"$current_date\",'1')");
//$rc_run_once = '1';
}
if($wpdb->get_var("SELECT COUNT(*) FROM $table_name") == '0')
{   $wpdb->query("insert into $table_name (session_id,execute_date,is_run) values ('1',\"$current_date\",'1')"); $rc_run_once = '1';}
$today_executed = $wpdb->get_var("select is_run from $table_name where datediff(\"$current_date\",date_format(execute_date,'%Y-%m-%d')) > 0");
//$rc_run_once = '1';
if($today_executed && $today_executed>0 || $rc_run_once)
{
if(get_option('ptthemes_listing_expiry_disable'))
{
if(get_option('ptthemes_listing_preexpiry_notice_disable'))
{
$number_of_grace_days = get_option('ptthemes_listing_preexpiry_notice_days');
if($number_of_grace_days=='')
{
$number_of_grace_days=1;	
}

$today = date('Y-m-d', strtotime("+".$number_of_grace_days." days"));
//echo $today;
$postid_str = $wpdb->get_results("select pm.meta_value, p.ID,p.post_author, p.post_title from $wpdb->posts p join $wpdb->postmeta pm on pm.post_id=p.ID where (p.post_type='place' or p.post_type='event') AND  meta_key='expire_date' AND meta_value!='Never' AND meta_value!='' AND meta_value='".$today."' ");

foreach($postid_str as $postid_str_obj)
{ 
clientEmail($postid_str_obj->ID,$postid_str_obj->post_author,'expiration'); // send expiration email
}
}


############################################# SET THE NEW PACKAGE OR SET AS DRAFT #######################################
$today = date('Y-m-d');
$postid_str = $wpdb->get_results("select pm.meta_value, p.ID,p.post_author, p.post_title from $wpdb->posts p join $wpdb->postmeta pm on pm.post_id=p.ID where (p.post_type='place' or p.post_type='event') AND  meta_key='expire_date' AND meta_value!='Never' AND meta_value!='' AND meta_value<='".$today."' ");

foreach($postid_str as $postid_str_obj)
{ 
$downgrade_pkg_num='';
$downgrade_pkg_num = $wpdb->get_var("SELECT downgrade_pkg FROM $price_db_table_name where pid=(SELECT meta_value FROM $wpdb->postmeta where meta_key='package_pid' and post_id=$postid_str_obj->ID )");

if($downgrade_pkg_num!=0){
$downgrade_pkg = array();
$downgrade_pkg = $wpdb->get_row("SELECT * FROM $price_db_table_name where pid=$downgrade_pkg_num");
//print_r($downgrade_pkg);	
$pkg_days = $downgrade_pkg->days;
if($downgrade_pkg->days=='0' || $downgrade_pkg->days==''){$expire_date = 'Never';}
else{$expire_date = date('Y-m-d', strtotime("+".$pkg_days." days"));}	
$wpdb->query("update $wpdb->postmeta set meta_value=\"$downgrade_pkg_num\" where meta_key='package_pid' and post_id=$postid_str_obj->ID");
$wpdb->query("update $wpdb->postmeta set meta_value=\"$downgrade_pkg->is_featured\" where meta_key='is_featured' and post_id=$postid_str_obj->ID");
$wpdb->query("update $wpdb->postmeta set meta_value=\"$expire_date\" where meta_key='expire_date' and post_id=$postid_str_obj->ID");

		### DOWNGRADE THE NUMBER OF CATEGORYS ###
		if($downgrade_pkg->cat_limit!=''){
		if($postid_str_obj->post_type =='event'){$post_tax ='eventcategory';}else{$post_tax ='placecategory';}
		$terms = wp_get_post_terms($postid_str_obj->ID, $post_tax, array("fields" => "all"));
		//print_r($terms);exit;
		$term_ids = array();
		foreach($terms as $termsObj){
		if($termsObj->parent==0){
		$term_ids[] = $termsObj->term_id;
		}
		}
		$cat_arr = array_slice($term_ids, 0, $downgrade_pkg->cat_limit);
		$term_ids = implode(",", $cat_arr);
		wp_set_post_terms( $postid_str_obj->ID, $term_ids, $post_tax, false ); 
		}// end cat limit
		### END DOWNGRADE THE NUMBER OF CATEGORYS ###

}else{
$listing_ex_status = get_option('ptthemes_listing_ex_status');
if($listing_ex_status=='')
{$listing_ex_status = 'draft';}
$wpdb->query("update $wpdb->posts set post_status=\"$listing_ex_status\" where ID=$postid_str_obj->ID");}
}
############################################# SET THE NEW PACKAGE OR SET AS DRAFT #######################################

$wpdb->query("update $table_name set execute_date=\"$current_date\" ,is_run=1  where session_id=1");
}
}
}
}
										  
										  

################################# FIX FOR FACEBOOK LIKE THUMB URL #############################################
add_action( 'wp_head', 'fb_like_thumbnails' );
if (!function_exists('fb_like_thumbnails')) {
function fb_like_thumbnails()
{

global $wpdb,$thumb_url,$wp_query;
if($wp_query->post->ID){
$default = get_option('ptthemes_logo_url');
$post_images = bdw_get_images($wp_query->post->ID,'large');
if ( $post_images > 0 )
$thumb = $post_images[0]; 
else
$thumb = $default;
}else{$thumb = $default;}
echo "\n\n<!-- Facebook Like Thumbnail -->\n<link rel=\"image_src\" href=\"$thumb\" />\n<!-- End Facebook Like Thumbnail -->\n\n";
}}
################################# END FIX FOR FACEBOOK LIKE THUMB URL ##########################################
################################# FUNCTION TO CALCULATE DISTANCE FOR SEARCH #############################################
if (!function_exists('calculateDistanceFromLatLong')) {
function calculateDistanceFromLatLong($point1,$point2,$uom='km') {
//	Use Haversine formula to calculate the great circle distance
//		between two points identified by longitude and latitude
switch (strtolower($uom)) {
case 'km'	:
$earthMeanRadius = 6371.009; // km
break;
case 'm'	:
case 'meters'	:
$earthMeanRadius = 6371.009 * 1000; // km
break;
case 'miles'	:
$earthMeanRadius = 3958.761; // miles
break;
case 'yards'	:
case 'yds'	:
$earthMeanRadius = 3958.761 * 1760; // yards
break;
case 'feet'	:
case 'ft'	:
$earthMeanRadius = 3958.761 * 1760 * 3; // feet
break;
case 'nm'	:
$earthMeanRadius = 3440.069; //  miles
break;
}
$deltaLatitude = deg2rad($point2['latitude'] - $point1['latitude']);
$deltaLongitude = deg2rad($point2['longitude'] - $point1['longitude']);
$a = sin($deltaLatitude / 2) * sin($deltaLatitude / 2) +
cos(deg2rad($point1['latitude'])) * cos(deg2rad($point2['latitude'])) *
sin($deltaLongitude / 2) * sin($deltaLongitude / 2);
$c = 2 * atan2(sqrt($a), sqrt(1-$a));
$distance = $earthMeanRadius * $c;
return $distance;
}}
################################# END FUNCTION TO CALCULATE DISTANCE FOR SEARCH #########################################

################################# CLIENT EMAIL FUNCTION ##############################################################
if (!function_exists('clientEmail')) {
function clientEmail($page_id,$user_id,$message_type,$custom_1=''){	
global $wpdb;
if($message_type=='expiration'){$subject = stripslashes(get_option('renew_email_subject')); $client_message = stripslashes(get_option('renew_email_content'));}
elseif($message_type=='post_submited'){$subject = get_option('post_submited_success_email_subject'); $client_message = get_option('post_submited_success_email_content');}
elseif($message_type=='renew'){$subject = get_option('post_renew_success_email_subject'); $client_message = get_option('post_renew_success_email_content');}
elseif($message_type=='upgrade'){$subject = get_option('post_upgrade_success_email_subject'); $client_message = get_option('post_upgrade_success_email_content');}
elseif($message_type=='claim_approved'){$subject = get_option('claim_approved_email_subject'); $client_message = get_option('claim_approved_email_content');}
elseif($message_type=='claim_rejected'){$subject = get_option('claim_rejected_email_subject'); $client_message = get_option('claim_rejected_email_content');}
elseif($message_type=='claim_requested'){$subject = get_option('claim_email_subject'); $client_message = get_option('claim_email_content');}
elseif($message_type=='auto_claim'){$subject = get_option('auto_claim_email_subject'); $client_message = get_option('auto_claim_email_content');}
elseif($message_type=='payment_success'){$subject = get_option('post_payment_success_client_email_subject'); $client_message = get_option('post_payment_success_client_email_content');}
elseif($message_type=='payment_fail'){$subject = get_option('post_payment_fail_admin_email_subject'); $client_message = get_option('post_payment_fail_admin_email_content');}
$transaction_details = $custom_1;
$approve_listing_link = '<a href="'.get_option('siteurl').'/?ptype=verify&rs='.$custom_1.'">'.VERIFY_TEXT.'</a>';	
$fromEmail = get_option('site_email');
$fromEmailName = get_site_emailName();
//$alivedays = get_post_meta($page_id,'alive_days',true);
$pkg_limit = get_property_price_info_listing($page_id);
$alivedays = $pkg_limit['days'];
$productlink = get_permalink($page_id);
$post_info = get_post($page_id);
$post_date =  date('dS F,Y',strtotime($post_info->post_date));
$listingLink ='<a href="'.$productlink.'"><b>'.$post_info->post_title.'</b></a>';
$loginurl = home_url().'/?ptype=login';
$loginurl_link = '<a href="'.$loginurl.'">login</a>';
$siteurl = home_url();
$siteurl_link = '<a href="'.$siteurl.'">'.$fromEmailName.'</a>';
$user_info = get_userdata($user_id);
$user_email = $user_info->user_email;
$display_name = $user_info->first_name;
$user_login = $user_info->user_login;
$number_of_grace_days = get_option('ptthemes_listing_preexpiry_notice_days');
if($number_of_grace_days==''){$number_of_grace_days=1;}
if($post_info->post_type == 'event'){$post_type='event';}else{$post_type='listing';}
$renew_link = '<a href="'.$siteurl.'?ptype=post_'.$post_type.'&renew=1&pid='.$page_id.'">'.RENEW_LINK.'</a>';
$search_array = array('[#client_name#]','[#listing_link#]','[#posted_date#]','[#number_of_days#]','[#number_of_grace_days#]','[#login_url#]','[#username#]','[#user_email#]','[#site_name_url#]','[#renew_link#]','[#post_id#]','[#site_name#]','[#approve_listing_link#]','[#transaction_details#]');
$replace_array = array($display_name,$listingLink,$post_date,$alivedays,$number_of_grace_days,$loginurl_link,$user_login,$user_email,$siteurl_link,$renew_link,$page_id,$fromEmailName,$approve_listing_link,$transaction_details);
$client_message = str_replace($search_array,$replace_array,$client_message);
$subject = str_replace($search_array,$replace_array,$subject);
//$client_message2 = 'message type:'.$message_type.'# post id:'.$page_id.'#user id:'.$user_id;
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
//$headers .= 'To: '.$display_name.' <'.$user_email.'>' . "\r\n";
$headers .= 'From: '.$fromEmailName.' <'.$fromEmail.'>' . "\r\n";
@wp_mail($user_email,$subject,$client_message,$headers);///To client email
}}
################################# CLIENT EMAIL FUNCTION END ##############################################################
################################# ADMIN EMAIL FUNCTION ##############################################################
if (!function_exists('adminEmail')) {
function adminEmail($page_id,$user_id,$message_type,$custom_1=''){
global $wpdb;
if($message_type=='expiration'){$subject = stripslashes(get_option('renew_email_subject')); $client_message = stripslashes(get_option('renew_email_content'));}
elseif($message_type=='post_submited'){$subject = get_option('post_submited_success_email_subject_admin'); $client_message = get_option('post_submited_success_email_content_admin');}
elseif($message_type=='renew'){$subject = get_option('post_renew_success_email_subject_admin'); $client_message = get_option('post_renew_success_email_content_admin');}
elseif($message_type=='upgrade'){$subject = get_option('post_upgrade_success_email_subject_admin'); $client_message = get_option('post_upgrade_success_email_content_admin');}
elseif($message_type=='claim_approved'){$subject = get_option('claim_approved_email_subject'); $client_message = get_option('claim_approved_email_content');}
elseif($message_type=='claim_rejected'){$subject = get_option('claim_rejected_email_subject'); $client_message = get_option('claim_rejected_email_content');}
elseif($message_type=='claim_requested'){$subject = get_option('claim_email_subject_admin'); $client_message = get_option('claim_email_content_admin');}
elseif($message_type=='auto_claim'){$subject = get_option('auto_claim_email_subject'); $client_message = get_option('auto_claim_email_content');}
elseif($message_type=='payment_success'){$subject = get_option('post_payment_success_admin_email_subject'); $client_message = get_option('post_payment_success_admin_email_content');}
elseif($message_type=='payment_fail'){$subject = get_option('post_payment_fail_admin_email_subject'); $client_message = get_option('post_payment_fail_admin_email_content');}
$transaction_details = $custom_1;	
$approve_listing_link = '<a href="'.get_option('siteurl').'/?ptype=verify&rs='.$custom_1.'">'.VERIFY_TEXT.'</a>';	
$fromEmail = get_option('site_email');
$fromEmailName = get_site_emailName();
//$alivedays = get_post_meta($page_id,'alive_days',true);
$pkg_limit = get_property_price_info_listing($page_id);
$alivedays = $pkg_limit['days'];
$productlink = get_permalink($page_id);
$post_info = get_post($page_id);
$post_date =  date('dS F,Y',strtotime($post_info->post_date));
$listingLink ='<a href="'.$productlink.'"><b>'.$post_info->post_title.'</b></a>';
$loginurl = home_url().'/?ptype=login';
$loginurl_link = '<a href="'.$loginurl.'">login</a>';
$siteurl = home_url();
$siteurl_link = '<a href="'.$siteurl.'">'.$fromEmailName.'</a>';
$user_info = get_userdata($user_id);
$user_email = $user_info->user_email;
$display_name = $user_info->first_name;
$user_login = $user_info->user_login;
$number_of_grace_days = get_option('ptthemes_listing_preexpiry_notice_days');
if($number_of_grace_days==''){$number_of_grace_days=1;}
if($post_info->post_type == 'event'){$post_type='event';}else{$post_type='listing';}
$renew_link = '<a href="'.$siteurl.'?ptype=post_'.$post_type.'&renew=1&pid='.$page_id.'">'.RENEW_LINK.'</a>';
$search_array = array('[#client_name#]','[#listing_link#]','[#posted_date#]','[#number_of_days#]','[#number_of_grace_days#]','[#login_url#]','[#username#]','[#user_email#]','[#site_name_url#]','[#renew_link#]','[#post_id#]','[#site_name#]','[#approve_listing_link#]','[#transaction_details#]');
$replace_array = array($display_name,$listingLink,$post_date,$alivedays,$number_of_grace_days,$loginurl_link,$user_login,$user_email,$siteurl_link,$renew_link,$page_id,$fromEmailName,$approve_listing_link,$transaction_details);
$client_message = str_replace($search_array,$replace_array,$client_message);	
$subject = str_replace($search_array,$replace_array,$subject);	
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
//$headers .= 'To: <'.$fromEmail.'>' . "\r\n";
$headers .= 'From: '.$fromEmailName.' <'.$fromEmail.'>' . "\r\n";
@wp_mail($fromEmail,$subject,$client_message,$headers);///To client email
}}
################################# ADMIN EMAIL FUNCTION END ##############################################################
################################# SEND EMAIL FUNCTION START #############################################################
if (!function_exists('sendEmail')) {
function sendEmail($fromEmail,$fromEmailName,$toEmail,$toEmailName,$to_subject,$to_message,$extra='',$message_type,$post_id='',$user_id='')
{
$login_details ='';
if($message_type=='send_friend'){$subject = stripslashes(get_option('email_friend_subject')); $message = stripslashes(get_option('email_friend_content'));}
elseif($message_type=='send_enquiry'){$subject = get_option('email_enquiry_subject'); $message = get_option('email_enquiry_content');}
elseif($message_type=='forgot_password'){$subject = get_option('forgot_password_subject'); $message = get_option('forgot_password_content'); $login_details =$to_message; }
elseif($message_type=='registration'){$subject = get_option('registration_success_email_subject'); $message = get_option('registration_success_email_content'); $login_details =$to_message; }
$to_message = nl2br($to_message);
$sitefromEmail = get_option('site_email');
$sitefromEmailName = get_site_emailName();
$productlink = get_permalink($post_id);
$post_info = get_post($post_id);
$listingLink ='<a href="'.$productlink.'"><b>'.$post_info->post_title.'</b></a>';
$siteurl = home_url();
$siteurl_link = '<a href="'.$siteurl.'">'.$siteurl.'</a>';
$loginurl = home_url().'/?ptype=login';
$loginurl_link = '<a href="'.$loginurl.'">login</a>';
if($fromEmail==''){$fromEmail = get_option('site_email_name');}
$fromEmail = str_replace('%40','@',$fromEmail );
if($fromEmailName==''){$fromEmailName = get_option('site_email');}
$search_array = array('[#listing_link#]','[#site_name_url#]','[#post_id#]','[#site_name#]','[#to_name#]','[#from_name#]','[#subject#]','[#comments#]','[#login_url#]','[#login_details#]','[#client_name#]','[#sender_email#]');
$replace_array = array($listingLink,$siteurl_link,$post_id,$sitefromEmailName,$toEmailName,$fromEmailName,$to_subject,$to_message,$loginurl_link,$login_details,$toEmailName,$fromEmail);
$message = str_replace($search_array,$replace_array,$message);

$search_array = array('[#listing_link#]','[#site_name_url#]','[#post_id#]','[#site_name#]','[#to_name#]','[#from_name#]','[#subject#]','[#client_name#]');
$replace_array = array($listingLink,$siteurl_link,$post_id,$sitefromEmailName,$toEmailName,$fromEmailName,$to_subject,$toEmailName);
$subject = str_replace($search_array,$replace_array,$subject);
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
$headers .= "Reply-To: ".$fromEmail. "\r\n";
//$headers .= 'To: '.$toEmailName.' <'.$toEmail.'>' . "\r\n";
$headers .= 'From: '.$sitefromEmailName.' <'.$sitefromEmail.'>' . "\r\n";
@wp_mail($toEmail, $subject, $message, $headers);

///////// ADMIN BCC EMIALS
if($message_type=='registration'){
$message_raw = explode("Password:", $message);
$message_raw2 = explode("</p>", $message_raw[1],2);
$message = $message_raw[0].'Password: **********</p>'.$message_raw2[1];
}
$adminEmail = get_bloginfo('admin_email');

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
$headers .= "Reply-To: ".$fromEmail. "\r\n";
//$headers .= 'To: <'.$adminEmail.'>' . "\r\n";
$headers .= 'From: '.$sitefromEmailName.' <'.$sitefromEmail.'>' . "\r\n";
if($message_type=='registration' && get_option('bcc_new_user')){$subject.=' - ADMIN BCC COPY'; @wp_mail($adminEmail, $subject, $message, $headers);}
if($message_type=='send_friend' && get_option('bcc_friend')){$subject.=' - ADMIN BCC COPY'; @wp_mail($adminEmail, $subject, $message, $headers);}
if($message_type=='send_enquiry' && get_option('bcc_enquiry')){$subject.=' - ADMIN BCC COPY'; @wp_mail($adminEmail, $subject, $message, $headers);}
}}
################################# SEND EMAIL FUNCTION END ##############################################################
################################# DATABASE UPDATE FUNCTIONS ############################################################
if (!function_exists('add_column_if_not_exist')) {
function add_column_if_not_exist($db, $column, $column_attr = "VARCHAR( 255 ) NOT NULL" ){
    $exists = false;
    $columns = mysql_query("show columns from $db");
    while($c = mysql_fetch_assoc($columns)){
        if($c['Field'] == $column){
            $exists = true;
            break;
        }
    }      
    if(!$exists){
        mysql_query("ALTER TABLE `$db` ADD `$column`  $column_attr");
    }
}}
################################# ENF DATABASE UPDATE FUNCTIONS ########################################################


if (!function_exists('gt_custom_login_logo')) {
function gt_custom_login_logo() {
    echo '<style type="text/css">
        h1 a { background-image:url('.get_bloginfo('template_url').'/skins/1-default/logo.png) !important; }
    </style>';
}}
 
add_action('login_head', 'gt_custom_login_logo');

if (!function_exists('checkForUpdates')) {
function checkForUpdates(){
$gt_ver = get_option( 'GeoTheme Version' );
$a = get_option('gt_show_app_page');
if( !$gt_ver ) {
add_option( 'GeoTheme Version', '3.2.7'); 
} else {
if($gt_ver < '3.2.7'){
geotheme_activation_setup();
update_option( 'GeoTheme Version', '3.2.7' );
} // Get the current version
### CHECK FOR UPDATE ANOUNCMENTS ###
$ctx = stream_context_create(array('http' => array('timeout' => 3)));
$gt_s = '&s='.get_bloginfo("url").'&v='.$gt_ver.'&a='.$a;	
$this_ver = get_option('GeoTheme Version'); // Get the current version
$ver_url = "http://geotheme.com/version.php?show=version";
$cur_ver = file_get_contents($ver_url.$gt_s,false,$ctx);
if($this_ver < $cur_ver){
$message_url = "http://geotheme.com/version.php?show=message";
$message = file_get_contents($message_url,false,$ctx);
update_option( 'GT_UD_MSG', $message );
}else{update_option( 'GT_UD_MSG', '' );}
### CHECK FOR SECURITY ANOUNCMENTS ###
$security_url = "http://geotheme.com/version.php?show=security";
$security_msg = file_get_contents($security_url,false,$ctx);
update_option( 'GT_SC_MSG', $security_msg );
### END CHECK FOR SECURITY ANOUNCMENTS ###
}
}}// end update function

if (!function_exists('showNotifications')) {
function showNotifications(){
	if($_GET['gt_hide']=='1'){
		update_option( 'GT_UD_MSG', '');
		update_option( 'GT_SC_MSG', '' );

	}
	
$site_url = get_bloginfo("url");
$admin_url = $site_url.'/wp-admin/';	
$hide= '<a href="'.$admin_url.'?gt_hide=1" style="float:right;margin-top:-20px;">Hide</a>';
if(get_option( 'GT_UD_MSG' )!='' && get_option( 'gt_update' )==1){echo get_option( 'GT_UD_MSG' ).$hide;}	
if(get_option( 'GT_SC_MSG' )!='' && get_option( 'gt_security' )==1){echo get_option( 'GT_SC_MSG' ).$hide;}
}}

if (!function_exists('db_fix')) {
function db_fix(){
	global $wpdb;
	if(!get_option('gt_db_fix')){
	$wpdb->query('ALTER TABLE '.$wpdb->posts.' ENGINE = MYISAM;');
    $wpdb->query('ALTER TABLE '.$wpdb->posts.' ADD FULLTEXT bsearch (post_title, post_content);');
    $wpdb->query('ALTER TABLE '.$wpdb->posts.' ADD FULLTEXT bsearch_title (post_title);');
    $wpdb->query('ALTER TABLE '.$wpdb->posts.' ADD FULLTEXT bsearch_content (post_content);');
    $wpdb->show_errors();
	update_option('gt_db_fix',1);
	}
}}

add_action("admin_head", "checkForUpdates"); 
add_action("admin_head", "showNotifications"); 
add_action("admin_head", "db_fix"); 

###################################################
######## FUNCTION TO GET USER SOCIAL PIC ##########
###################################################
if (!function_exists('get_user_pic')) {
function get_user_pic(){
	global $current_user;
	 get_currentuserinfo();
$user_id = $current_user->ID; // get user id
if($user_id){
	
#### CHECK FOR FACEBOOK PIC	
if(get_user_meta($user_id, 'social_connect_facebook_id', true) && !get_user_meta($user_id, 'user_pic_url', true)){	
$facbook_id = get_user_meta($user_id, 'social_connect_facebook_id', true);
//$facebook_pic_url = 'http://graph.facebook.com/'.$facbook_id.'/picture?type=large'; // large
$facebook_pic_url = 'http://graph.facebook.com/'.$facbook_id.'/picture'; // small
update_user_meta($user_id, 'user_pic_url', $facebook_pic_url);
} //END FACBOOK CHECK	
	
#### CHECK FOR TWITTER PIC	
if(get_user_meta($user_id, 'social_connect_twitter_id', true) && !get_user_meta($user_id, 'user_pic_url', true)){	
$twitter_id = get_user_meta($user_id, 'social_connect_twitter_id', true);
$json = file_get_contents("http://api.twitter.com/1/users/lookup.json?user_id=".$twitter_id."&include_entities=false");
$json_array = json_decode($json, true);
$twitter_pic_url = $json_array['0']['profile_image_url'];
update_user_meta($user_id, 'user_pic_url', $twitter_pic_url);
} //END TWITTER CHECK	

} // END IF USER IF
}}

get_user_pic(); // run the function if on there profile page.

if (!function_exists('get_facebook_pic')) {
function get_facebook_pic(){
	global $current_user;
	 get_currentuserinfo();
$user_id = $current_user->ID; // get user id
if($user_id){
	
#### CHECK FOR FACEBOOK PIC	
if(get_user_meta($user_id, 'social_connect_facebook_id', true)){	
$facbook_id = get_user_meta($user_id, 'social_connect_facebook_id', true);
//$facebook_pic_url = 'http://graph.facebook.com/'.$facbook_id.'/picture?type=large'; // large
$facebook_pic_url = 'http://graph.facebook.com/'.$facbook_id.'/picture'; // small
update_user_meta($user_id, 'user_pic_url', $facebook_pic_url);
} //END FACBOOK CHECK	
	
} // END IF USER IF
}}


if (!function_exists('get_twitter_pic')) {
function get_twitter_pic(){
	global $current_user;
	 get_currentuserinfo();
$user_id = $current_user->ID; // get user id
if($user_id){
	
#### CHECK FOR TWITTER PIC	
if(get_user_meta($user_id, 'social_connect_twitter_id', true)){	
$twitter_id = get_user_meta($user_id, 'social_connect_twitter_id', true);
$json = file_get_contents("http://api.twitter.com/1/users/lookup.json?user_id=".$twitter_id."&include_entities=false");
$json_array = json_decode($json, true);
$twitter_pic_url = $json_array['0']['profile_image_url'];
update_user_meta($user_id, 'user_pic_url', $twitter_pic_url);
} //END TWITTER CHECK	

} // END IF USER IF
}}


###################################################
### FUNCTION TO REPLACE AVATAR WITH SOCIAL PIC ####
###################################################
if (!function_exists('show_user_avatar')) {
function show_user_avatar($avatar, $comment, $size) {
	global $wpdb;
if(isset($comment->user_id)){$user_id = $comment->user_id;}	
elseif(get_user_by('email', $comment)){$user_info = get_user_by('email', $comment);$user_id = $user_info->ID;}
else{$user_id = $comment;}
if($user_id){$user_pic = get_user_meta($user_id, 'user_pic_url', true);}
if($user_pic){
$avatar = "<img alt='Profile pic' src='$user_pic' class='avatar avatar-$size photo' height='$size' width='$size' />";
}
return $avatar;
}}
add_filter( 'get_avatar','show_user_avatar', 1, 3 );



##############################	 FUNCTION TO NOT LIST REPLIES AS REVIEWS
add_filter('get_comments_number', 'fix_comment_count', 10, 2);
function fix_comment_count( $count, $post_id) {
	if ( ! is_admin() ) {
		$comments_by_type = &separate_comments(get_comments('status=approve&post_id=' . $post_id . '&parent=0'));
		return count($comments_by_type['comment']);
	} else {
		return $count;
	}
}

##############################	 END FUNCTION TO NOT LIST REPLIES AS REVIEWS

##############################	 NATIVE MENU SUPPORT START

add_action( 'init', 'register_my_menus' );

function register_my_menus() {
register_nav_menus(
array(
'main_menu' => __( 'Main Menu' ),
'top_menu' => __( 'Top Menu' ),
'footer_menu' => __( 'Footer Menu' )
)
);
}
##############################	 NATIVE MENU SUPPORT End

##############################	 LOAD EXTRA STYLES FOR ADMIN AND EVENTS
$uri = $_SERVER["REQUEST_URI"];
if(
$_REQUEST['page']=='gt_tools' 
|| $_REQUEST['ptype']=='post_event' 
|| $_REQUEST['page']=='app_settings' 
|| strpos($uri, 'edit-tags.php')
|| strpos($uri, 'post.php')
){
$plugin_path = get_bloginfo('template_url').'/library/cat-meta';
if($_REQUEST['ptype']=='post_event' ){}else{wp_enqueue_style( 'tax-meta-clss', $plugin_path . '/css/Tax-meta-class.css' );}
wp_enqueue_script( 'tax-meta-clss', $plugin_path . '/js/tax-meta-clss.js', array( 'jquery' ), null, true );
wp_enqueue_style( 'tmc-jquery-ui-css', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/themes/base/jquery-ui.css' );
wp_enqueue_script( 'tmc-jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js', array( 'jquery' ) );
wp_enqueue_script( 'at-timepicker', $plugin_path . '/js/jquery-ui-timepicker-addon.js', array( 'tmc-jquery-ui' ),false,true );
}



###################################################
####### SETUP THE DATABSE FOR GEOTHEME V3 #########
###################################################
if(strpos($_SERVER["REQUEST_URI"], 'themes.php?activated=true')){
geotheme_activation_setup();
}


###################################################
####### ADD LOCATION TO CATEGORY LINKS ############
###################################################
if(get_option('cat_link_locations')){
add_filter( 'term_link', 'my_term_to_type', 10, 3 );

function my_term_to_type( $link, $term, $taxonomy ) {
if($taxonomy == 'placecategory' || $taxonomy == 'eventcategory' || $taxonomy == 'category') {
		$location = $_SESSION['location_slug'];
		$loc_area = 'multi_city';
		if($_SESSION['multi_country'] || $_SESSION['multi_region'] || $_SESSION['area']){
			if($_SESSION['multi_country']){$loc_area = 'multi_country';}
			if($_SESSION['multi_region']){$loc_area = 'multi_region';}
			if($_SESSION['area']){$loc_area = ''; $location ='';}
		}
		if($location){ 
		$link = add_query_arg( $loc_area, $location, $link );
		}
	}

	return $link;
}
}
###################################################
####### ADD LOCATION TO CATEGORY LINKS END ########
###################################################

###################################################
####### SHORTEN STRING FUNCTION START #############
###################################################
if (!function_exists('gt_user_short')) {
function gt_user_short($str, $limit=16) {
    if (strlen ($str) > $limit) {
        $str = substr ($str, 0, $limit - 3);
        return $str.'...';
    }
    return trim($str);
}
}
###################################################
####### SHORTEN STRING FUNCTION END ###############
###################################################

###################################################
############# GET CURRENT PAGE URL ################
###################################################
if (!function_exists('curPageURL')) {
function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}}
###################################################
############# MODERATION REASONS ##################
###################################################
if (!function_exists('gt_moderation_reason(')) {
function gt_moderation_reason($reason='') {
$reason_arr = array(1=>__('Spam'),2=>__('Language'),3=>__('Comments'),4=>__('Images'));
if($reason=='array'){return $reason_arr;}
elseif($reason && $reason!='array'){return $reason_arr[$reason];}else{ 
?>
<option value=""><?php _e('Select Reason');?></option>
<option value="1"><?php echo $reason_arr[1];?></option>
<option value="2"><?php echo $reason_arr[2];?></option>
<option value="3"><?php echo $reason_arr[3];?></option>
<option value="4"><?php echo $reason_arr[4];?></option>
<?php }
}}
###################################################
############# MODERATION FORM OUTPUT ##############
###################################################
if (!function_exists('gt_moderation_form')) {
function gt_moderation_form($post_id) {
?>
<script type="text/javascript">
function send_moderation(){
	jQuery('#report_this_ajax').slideToggle("200");
	post_id = jQuery("#moderation_post_id").val();
	reason = jQuery("#moderation_reason").val();
	modText = jQuery("#moderation_text").val();

	ajaxUrl = "<?php echo home_url().'/?ajax=report'; ?>";
	jQuery.ajax({ type: "POST", url: ajaxUrl, data: "reason="+reason+"&modText="+modText+"&id="+post_id,
		 success: function(msg)
		{
		  if(msg != "Error")
		  {	
		  
		  jQuery("#report_this_ajax").html("<span id='moderation_thanks'>"+msg+"</span");
		  jQuery('#report_this_ajax').slideToggle("200");
		  //alert('done');
		  //alert(msg);
		  }
		}
	  });
	return false;
}
</script>
<form action="#">
<input type="hidden" name="moderation_post_id" id="moderation_post_id" value="<?php echo $post_id;?>" />
<select name="moderation_reason" id="moderation_reason">
<?php echo gt_moderation_reason();?>
</select>
<br />
<label><?php _e('Notes (optional):');?></label>
<br />
<textarea name="moderation_text" id="moderation_text"></textarea>
<br />
<input name="submit" type="submit" id="submit" tabindex="5" value="Submit" onclick="return send_moderation();">
</form>
<?php
	
}}
###################################################
############# MODERATION SUBMIT ###################
###################################################
if (!function_exists('gt_moderation_submit')) {
function gt_moderation_submit($post_id,$reason,$mod_text) {
	global $wpdb,$current_user,$moderation_db_table_name;
if(!$reason){ return REPORT_NO_REASON;}
if($current_user->ID && $post_id){
$wpdb->query("SELECT * from $moderation_db_table_name where user_id='".$current_user->ID."' AND list_id='".$post_id."'");	
$reports = $wpdb->num_rows;
if($reports >0){echo REPORT_ALREADY_MSG;}else{
$time = time();
$reported = get_post($post_id, ARRAY_A);
$moderation_insert = '
INSERT INTO `'.$moderation_db_table_name.'` (`list_id`, `list_title`, `user_id`, `user_comments`, `user_ip`, `claim_date`, `moderation_reason`, `authorid`, `status`) VALUES
("'.$post_id.'", "'.$reported['post_title'].'", '.$current_user->ID.', "'.$mod_text.'", "'.$_SERVER['REMOTE_ADDR'].'", "'.$time.'", "'.$reason.'", "'.$reported['post_author'].'", "")';
$wpdb->query($moderation_insert);
echo REPORT_REPORTED;
}
}
}}


if(!function_exists('gt_max_upload_size')) {
function gt_max_upload_size() {
	return '2mb'; 
}}

if(!function_exists('gt_plupload_admin_head')) {
function gt_plupload_admin_head() {
// place js config array for plupload
    $plupload_init = array(
        'runtimes' => 'html5,silverlight,flash,html4',
        'browse_button' => 'plupload-browse-button', // will be adjusted per uploader
        'container' => 'plupload-upload-ui', // will be adjusted per uploader
        'drop_element' => 'drag-drop-area', // will be adjusted per uploader
        'file_data_name' => 'async-upload', // will be adjusted per uploader
        'multiple_queues' => true,
       //'max_file_size' => wp_max_upload_size() . 'b',
        'max_file_size' => gt_max_upload_size(),
        'url' => admin_url('admin-ajax.php'),
        'flash_swf_url' => includes_url('js/plupload/plupload.flash.swf'),
        'silverlight_xap_url' => includes_url('js/plupload/plupload.silverlight.xap'),
        'filters' => array(array('title' => __('Allowed Files'), 'extensions' => 'jpeg,jpg,gif,png')),
        'multipart' => true,
        'urlstream_upload' => true,
        'multi_selection' => false, // will be added per uploader
         // additional post data to send to our ajax hook
        'multipart_params' => array(
            '_ajax_nonce' => "", // will be added per uploader
            'action' => 'plupload_action', // the ajax action name
            'imgid' => 0 // will be added per uploader
        )
    );
?>
<script type="text/javascript">
    var base_plupload_config=<?php echo json_encode($plupload_init); ?>;
</script>
<?php
}
}


function g_plupload_action() {
 
    // check ajax noonce
    $imgid = $_POST["imgid"];
    check_ajax_referer($imgid . 'pluploadan');
 
    // handle file upload
    $status = wp_handle_upload($_FILES[$imgid . 'async-upload'], array('test_form' => true, 'action' => 'plupload_action'));
 //print_r( $status);
    // send the uploaded file url in response
    echo $status['url'];
    exit;
}
add_action('wp_ajax_plupload_action', "g_plupload_action");
add_action( 'wp_ajax_nopriv_plupload_action', 'g_plupload_action' ); // call for not logged in ajax


function gt_add_remove_images($pid,$newArr){
global $wpdb;
if($pid){}else{ return false;}
$curImgArr = array();
$newImgArr = array();
$curIdArr = array();
$newIdArr = array();
$noDup = array();
$curArr = get_children('order=ASC&orderby=menu_order ID&post_type=attachment&post_mime_type=image&post_parent=' . $pid );

// Get image name
foreach($curArr as $key=>$val)
	   {
		$imgUrl = wp_get_attachment_image_src($val->ID,'large');
		$imgName = end(explode('/',$imgUrl[0]));
		$curImgArr[] = $imgName;
		$curIdArr[$imgName] = $val->ID;
	   }
	   
// Get image name	   
foreach($newArr as $imgN)
	   {
		$nimgName = end(explode('/',$imgN));
		$newImgArr[] = $nimgName;
		$newIdArr[$nimgName] = $imgN;
	   }
	   
//  Delete images that have been removed	
$noDup = $curImgArr;
$delArr = array_diff(array_unique($noDup), $newImgArr);
foreach($delArr as $del)
		{
		wp_delete_attachment( $curIdArr[$del], $force_delete = true ); 
		}
		
//  Add new images	
$menu_order = 0;
$newArr = array_diff($newImgArr,$curImgArr);
foreach($newImgArr as $new)
		{	
			$menu_order++;
			// you must first include the image.php file
			// for the function wp_generate_attachment_metadata() to work
			require_once(ABSPATH . 'wp-admin/includes/image.php');
			if($curIdArr[$new]){
			$thisattachment = array();
			$thisattachment['ID'] = $curIdArr[$new];
			$thisattachment['menu_order'] = $menu_order;
			wp_update_post($thisattachment);
			}else{
			$wp_upload_dir = wp_upload_dir(); // Array of key => value pairs
			$filename =  $wp_upload_dir['path'] . '/'. $new;
			$attachment = array(
		   'guid' => $wp_upload_dir['url'] . '/'. $new, 
		   'post_mime_type' => 'image/jpeg',
		   'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
		   'post_content' => '',
		   'menu_order' => $menu_order,
		   'post_status' => 'inherit'
			);
			
			$attach_id = wp_insert_attachment( $attachment, $filename, $pid );
			
			$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
			wp_update_attachment_metadata( $attach_id, $attach_data );
			}
			
		}
}


// run the expiry check twice a day
if ( !wp_next_scheduled('my_task_hook') ) {
	wp_schedule_event( time(), 'twicedaily', 'my_task_hook' ); // hourly, daily and twicedaily
}
if (!function_exists('place_expire_check_cron')) {
function place_expire_check_cron() {
place_expire_check();
checkForUpdates();
}}
add_action('my_task_hook', 'place_expire_check_cron');
//place_expire_check();
/////////////////PLACE EXPIRY SETTINGS CODING END/////////////////


// ADVANCED NEAR SEARCH LOCATION FUNCTION
if (!function_exists('gt_advanced_near_search')) {
function gt_advanced_near_search(){
	global $wpdb;
	$near_add = "";
	if(get_option('advanced_near_search')!=0){
	if($_SESSION['location_name'] && $_SESSION['location_name']!='EVERYWHERE' && $_SESSION['multi_city']!=0 ){
		$near_add .=  "+' ";
	$near_add .=  $_SESSION['location_name'];
	}
	}
	
	if($near_add && get_option('search_near_add')){ $near_add .= ", ".get_option('search_near_add')."'";}
	elseif(get_option('search_near_add')){ $near_add .= "+' ".get_option('search_near_add')."'";}
	elseif($near_add){$near_add .=  "'";}
	
	echo $near_add;
	
}
}



// Add specific CSS class by filter
add_filter('body_class','gt_class_names');
if (!function_exists('gt_class_names')) {
function gt_class_names($classes) {
	if($_REQUEST['ptype']=='preview'){
	$classes[] = 'single';	
	$classes[] = 'single-place';	
	}
	
	if($_REQUEST['ptype']=='preview_event'){
	$classes[] = 'single';	
	$classes[] = 'single-event';	
	}
	

	return $classes;
}
}





/*
if (!function_exists('localization_theme_setup')) {
function localization_theme_setup() {

	// Retrieve the directory for the localization files
	$lang_dir = get_template_directory() . '/localization');
	
	// Set the theme's text domain using the unique identifier from above
	load_theme_textdomain('gt_local', $lang_dir);

} // end custom_theme_setup
}
add_action('after_theme_setup', 'localization_theme_setup'):
*/


?>