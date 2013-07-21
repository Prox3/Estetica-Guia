<?php
function geotheme_activation_setup(){
	
/////////////////PLACE PRICE SETTINGS CODING START/////////////////
global $wpdb,$table_prefix;
$price_db_table_name = $table_prefix . "price";
if($wpdb->get_var("SHOW TABLES LIKE \"$price_db_table_name\"") != $price_db_table_name)
{
$price_table = 'CREATE TABLE IF NOT EXISTS `'.$price_db_table_name.'` (
`pid` int(11) NOT NULL AUTO_INCREMENT,
`title` varchar(255) NOT NULL,
`amount` float(12,2) NOT NULL,
`cat` text NOT NULL,
`status` tinyint(2) NOT NULL DEFAULT \'1\',
`days` int(10) NOT NULL,
`is_featured` tinyint(4) NOT NULL DEFAULT \'0\',
`title_desc` text NOT NULL,
`property_feature_pkg` int(11) NOT NULL,
`timing_pkg` varchar(255) NOT NULL,
`contact_pkg` varchar(255) NOT NULL,
`email_pkg` varchar(255) NOT NULL,
`website_pkg` varchar(255) NOT NULL,
`twitter_pkg` varchar(255) NOT NULL,
`facebook_pkg` varchar(255) NOT NULL,
`kw_tags_pkg` varchar(255) NOT NULL,
`html_editor` varchar(255) NOT NULL,
`image_limit` varchar(255) NOT NULL,
`cat_limit` varchar(255) NOT NULL,
`post_type` varchar(255) NOT NULL,
`link_business_pkg` varchar(255) NOT NULL,
`recurring_pkg` varchar(255) NOT NULL,
`reg_desc_pkg` varchar(255) NOT NULL,
`reg_fees_pkg` varchar(255) NOT NULL,
`downgrade_pkg` varchar(255) NOT NULL,
`property_desc_pkg` varchar(255) NOT NULL,
`sort_order` int(11) NOT NULL,
PRIMARY KEY (`pid`)
)';
$wpdb->query($price_table);
$price_insert = '
INSERT INTO `'.$price_db_table_name.'` (`pid`,`title`,`amount`,`days`,`status`,`cat`,`is_featured`,`title_desc`,`property_feature_pkg`,`timing_pkg`,`contact_pkg`,`email_pkg`,`website_pkg`,`twitter_pkg`,`facebook_pkg`,`kw_tags_pkg`,`html_editor`,`image_limit`,`cat_limit`,`post_type`,`link_business_pkg`,`recurring_pkg`,`reg_desc_pkg`,`reg_fees_pkg`,`downgrade_pkg`,`property_desc_pkg`,`sort_order`) VALUES
(1, "Free", 0.00, 0, 1, "", 0, "", 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 2, "listing", 0, 0, 0, 0, "",1,1),
(2, "Featured", 10.00, 30, 1, "", 1, "", 1, 1, 1, 1, 1, 1, 1, 1, 1, 10, 10, "listing", 1, 1, 1, 1, "1",1,2),
(3, "Free", 0.00, 0, 1, "", 0, "", 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 2, "event", 0, 0, 0, 0, "",1,3),
(4, "Featured", 10.00, 30, 1, "", 1, "", 1, 1, 1, 1, 1, 1, 1, 1, 1, 10, 10, "event", 1, 1, 1, 1, "1",1,4)';
$wpdb->query($price_insert);
}else
{
$wpdb->query("ALTER TABLE $price_db_table_name ADD `is_featured` TINYINT( 4 ) NOT NULL DEFAULT '0'");
$wpdb->query("ALTER TABLE $price_db_table_name ADD `title_desc` TEXT NOT NULL");
$wpdb->query("ALTER TABLE $price_db_table_name ADD `cat` text NOT NULL");
$wpdb->query("ALTER TABLE $price_db_table_name MODIFY `cat` TEXT NOT NULL");

}
/////////////////PLACE PRICE SETTINGS CODING END/////////////////
/////////////////CLAIM LISTING SETTINGS CODING START/////////////////

