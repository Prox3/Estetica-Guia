<?php
session_start();
ob_start();
$multicity_db_table_name = $table_prefix . "multicity"; // DATABASE TABLE  MULTY CITY
$multiregion_db_table_name = $table_prefix . "multiregion"; // DATABASE TABLE  MULTY REGION
$multicountry_db_table_name = $table_prefix . "multicountry"; // DATABASE TABLE  MULTY COUNTRY
$multihood_db_table_name = $table_prefix . "multihood"; // DATABASE TABLE  MULTY COUNTRY

$city_info = get_multicity_name_info();
if(count($city_info)>1)
{	if(isset($_GET['multi_city']) && $_GET['multi_city']=='clear'){echo 'multi_city session clear';$_SESSION['multi_city']='';exit;}

	if(($_SESSION['multi_city']=='' && get_option('user_near')==1 && $_GET['multi_city']!='find') || ($_GET['multi_city']=='findme') )
	{	
		$home_url = site_url();
		//echo $home_url;
		$goe_locate = '<script type="text/javascript"
  src="http://maps.google.com/maps/api/js?sensor=true"></script> 
<script type="text/javascript" src="http://gmaps-samples-v3.googlecode.com/svn/trunk/geolocate/geometa.js"></script> 
 
<script type="text/javascript"> 
// <![CDATA[ 
onload = initialise();
  function initialise() {
    var latlng = new google.maps.LatLng(-25.363882,131.044922);
    var myOptions = {
      zoom: 4,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.TERRAIN,
      disableDefaultUI: true
    }
	
    prepareGeolocation();
    doGeolocation();
  }
 
  function doGeolocation() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(positionSuccess, positionError);
    } else {
      positionError(-1);
    }
  }
 
  function positionError(err) {
    var msg;
    switch(err.code) {
      case err.UNKNOWN_ERROR:
        msg = "Unable to find your location";
        break;
      case err.PERMISSION_DENINED:
        msg = "Permission denied in finding your location";
        break;
      case err.POSITION_UNAVAILABLE:
        msg = "Your location is currently unknown";
        break;
      case err.BREAK:
        msg = "Attempt to find location took too long";
        break;
      default:
        msg = "Location detection not supported in browser";
    }
    //document.getElementById(\'info\').innerHTML = msg;
    alert(msg);
  }
 
  function positionSuccess(position) {
    // Centre the map on the new location
    var coords = position.coords || position.coordinate || position;
    
 //alert(coords.latitude + \', \' + coords.longitude );
 window.location = "'. $home_url. '/?multi_city=find&cus_lat="+coords.latitude+"&cus_lon="+coords.longitude+"&redirect="+document.location.href;
   
  }

 // ]]> 
</script> ';}
	else if(isset($_GET['multi_city']) && $_GET['multi_city']=='find')
	{
		global $wpdb;
$cus_lat = $_GET['cus_lat'];
$cus_lon = $_GET['cus_lon'];
$redirect = $_GET['redirect'];
if($cus_lat && $cus_lon){
$near_city_id = $wpdb->get_var("SELECT city_id, ( 3959 * acos( cos( radians($cus_lat) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians($cus_lon) ) + sin( radians($cus_lat) ) * sin( radians( lat ) ) ) ) AS distance FROM $multicity_db_table_name  ORDER BY distance"); 
//echo $near_city_id;
$_SESSION['multi_city'] = $near_city_id;
$_SESSION['location_name'] =  $wpdb->get_var("select cityname from $multicity_db_table_name where city_id=\"$near_city_id\"");
$_SESSION['location_slug'] =  $wpdb->get_var("select city_slug from $multicity_db_table_name where city_id=\"$near_city_id\"");
}else{
$_SESSION['multi_city'] = $wpdb->get_var("select city_id from $multicity_db_table_name where is_default=1");
$_SESSION['location_name'] =  $wpdb->get_var("select cityname from $multicity_db_table_name where where is_default=1");
$_SESSION['location_slug'] =  $wpdb->get_var("select city_slug from $multicity_db_table_name where where is_default=1");
}
if(strstr($redirect,'=findme')){header( 'Location: '.home_url() );exit;}else{header( 'Location: '.$redirect );exit;}
	}else
	{
		if(isset($_GET['multi_city']) && ($_GET['multi_city']!='' || $_SESSION['multi_city']) && get_option('ptthemes_enable_multicity_flag'))
		{
			if($_GET['multi_city']!='')
			{
				$city_slug = mysql_real_escape_string ($_GET['multi_city']);
				$_SESSION['multi_city']= $wpdb->get_var("select city_id from $multicity_db_table_name where city_slug=\"$city_slug\"");	
				if(!$_SESSION['multi_city']){$_SESSION['multi_city']=$_GET['multi_city'];} //Set city array ID	
				$_SESSION['multi_country'] = false;
				$_SESSION['multi_region'] = false;
				$_SESSION['area'] = false;
				$_SESSION['location_name'] =  $wpdb->get_var("select cityname from $multicity_db_table_name where city_slug=\"$city_slug\"");
				if(!$_SESSION['location_name']) { $_SESSION['location_name'] = $wpdb->get_var("select cityname from $multicity_db_table_name where city_id=\"$city_slug\"");}
				$_SESSION['location_slug'] =  $city_slug;

			}
			//$_SESSION['multi_city_name']= get_multicity_city_settings($_GET['multi_city']); //set city name to session
		}	
	}
}else
{
	$city_id_key = array_keys($city_info);
	//$_SESSION['multi_city']=$city_id_key[0]; //Set city array ID
	$_SESSION['location_name'] =  $wpdb->get_var("select cityname from $multicity_db_table_name where is_default=1");
	$_SESSION['multi_city_default']=$wpdb->get_var("select city_id from $multicity_db_table_name where is_default=1");

}
$cur_city_def = $_SESSION['multi_city'];
//$_SESSION['location_name']='';
if(!$_SESSION['location_name']){$_SESSION['location_name'] =  $wpdb->get_var("select cityname from $multicity_db_table_name where city_id=\"$cur_city_def\"");}


