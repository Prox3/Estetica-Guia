<?php
/////////////////////////////////////////

// ************* Theme Options Page *********** //

add_action('admin_menu', 'mkt_add_product'); //Add new menu block to admin side
if (!function_exists('mkt_add_product')) {
function mkt_add_product(){	
#######  GET NUMBER OF OUTSTANDING CLAIMS ############
   	global $wpdb,$claim_db_table_name;	
	$wpdb->query("SELECT * from $claim_db_table_name where status=''");	
    $claims = $wpdb->num_rows;
	$claims_num1 = '';
	if($claims > 0){$claims_num1 = '<span class="update-plugins count-2" title="1 WordPress Update, 1 Plugin Update"><span class="update-count">'.$claims.'</span></span>';}
######################################################
#######  GET NUMBER OF OUTSTANDING MODERATION CLAIMS ############
   	global $wpdb,$moderation_db_table_name;	
	$wpdb->query("SELECT * from $moderation_db_table_name where status=''");	
    $mod_claims = $wpdb->num_rows;
	$mod_claims_num1 = '';
	if($mod_claims > 0){$mod_claims_num1 = '<span class="update-plugins count-2" title="1 WordPress Update, 1 Plugin Update"><span class="update-count">'.$mod_claims.'</span></span>';}
	
	$claims_num ='';
	if($mod_claims > 0 || $claims > 0){
	$claims_num = '<span class="update-plugins count-2" title="1 WordPress Update, 1 Plugin Update"><span class="update-count">'.($claims+$mod_claims).'</span></span>';	
	}
######################################################

	if(function_exists(add_object_page))
    {
        add_object_page ('Geo Theme', 'Geo Theme'.$claims_num.'', 8,'product_menu.php', 'admin_settings',  get_bloginfo('template_url').'/images/favicon.ico');
    }
    else
    {
        add_menu_page ('Geo Theme', 'Geo Theme', 8,'product_menu.php', 'admin_settings',  get_bloginfo('template_url').'/images/favicon.ico',33); 
		
    }
	add_menu_page ('GT Tools', 'GT Tools', 8,'gt_tools', 'gt_tools',  get_bloginfo('template_url').'/images/favicon.ico', 34); 
	
	if(get_option('gt_show_app_page')){
	add_menu_page ('App Settings', 'App Settings', 8,'app_settings', 'app_settings',  get_bloginfo('template_url').'/images/favicon.ico', 35); 
	}
	$claims_num2 = '';
   	if($claims > 0){$claims_num2 = "<span class='update-plugins count-2' title='1 WordPress Update, 1 Plugin Update'><span class='update-count'>".$claims."</span></span>";}
	
	add_submenu_page('product_menu.php', __("General Settings"), __("General Settings"), 8, 'product_menu.php', 'admin_settings');
	add_submenu_page('product_menu.php', __("Design Settings"), __("Design Settings"), 8, 'theme_settings', 'theme_settings');
	add_submenu_page('product_menu.php', __("Payment Options"), __("Payment Options"), 8, 'paymentoptions', 'payment_options');
	add_submenu_page('product_menu.php', __("Category Icons"), __("Category Icons"), 8, 'category_icons', 'category_icons');
	add_submenu_page('product_menu.php', __("Manage Coupon"),  __("Manage Coupon"), 8, 'managecoupon', 'manage_coupon');
	add_submenu_page('product_menu.php', __("Manage Price"), __("Manage Price"), 8, 'price', 'manage_price');
if(get_option('ptthemes_enable_multicountry_flag')){add_submenu_page('product_menu.php', __("Manage Country"), __("Manage Country"), 8, 'country', 'manage_country');}
if(get_option('ptthemes_enable_multiregion_flag')){add_submenu_page('product_menu.php', __("Manage Region"), __("Manage Region"), 8, 'region', 'manage_region');}
	add_submenu_page('product_menu.php', __("Manage City"), __("Manage City"), 8, 'city', 'manage_city');
if(get_option('ptthemes_enable_multihood_flag')){add_submenu_page('product_menu.php', __("Manage Neighbourhoods"), __("Manage Neighbourhoods"), 8, 'hood', 'manage_hood');}	
	add_submenu_page('product_menu.php', __("Manage Post Custom Fields"), __("Post Custom Fields"), 8, 'custom', 'manage_custom');
	add_submenu_page('product_menu.php', __("Notifications"), __("Notifications"), 8, 'notification', 'notification');
	add_submenu_page('gt_tools', __("Import / Export"), __("Import / Export"), 8, 'bulk', 'bulk_upload');
	//add_submenu_page('product_menu.php', __("Tools"), __("Tools"), 8, 'tools', 'admin_tools');
	add_submenu_page('product_menu.php', __("Claim Listings"), __("Claim Listings").$claims_num1, 8, 'claimlistings', 'claim_listings');
	add_submenu_page('product_menu.php', __("Moderation"), __("Moderation").$mod_claims_num1 , 8, 'moderation', 'post_moderation');
	add_submenu_page('gt_tools', __("Convert Listings"), __("Convert Listings"), 8, 'convertlistings', 'convert_listings');
	add_submenu_page('gt_tools', __("Diagnostics"), __("Diagnostics"), 8, 'diagnostics', 'gt_diagnostics');
}}
if (!function_exists('manage_custom')) {
function manage_custom()
{
	apply_filters( 'templatic_custom_fields', include_once(TEMPLATEPATH . '/library/includes/admin_manage_custom_fields.php') )	;
}}
if (!function_exists('notification')) {
function notification()
{
	if($_REQUEST['file']!='')
	{
		include_once(TEMPLATEPATH . '/library/includes/admin_notification_edit.php');
	}else
	{
		include_once(TEMPLATEPATH . '/library/includes/admin_notification.php');
	}
}}
if (!function_exists('manage_city')) {
function manage_city()
{
	if($_REQUEST['pagetype']=='addedit')
	{
		include_once(TEMPLATEPATH . '/library/includes/admin_add_city.php');
	}else
	{
		include_once(TEMPLATEPATH . '/library/includes/admin_manage_city.php');
	}
}}
if (!function_exists('manage_region')) {
function manage_region()
{
	if($_REQUEST['pagetype']=='addedit')
	{
		include_once(TEMPLATEPATH . '/library/includes/admin_add_region.php');
	}else
	{
		include_once(TEMPLATEPATH . '/library/includes/admin_manage_region.php');
	}
}}
if (!function_exists('manage_hood')) {
function manage_hood()
{
	if($_REQUEST['pagetype']=='addedit')
	{
		include_once(TEMPLATEPATH . '/library/includes/admin_add_hood.php');
	}else
	{
		include_once(TEMPLATEPATH . '/library/includes/admin_manage_hood.php');
	}
}}
if (!function_exists('manage_country')) {
function manage_country()
{
	if($_REQUEST['pagetype']=='addedit')
	{
		include_once(TEMPLATEPATH . '/library/includes/admin_add_country.php');
	}else
	{
		include_once(TEMPLATEPATH . '/library/includes/admin_manage_country.php');
	}
}}
if (!function_exists('bulk_upload')) {
function bulk_upload()
{
	include_once(TEMPLATEPATH . '/library/includes/admin_bulk_upload.php');
}}
if (!function_exists('gt_tools')) {
function gt_tools()
{
	include_once(TEMPLATEPATH . '/library/includes/admin_manage_tools.php');
}}
if (!function_exists('app_settings')) {
function app_settings()
{
	include_once(TEMPLATEPATH . '/app/admin_app_settings.php');
}}
if (!function_exists('admin_settings')) {
function admin_settings()
{
	include_once(TEMPLATEPATH . '/library/includes/admin_settings.php');
}}
if (!function_exists('theme_settings')) {
function theme_settings()
{
	mytheme_add_admin();
}}
if (!function_exists('payment_options')) {
function payment_options()
{
	include_once(TEMPLATEPATH . '/library/includes/admin_paymethods.php');
}}
if (!function_exists('category_icons')) {
function category_icons()
{
	include_once(TEMPLATEPATH . '/library/includes/admin_category_icons.php');
}}
if (!function_exists('manage_coupon')) {
function manage_coupon()
{
	if($_REQUEST['pagetype']=='addedit')
	{
		include_once(TEMPLATEPATH . '/library/includes/admin_coupon.php');
	}else
	{
		include_once(TEMPLATEPATH . '/library/includes/admin_manage_coupon.php');
	}
}}
if (!function_exists('manage_price')) {
function manage_price()
{
	if($_REQUEST['pagetype']=='addedit')
	{
		include_once(TEMPLATEPATH . '/library/includes/admin_price.php');
	}else
	{
		include_once(TEMPLATEPATH . '/library/includes/admin_manage_price.php');
	}
}}
if (!function_exists('claim_listings')) {
function claim_listings()
{
	if($_REQUEST['pagetype']=='addedit')
	{
		include_once(TEMPLATEPATH . '/library/includes/admin_claim.php');
	}else
	{
		include_once(TEMPLATEPATH . '/library/includes/admin_manage_claim.php');
	}
}}
if (!function_exists('post_moderation')) {
function post_moderation()
{
	if($_REQUEST['pagetype']=='addedit')
	{
		include_once(TEMPLATEPATH . '/library/moderation/admin_moderation.php');
	}else
	{
		include_once(TEMPLATEPATH . '/library/moderation/admin_manage_moderation.php');
	}
}}
if (!function_exists('convert_listings')) {
function convert_listings()
{
	include_once(TEMPLATEPATH . '/library/includes/admin_convert.php');
}}

if (!function_exists('gt_diagnostics')) {
function gt_diagnostics()
{
	include_once(TEMPLATEPATH . '/library/includes/admin_diagnostics.php');
}}
?>