$claim_db_table_name = $table_prefix . "claim";
if($wpdb->get_var("SHOW TABLES LIKE \"$claim_db_table_name\"") != $claim_db_table_name)
{
$claim_table = 'CREATE TABLE IF NOT EXISTS `'.$claim_db_table_name.'` (
`pid` int(11) NOT NULL AUTO_INCREMENT,
`list_id` varchar(255) NOT NULL,
`list_title` varchar(255) NOT NULL,
`user_id` varchar(255) NOT NULL,
`user_name` varchar(255) NOT NULL,
`user_email` varchar(255) NOT NULL,
`user_fullname` varchar(255) NOT NULL,
`user_number` varchar(255) NOT NULL,
`user_position` varchar(255) NOT NULL,
`user_comments` longtext NOT NULL,
`admin_comments` longtext NOT NULL,
`claim_date` varchar(255) NOT NULL,
`org_author` varchar(255) NOT NULL,
`org_authorid` varchar(255) NOT NULL,
`rand_string` varchar(255) NOT NULL,
`status` varchar(255) NOT NULL,
`user_ip` varchar(255) NOT NULL,
PRIMARY KEY (`pid`)
)';
$wpdb->query($claim_table);
$claim_insert = '
INSERT INTO `'.$claim_db_table_name.'` (`pid`, `list_id`, `list_title`, `user_id`, `user_name`, `user_email`, `user_fullname`, `user_number`, `user_position`, `user_comments`, `admin_comments`, `claim_date`, `org_author`, `org_authorid`, `rand_string`, `status`, `user_ip`) VALUES
(1, 1, "Delete me", 1, "MyUserName", "my@email.com", "James Bond", "07877777777", "Manager", "I am the manager and i would like to claim this listing", "admin comments here", "1 april 2011", "Admin", 1, "xxxyyyzzz111222333", 2, "192.168.2.1")';
$wpdb->query($claim_insert);
}else
{
$wpdb->query("ALTER TABLE $claim_db_table_name MODIFY `user_comments` longtext NOT NULL");
$wpdb->query("ALTER TABLE $claim_db_table_name MODIFY `admin_comments` longtext NOT NULL");
}
/////////////////CLAIM LISTING SETTINGS CODING END/////////////////
/////////////////MODERATION SETTINGS CODING START/////////////////