##################################### STAT/REGION FUNCTION ##########################################################
if($_GET['multi_region']){
$region_slug = mysql_real_escape_string ($_GET['multi_region']);
$region_id = $wpdb->get_var("select region_id from $multiregion_db_table_name where region_slug=\"$region_slug\"");
$city_arr = $wpdb->get_var("select cities from $multiregion_db_table_name where region_id=$region_id");
$_SESSION['multi_city'] = $city_arr;
$_SESSION['multi_region'] = $region_id;
$_SESSION['multi_country'] = false;
$_SESSION['area'] = false;
$_SESSION['location_name'] =  $wpdb->get_var("select regionname from $multiregion_db_table_name where region_id=$region_id");
$_SESSION['location_slug'] =  $region_slug;

	}
##################################### END REGION FUNCTION ######################################################
##################################### STAT HOOD FUNCTION ##########################################################
if($_GET['area']){
$hood_slug = mysql_real_escape_string ($_GET['area']);
$hood_id = $wpdb->get_var("select hood_id from $multihood_db_table_name where hood_slug=\"$hood_slug\"");
$city_id = $wpdb->get_var("select cities from $multihood_db_table_name where hood_id=$hood_id");
$_SESSION['area'] = $hood_id;
$_SESSION['multi_city'] = $city_id;
$_SESSION['multi_region'] = false;
$_SESSION['multi_country'] = false;
$_SESSION['location_name'] = $wpdb->get_var("select hoodname from $multihood_db_table_name where hood_id=$hood_id");
$_SESSION['location_slug'] = '';
	}
##################################### END HOOD FUNCTION ######################################################
##################################### COUNTRY FUNCTION ##########################################################
if($_GET['multi_country']){
$country_slug = mysql_real_escape_string ($_GET['multi_country']);
$country_id = $wpdb->get_var("select country_id from $multicountry_db_table_name where country_slug=\"$country_slug\"");
$region_arr = $wpdb->get_var("select regions from $multicountry_db_table_name where country_id=$country_id");
if($region_arr){
	$region_arr = explode(',',$region_arr);
	$city_ids=array();
	foreach($region_arr as $region){
		$get_city_ids =  $wpdb->get_var("select cities from $multiregion_db_table_name where region_id=$region");
		if($get_city_ids){$city_ids[] = $get_city_ids;}
		}
		$city_ids = implode(',',$city_ids);
	}else{
$city_ids = $wpdb->get_var("select cities from $multicountry_db_table_name where country_id=$country_id");
	}
$_SESSION['multi_city'] = $city_ids;
$_SESSION['multi_country'] = $country_id;
$_SESSION['multi_region'] = false;
$_SESSION['area'] = false;
$_SESSION['location_name'] =  $wpdb->get_var("select countryname from $multicountry_db_table_name where country_id=$country_id");
$_SESSION['location_slug'] =  $country_slug;

	}
##################################### END COUNTRY FUNCTION ######################################################

if(get_option('ptthemes_enable_multicity_flag') && $_SESSION['multi_city']=='')
{//echo'i set it';
	$_SESSION['multi_city']=$wpdb->get_var("select city_id from $multicity_db_table_name where (is_default=1)");
}else
if(!get_option('ptthemes_enable_multicity_flag'))
{
	$default_city = $wpdb->get_var("select city_id from $multicity_db_table_name where (is_default=1)");
	if($default_city)
	{
		$_SESSION['multi_city']=$default_city;	
	}else
	{
		$_SESSION['multi_city'] = '';	
	}	
}

function get_multi_city_id(){
if($_SESSION['area']){$multi_city_id = mysql_real_escape_string ($_SESSION['area']);}else{$multi_city_id = mysql_real_escape_string ($_SESSION['multi_city']);}
return $multi_city_id;
}
function get_multi_city_meta(){
if($_SESSION['area']){$meta_key = 'post_hood_id';}else{$meta_key = 'post_city_id';}
return $meta_key;
}

