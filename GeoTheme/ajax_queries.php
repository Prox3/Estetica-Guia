<?php 

if($_REQUEST['ajax']=='get_countrys'){
echo get_country_location_menu();
}
if($_REQUEST['ajax']=='get_regions'){
echo get_region_locations();
}
if($_REQUEST['ajax']=='dig_regions' && $_REQUEST['country_id']){
$country_id = mysql_real_escape_string ($_REQUEST['country_id']);
echo get_region_location_menu($country_id);
}

if($_REQUEST['ajax']=='dig_cities' && $_REQUEST['region_id']){
$region_id = mysql_real_escape_string ($_REQUEST['region_id']);
echo get_region_city_location_menu($region_id);
}

if($_REQUEST['ajax']=='dig_hoods' && $_REQUEST['city_id']){
$city_id = mysql_real_escape_string ($_REQUEST['city_id']);
echo get_hoods_location_menu($city_id);
}


if($_REQUEST['ajax']=='get_cities'){
echo get_city_location_menu();
}

if($_REQUEST['ajax']=='get_hoods_dd' && $_REQUEST['city_id']){
$city_id = mysql_real_escape_string ($_REQUEST['city_id']);
echo get_multihood_dl_options($selected='',$default_option='',$att='', $city_id, $hood_id);
}


if($_REQUEST['ajax']=='lat' && $_REQUEST['city_id']){
$city_id = mysql_real_escape_string ($_REQUEST['city_id']);
echo get_city_lat($city_id);
}

if($_REQUEST['ajax']=='lng' && $_REQUEST['city_id']){
$city_id = mysql_real_escape_string ($_REQUEST['city_id']);
echo get_city_lng($city_id);
}

if($_REQUEST['ajax']=='latlng' && $_REQUEST['city_id']){
$city_id = mysql_real_escape_string ($_REQUEST['city_id']);
echo get_city_latlng($city_id);
}

if($_REQUEST['ajax']=='lat' && $_REQUEST['hood_id']){
$hood_id = mysql_real_escape_string ($_REQUEST['hood_id']);
echo get_hood_lat($hood_id);
}

if($_REQUEST['ajax']=='lng' && $_REQUEST['hood_id']){
$hood_id = mysql_real_escape_string ($_REQUEST['hood_id']);
echo get_hood_lng($hood_id);
}

if($_REQUEST['ajax']=='latlng' && $_REQUEST['hood_id']){
$hood_id = mysql_real_escape_string ($_REQUEST['hood_id']);
echo get_hood_latlng($hood_id);
}

#### FUNCTIONS FOR REPORTING POSTS #####
if($_REQUEST['ajax']=='report_form' && $_REQUEST['post_id']){
$post_id = mysql_real_escape_string ($_REQUEST['post_id']);
global $current_user;
if($current_user->ID){
echo gt_moderation_form($post_id);
}else{ echo REPORT_LOGIN_MSG;}
}

if($_REQUEST['ajax']=='report' && $_REQUEST['id']){
$id = mysql_real_escape_string ($_REQUEST['id']);
$mod_text = mysql_real_escape_string ($_REQUEST['modText']);
$reason = mysql_real_escape_string ($_REQUEST['reason']);
echo gt_moderation_submit($id,$reason,$mod_text);
}





?>