$moderation_db_table_name = $table_prefix . "gt_moderation";
if($wpdb->get_var("SHOW TABLES LIKE \"$moderation_db_table_name\"") != $moderation_db_table_name)
{
$moderation_table = 'CREATE TABLE IF NOT EXISTS `'.$moderation_db_table_name.'` (
`pid` int(11) NOT NULL AUTO_INCREMENT,
`list_id` varchar(255) NOT NULL,
`list_title` varchar(255) NOT NULL,
`user_id` varchar(255) NOT NULL,
`user_comments` longtext NOT NULL,
`user_ip` varchar(255) NOT NULL,
`admin_comments` longtext NOT NULL,
`claim_date` varchar(255) NOT NULL,
`moderation_reason` varchar(255) NOT NULL,
`authorid` varchar(255) NOT NULL,
`status` varchar(255) NOT NULL,
PRIMARY KEY (`pid`)
)';
$wpdb->query($moderation_table);
//INSERT INTO `'.$moderation_db_table_name.'` (`list_id`, `list_title`, `user_id`, `user_comments`, `user_ip`, `admin_comments`, `claim_date`, `moderation_reason`, `authorid`, `status`) VALUES
//("'.$post_id.'", "'.$reported['post_title'].'", '.$current_user->ID.', "'.$mod_text.'", "'.$_SERVER['REMOTE_ADDR'].'", "James Bond", "07877777777", "Manager", "I am the manager and i would like to claim this listing", "admin comments here", "1 april 2011", "Admin", 1, "xxxyyyzzz111222333", 2, "192.168.2.1")';
//$wpdb->query($moderation_insert);
}
/////////////////MODERATION SETTINGS CODING END/////////////////
////////////////////// BREADCRUM SQL START ////////////////////////
$breadcrum_insert = "INSERT INTO `".$table_prefix."options` (`option_id`, `blog_id`, `option_name`, `option_value`, `autoload`) VALUES
('', 0, 'bcn_version', '3.9.0', 'no'),
('', 0, 'bcn_options_bk', 'a:93:{s:16:\"mainsite_display\";b:1;s:14:\"mainsite_title\";s:4:\"Home\";s:15:\"mainsite_anchor\";s:40:\"<a title=\"Go to %title%.\" href=\"%link%\">\";s:15:\"mainsite_prefix\";s:0:\"\";s:15:\"mainsite_suffix\";s:0:\"\";s:12:\"home_display\";b:1;s:10:\"home_title\";s:4:\"Blog\";s:11:\"home_anchor\";s:40:\"<a title=\"Go to %title%.\" href=\"%link%\">\";s:12:\"blog_display\";b:1;s:11:\"blog_anchor\";s:40:\"<a title=\"Go to %title%.\" href=\"%link%\">\";s:11:\"home_prefix\";s:0:\"\";s:11:\"home_suffix\";s:0:\"\";s:9:\"separator\";s:6:\" &gt; \";s:16:\"max_title_length\";i:0;s:19:\"current_item_linked\";b:0;s:19:\"current_item_anchor\";s:50:\"<a title=\"Reload the current page.\" href=\"%link%\">\";s:19:\"current_item_prefix\";s:0:\"\";s:19:\"current_item_suffix\";s:0:\"\";s:16:\"post_page_prefix\";s:0:\"\";s:16:\"post_page_suffix\";s:0:\"\";s:16:\"post_page_anchor\";s:40:\"<a title=\"Go to %title%.\" href=\"%link%\">\";s:14:\"post_page_root\";s:1:\"0\";s:12:\"paged_prefix\";s:0:\"\";s:12:\"paged_suffix\";s:0:\"\";s:13:\"paged_display\";b:0;s:16:\"post_post_prefix\";s:0:\"\";s:16:\"post_post_suffix\";s:0:\"\";s:16:\"post_post_anchor\";s:40:\"<a title=\"Go to %title%.\" href=\"%link%\">\";s:14:\"post_post_root\";s:1:\"0\";s:26:\"post_post_taxonomy_display\";b:1;s:23:\"post_post_taxonomy_type\";s:8:\"category\";s:17:\"attachment_prefix\";s:0:\"\";s:17:\"attachment_suffix\";s:0:\"\";s:10:\"404_prefix\";s:0:\"\";s:10:\"404_suffix\";s:0:\"\";s:9:\"404_title\";s:3:\"404\";s:13:\"search_prefix\";s:24:\"Search results for &#39;\";s:13:\"search_suffix\";s:5:\"&#39;\";s:13:\"search_anchor\";s:77:\"<a title=\"Go to the first page of search results for %title%.\" href=\"%link%\">\";s:15:\"post_tag_prefix\";s:0:\"\";s:15:\"post_tag_suffix\";s:0:\"\";s:15:\"post_tag_anchor\";s:57:\"<a title=\"Go to the %title% tag archives.\" href=\"%link%\">\";s:13:\"author_prefix\";s:13:\"Content by: \";s:13:\"author_suffix\";s:0:\"\";s:13:\"author_anchor\";s:67:\"<a title=\"Go to the first page of posts by %title%.\" href=\"%link%\">\";s:11:\"author_name\";s:12:\"display_name\";s:15:\"category_prefix\";s:0:\"\";s:15:\"category_suffix\";s:0:\"\";s:15:\"category_anchor\";s:62:\"<a title=\"Go to the %title% category archives.\" href=\"%link%\">\";s:23:\"archive_category_prefix\";s:25:\"Archive by category &#39;\";s:23:\"archive_category_suffix\";s:5:\"&#39;\";s:23:\"archive_post_tag_prefix\";s:20:\"Archive by tag &#39;\";s:23:\"archive_post_tag_suffix\";s:5:\"&#39;\";s:11:\"date_anchor\";s:53:\"<a title=\"Go to the %title% archives.\" href=\"%link%\">\";s:19:\"archive_date_prefix\";s:0:\"\";s:19:\"archive_date_suffix\";s:0:\"\";s:17:\"post_event_prefix\";s:0:\"\";s:17:\"post_event_suffix\";s:0:\"\";s:17:\"post_event_anchor\";s:40:\"<a title=\"Go to %title%.\" href=\"%link%\">\";s:15:\"post_event_root\";s:1:\"0\";s:27:\"post_event_taxonomy_display\";b:1;s:24:\"post_event_taxonomy_type\";s:13:\"eventcategory\";s:17:\"post_place_prefix\";s:0:\"\";s:17:\"post_place_suffix\";s:0:\"\";s:17:\"post_place_anchor\";s:40:\"<a title=\"Go to %title%.\" href=\"%link%\">\";s:15:\"post_place_root\";s:1:\"0\";s:27:\"post_place_taxonomy_display\";b:1;s:24:\"post_place_taxonomy_type\";s:13:\"placecategory\";s:20:\"eventcategory_prefix\";s:0:\"\";s:20:\"eventcategory_suffix\";s:0:\"\";s:20:\"eventcategory_anchor\";s:70:\"<a title=\"Go to the %title% Event Categories archives.\" href=\"%link%\">\";s:28:\"archive_eventcategory_prefix\";s:0:\"\";s:28:\"archive_eventcategory_suffix\";s:0:\"\";s:17:\"event_tags_prefix\";s:0:\"\";s:17:\"event_tags_suffix\";s:0:\"\";s:17:\"event_tags_anchor\";s:64:\"<a title=\"Go to the %title% Event Tags archives.\" href=\"%link%\">\";s:25:\"archive_event_tags_prefix\";s:0:\"\";s:25:\"archive_event_tags_suffix\";s:0:\"\";s:20:\"placecategory_prefix\";s:0:\"\";s:20:\"placecategory_suffix\";s:0:\"\";s:20:\"placecategory_anchor\";s:70:\"<a title=\"Go to the %title% Place Categories archives.\" href=\"%link%\">\";s:28:\"archive_placecategory_prefix\";s:0:\"\";s:28:\"archive_placecategory_suffix\";s:0:\"\";s:17:\"place_tags_prefix\";s:0:\"\";s:17:\"place_tags_suffix\";s:0:\"\";s:17:\"place_tags_anchor\";s:64:\"<a title=\"Go to the %title% Place Tags archives.\" href=\"%link%\">\";s:25:\"archive_place_tags_prefix\";s:0:\"\";s:25:\"archive_place_tags_suffix\";s:0:\"\";s:11:\"city_prefix\";s:0:\"\";s:11:\"city_suffix\";s:0:\"\";s:11:\"city_anchor\";s:63:\"<a title=\"Go to the %title% Post Tags archives.\" href=\"%link%\">\";s:19:\"archive_city_prefix\";s:0:\"\";s:19:\"archive_city_suffix\";s:0:\"\";}', 'no'),
('', 0, 'bcn_options', 'a:93:{s:16:\"mainsite_display\";b:0;s:14:\"mainsite_title\";s:4:\"Home\";s:15:\"mainsite_anchor\";s:40:\"<a title=\"Go to %title%.\" href=\"%link%\">\";s:15:\"mainsite_prefix\";s:0:\"\";s:15:\"mainsite_suffix\";s:0:\"\";s:12:\"home_display\";b:1;s:10:\"home_title\";s:4:\"Home\";s:11:\"home_anchor\";s:40:\"<a title=\"Go to %title%.\" href=\"%link%\">\";s:12:\"blog_display\";b:0;s:11:\"blog_anchor\";s:40:\"<a title=\"Go to %title%.\" href=\"%link%\">\";s:11:\"home_prefix\";s:0:\"\";s:11:\"home_suffix\";s:0:\"\";s:9:\"separator\";s:6:\" &gt; \";s:16:\"max_title_length\";s:1:\"0\";s:19:\"current_item_linked\";b:0;s:19:\"current_item_anchor\";s:50:\"<a title=\"Reload the current page.\" href=\"%link%\">\";s:19:\"current_item_prefix\";s:0:\"\";s:19:\"current_item_suffix\";s:0:\"\";s:16:\"post_page_prefix\";s:0:\"\";s:16:\"post_page_suffix\";s:0:\"\";s:16:\"post_page_anchor\";s:40:\"<a title=\"Go to %title%.\" href=\"%link%\">\";s:14:\"post_page_root\";s:1:\"0\";s:12:\"paged_prefix\";s:0:\"\";s:12:\"paged_suffix\";s:0:\"\";s:13:\"paged_display\";b:0;s:16:\"post_post_prefix\";s:0:\"\";s:16:\"post_post_suffix\";s:0:\"\";s:16:\"post_post_anchor\";s:40:\"<a title=\"Go to %title%.\" href=\"%link%\">\";s:14:\"post_post_root\";s:1:\"0\";s:26:\"post_post_taxonomy_display\";b:1;s:23:\"post_post_taxonomy_type\";s:8:\"category\";s:17:\"attachment_prefix\";s:0:\"\";s:17:\"attachment_suffix\";s:0:\"\";s:10:\"404_prefix\";s:0:\"\";s:10:\"404_suffix\";s:0:\"\";s:9:\"404_title\";s:3:\"404\";s:13:\"search_prefix\";s:24:\"Search results for &#39;\";s:13:\"search_suffix\";s:5:\"&#39;\";s:13:\"search_anchor\";s:77:\"<a title=\"Go to the first page of search results for %title%.\" href=\"%link%\">\";s:15:\"post_tag_prefix\";s:0:\"\";s:15:\"post_tag_suffix\";s:0:\"\";s:15:\"post_tag_anchor\";s:57:\"<a title=\"Go to the %title% tag archives.\" href=\"%link%\">\";s:13:\"author_prefix\";s:13:\"Articles by: \";s:13:\"author_suffix\";s:0:\"\";s:13:\"author_anchor\";s:67:\"<a title=\"Go to the first page of posts by %title%.\" href=\"%link%\">\";s:11:\"author_name\";s:12:\"display_name\";s:15:\"category_prefix\";s:0:\"\";s:15:\"category_suffix\";s:0:\"\";s:15:\"category_anchor\";s:62:\"<a title=\"Go to the %title% category archives.\" href=\"%link%\">\";s:23:\"archive_category_prefix\";s:25:\"Archive by category &#39;\";s:23:\"archive_category_suffix\";s:5:\"&#39;\";s:23:\"archive_post_tag_prefix\";s:20:\"Archive by tag &#39;\";s:23:\"archive_post_tag_suffix\";s:5:\"&#39;\";s:11:\"date_anchor\";s:53:\"<a title=\"Go to the %title% archives.\" href=\"%link%\">\";s:19:\"archive_date_prefix\";s:0:\"\";s:19:\"archive_date_suffix\";s:0:\"\";s:17:\"post_event_prefix\";s:0:\"\";s:17:\"post_event_suffix\";s:0:\"\";s:17:\"post_event_anchor\";s:40:\"<a title=\"Go to %title%.\" href=\"%link%\">\";s:15:\"post_event_root\";s:1:\"0\";s:27:\"post_event_taxonomy_display\";b:1;s:24:\"post_event_taxonomy_type\";s:13:\"eventcategory\";s:17:\"post_place_prefix\";s:0:\"\";s:17:\"post_place_suffix\";s:0:\"\";s:17:\"post_place_anchor\";s:40:\"<a title=\"Go to %title%.\" href=\"%link%\">\";s:15:\"post_place_root\";s:1:\"0\";s:27:\"post_place_taxonomy_display\";b:1;s:24:\"post_place_taxonomy_type\";s:13:\"placecategory\";s:20:\"eventcategory_prefix\";s:0:\"\";s:20:\"eventcategory_suffix\";s:0:\"\";s:20:\"eventcategory_anchor\";s:70:\"<a title=\"Go to the %title% Event Categories archives.\" href=\"%link%\">\";s:28:\"archive_eventcategory_prefix\";s:0:\"\";s:28:\"archive_eventcategory_suffix\";s:0:\"\";s:17:\"event_tags_prefix\";s:0:\"\";s:17:\"event_tags_suffix\";s:0:\"\";s:17:\"event_tags_anchor\";s:64:\"<a title=\"Go to the %title% Event Tags archives.\" href=\"%link%\">\";s:25:\"archive_event_tags_prefix\";s:0:\"\";s:25:\"archive_event_tags_suffix\";s:0:\"\";s:20:\"placecategory_prefix\";s:0:\"\";s:20:\"placecategory_suffix\";s:0:\"\";s:20:\"placecategory_anchor\";s:70:\"<a title=\"Go to the %title% Place Categories archives.\" href=\"%link%\">\";s:28:\"archive_placecategory_prefix\";s:0:\"\";s:28:\"archive_placecategory_suffix\";s:0:\"\";s:17:\"place_tags_prefix\";s:0:\"\";s:17:\"place_tags_suffix\";s:0:\"\";s:17:\"place_tags_anchor\";s:64:\"<a title=\"Go to the %title% Place Tags archives.\" href=\"%link%\">\";s:25:\"archive_place_tags_prefix\";s:0:\"\";s:25:\"archive_place_tags_suffix\";s:0:\"\";s:11:\"city_prefix\";s:0:\"\";s:11:\"city_suffix\";s:0:\"\";s:11:\"city_anchor\";s:63:\"<a title=\"Go to the %title% Post Tags archives.\" href=\"%link%\">\";s:19:\"archive_city_prefix\";s:0:\"\";s:19:\"archive_city_suffix\";s:0:\"\";}', 'yes')";
if(get_option('bcn_version')=='3.9.0'){}else{$wpdb->query($breadcrum_insert);}
 