if(strstr($_SERVER['REQUEST_URI'],'/wp-admin/'))
{
$sortorder_column=$wpdb->get_var("SHOW COLUMNS FROM $multicity_db_table_name where field='sortorder'");
if(!$sortorder_column)
{
	$wpdb->query("ALTER TABLE $multicity_db_table_name ADD `sortorder` INT NOT NULL AFTER `scall_factor`");
}
}
function get_multicity_city_settings($id,$option_name='cityname')
{
	global $wpdb,$multicity_db_table_name;
	return $wpdb->get_var("select $option_name from $multicity_db_table_name where city_id=\"$id\"");
}

function get_current_city_lat(){
global $wpdb,$multicountry_db_table_name,$multiregion_db_table_name,$multicity_db_table_name,$multihood_db_table_name;	
if($_SESSION['multi_country']){
$country_id = mysql_real_escape_string($_SESSION['multi_country']); 
$lat = $wpdb->get_var("select lat from $multicountry_db_table_name where country_id=$country_id");}	
elseif($_SESSION['multi_region']){
$region_id = mysql_real_escape_string($_SESSION['multi_region']); 
$lat = $wpdb->get_var("select lat from $multiregion_db_table_name where region_id=$region_id");}
elseif($_SESSION['area']){
$hood_id = mysql_real_escape_string($_SESSION['area']); 
$lat = $wpdb->get_var("select lat from $multihood_db_table_name where hood_id=$hood_id");}
elseif($_SESSION['multi_city'] || $_SESSION['multi_city']=='0' ){
$city_id = mysql_real_escape_string($_SESSION['multi_city']); 
$lat = $wpdb->get_var("select lat from $multicity_db_table_name where city_id=$city_id");}
if($lat){return $lat;}else{return 34;}
}

function get_city_lat($city_id){
global $wpdb,$multicity_db_table_name;
$lat = $wpdb->get_var("select lat from $multicity_db_table_name where city_id=$city_id");
return $lat;
}

function get_city_lng($city_id){
global $wpdb,$multicity_db_table_name;
$lng = $wpdb->get_var("select lng from $multicity_db_table_name where city_id=$city_id");
return $lng;
}

function get_city_latlng($city_id){
global $wpdb,$multicity_db_table_name;
$lng = $wpdb->get_var("select lng from $multicity_db_table_name where city_id=$city_id");
$lat = $wpdb->get_var("select lat from $multicity_db_table_name where city_id=$city_id");
return $lat.','.$lng;
}
###
function get_hood_lat($hood_id){
global $wpdb,$multihood_db_table_name;
$lat = $wpdb->get_var("select lat from $multihood_db_table_name where hood_id=$hood_id");
return $lat;
}

function get_hood_lng($hood_id){
global $wpdb,$multihood_db_table_name;
$lng = $wpdb->get_var("select lng from $multihood_db_table_name where hood_id=$hood_id");
return $lng;
}

function get_hood_latlng($hood_id){
global $wpdb,$multihood_db_table_name;
$lng = $wpdb->get_var("select lng from $multihood_db_table_name where hood_id=$hood_id");
$lat = $wpdb->get_var("select lat from $multihood_db_table_name where hood_id=$hood_id");
return $lat.','.$lng;
}

function get_current_city_lng(){
global $wpdb,$multicountry_db_table_name,$multiregion_db_table_name,$multicity_db_table_name,$multihood_db_table_name;	
if($_SESSION['multi_country']){
$country_id = mysql_real_escape_string($_SESSION['multi_country']); 
$lng = $wpdb->get_var("select lng from $multicountry_db_table_name where country_id=$country_id");}	
elseif($_SESSION['multi_region']){
$region_id = mysql_real_escape_string($_SESSION['multi_region']); 
$lng = $wpdb->get_var("select lng from $multiregion_db_table_name where region_id=$region_id");}
elseif($_SESSION['area']){
$hood_id = mysql_real_escape_string($_SESSION['area']); 
$lng = $wpdb->get_var("select lng from $multihood_db_table_name where hood_id=$hood_id");}
elseif($_SESSION['multi_city'] || $_SESSION['multi_city']=='0' ){
$city_id = mysql_real_escape_string($_SESSION['multi_city']); 
$lng = $wpdb->get_var("select lng from $multicity_db_table_name where city_id=$city_id");}
if($lng){return $lng;}else{return 0;}
}

function get_current_city_scale_factor(){
global $wpdb,$multicountry_db_table_name,$multiregion_db_table_name,$multicity_db_table_name,$multihood_db_table_name;	
if($_SESSION['multi_country']){
$country_id = mysql_real_escape_string($_SESSION['multi_country']); 
$scall_factor = $wpdb->get_var("select scall_factor from $multicountry_db_table_name where country_id=$country_id");}	
elseif($_SESSION['multi_region']){
$region_id = mysql_real_escape_string($_SESSION['multi_region']); 
$scall_factor = $wpdb->get_var("select scall_factor from $multiregion_db_table_name where region_id=$region_id");}
elseif($_SESSION['area']){
$hood_id = mysql_real_escape_string($_SESSION['area']); 
$scall_factor = $wpdb->get_var("select scall_factor from $multihood_db_table_name where hood_id=$hood_id");}
elseif($_SESSION['multi_city'] || $_SESSION['multi_city']=='0' ){
$city_id = mysql_real_escape_string($_SESSION['multi_city']); 
$scall_factor = $wpdb->get_var("select scall_factor from $multicity_db_table_name where city_id=$city_id");}
if($scall_factor){return $scall_factor;}else{return 3;}
}