////////////////////// BREADCRUM SQL START ////////////////////////

	
//////////////////// MULTI CITY START //////////////////////////////////
$multicity_db_table_name = $table_prefix . "multicity"; // DATABASE TABLE  MULTY CITY
$wpdb->query("CREATE TABLE IF NOT EXISTS `".$multicity_db_table_name."` (
  `city_id` int(11) NOT NULL AUTO_INCREMENT,
  `cityname` varchar(255) NOT NULL,
  `city_slug` varchar(255) NOT NULL,
  `lat` varchar(255) NOT NULL,
  `lng` varchar(255) NOT NULL,
  `scall_factor` int(100) NOT NULL,
  `sortorder` int(11) NOT NULL,
  `is_zoom_home` varchar(100) NOT NULL,
  `categories` text NOT NULL,
  `is_default` tinyint(4) NOT NULL DEFAULT '0',
  `cat_ex` VARCHAR( 255 ) NOT NULL,
  `home_desc` TEXT NOT NULL,
  `meta_desc` TEXT NOT NULL,
  PRIMARY KEY (`city_id`)
)");
//////////////////// MULTI CITY  END //////////////////////////////////
//////////////////// MULTI REGION START //////////////////////////////////
$multiregion_db_table_name = $table_prefix . "multiregion"; // DATABASE TABLE  MULTY REGION
$wpdb->query("CREATE TABLE IF NOT EXISTS `".$multiregion_db_table_name."` (
  `region_id` int(11) NOT NULL AUTO_INCREMENT,
  `regionname` varchar(255) NOT NULL,
  `region_slug` varchar(255) NOT NULL,
  `lat` varchar(255) NOT NULL,
  `lng` varchar(255) NOT NULL,
  `scall_factor` int(100) NOT NULL,
  `sortorder` int(11) NOT NULL,
  `is_zoom_home` varchar(100) NOT NULL,
  `categories` text NOT NULL,
  `cities` text NOT NULL,
  `is_default` tinyint(4) NOT NULL DEFAULT '0',
  `cat_ex` VARCHAR( 255 ) NOT NULL,
  `home_desc` TEXT NOT NULL,
  `meta_desc` TEXT NOT NULL,
  PRIMARY KEY (`region_id`)
)");
//////////////////// MULTI REGION  END //////////////////////////////////
//////////////////// MULTI COUNTRY START //////////////////////////////////
$multicountry_db_table_name = $table_prefix . "multicountry"; // DATABASE TABLE  MULTY COUNTRY
$wpdb->query("CREATE TABLE IF NOT EXISTS `".$multicountry_db_table_name."` (
  `country_id` int(11) NOT NULL AUTO_INCREMENT,
  `countryname` varchar(255) NOT NULL,
  `country_slug` varchar(255) NOT NULL,
  `lat` varchar(255) NOT NULL,
  `lng` varchar(255) NOT NULL,
  `scall_factor` int(100) NOT NULL,
  `sortorder` int(11) NOT NULL,
  `is_zoom_home` varchar(100) NOT NULL,
  `categories` text NOT NULL,
  `cities` text NOT NULL,
  `regions` text NOT NULL,
  `is_default` tinyint(4) NOT NULL DEFAULT '0',
  `cat_ex` VARCHAR( 255 ) NOT NULL,
  `home_desc` TEXT NOT NULL,
  `meta_desc` TEXT NOT NULL,
  PRIMARY KEY (`country_id`)
)");
//////////////////// MULTI COUNTRY  END //////////////////////////////////
//////////////////// MULTI REGION START //////////////////////////////////
$multihood_db_table_name = $table_prefix . "multihood"; // DATABASE TABLE  MULTY REGION
$wpdb->query("CREATE TABLE IF NOT EXISTS `".$multihood_db_table_name."` (
  `hood_id` int(11) NOT NULL AUTO_INCREMENT,
  `hoodname` varchar(255) NOT NULL,
  `hood_slug` varchar(255) NOT NULL,
  `lat` varchar(255) NOT NULL,
  `lng` varchar(255) NOT NULL,
  `scall_factor` int(100) NOT NULL,
  `sortorder` int(11) NOT NULL,
  `is_zoom_home` varchar(100) NOT NULL,
  `categories` text NOT NULL,
  `cities` text NOT NULL,
  `is_default` tinyint(4) NOT NULL DEFAULT '0',
  `cat_ex` VARCHAR( 255 ) NOT NULL,
  `home_desc` TEXT NOT NULL,
  `meta_desc` TEXT NOT NULL,
  PRIMARY KEY (`hood_id`)
)");
//////////////////// MULTI REGION  END //////////////////////////////////
//////////////////// CUSTOM POST META START //////////////////////////////////