function get_current_city_map_scroll_flag(){
global $wpdb,$multicountry_db_table_name,$multiregion_db_table_name,$multicity_db_table_name,$multihood_db_table_name;	
if($_SESSION['multi_country']){
$country_id = mysql_real_escape_string($_SESSION['multi_country']); 
$map_scroll = $wpdb->get_var("select is_zoom_home from $multicountry_db_table_name where country_id=$country_id");}	
elseif($_SESSION['multi_region']){
$region_id = mysql_real_escape_string($_SESSION['multi_region']); 
$map_scroll = $wpdb->get_var("select is_zoom_home from $multiregion_db_table_name where region_id=$region_id");}
elseif($_SESSION['area']){
$hood_id = mysql_real_escape_string($_SESSION['area']); 
$map_scroll = $wpdb->get_var("select is_zoom_home from $multihood_db_table_name where hood_id=$hood_id");}
elseif($_SESSION['multi_city'] || $_SESSION['multi_city']=='0' ){
$city_id = mysql_real_escape_string($_SESSION['multi_city']); 
$map_scroll = $wpdb->get_var("select is_zoom_home from $multicity_db_table_name where city_id=$city_id");}
if($map_scroll){return $map_scroll;}else{return 'Yes';}
}

function get_current_city_category(){
global $wpdb,$multicountry_db_table_name,$multiregion_db_table_name,$multicity_db_table_name,$multihood_db_table_name;
if(!get_option('ptthemes_map_set_default')){
if($_SESSION['multi_country']){
$country_id = mysql_real_escape_string($_SESSION['multi_country']); 
$categories = $wpdb->get_var("select categories from $multicountry_db_table_name where country_id=$country_id");}	
elseif($_SESSION['multi_region']){
$region_id = mysql_real_escape_string($_SESSION['multi_region']); 
$categories = $wpdb->get_var("select categories from $multiregion_db_table_name where region_id=$region_id");}
elseif($_SESSION['area']){
$hood_id = mysql_real_escape_string($_SESSION['area']); 
$categories = $wpdb->get_var("select categories from $multihood_db_table_name where hood_id=$hood_id");}
elseif($_SESSION['multi_city'] || $_SESSION['multi_city']=='0' ){
$city_id = mysql_real_escape_string($_SESSION['multi_city']); 
$categories = $wpdb->get_var("select categories from $multicity_db_table_name where city_id=$city_id");}
else{$categories = $wpdb->get_var("select categories from $multicity_db_table_name where is_default=1");}
}else{$categories = $wpdb->get_var("select categories from $multicity_db_table_name where is_default=1");}

	return $categories;	
}

function get_current_city_cat_ex(){
global $wpdb,$multicountry_db_table_name,$multiregion_db_table_name,$multicity_db_table_name,$multihood_db_table_name;
if(!get_option('ptthemes_map_set_default')){
if($_SESSION['multi_country']){
$country_id = mysql_real_escape_string($_SESSION['multi_country']); 
$cat_ex = $wpdb->get_var("select cat_ex from $multicountry_db_table_name where country_id=$country_id");}	
elseif($_SESSION['multi_region']){
$region_id = mysql_real_escape_string($_SESSION['multi_region']); 
$cat_ex = $wpdb->get_var("select cat_ex from $multiregion_db_table_name where region_id=$region_id");}
elseif($_SESSION['area']){
$hood_id = mysql_real_escape_string($_SESSION['area']); 
$cat_ex = $wpdb->get_var("select cat_ex from $multihood_db_table_name where hood_id=$hood_id");}
elseif($_SESSION['multi_city'] || $_SESSION['multi_city']=='0' ){
$city_id = mysql_real_escape_string($_SESSION['multi_city']); 
$cat_ex = $wpdb->get_var("select cat_ex from $multicity_db_table_name where city_id=$city_id");}
else{$cat_ex= $wpdb->get_var("select cat_ex from $multicity_db_table_name where is_default=1");}
}else{$cat_ex= $wpdb->get_var("select cat_ex from $multicity_db_table_name where is_default=1");}

	return $cat_ex;	
}