$gp = $table_prefix . "templatic_custom_post_fields";
$gt = $table_prefix . "geotheme_custom_post_fields";
$gpe = $wpdb->query("SHOW TABLES LIKE '".$gp."'");
if($gpe>0){$tb2 = $wpdb->query("RENAME TABLE $gp TO $gt");}

$custom_post_meta_db_table_name = $table_prefix . "geotheme_custom_post_fields";
$wpdb->query('CREATE TABLE IF NOT EXISTS `'.$custom_post_meta_db_table_name.'` (
	  `cid` int(11) NOT NULL AUTO_INCREMENT,
	  `admin_title` varchar(255) NOT NULL,
	  `htmlvar_name` varchar(255) NOT NULL,
	  `admin_desc` text NOT NULL,
	  `site_title` varchar(255) NOT NULL,
	  `ctype` varchar(255) NOT NULL COMMENT "text,checkbox,radio,select,textarea",
	  `default_value` text NOT NULL,
	  `option_values` text NOT NULL,
	  `clabels` text NOT NULL,
	  `sort_order` int(11) NOT NULL,
	  `is_active` tinyint(4) NOT NULL DEFAULT "1",
	  `show_on_listing` tinyint(4) NOT NULL DEFAULT "1",
	  `show_on_detail` tinyint(4) NOT NULL DEFAULT "1",
	  `extrafield1` text NOT NULL,
	  `extrafield2` text NOT NULL,
	  `cat_sort` text NOT NULL,
	  `cat_filter` text NOT NULL,
	  PRIMARY KEY (`cid`)
	)');