function get_location_desc(){
global $wpdb,$multicountry_db_table_name,$multiregion_db_table_name,$multicity_db_table_name,$multihood_db_table_name;
if($_SESSION['multi_country']){
$country_id = mysql_real_escape_string($_SESSION['multi_country']); 
$cat_ex = $wpdb->get_var("select home_desc from $multicountry_db_table_name where country_id=$country_id");}	
elseif($_SESSION['multi_region']){
$region_id = mysql_real_escape_string($_SESSION['multi_region']); 
$cat_ex = $wpdb->get_var("select home_desc  from $multiregion_db_table_name where region_id=$region_id");}
elseif($_SESSION['area']){
$hood_id = mysql_real_escape_string($_SESSION['area']); 
$cat_ex = $wpdb->get_var("select home_desc  from $multihood_db_table_name where hood_id=$hood_id");}
elseif($_SESSION['multi_city'] || $_SESSION['multi_city']=='0' ){
$city_id = mysql_real_escape_string($_SESSION['multi_city']); 
$cat_ex = $wpdb->get_var("select home_desc  from $multicity_db_table_name where city_id=$city_id");}
else{$cat_ex= $wpdb->get_var("select home_desc  from $multicity_db_table_name where is_default=1");}
return $cat_ex;	
}

function get_location_meta_desc(){
global $wpdb,$multicountry_db_table_name,$multiregion_db_table_name,$multicity_db_table_name,$multihood_db_table_name;
if($_SESSION['multi_country']){
$country_id = mysql_real_escape_string($_SESSION['multi_country']); 
$cat_ex = $wpdb->get_var("select meta_desc from $multicountry_db_table_name where country_id=$country_id");}	
elseif($_SESSION['multi_region']){
$region_id = mysql_real_escape_string($_SESSION['multi_region']); 
$cat_ex = $wpdb->get_var("select meta_desc from $multiregion_db_table_name where region_id=$region_id");}
elseif($_SESSION['area']){
$hood_id = mysql_real_escape_string($_SESSION['area']); 
$cat_ex = $wpdb->get_var("select meta_desc  from $multihood_db_table_name where hood_id=$hood_id");}
elseif($_SESSION['multi_city'] || $_SESSION['multi_city']=='0' ){
$city_id = mysql_real_escape_string($_SESSION['multi_city']); 
$cat_ex = $wpdb->get_var("select meta_desc  from $multicity_db_table_name where city_id=$city_id");}
else{$cat_ex= $wpdb->get_var("select meta_desc  from $multicity_db_table_name where is_default=1");}
return $cat_ex;	
}

function set_multi_city_wp_admin_post_custom_fields()
{
	global $wpdb,$multicity_db_table_name;
	$multi_city=$wpdb->get_var("select group_concat(city_id) from $multicity_db_table_name where is_default=1");
	$desc_str = get_multicity_id_name_desc();
	$return_arr = array(
	"post_city_id" => array (
		"name"		=> "post_city_id",
		"default" 	=> $multi_city,
		"label" 	=> __("City ID"),
		"type" 		=> "text",
		"desc"      => __("Enter City ID. In case of Multi city settings, The posts will display as per City ID.(For Blog, enter 0 to have the post display in all cities)").'<br><b>'.__('The city Id Information as per theme design settings : ').$desc_str.'</b>',
	),
	);
	return $return_arr;
}

function get_multicity_id_name_desc()
{
	$multicity_arr = get_multicity_name_info();
	$desc_str = '';
	if($multicity_arr)
	{
		foreach($multicity_arr as $key=>$val)
		{
			$desc_arr[] = $val. '=' . $key;
		}
		if($desc_arr)
		{
			$desc_str = implode(', ',$desc_arr);	
		}
	}
	return $desc_str;
}
function get_multicity_name_info()
{
	global $multicity_db_table_name,$wpdb;
	$city_info = array();
	$multisite_arr = $wpdb->get_results("select * from $multicity_db_table_name order by sortorder asc, is_default desc");
	if($multisite_arr)
	{
		foreach($multisite_arr as $multisite_arr_obj)
		{
			$city_info[$multisite_arr_obj->city_id] =  $multisite_arr_obj->cityname;
		}
	}
	return $city_info;
}

function get_multicity_dl_options($selected='',$default_option='',$att='')
{
	//$city_info = get_multicity_name_info();
	global $city_info;
	$return_str = '';
	if($city_info)
	{
		foreach($city_info as $key=>$val)
		{ if($key){
			$city_name = trim($val);
			$return_str .= '<option ';
			if($selected==$key)
			{
				$return_str .= ' selected="selected" ';		
			}
			$return_str .= 'value="'.$key.'" '.$att.'>';
			$return_str .= trim($val).'</option>';
		}
		}
	}
	return $return_str;
}
function get_multicity_dl_options_noall($selected='',$default_option='',$att='')
{
	//$city_info = get_multicity_name_info();
	global $city_info;
	$return_str = '';
	if($city_info)
	{
		foreach($city_info as $key=>$val)
		{ if(get_option('ptthemes_enable_everycity_flag') && $key==0){
			$city_name = trim($val);
			$return_str .= '<option ';
			if($selected==$key)
			{
				$return_str .= ' selected="selected" ';		
			}
			$return_str .= 'value="'.$key.'" '.$att.'>';
			$return_str .= trim($val).'</option>';
		}elseif($key){
			$city_name = trim($val);
			$return_str .= '<option ';
			if($selected==$key)
			{
				$return_str .= ' selected="selected" ';		
			}
			$return_str .= 'value="'.$key.'" '.$att.'>';
			$return_str .= trim($val).'</option>';			
		}
		}
	}
	return $return_str;
}

function get_multicity_checkbox_options($name,$selected='')
{
	//$city_info = get_multicity_name_info();
	global $city_info;
	$return_str = '';
	if($city_info)
	{
		foreach($city_info as $key=>$val)
		{
			$city_name = trim($val);
			$return_str .= '<div class="multi_checkbox"><input type="checkbox" ';
			if($selected==($key))
			{
				$return_str .= ' checked="checked" ';		
			}
			$return_str .= 'value="'.($val).'" name='.$name;
			$return_str .= ' />'.trim($val).'</div>';
		}
	}
	return $return_str;
}

function get_multicity_dl($dl_name,$dl_id='',$selected='',$extra='',$default_option='',$noall)
{
	if($dl_id=='')
	{
		$dl_id = $dl_name;	
	}
	if($noall){
	$dl_options = get_multicity_dl_options($selected,$default_option);
	}else{$dl_options = get_multicity_dl_options_noall($selected,$default_option);}
	if($dl_options){
		$return_str = '<form id="multicity_dl_frm_id" name="multicity_dl_frm_name" action="" method="get">';
		$return_str .= get_multicit_select_dl($dl_name,$dl_id,$selected,$extra,$default_option,$dl_options);
		$return_str .= '</form>';
	}
	return $return_str;
}





function get_multicit_select_dl($dl_name,$dl_id='',$selected='',$extra='',$default_option='',$dl_options='')
{
	if($dl_options=='')
	{
		$dl_options = get_multicity_dl_options($selected,$default_option);
	}
	$return_str = '';
	$return_str .= '<select name="'.$dl_name.'" id="'.$dl_id.'" '.$extra.'>';
	$return_str .= $dl_options;
	return $return_str .= '</select>';	
}

function get_multihood_dl_options($selected='',$default_option='',$att='', $city_id, $hood_id)
{
	global $wpdb, $multihood_db_table_name;
	$hood_info = $wpdb->get_results("select hood_id,hoodname from $multihood_db_table_name where cities = $city_id hood_id IN( SELECT DISTINCT meta.meta_value FROM wp_postmeta meta INNER JOIN wp_term_relationships ON wp_term_relationships.object_id = meta.post_id INNER JOIN wp_posts post ON post.ID= meta.post_id AND post.post_type='place') order by sortorder asc, is_default desc");
/*SELECT hood_id, hoodname 
FROM `wp_multihood`
WHERE cities = 1 AND `hood_id` IN(
SELECT DISTINCT meta.`meta_value` FROM `wp_postmeta` meta 
INNER JOIN wp_term_relationships ON wp_term_relationships.`object_id` = meta.post_id
INNER JOIN `wp_posts` post ON post.`ID`= meta.`post_id` AND post.`post_type`='place'  
)
ORDER BY sortorder ASC, is_default DESC */

	
	$return_str = '';
	print_r($city_id);
	print_r($hood_info);
	if($hood_info)
	{ 	$return_str .= '<option value="" >'.__('Selecione').'</option>';

		foreach($hood_info as $hood)
		{ if($hood){
			$return_str .= '<option ';
			if($hood_id==$hood->hood_id)
			{
				$return_str .= ' selected="selected" ';		
			}
			$return_str .= 'value="'.$hood->hood_id.'" '.$att.'>';
			$return_str .= $hood->hoodname.'</option>';
		}
		}
	}else{$return_str .= '<option value="" >'.__('No Neighbourhoods').'</option>';}
	return $return_str;
}

function get_multihood_select_dl($dl_name,$dl_id='',$selected='',$extra='',$default_option='',$dl_options='',$hood_id)
{?>
<script type='text/javascript'>
/* <![CDATA[ */
jQuery('#post_city_id').change(function() {
  var city_id = jQuery("#post_city_id").val();
  jQuery("#post_hood_id").load("<?php echo get_bloginfo('url').'/?ajax=get_hoods_dd&city_id='; ?>"+city_id);
});
<?php if(strstr($selected,',')){?>
jQuery(document).ready(function() {
var city_id_load = jQuery("#post_city_id").val();
 jQuery("#post_hood_id").load("<?php echo get_bloginfo('url').'/?ajax=get_hoods_dd&city_id='; ?>"+city_id_load);
});
<?php }?>
/* ]]> */
</script>
<?php
	if($dl_options=='')
	{
		$dl_options = get_multihood_dl_options($selected,$default_option ,'',$selected,$hood_id);
	}
	$return_str = '';
	$return_str .= '<select name="'.$dl_name.'" id="'.$dl_id.'" '.$extra.'>';
	$return_str .= $dl_options;
	return $return_str .= '</select>';	
}



function multicity_js_insert_to_header()
{
?>
<script type="text/javascript">
function set_selected_city(city)
{
	document.multicity_dl_frm_name.submit();
}
</script>
<?php
}
add_action('wp_head', 'multicity_js_insert_to_header');