//////////////////// CUSTOM POST META END //////////////////////////////////
//////////////////// WEE UPDATE START //////////////////////////////////
$term_icon_column=$wpdb->get_var("SHOW COLUMNS FROM $wpdb->terms where field='term_icon'");
if(!$term_icon_column)
{
$wpdb->query("ALTER TABLE $wpdb->terms ADD `term_icon` TEXT NULL DEFAULT NULL");
}
//////////////////// WEE UPDATE END //////////////////////////////////
//////////////////// RATINGS TABLE START //////////////////////////////////
$rating_table_name = $wpdb->prefix.'ratings';
$wpdb->query("CREATE TABLE IF NOT EXISTS $rating_table_name (
  rating_id int(11) NOT NULL AUTO_INCREMENT,
  rating_postid int(11) NOT NULL,
  rating_posttitle text NOT NULL,
  rating_rating int(2) NOT NULL,
  rating_timestamp varchar(15) NOT NULL,
  rating_ip varchar(40) NOT NULL,
  rating_host varchar(200) NOT NULL,
  rating_username varchar(50) NOT NULL,
  rating_userid int(10) NOT NULL DEFAULT '0',
  comment_id int(11) NOT NULL,
  PRIMARY KEY (rating_id)
) ENGINE=MyISAM");