function get_city_location_menu(){
	global $wpdb,$multicountry_db_table_name,$multiregion_db_table_name,$multicity_db_table_name,$multihood_db_table_name;
	$cities =array();
	$cities = $wpdb->get_results("select city_id,cityname,city_slug from $multicity_db_table_name where city_id!=0 order by sortorder asc, is_default desc");
	foreach($cities as $city){?>
<li class="<?php if($_SESSION['location_name']==$city->cityname){echo 'current_location';}?>" >
<div>
<span onclick="window.location.href = '<?php echo get_bloginfo('url').'/?multi_city='.$city->city_slug; ?>';"><?php echo $city->cityname; ?></span>
<?php $hoods = $wpdb->get_results("select * from $multihood_db_table_name where $city->city_id in (cities)"); if($hoods){?>
<?php /*?><span class="location_dig" onclick="dig_hoods(<?php echo $city->city_id; ?>)" >&nbsp;</span><?php */?>
<?php }?>
</div>
</li>
		<?php }
}

function get_region_locations(){
	global $wpdb,$multicountry_db_table_name,$multiregion_db_table_name,$multicity_db_table_name;
	$regions =array();
	$regions = $wpdb->get_results("select region_id,regionname,region_slug from $multiregion_db_table_name  order by sortorder asc, is_default desc");
	foreach($regions as $region){?>
<li class="<?php if($_SESSION['location_name']==$region->regionname){echo 'current_location';}?>" >
<div>
<span onclick="window.location.href = '<?php echo get_bloginfo('url').'/?multi_region='. $region->region_slug; ?>';"><?php echo  $region->regionname; ?></span>
<span class="location_dig" onclick="dig_cities(<?php echo $region->region_id; ?>)" >&nbsp;</span>
</div>
</li>		<?php }
}

function get_region_city_location_menu($region_id){
	global $wpdb,$multicountry_db_table_name,$multiregion_db_table_name,$multicity_db_table_name,$multihood_db_table_name;
	if(!$region_id){$region_id = mysql_real_escape_string ($_SESSION['multi_region']);}
	if(!$region_id){$city_id = mysql_real_escape_string ($_SESSION['multi_city']);$region_id = $wpdb->get_var("select region_id from $multiregion_db_table_name where $city_id in (cities)");}
	if($region_id){
	$city_ids = $wpdb->get_var("select cities from $multiregion_db_table_name where region_id=\"$region_id\"");
	$cities =array();
	$cities = $wpdb->get_results("select city_id,cityname,city_slug from $multicity_db_table_name where city_id in ($city_ids) order by sortorder asc, is_default desc");
	foreach($cities as $city){?>
<li class="<?php if($_SESSION['location_name']==$city->cityname){echo 'current_location';}?>" >
<div>
<span onclick="window.location.href = '<?php echo get_bloginfo('url').'/?multi_city='.$city->city_slug; ?>';"><?php echo $city->cityname; ?></span>
<?php $hoods = $wpdb->get_results("select * from $multihood_db_table_name where $city->city_id in (cities)"); if($hoods){?>
<?php /*?><span class="location_dig" onclick="dig_hoods(<?php echo $city->city_id; ?>)" >&nbsp;</span><?php */?>
<?php }?>
</div>
</li>
		<?php }}
}


function get_country_location_menu(){
	global $wpdb,$multicountry_db_table_name,$multiregion_db_table_name,$multicity_db_table_name;
	$countrys =array();
	$countrys = $wpdb->get_results("select country_id,countryname,country_slug from $multicountry_db_table_name order by sortorder asc, is_default desc");
	foreach($countrys as $country){?>
<li class="<?php if($_SESSION['location_name']==$country->countryname){echo 'current_location';}?>" >
<div>
<span onclick="window.location.href = '<?php echo get_bloginfo('url').'/?multi_country='.$country->country_slug; ?>';"><?php echo $country->countryname; ?></span>
<span class="location_dig" onclick="dig_regions(<?php echo $country->country_id; ?>)" >&nbsp;</span>
</div>
</li>
		<?php }
}

function get_hoods_location_menu($city_id){
	global $wpdb,$multicountry_db_table_name,$multiregion_db_table_name,$multicity_db_table_name,$multihood_db_table_name;
	if(!$city_id){$city_id = mysql_real_escape_string ($_SESSION['multi_city']);}
	$hoods =array();
	$hoods= $wpdb->get_results("select hood_id,hoodname,hood_slug,cities from $multihood_db_table_name where $city_id in (cities) order by sortorder asc, is_default desc");
	foreach($hoods as $hood){?>
<li class="<?php if($_SESSION['location_name']==$hood->hoodname){echo 'current_location';}?>" >
<div>
<span onclick="window.location.href = '<?php echo get_bloginfo('url').'/?area='.$hood->hood_slug; ?>';"><?php echo $hood->hoodname; ?></span>
</div>
</li>
		<?php }
}