//$wpdb->query("ALTER TABLE $rating_table_name MODIFY `rating_posttitle` TEXT NOT NULL");
//////////////////// RATINGS TABLE END //////////////////////////////////

############################################################################
#################### UPDATE THE LOCATION DATABASES #########################
############################################################################
global $wpdb,$multiregion_db_table_name,$multicity_db_table_name,$multicountry_db_table_name,$multihood_db_table_name;
// CITY
add_column_if_not_exist($multicity_db_table_name, 'city_slug');
add_column_if_not_exist($multicity_db_table_name, 'cat_ex');
// COUNTRY
add_column_if_not_exist($multicountry_db_table_name, 'cat_ex');
// HOOD
add_column_if_not_exist($multihood_db_table_name, 'cat_ex');
// REGION
add_column_if_not_exist($multiregion_db_table_name, 'cat_ex');

############################################################################
#################### UPDATE THE PRICE DATABASES ############################
############################################################################
global $price_db_table_name;
add_column_if_not_exist($price_db_table_name, 'property_desc_pkg');
add_column_if_not_exist($price_db_table_name, 'property_feature_pkg');
add_column_if_not_exist($price_db_table_name, 'timing_pkg');
add_column_if_not_exist($price_db_table_name, 'contact_pkg');
add_column_if_not_exist($price_db_table_name, 'email_pkg');
add_column_if_not_exist($price_db_table_name, 'website_pkg');
add_column_if_not_exist($price_db_table_name, 'twitter_pkg');
add_column_if_not_exist($price_db_table_name, 'facebook_pkg');
add_column_if_not_exist($price_db_table_name, 'kw_tags_pkg');
add_column_if_not_exist($price_db_table_name, 'image_limit');
add_column_if_not_exist($price_db_table_name, 'cat_limit');
add_column_if_not_exist($price_db_table_name, 'html_editor');
add_column_if_not_exist($price_db_table_name, 'html_editor');
add_column_if_not_exist($price_db_table_name, 'post_type');
add_column_if_not_exist($price_db_table_name, 'link_business_pkg');
add_column_if_not_exist($price_db_table_name, 'recurring_pkg');
add_column_if_not_exist($price_db_table_name, 'reg_desc_pkg');
add_column_if_not_exist($price_db_table_name, 'reg_fees_pkg');
add_column_if_not_exist($price_db_table_name, 'downgrade_pkg');
add_column_if_not_exist($price_db_table_name, 'listing_desc_pkg');
add_column_if_not_exist($price_db_table_name, 'google_analytics');
add_column_if_not_exist($price_db_table_name, 'video_pkg');
//Recurring payments
add_column_if_not_exist($price_db_table_name, 'sub_active');
add_column_if_not_exist($price_db_table_name, 'sub_units');
add_column_if_not_exist($price_db_table_name, 'sub_units_num');

	

if(!get_option("medium_crop"))
add_option("medium_crop", "0");
else
update_option("medium_crop", "0");

} // END MAIN FUNCTION geotheme_activation_setup