function get_region_location_menu($country_id=''){
	global $wpdb,$multicountry_db_table_name,$multiregion_db_table_name,$multicity_db_table_name,$multihood_db_table_name;
	if(!$country_id){$country_id = mysql_real_escape_string ($_SESSION['multi_country']);}
	if(!$country_id){$region_id = mysql_real_escape_string ($_SESSION['multi_region']); $country_id = $wpdb->get_var("select country_id from $multicountry_db_table_name where $region_id in (regions)");}
	$region_arr = $wpdb->get_var("select regions from $multicountry_db_table_name where country_id=$country_id");
	if($region_arr){
	$regions =array();
	$regions = $wpdb->get_results("select region_id,regionname,region_slug from $multiregion_db_table_name  where region_id in ($region_arr) order by sortorder asc, is_default desc");
	foreach($regions as $region){?>
<li class="<?php if($_SESSION['location_name']==$region->regionname){echo 'current_location';}?>" >
<div>
<span onclick="window.location.href = '<?php echo get_bloginfo('url').'/?multi_region='. $region->region_slug; ?>';"><?php echo  $region->regionname; ?></span>
<span class="location_dig" onclick="dig_cities(<?php echo $region->region_id; ?>)" >&nbsp;</span>
</div>
</li>
		<?php }
	}else{
	$city_arr = $wpdb->get_var("select cities from $multicountry_db_table_name where country_id=$country_id");	
	$cities =array();
	$cities= $wpdb->get_results("select city_id,cityname,city_slug from $multicity_db_table_name  where city_id in ($city_arr) order by sortorder asc, is_default desc");
	foreach($cities as $city){?>
<li class="<?php if($_SESSION['location_name']==$city->cityname){echo 'current_location';}?>" >
<div>
<span onclick="window.location.href = '<?php echo get_bloginfo('url').'/?multi_city='. $city->city_slug; ?>';"><?php echo  $city->cityname; ?></span>
<?php $hoods = $wpdb->get_results("select * from $multihood_db_table_name where $city->city_id in (cities)"); if($hoods){?>
<?php /*?><span class="location_dig" onclick="dig_hoods(<?php echo $city->city_id; ?>)" >&nbsp;</span><?php */?>
<?php }?></div></li>		<?php }
	
			
	}
}

function get_location_menu(){ global $multicity_db_table_name, $wpdb;?>
<script type='text/javascript'>
/* <![CDATA[ */
function dig_regions(country_id){
jQuery("#location_select_list").load("<?php echo get_bloginfo('url').'/?ajax=dig_regions&country_id='; ?>"+country_id);
}
function dig_cities(region_id){
jQuery("#location_select_list").load("<?php echo get_bloginfo('url').'/?ajax=dig_cities&region_id='; ?>"+region_id);
}
function dig_hoods(city_id){
//jQuery("#location_select_list").load("<?php echo get_bloginfo('url').'/?ajax=dig_hoods&city_id='; ?>"+city_id);
}
/* ]]> */
</script>
<ul id="location_select_mainlist">
<?php if(get_option('ptthemes_enable_everycity_flag')){?>
<li id="get_everywhere" ><span onclick="window.location.href = '<?php echo get_bloginfo('url').'/?multi_city=0'; ?>';"><?php $everywhere = $wpdb->get_var("select cityname from $multicity_db_table_name where city_id=0"); if($everywhere){echo $everywhere;}  ?></span></li>
<?php }?>
<?php if(get_option('ptthemes_enable_multicountry_flag')){?>
<li id="get_countrys" ><span><?php echo  __('Todos os Estados'); ?></span></li>
<?php }?>
<?php if(get_option('ptthemes_enable_multiregion_flag')){?>
<li id="get_regions" ><span><?php echo  __('Todas as Regiões'); ?></span></li>
<?php }?>
<?php if(get_option('ptthemes_enable_multicity_flag')){?>
<li id="get_cities" ><span><?php echo  __('Todas as Cidades'); ?></span></li>
<?php }?>
<?php if(get_option('ptthemes_enable_multihood_flag')=='disabled'){?>
<li id="get_hoods" ><span><?php echo  __('Todos os Bairros'); ?></span></li>
<?php }?>
<?php if(!get_option('user_near_search')==0){?>
<li id="locate_me" onclick="window.location.href = '<?php echo get_bloginfo('url').'/?multi_city=findme'; ?>';"><span><?php echo  __('Perto de mim'); ?></span></li>
<?php }?>
</ul>
<ul id="location_select_list">

<?php
	if($_SESSION['multi_country']=='all'){get_city_location_menu();}
	elseif($_SESSION['multi_country'] && $_SESSION['multi_country']!='all'){get_country_location_menu();}
	elseif($_SESSION['multi_region']){get_region_location_menu();}
	elseif($_SESSION['multi_city'] && get_option('ptthemes_enable_multiregion_flag')){get_region_city_location_menu();}
	elseif($_SESSION['multi_city'] && !get_option('ptthemes_enable_multiregion_flag')){get_city_location_menu();}
	elseif($_SESSION['area']){get_hoods_location_menu();}
	//get_city_location_menu();
	?>
    </ul>
    <?php
	};


?>