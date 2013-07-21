<?php 
//Custom Settings
if(strstr($_SERVER['REQUEST_URI'],'/wp-admin/'))
{
if($_REQUEST['post'])
{
$postid = $_REQUEST['post'];
}else
{
$postid = $_REQUEST['post_ID'];
}
$blog_cat = get_option('ptthemes_blogcategory');
$blog_cat = get_blog_sub_cats_str($type='array');
$cagInfo = get_the_category($postid);
foreach($cagInfo as $cagInfo_obj)
{
$cat_array[] = $cagInfo_obj->term_id;
}
$post_type = '';
if($_REQUEST['post'])
{
global $wpdb;
$pid=$_REQUEST['post'];
$post_type = $wpdb->get_var("select post_type from $wpdb->posts where ID=\"$pid\"");
}
if($_REQUEST['post_type']=='event' || $post_type=='event')
{
$currency = get_option('currency');
$currencysym = get_option('currencysym');
$pt_metaboxes = array(
"package_pid" => array (
"name"		=> "package_pid",
"default" 	=> "",
"label" 	=> __("Package ID"),
"type" 		=> "text",
"desc"      => __("Enter the package ID for the listing.")
),
"video" => array (
"name"		=> "video",
"default" 	=> "",
"label" 	=> __("Custom Video code"),
"type" 		=> "textarea",
"desc"      => __("Enter embed code for video. eg. : code from youtibe, vimeo, etc")
),
"address" => array (
"name"		=> "address",
"default" 	=> "",
"label" 	=> __("Listing Address"),
"type" 		=> "text",
"desc"      => __("<span class=note>Enter listing place address. eg. : <b>230 Vine Street And locations throughout Old City,
Philadelphia, PA 19106</b><br><input type='button' class='b_submit' value='Set Address on Map' onclick='codeAddress()' style='float:none;'/> </span>")
),
"map" => array (
"name"		=> "map",
"default" 	=> "",
"label" 	=> __("Set Address"),
"type" 		=> "map",
"desc"      => __("Set position on map")
),
"map_zoom" => array (
"name"		=> "map_zoom",
"default" 	=> "",
"label" 	=> __("Map Zoom Level"),
"type" 		=> "text",
"desc"      => __("Set the map zoom level(set with map). eg. : <b>5</b>")
),
"geo_latitude" => array (
"name"		=> "geo_latitude",
"default" 	=> "",
"label" 	=> __("Map Latitude "),
"type" 		=> "text",
"desc"      => __("Enter Google Map Latitude. eg. : <b>39.955823048131286</b>")
),
"geo_longitude" => array (
"name"		=> "geo_longitude",
"default" 	=> "",
"label" 	=> __("Map Longitude"),
"type" 		=> "text",
"desc"      => __("Enter Google Map Longitude. eg. : <b>-75.14408111572266</b>")
),
"st_date" => array (
"name"		=> "st_date",
"default" 	=> "",
"label" 	=> __("Starting Date"),
"type" 		=> "text",
"desc"      => __("Enter Event Starting Date. eg. : ")."<b>".date('Y-m-d')."</b>"
),
"st_time" => array (
"name"		=> "st_time",
"default" 	=> "",
"label" 	=> __("Starting Time"),
"type" 		=> "text",
"desc"      => __("Enter Event Starting Time. 24 hours timing format. eg. : ")."<b>".date('H:i')."</b>"
),
"end_date" => array (
"name"		=> "end_date",
"default" 	=> "",
"label" 	=> __("Ending Date"),
"type" 		=> "text",
"desc"      => __("Enter Event Ending Date. eg. : ")."<b>".date('Y-m-d')."</b>"
),
"end_time" => array (
"name"		=> "end_time",
"default" 	=> "",
"label" 	=> __("Ending Time"),
"type" 		=> "text",
"desc"      => __("Enter Event Ending Time. 24 hours timing format. eg. : "). "<b>".date('H:i')."</b>"
),
"recurring" => array (
"name"		=> "recurring",
"default" 	=> "",
"label" 	=> __("Recurring Event?"),
"type" 		=> "select",
"options" 	=> array('','week','two_week','month','year'),
"desc"      => __("Select if event is recurring. eg. : <b>Every Week. Note: \"Event End Date\" must be selected.</b>")
),
"reg_desc" => array (
"name"		=> "reg_desc",
"default" 	=> "",
"label" 	=> __("Registration Description"),
"type" 		=> "textarea",
"desc"      => __("Enter Registration Description")
),
"reg_fees" => array (
"name"		=> "reg_fees",
"default" 	=> "",
"label" 	=> __("Registration Fees"),
"type" 		=> "text",
"desc"      => __("Enter Registration Fees, in $currency eg. : ")."<b>".$currencysym."10</b>"
),
"contact" => array (
"name"		=> "contact",
"default" 	=> "",
"label" 	=> __("Contact Information"),
"type" 		=> "text",
"desc"      => __("Enter Contact Information, Phone or mobile number. eg. : <b>(610) 388-1000</b>")
),
"contact_show" => array (
"name"		=> "contact_show",
"default" 	=> "",
"label" 	=> __("Publish Contact Information?"),
"type" 		=> "select",
"options" 	=> array('Yes','No'),
"desc"      => __("Wish to publish Contact Information on detail page?")
),
"email" => array (
"name"		=> "email",
"default" 	=> "",
"label" 	=> __("Email Address"),
"type" 		=> "text",
"desc"      => __("Enter Address. eg. : <b>info@myplace.com</b>")
),
"email_show" => array (
"name"		=> "email_show",
"default" 	=> "",
"label" 	=> __("Publish Email?"),
"type" 		=> "select",
"options" 	=> array('Yes','No'),
"desc"      => __("Wish to publish email on detail page?")
),
"website" => array (
"name"		=> "website",
"default" 	=> "",
"label" 	=> __("Website"),
"type" 		=> "text",
"desc"      => __("Enter Website Address. eg. : <b>http://myplace.com</b>")
),
"web_show" => array (
"name"		=> "web_show",
"default" 	=> "",
"label" 	=> __("Publish Website?"),
"type" 		=> "select",
"options" 	=> array('Yes','No'),
"desc"      => __("Wish to publish Website on detail page?")
),
"twitter" => array (
"name"		=> "twitter",
"default" 	=> "",
"label" 	=> __("Twitter"),
"type" 		=> "text",
"desc"      => __("Enter Twitter Address. eg. : <b>http://twitter.com/myplace</b>")
),
"facebook" => array (
"name"		=> "facebook",
"default" 	=> "",
"label" 	=> __("Facebook"),
"type" 		=> "text",
"desc"      => __("Enter Facebook Address. eg. : <b>http://facebook.com/myplace</b>")
),
"a_businesses" => array (
"name"		=> "a_businesses",
"default" 	=> "",
"label" 	=> __("Businesses"),
"type" 		=> "text",
"desc"      => __("Business")
),
"is_featured" => array (
"name"		=> "is_featured",
"default" 	=> "",
"label" 	=> __("Featured"),
"type" 		=> "text",
"desc"      => __("Enter <b>1</b> if you want to set as Featured else leave blank")
),
"paid_amount" => array (
"name"		=> "paid_amount",
"default" 	=> "",
"label" 	=> __("Paid Amount"),
"type" 		=> "text",
"desc"      => __("Paid Amount to publish the listing. eg. : <b>$10</b>")
),
"paymentmethod" => array (
"name"		=> "paymentmethod",
"default" 	=> "",
"label" 	=> __("Payment Method"),
"type" 		=> "text",
"desc"      => __("Payment Method used to publish the listing. eg. : <b>paypal/googlecheckout/authorizenet/cashondelivery ... etc</b>")
),
);
}elseif($_REQUEST['post_type']=='place' || $post_type=='place')
{
$pt_metaboxes = array(
"package_pid" => array (
"name"		=> "package_pid",
"default" 	=> "",
"label" 	=> __("Package ID"),
"type" 		=> "text",
"desc"      => __("Enter the package ID for the listing.")
),
"video" => array (
"name"		=> "video",
"default" 	=> "",
"label" 	=> __("Custom Video code"),
"type" 		=> "textarea",
"desc"      => __("Enter embed code for video. eg. : code from youtube, vimeo, etc")
),
"address" => array (
"name"		=> "address",
"default" 	=> "",
"label" 	=> __("Listing Address"),
"type" 		=> "text",
"desc"      => __("Enter listing place address. eg. : <b>230 Vine Street And locations throughout Old City,
Philadelphia, PA 19106</b><br><input type='button' class='b_submit' value='Set Address on Map' onclick='codeAddress()' style='float:none;'/>")
),
"map" => array (
"name"		=> "map",
"default" 	=> "",
"label" 	=> __("Set Address"),
"type" 		=> "map",
"desc"      => __("Set position on map")
),
"map_zoom" => array (
"name"		=> "map_zoom",
"default" 	=> "",
"label" 	=> __("Map Zoom Level"),
"type" 		=> "text",
"desc"      => __("Set the map zoom level(set with map). eg. : <b>5</b>")
),
"geo_latitude" => array (
"name"		=> "geo_latitude",
"default" 	=> "",
"label" 	=> __("Map Latitude"),
"type" 		=> "text",
"desc"      => __("Enter Google Map Latitude. eg. : <b>39.955823048131286</b>")
),
"geo_longitude" => array (
"name"		=> "geo_longitude",
"default" 	=> "",
"label" 	=> __("Map Longitude "),
"type" 		=> "text",
"desc"      => __("Enter Google Map Longitude. eg. : <b>-75.14408111572266</b>")
),
"timing" => array (
"name"		=> "timing",
"default" 	=> "",
"label" 	=> __("Timing Information"),
"type" 		=> "text",
"desc"      => __("Enter Timing Information. eg. : <b>10.00 am to 6 pm</b>")
),
"contact" => array (
"name"		=> "contact",
"default" 	=> "",
"label" 	=> __("Contact Information"),
"type" 		=> "text",
"desc"      => __("Enter Contact Information, Phone or mobile number. eg. : <b>(610) 388-1000</b>")
),
"contact_show" => array (
"name"		=> "contact_show",
				"default" 	=> "",
				"label" 	=> __("Publish Contact Information?"),
				"type" 		=> "select",
				"options" 	=> array('Yes','No'),
				"desc"      => __("Wish to publish Contact Information on detail page?")
			),
			"email" => array (
				"name"		=> "email",
				"default" 	=> "",
				"label" 	=> __("Email Address"),
				"type" 		=> "text",
				"desc"      => __("Enter Address. eg. : <b>info@myplace.com</b>")
			),
			"email_show" => array (
				"name"		=> "email_show",
				"default" 	=> "",
				"label" 	=> __("Publish Email?"),
				"type" 		=> "select",
				"options" 	=> array('Yes','No'),
				"desc"      => __("Wish to publish email on detail page?")
			),
			"website" => array (
				"name"		=> "website",
				"default" 	=> "",
				"label" 	=> __("Website"),
				"type" 		=> "text",
				"desc"      => __("Enter Website Address. eg. : <b>http://myplace.com</b>")
			),
			"web_show" => array (
				"name"		=> "web_show",
				"default" 	=> "",
				"label" 	=> __("Publish Website?"),
				"type" 		=> "select",
				"options" 	=> array('Yes','No'),
				"desc"      => __("Wish to publish Website on detail page?")
			),
			"twitter" => array (
				"name"		=> "twitter",
				"default" 	=> "",
				"label" 	=> __("Twitter"),
				"type" 		=> "text",
				"desc"      => __("Enter Twitter Address. eg. : <b>http://twitter.com/myplace</b>")
			),
			"facebook" => array (
				"name"		=> "facebook",
				"default" 	=> "",
				"label" 	=> __("Facebook"),
				"type" 		=> "text",
				"desc"      => __("Enter Facebook Address. eg. : <b>http://facebook.com/myplace</b>")
			),
			"is_featured" => array (
				"name"		=> "is_featured",
				"default" 	=> "",
				"label" 	=> __("Is Featured"),
				"type" 		=> "text",
				"desc"      => __("Enter <b>1</b> if want to set as Feature else <b>0</b>")
			),
			"proprty_feature" => array (
				"name"		=> "proprty_feature",
				"default" 	=> "",
				"label" 	=> __("Special Offer"),
				"type" 		=> "textarea",
				"desc"      => __("Enter your Special offer here.")
			),
			"paid_amount" => array (
				"name"		=> "paid_amount",
				"default" 	=> "",
				"label" 	=> __("Paid Amount"),
				"type" 		=> "text",
				"desc"      => __("Paid Amount to publish the listing. eg. : <b>$10</b>")
			),
			"paymentmethod" => array (
				"name"		=> "paymentmethod",
				"default" 	=> "",
				"label" 	=> __("Payment Method"),
				"type" 		=> "text",
				"desc"      => __("Payment Method used to publish the listing. eg. : <b>paypal/googlecheckout/authorizenet/cashondelivery ... etc</b>")
			),
			"alive_days" => array (
				"name"		=> "alive_days",
				"default" 	=> "",
				"label" 	=> __("Number of days to be Published "),
				"type" 		=> "text",
				"desc"      => __("Enter Number of publish days for listing. eg. : <b>30</b>")
			),
		);
	}elseif($_REQUEST['post_type']=='invoice' || $post_type=='invoice'){
		$pt_metaboxes = array(
			"package_pid" => array (
				"name"		=> "package_pid",
				"default" 	=> "",
				"label" 	=> __("Package ID"),
				"type" 		=> "text",
				"desc"      => __("Enter the package ID for the listing.")
			),
			
			
			"paid_amount" => array (
				"name"		=> "paid_amount",
				"default" 	=> "",
				"label" 	=> __("Paid Amount"),
				"type" 		=> "text",
				"desc"      => __("Paid Amount to publish the listing. eg. : <b>$10</b>")
			),
			"paymentmethod" => array (
				"name"		=> "paymentmethod",
				"default" 	=> "",
				"label" 	=> __("Payment Method"),
				"type" 		=> "text",
				"desc"      => __("Payment Method used to publish the listing. eg. : <b>paypal/googlecheckout/authorizenet/cashondelivery ... etc</b>")
			),
			"alive_days" => array (
				"name"		=> "alive_days",
				"default" 	=> "",
				"label" 	=> __("Number of days to be Published "),
				"type" 		=> "text",
				"desc"      => __("Enter Number of publish days for listing. eg. : <b>30</b>")
			)
		);
		
		
		
		}else{
		$pt_metaboxes = array(
			"video" => array (
				"name"		=> "video",
				"default" 	=> "",
				"label" 	=> __("Custom Video code"),
				"type" 		=> "textarea",
				"desc"      => __("Enter embed code for video. eg. : code from youtube, vimeo, etc")
			),"position" => array (
			"name"		=> "position",
			"default" 	=> "left",
			"label" 	=> __("Image Position"),
			"type" 		=> "select",
			"options"	=> array("left","right"),
			"desc"      => __("Enter Image Position. eg. : left/right")
		));
	}
	
	
	
	
	$multi_city_post_custom = set_multi_city_wp_admin_post_custom_fields();
	if($multi_city_post_custom)
	{
		$pt_metaboxes = array_merge($pt_metaboxes,$multi_city_post_custom);
	}
	if(is_array($custom_metaboxes)){
	$pt_metaboxes =	array_merge($pt_metaboxes,$custom_metaboxes);
	}
}



// Excerpt length
if(!function_exists('bm_better_excerpt')){
function bm_better_excerpt($length, $ellipsis) {
$text = get_the_content();
$text = strip_tags($text);
$text = substr($text, 0, $length);
$text = substr($text, 0, strrpos($text, " "));
$text = $text.$ellipsis;
return $text;
}
}
// Custom fields for WP write panel
// This code is protected under Creative Commons License: http://creativecommons.org/licenses/by-nc-nd/3.0/
if(!function_exists('ptthemes_meta_box_content')){
function ptthemes_meta_box_content() {
    global $post, $pt_metaboxes;
    $output = '';
    $output .= '<div class="pt_metaboxes_table">'."\n";
	foreach ($pt_metaboxes as $pt_id => $pt_metabox) {
    if($pt_metabox['type'] == 'text' OR $pt_metabox['type'] == 'select' OR $pt_metabox['type'] == 'checkbox' OR $pt_metabox['type'] == 'textarea' OR $pt_metabox['type'] == 'map')
			$pt_metaboxvalue = get_post_meta($post->ID,$pt_metabox["name"],true);
           	if ($pt_metaboxvalue == "" || !isset($pt_metaboxvalue)) {

                $pt_metaboxvalue = $pt_metabox['default'];
            }
            if($pt_metabox['type'] == 'text'){
                $output .= "\t".'<div>';
                $output .= "\t\t".'<br/><p class=lable_title><label for="'.$pt_id.'">'.$pt_metabox['label'].'</label></p>'."\n";
                $output .= "\t\t".'<p><input size="100" class="pt_input_text" type="'.$pt_metabox['type'].'" value="'.$pt_metaboxvalue.'" name="ptthemes_'.$pt_metabox["name"].'" id="'.$pt_id.'"/></p>'."\n";
                $output .= "\t\t".'<p class=note>'.$pt_metabox['desc'].'</p>'."\n";
                $output .= "\t".'</div>'."\n";
            }
			
			elseif($pt_metabox['type'] == 'map'){?>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script> 
<script type="text/javascript">
/* <![CDATA[ */
var map;
var marker;
var latlng;
var geocoder;
var address;
var CITY_MAP_CENTER_LAT ='<?php echo get_post_meta($post->ID,"geo_latitude",true);?>';
var CITY_MAP_CENTER_LNG = '<?php echo get_post_meta($post->ID,"geo_longitude",true);?>';
var CITY_MAP_ZOOMING_FACT=<?php if(get_post_meta($post->ID,"map_zoom",true)){echo get_post_meta($post->ID,"map_zoom",true);}else{echo 3;}?>;
if(CITY_MAP_CENTER_LAT=='')
{
var CITY_MAP_CENTER_LAT = 34;	
}
if(CITY_MAP_CENTER_LNG=='')
{
var CITY_MAP_CENTER_LNG = 0;	
}
if(CITY_MAP_CENTER_LAT!='' && CITY_MAP_CENTER_LNG!='' && CITY_MAP_ZOOMING_FACT!='')
{
}else if(CITY_MAP_ZOOMING_FACT!='')
{
var CITY_MAP_ZOOMING_FACT = 3;	
}
var geocoder = new google.maps.Geocoder();
function updateMarkerStatus(str) {
document.getElementById('markerStatus').innerHTML = str;
}
function updateMarkerPosition(latLng) {
document.getElementById('geo_latitude').value=latLng.lat();
document.getElementById('geo_longitude').value=latLng.lng();
}
function updateMapZoom(zoom) {
	//alert(zoom);
document.getElementById('map_zoom').value=zoom;
}
function initialize() {
geocoder = new google.maps.Geocoder();
var latLng = new google.maps.LatLng(CITY_MAP_CENTER_LAT,CITY_MAP_CENTER_LNG);
var myOptions = {
zoom: CITY_MAP_ZOOMING_FACT,
center: latLng,
scrollwheel: false,
mapTypeId: google.maps.MapTypeId.ROADMAP
}
map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
marker = new google.maps.Marker({
//position: latLng,
title: 'Point A',
map: map,
draggable: true
});
marker.setPosition(latLng);
// Update current position info.
//updateMarkerPosition(latLng);
//geocodePosition(latLng);
// Add dragging event listeners.
google.maps.event.addListener(marker, 'dragstart', function() {
//updateMarkerAddress('Dragging...');
});
google.maps.event.addListener(marker, 'drag', function() {
// updateMarkerStatus('Dragging...');
updateMarkerPosition(marker.getPosition());
});
google.maps.event.addListener(marker, 'dragend', function() {
// updateMarkerStatus('Drag ended');
centerMap();
});
google.maps.event.addListener(map, 'dragend', function() {
// updateMarkerStatus('Drag ended');
centerMarker();
updateMarkerPosition(marker.getPosition());
//alert(map.zoom);
updateMapZoom(map.zoom);
});
 google.maps.event.addListener(map, 'zoom_changed', function() {
updateMapZoom(map.zoom);
  });
}
function centerMap() {
map.panTo(marker.getPosition());
}
function centerMarker() {
//alert('drag');
var center = map.getCenter(); 
marker.setPosition(center);
}		
  function codeAddress() {
	  
	  //alert('click1');
	
    var address = document.getElementById("address").value;
    geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
		 // alert('click2'+ results);
		marker.setPosition(results[0].geometry.location);
        map.setCenter(results[0].geometry.location);
		updateMarkerPosition(marker.getPosition());
      /*  var marker = new google.maps.Marker({
            map: map, 
            position: results[0].geometry.location,
			title: 'Point A',
		    draggable: true
			
        });*/
      } else {
        alert("Geocode was not successful for the following reason: " + status);
      }
    });
  }
/* ]]> */
</script>
<script type="text/javascript">
// Onload handler to fire off the app.
google.maps.event.addDomListener(window, 'load', initialize);
</script>

<?php
                $output .= "\t\t".'<div id="map_canvas" style=" height:300px; width:435px;"  class="form_row clearfix"></div>'."\n";

            }
            elseif ($pt_metabox['type'] == 'textarea'){
				$output .= "\t".'<div>';
                $output .= "\t\t".'<br/><p class=lable_title><label for="'.$pt_id.'">'.$pt_metabox['label'].'</label></p>'."\n";
                $output .= "\t\t".'<p><textarea rows="5" cols="98" class="pt_input_textarea" name="ptthemes_'.$pt_metabox["name"].'" id="'.$pt_id.'">' . $pt_metaboxvalue . '</textarea></p>'."\n";
                $output .= "\t\t".'<p class=note>'.$pt_metabox['desc'].'</p>'."\n";
                $output .= "\t".'</div>'."\n";
            }
           elseif ($pt_metabox['type'] == 'select'){
                $output .= "\t".'<div>';
                $output .= "\t\t".'<br/><p class=lable_title><label for="'.$pt_id.'">'.$pt_metabox['label'].'</label></p>'."\n";
                $output .= "\t\t".'<p><select class="pt_input_select" id="'.$pt_id.'" name="ptthemes_'. $pt_metabox["name"] .'"></p>'."\n";
                $array = $pt_metabox['options'];
                if($array){
                    foreach ( $array as $id => $option ) {
                        $selected = '';
                        if($pt_metabox['default'] == $option){$selected = 'selected="selected"';} 
                        if($pt_metaboxvalue == $option){$selected = 'selected="selected"';}
                        $output .= '<option value="'. $option .'" '. $selected .'>' . $option .'</option>';
                    }
                }
                $output .= '</select><p class=note>'.$pt_metabox['desc'].'</p>'."\n";
                $output .= "\t".'</div>'."\n";
            }
            elseif ($pt_metabox['type'] == 'checkbox'){
                if($pt_metaboxvalue == 'on') { $checked = 'checked="checked"';} else {$checked='';}
				$output .= "\t".'<div>';
                $output .= "\t\t".'<br/><p class=lable_title><label for="'.$pt_id.'">'.$pt_metabox['label'].'</label></p>'."\n";
                $output .= "\t\t".'<p><input type="checkbox" '.$checked.' class="pt_input_checkbox"  id="'.$pt_id.'" name="ptthemes_'. $pt_metabox["name"] .'" /></p>'."\n";
                $output .= "\t\t".'<p class=note>'.$pt_metabox['desc'].'</p>'."\n";
                $output .= "\t".'</div>'."\n";
            }        
        }
    
    $output .= '</div>'."\n\n";
    echo $output;
}
}

if(!function_exists('ptthemes_metabox_insert')){
function ptthemes_metabox_insert() {
    global $pt_metaboxes;
    global $globals;
    $pID = $_POST['post_ID'];
    $counter = 0;
    foreach ($pt_metaboxes as $pt_metabox) { // On Save.. this gets looped in the header response and saves the values submitted
    if($pt_metabox['type'] == 'text' OR $pt_metabox['type'] == 'select' OR $pt_metabox['type'] == 'checkbox' OR $pt_metabox['type'] == 'textarea') // Normal Type Things...
        {
            $var = "ptthemes_".$pt_metabox["name"];
			 if (isset($_POST[$var])) {            
                if( get_post_meta( $pID, $pt_metabox["name"] ) == "" )
                    add_post_meta($pID, $pt_metabox["name"], $_POST[$var], true );
                elseif($_POST[$var] != get_post_meta($pID, $pt_metabox["name"], true))
                    update_post_meta($pID, $pt_metabox["name"], $_POST[$var]);
                elseif($_POST[$var] == "")
                    delete_post_meta($pID, $pt_metabox["name"], get_post_meta($pID, $pt_metabox["name"], true));
            }  
        } 
    }
}
}

if(!function_exists('ptthemes_header_inserts')){
function ptthemes_header_inserts(){

	echo '<link rel="stylesheet" type="text/css" href="'.get_bloginfo('template_directory').'/library/functions/admin_style.css" media="screen" />';
}}
if(!function_exists('list_transactions')){
function list_transactions(){ 
global $post, $wpdb;
$pid_sql = "select * from $wpdb->posts p where p.post_title=\"$post->ID\"  GROUP BY p.ID ORDER BY p.post_date desc";
$invoice_ids = $wpdb->get_results($pid_sql);
?>
<table width="75%" cellpadding="3" cellspacing="3" class="widefat post fixed" >
    <tr>
      <td width="14%"><?php _e('Type');?></td>
      <td width="14%"><?php _e('Payment Method');?></td>
      <td width="14%"><?php _e('Paid Amount');?></td>
      <td width="14%"><?php _e('Date');?></td>
	</tr>
<?php
$total = '';
foreach($invoice_ids as $invoice){
$cur_sym = get_option('currencysym');
$status = get_post_meta($invoice->ID, '_status',true);
$paid_amt ='';
$paid_amt = get_post_meta($invoice->ID, 'paid_amount',true);
if($status=='Paid' || $status=='Subscription-Payment'){$total = $total + $paid_amt; }
?>
   
    <tr>
      <td><?php edit_post_link($status, '', '',$invoice->ID);?></td>
      <td><?php echo get_post_meta($invoice->ID, 'paymentmethod',true);?></td>
      <td><?php if($paid_amt){echo $cur_sym.$paid_amt;}else{echo __('Na');} ?></td>
      <td><?php echo $invoice->post_date;?></td>
	</tr>
    
    
<?php
}
echo '</table><br />';
echo __('<b>Total Recived: </b>').$cur_sym.$total;
}}
if(!function_exists('ptthemes_meta_box')){
function ptthemes_meta_box() {
    if ( function_exists('add_meta_box') ) {
        add_meta_box('ptthemes-settings',$GLOBALS['themename'].' Custom Settings','ptthemes_meta_box_content','post','normal','high');
		add_meta_box('ptthemes-settings',$GLOBALS['themename'].' Custom Settings','ptthemes_meta_box_content','event','normal','high');
		
		add_meta_box('ptthemes-settings',$GLOBALS['themename'].' Custom Settings','ptthemes_meta_box_content','place','normal','high');
		
		add_meta_box('ptthemes-settings',$GLOBALS['themename'].' Custom Settings','ptthemes_meta_box_content','invoice','normal','high');
		
		// INVOICES
		add_meta_box('transactions-list','Event Transactions','list_transactions','event','normal','high');
		
		add_meta_box('transactions-list','Place Transactions','list_transactions','place','normal','high');
    }
}}
add_action('admin_menu', 'ptthemes_meta_box');
add_action('admin_head', 'ptthemes_header_inserts');
if(is_admin()){
add_action('save_post', 'ptthemes_metabox_insert');
}

function relativeDate($posted_date) {
    $tz = 0;    // change this if your web server and weblog are in different timezones
                // see project page for instructions on how to do this
    $month = substr($posted_date,4,2);
    if ($month == "02") { // february
    	// check for leap year
    	$leapYear = isLeapYear(substr($posted_date,0,4));
    	if ($leapYear) $month_in_seconds = 2505600; // leap year
    	else $month_in_seconds = 2419200;
    }
    else { // not february
    // check to see if the month has 30/31 days in it
    	if ($month == "04" or 
    		$month == "06" or 
    		$month == "09" or 
    		$month == "11")
    		$month_in_seconds = 2592000; // 30 day month
    	else $month_in_seconds = 2678400; // 31 day month;
    }
  
/* 
some parts of this implementation borrowed from:
http://maniacalrage.net/archives/2004/02/relativedatesusing/ 
*/
    $in_seconds = strtotime(substr($posted_date,0,8).' '.
                  substr($posted_date,8,2).':'.
                  substr($posted_date,10,2).':'.
                  substr($posted_date,12,2));
    $diff = time() - ($in_seconds + ($tz*3600));
    $months = floor($diff/$month_in_seconds);
    $diff -= $months*2419200;
    $weeks = floor($diff/604800);
    $diff -= $weeks*604800;
    $days = floor($diff/86400);
    $diff -= $days*86400;
    $hours = floor($diff/3600);
    $diff -= $hours*3600;
    $minutes = floor($diff/60);
    $diff -= $minutes*60;
    $seconds = $diff;
    if ($months>0) {
        // over a month old, just show date ("Month, Day Year")
        echo ''; the_time('F jS, Y');
    } else {
        if ($weeks>0) {
            // weeks and days
            $relative_date .= ($relative_date?', ':'').$weeks.' '.RELATIVE_WEEK.''.($weeks>1?''.RELATIVE_S.'':'');
            $relative_date .= $days>0?($relative_date?', ':'').$days.' '.RELATIVE_DAY.''.($days>1?''.RELATIVE_S.'':''):'';
        } elseif ($days>0) {
            // days and hours
            $relative_date .= ($relative_date?', ':'').$days.' '.RELATIVE_DAY.''.($days>1?''.RELATIVE_S.'':'');
            $relative_date .= $hours>0?($relative_date?', ':'').$hours.' '.RELATIVE_HOUR.''.($hours>1?''.RELATIVE_S.'':''):'';
        } elseif ($hours>0) {
            // hours and minutes
            $relative_date .= ($relative_date?', ':'').$hours.' '.RELATIVE_HOUR.''.($hours>1?''.RELATIVE_S.'':'');
            $relative_date .= $minutes>0?($relative_date?', ':'').$minutes.' '.RELATIVE_MINUTE.''.($minutes>1?''.RELATIVE_S.'':''):'';
        } elseif ($minutes>0) {
            // minutes only
            $relative_date .= ($relative_date?', ':'').$minutes.' '.RELATIVE_MINUTE.''.($minutes>1?''.RELATIVE_S.'':'');
        } else {
            // seconds only
            $relative_date .= ($relative_date?', ':'').$seconds.' '.RELATIVE_MINUTE.''.($seconds>1?''.RELATIVE_S.'':'');
        }
        // show relative date and add proper verbiage
    	echo ''.RELATIVE_POSTED.' '.$relative_date.' '.RELATIVE_AGO.'';
    }
}

function isLeapYear($year) {
        return $year % 4 == 0 && ($year % 400 == 0 || $year % 100 != 0);
}

if(!function_exists('how_long_ago')){
	function how_long_ago($timestamp){
		$difference = time() - $timestamp;

		if($difference >= 60*60*24*365){        // if more than a year ago
			$int = intval($difference / (60*60*24*365));
			$s = ($int > 1) ? ''.RELATIVE_S.'' : '';
			$r = $int . ' '.RELATIVE_YEAR.'' . $s . ' '.RELATIVE_AGO.'';
		} elseif($difference >= 60*60*24*7*5){  // if more than five weeks ago
			$int = intval($difference / (60*60*24*30));
			$s = ($int > 1) ? ''.RELATIVE_S.'' : '';
			$r = $int . ' '.RELATIVE_MONTH.'' . $s . ' '.RELATIVE_AGO.'';
		} elseif($difference >= 60*60*24*7){        // if more than a week ago
			$int = intval($difference / (60*60*24*7));
			$s = ($int > 1) ? ''.RELATIVE_S.'' : '';
			$r = $int . ' '.RELATIVE_WEEK.'' . $s . ' '.RELATIVE_AGO.'';
		} elseif($difference >= 60*60*24){      // if more than a day ago
			$int = intval($difference / (60*60*24));
			$s = ($int > 1) ? ''.RELATIVE_S.'' : '';
			$r = $int . ' '.RELATIVE_DAY.'' . $s . ' '.RELATIVE_AGO.'';
		} elseif($difference >= 60*60){         // if more than an hour ago
			$int = intval($difference / (60*60));
			$s = ($int > 1) ? ''.RELATIVE_S.'' : '';
			$r = $int . ' '.RELATIVE_HOUR.'' . $s . ' '.RELATIVE_AGO.'';
		} elseif($difference >= 60){            // if more than a minute ago
			$int = intval($difference / (60));
			$s = ($int > 1) ? ''.RELATIVE_S.'' : '';
			$r = $int . ' '.RELATIVE_MINUTE.'' . $s . ' '.RELATIVE_AGO.'';
		} else {                                // if less than a minute ago
			$r = ''.RELATIVE_MOMENTS.' '.RELATIVE_AGO.'';
		}

		return $r;
	}
}

// NOTE the ">" symbol in the following line must
// be the last character in the file - do not add
// any spaces, tabs or newlines after it, or you
// will get "header already sent" errors.
/*
Plugin Name: WP-PageNavi 
Plugin URI: http://www.lesterchan.net/portfolio/programming.php 
*/ 

if (!function_exists('wp_pagenavi')) {
function wp_pagenavi($before = '', $after = '', $prelabel = '', $nxtlabel = '', $pages_to_show = 5, $always_show = false) {

	global $request, $posts_per_page, $wpdb, $paged,$blog_id;
	if(empty($prelabel)) {
		$prelabel  = '<strong>&laquo;</strong>';
	}
	if(empty($nxtlabel)) {
		$nxtlabel = '<strong>&raquo;</strong>';
	}
	$half_pages_to_show = round($pages_to_show/2);
	//echo 'request= '.$request;
	
if(strstr($request,",CASE WHEN (select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key like \"is_featured\") THEN 1 ELSE 0 END AS is_featured")){$request =str_replace(",CASE WHEN (select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key like \"is_featured\") THEN 1 ELSE 0 END AS is_featured", "", $request); } // strip out the search bit for scoring
	if (!is_single()) {
		if(is_tag()) {
			preg_match('#FROM\s(.*)\sGROUP BY#siU', $request, $matches);		
		} elseif (!is_category()) {
			preg_match('#FROM\s(.*)\sORDER BY#siU', $request, $matches);	
		} else {
			preg_match('#FROM\s(.*)\sGROUP BY#siU', $request, $matches);		
		}
		//print_r( $matches);
$fromwhere = $matches[1];
$fromwhere = str_replace("GROUP BY ".$wpdb->prefix."posts.ID", "", $fromwhere);
if($blog_id && $blog_id!=1){$fromwhere = str_replace("GROUP BY ".$wpdb->prefix.$blog_id."_posts.ID", "", $fromwhere);}
//echo $fromwhere;
		$numposts = $wpdb->get_var("SELECT COUNT(DISTINCT ID) FROM $fromwhere");
		//echo '###'.$numposts;
$max_page = ceil($numposts /$posts_per_page);
		if(empty($paged)) {
			$paged = 1;
		}
		if($max_page > 1 || $always_show) {
			echo "$before <div class='Navi'>";
			if ($paged >= ($pages_to_show-1)) {
				echo '<a href="'.str_replace('&paged','&amp;paged',get_pagenum_link()).'">&laquo;</a>';
			}
			previous_posts_link($prelabel);
			for($i = $paged - $half_pages_to_show; $i  <= $paged + $half_pages_to_show; $i++) {
				if ($i >= 1 && $i <= $max_page) {
					if($i == $paged) {
						echo "<strong class='on'>$i</strong>";
					} else {
						echo ' <a href="'.str_replace('&paged','&amp;paged',get_pagenum_link($i)).'">'.$i.'</a> ';
					}
				}
			}
			next_posts_link($nxtlabel, $max_page);
			if (($paged+$half_pages_to_show) < ($max_page)) {
				echo '<a href="'.str_replace('&paged','&amp;paged',get_pagenum_link($max_page)).'">&raquo;</a>';
			}
			echo "</div> $after";
		}
	}
}}

// Use Noindex for sections specified in theme admin

if (!function_exists('ptthemes_noindex_head')) {
function ptthemes_noindex_head() {
    if ((is_category() && get_option('ptthemes_noindex_category')) ||
	    (is_tag() && get_option('ptthemes_noindex_tag')) ||
		(is_day() && get_option('ptthemes_noindex_daily')) ||
		(is_month() && get_option('ptthemes_noindex_monthly')) ||
		(is_year() && get_option('ptthemes_noindex_yearly')) ||
		(is_author() && get_option('ptthemes_noindex_author')) ||
		(is_search() && get_option('ptthemes_noindex_search'))) {

		$meta_string .= '<meta name="robots" content="noindex,follow" />';
	}	
	if(isset($meta_string)){echo $meta_string;}
}}
add_action('wp_head', 'ptthemes_noindex_head');

///////////NEW FUNCTIONS  START//////
if (!function_exists('bdw_get_images')) {
function bdw_get_images($iPostID,$img_size='thumb',$no_images='') 
{
    $arrImages =& get_children('order=ASC&orderby=menu_order ID&post_type=attachment&post_mime_type=image&post_parent=' . $iPostID );
	//print_r($arrImages);
	$counter = 0;
	$return_arr = array();
	if($arrImages) 
	{		
       foreach($arrImages as $key=>$val)
	   {
	   		$id = $val->ID;
			//print_r($val);
			if($img_size == 'gallery')
			{	
				$img_arr = wp_get_attachment_image_src($id,'large');	// THE FULL SIZE IMAGE INSTEAD
				$img_arr[] = $val->post_title; // add the title to the array
				$img_arr[] = $val->post_content; // add the description to the array
				$return_arr[] = $img_arr;
			}
			elseif($img_size == 'large')
			{
				$img_arr = wp_get_attachment_image_src($id,'large');	// THE FULL SIZE IMAGE INSTEAD
				$return_arr[] = $img_arr[0];
			}
			elseif($img_size == 'medium')
			{
				$img_arr = wp_get_attachment_image_src($id, 'medium'); //THE medium SIZE IMAGE INSTEAD
				$return_arr[] = $img_arr[0];
			}
			elseif($img_size == 'thumb')
			{
				$img_arr = wp_get_attachment_image_src($id, 'thumbnail'); // Get the thumbnail url for the attachment
				$return_arr[] = $img_arr[0];
			}
			$counter++;
			if($no_images!='' && $counter==$no_images)
			{
				break;	
			}
	   }
	  return $return_arr;
	}
}}
if (!function_exists('bdw_get_images_desc')) {
function bdw_get_images_desc($iPostID,$no_images='') 
{
    $arrImages =& get_children('order=ASC&orderby=menu_order ID&post_type=attachment&post_mime_type=image&post_parent=' . $iPostID );
	$counter = 0;
	$return_arr = array();
	if($arrImages) 
	{		
       foreach($arrImages as $key=>$val)
	   {
	   		//$id = $val->ID;
	   		$desc[0] = $val->post_content;
			$return_arr[] = $desc[0];

			$counter++;
			if($no_images!='' && $counter==$no_images)
			{
				break;	
			}
	   }
	  return $return_arr;
	}
}}
if (!function_exists('get_related_posts')) {
function get_related_posts($postdata)
{	 
global $wpdb;
#################################fixed by stiofan to only include listings in the same city.
	$post_meta = get_post_meta($postdata->ID, '',false);
	$post_city_id = $post_meta['post_city_id'][0];	
############################################################################
	
	//$postCatArr = wp_get_post_categories($postdata->ID);
	$postCatArr = get_the_terms($postdata->ID, 'placecategory');
	$post_array = array();
	//for($c=0;$c<count($postCatArr);$c++)
	$cats='';
	$i=0;
	foreach ($postCatArr as $taxindex => $taxitem)
	{
		if($i!=0){$cats .= ','.$taxitem->term_id;}else{$cats .= $taxitem->term_id;}
		$i++;
		
		}
		$related_post = "select p.* from $wpdb->posts p join $wpdb->postmeta pm on pm.post_id=p.ID where p.post_type='place' AND p.ID!=$postdata->ID and p.post_status='publish' and (pm.meta_key='post_city_id' and (pm.meta_value in ($post_city_id) )) and p.ID in (select tr.object_id from $wpdb->term_relationships tr join $wpdb->term_taxonomy t on t.term_taxonomy_id=tr.term_taxonomy_id where t.term_id in ($cats) ) order by p.post_date desc limit 5";
		$category_posts = $wpdb->get_results($related_post);
		foreach($category_posts as $post) 
		{
			if($post->ID !=  $postdata->ID)
			{
				$post_array[$post->ID] = $post;
			}
		}
	
if($post_array)
{
?>
<div class="realated_post clearfix">
<h3><span><?php _e('Related Listing');?></span></h3>

<ul class="category_grid_view clearfix">
<?php
	$img_zc = get_img_zc(get_option('ptthemes_image_zc'));
	$img_q = get_option('ptthemes_image_q');### added image quality option
	$relatedprd_count = 0;
	foreach($post_array as $postval)
	{
		$product_id = $postval->ID;
		$post_title = $postval->post_title;
		$productlink = get_permalink($product_id);
		$post_date = $postval->post_date;
		$comment_count = $postval->comment_count;
		$text = $postval->post_content;
		$length = 100;
		$text = strip_tags($text);
		if(strlen($text)>$length)
		{
			$text = substr($text, 0, $length);
			$text = substr($text, 0, strrpos($text, " "));
			$text = $text.' ...';
		}
		if($postval->post_status == 'publish')
		{
			$post_images = bdw_get_images($postval->ID,'medium');
			
			if($post_images[0]!='')
			{
				$relatedprd_count++;
			?>
            <li class="clearfix"> 
             <?php if($post_images[0]){ global $thumb_url;?>
       <a class="post_img" href="<?php echo $productlink; ?>"><img src="<?php echo $post_images[0];?>" alt="<?php echo $post_title; ?>" title="<?php echo $post_title; ?>"  /> </a>  
<?php }?>
   <div class="widget_main_title"><h3> <a href="<?php echo $productlink; ?>"><?php echo (strlen($post_title) > 31) ? substr($post_title,0,30).'...' : $post_title;?></a></h3> </div>
                    <span class="rating"><?php echo get_post_rating_star($product_id);?></span>                    
                    <!-- <p><?php //echo $text; ?> </p> -->
                
                 <p class="review clearfix">    
                 <a href="<?php echo $productlink; ?>#comments" class="pcomments" ><?php echo get_comments_number($postval->ID); ?> </a>  
                 <span class="readmore"> <a href="<?php echo $productlink; ?>"><?php _e('read more');?> </a> </span>
                 </p>
     
            </li>
            <?php
			if($relatedprd_count==5){ break;}
			}
		}
	}
?>
</ul>
</div>
<?php
}
}}



if (!function_exists('recent_comments')) {
function recent_comments($g_size = 30, $no_comments = 10, $comment_lenth = 60, $show_pass_post = false) {
        global $wpdb, $tablecomments, $tableposts,$rating_table_name;
		$tablecomments = $wpdb->comments;
		$tableposts = $wpdb->posts;
		
		$comments_echo ='';
################################### FIX BY STIOFAN HEBTECH.CO.UK TO HIDE BLOG COMMENTS IN REVIEWS #####################################		
		//$request = "SELECT ID, comment_ID, comment_content, comment_author,comment_post_ID, comment_author_email FROM $tableposts, $tablecomments WHERE $tableposts.ID=$tablecomments.comment_post_ID AND post_status = 'publish' ";
		$city_id = mysql_real_escape_string ($_SESSION['multi_city']);
		if($_SESSION['multi_city']){$request = "SELECT p.ID, p.post_type, co.comment_ID, co.user_id, co.comment_content, co.comment_author,co.comment_post_ID, co.comment_author_email FROM $tableposts  as p join $tablecomments co on p.ID=co.comment_post_ID join $wpdb->postmeta pm on pm.post_id=p.ID WHERE  p.post_status = 'publish' AND p.post_type IN('place','event') AND pm.meta_key='post_city_id' and pm.meta_value in ($city_id) AND co.comment_approved = '1' ORDER BY co.comment_date DESC LIMIT $no_comments";
		}
		else{$request = "SELECT ID, post_type, comment_ID, comment_content, comment_author,comment_post_ID, user_id, comment_author_email FROM $tableposts, $tablecomments WHERE $tableposts.ID=$tablecomments.comment_post_ID AND post_status = 'publish' AND post_type IN('place','event') AND comment_approved = '1' ORDER BY $tablecomments.comment_date DESC LIMIT $no_comments";
		}
        $comments = $wpdb->get_results($request);

        foreach ($comments as $comment) {
		$comment_id ='';
		$comment_id = $comment->comment_ID;
		$comment_content = strip_tags($comment->comment_content);
		
		$comment_content = preg_replace('#(\\[img\\]).+(\\[\\/img\\])#', '', $comment_content);
		$comment_excerpt = mb_substr($comment_content, 0, $comment_lenth)."";
		$permalink = get_permalink($comment->ID)."#comment-".$comment->comment_ID;
		$comment_author_email = $comment->comment_author_email;
		$comment_post_ID = $comment->comment_post_ID;

		$na=true;
		if(function_exists('icl_object_id') && icl_object_id($comment_post_ID, $comment->post_type, true)){
		$comment_post_ID2 = icl_object_id($comment_post_ID, $comment->post_type, false);
		if($comment_post_ID==$comment_post_ID2){}else{$na=false;}
		}
		
		$post_title = get_the_title($comment_post_ID);
		$permalink = get_permalink($comment_post_ID);
		if($comment->user_id){$user_profile_url = get_author_posts_url($comment->user_id);}
		else{$user_profile_url ='';}
		
		if($comment_id && $na){
   $comments_echo .= '<li class="clearfix">';
  $comments_echo .=  "<span class=\"li".$comment_id."\">";
		if (function_exists('get_avatar')) {
					  if (!isset($comment->comment_type) && $comment->comment_type=='' ) {
						 if($user_profile_url){ $comments_echo .=   '<a href="'.$user_profile_url.'">';}
						 $comments_echo .=  get_avatar($comment->comment_author_email, 60, $template_path . ''.get_bloginfo('template_directory').'/images/gravatar2.png');
						if($user_profile_url){ $comments_echo .=  '</a>';}
					  } elseif ( (isset($comment->comment_type) && $comment->comment_type == 'trackback') || (isset($comment->comment_type) && $comment->comment_type=='pingback') ) {
					if($user_profile_url){	 $comments_echo .=   '<a href="'.$user_profile_url.'">';}
						 $comments_echo .=  get_avatar($comment->comment_author_url, 60, $template_path . ''.get_bloginfo('template_directory').'/images/gravatar2.png');
					  }
				   } elseif (function_exists('gravatar')) {
					if($user_profile_url){  $comments_echo .=   '<a href="'.$user_profile_url.'">';}
					  $comments_echo .=  "<img src=\"";
					  if ('' == $comment->comment_type) {
						 $comments_echo .=  gravatar($comment->comment_author_email,60, $template_path . ''.get_bloginfo('template_directory').'/images/gravatar2.png');
						if($user_profile_url){  $comments_echo .=  '</a>';}
					  } elseif ( ('trackback' == $comment->comment_type) || ('pingback' == $comment->comment_type) ) {
					if($user_profile_url){	$comments_echo .=   '<a href="'.$user_profile_url.'">';}
						$comments_echo .=  gravatar($comment->comment_author_url,60, $template_path . ''.get_bloginfo('template_directory').'/images/gravatar2.png');
						if($user_profile_url){ $comments_echo .=  '</a>';}
					  }
					 $comments_echo .=  "\" alt=\"\" class=\"avatar\" />";
				   }
    $comments_echo .=  "</span>\n";
    $comments_echo .=  '' ;

           
 			$comments_echo .=   '<a href="'.$permalink.'">'.$post_title.'</a>';
			 $post_rating = $wpdb->get_var("select rating_rating from $rating_table_name where comment_id=\"$comment_id\"");
			 $comments_echo .=  '<br />'.draw_rating_star($post_rating);
			 
 			$comments_echo .=  "<a class=\"comment_excerpt\" href=\"" . $permalink . "\" title=\"View the entire comment\">";
			$comments_echo .=  $comment_excerpt;
			//echo preg_replace('#(\\[img\\]).+(\\[\\/img\\])#', '', $comment_excerpt);
			$comments_echo .=  "</a>";
			
			$comments_echo .=  '</li>';

	            }
		}

return $comments_echo;
}}

if (!function_exists('wide_recent_comments')) {
function wide_recent_comments($g_size = 30, $no_comments = 10, $comment_lenth, $show_pass_post = false, $is_comments=true) {
        global $wpdb, $tablecomments, $tableposts,$rating_table_name,$template_path;
		$tablecomments = $wpdb->comments;
		$tableposts = $wpdb->posts;
################################### FIX BY STIOFAN HEBTECH.CO.UK TO HIDE BLOG COMMENTS IN REVIEWS #####################################		
		$city_id = mysql_real_escape_string ($_SESSION['multi_city']);
		if($_SESSION['multi_city']){$request = "SELECT p.ID, p.post_type, co.comment_ID, co.user_id, co.comment_content, co.comment_author,co.comment_post_ID, co.comment_author_email FROM $tableposts  as p join $tablecomments co on p.ID=co.comment_post_ID join $wpdb->postmeta pm on pm.post_id=p.ID WHERE  p.post_status = 'publish' AND p.post_type IN('place','event') AND pm.meta_key='post_city_id' and pm.meta_value in ($city_id) AND co.comment_approved = '1' ORDER BY co.comment_date DESC LIMIT $no_comments";
		}
		else{$request = "SELECT ID, post_type, comment_ID, comment_content, comment_author,comment_post_ID, user_id, comment_author_email FROM $tableposts, $tablecomments WHERE $tableposts.ID=$tablecomments.comment_post_ID AND post_status = 'publish' AND post_type IN('place','event') AND comment_approved = '1' ORDER BY $tablecomments.comment_date DESC LIMIT $no_comments";
		}
################################### END FIX BY STIOFAN HEBTECH.CO.UK TO HIDE BLOG COMMENTS IN REVIEWS ##################################		
        $comments = $wpdb->get_results($request);
		//$comment_lenth = 220;
		
		if($comments && $is_comments){
        foreach ($comments as $comment) {
		$comment_id = $comment->comment_ID;
		$comment_content = strip_tags($comment->comment_content);
		
		$comment_content = preg_replace('#(\\[img\\]).+(\\[\\/img\\])#', '', $comment_content);
		$comment_excerpt = mb_substr($comment_content, 0, $comment_lenth)."";
		$permalink = get_permalink($comment->ID)."#comment-".$comment->comment_ID;
		$comment_author = $comment->comment_author;
		$comment_author_email = $comment->comment_author_email;
		$comment_post_ID = $comment->comment_post_ID;
		
		$na=true;
		if(function_exists('icl_object_id') && icl_object_id($comment_post_ID, $comment->post_type, true)){
		$comment_post_ID2 = icl_object_id($comment_post_ID, $comment->post_type, false);
		if($comment_post_ID==$comment_post_ID2){}else{$na=false;}
		}
		
		$post_title = get_the_title($comment_post_ID);
		$permalink = get_permalink($comment_post_ID);
		
		if($comment->user_id){$user_profile_url = get_author_posts_url($comment->user_id);}
		else{$user_profile_url ='';}
		
		if($comment_id && $na){
   echo '<li class="clearfix wide_comments" >';
   echo "<span class=\"li".$comment_id."\" > ";
		if (function_exists('get_avatar')) {
					  if (!isset($comment->comment_type) && $comment->comment_type=='') {
						if($user_profile_url){  echo  '<a href="'.$user_profile_url.'">';}
						 echo get_avatar($comment->comment_author_email, 60, get_bloginfo('template_directory').'/images/gravatar2.png', 'Profile pic');
						if($user_profile_url){ echo '</a>';}
					  } elseif ( (isset($comment->comment_type) && $comment->comment_type=='trackback') || (isset($comment->comment_type) && $comment->comment_type=='pingback') ) {
						 echo  '<a href="'.$user_profile_url.'">';
						 echo get_avatar($comment->comment_author_url, 60, $template_path . ''.get_bloginfo('template_directory').'/images/gravatar2.png');
					  }
				   } elseif (function_exists('gravatar')) {
					if($user_profile_url){   echo  '<a href="'.$user_profile_url.'">';}
					  echo "<img src=\"";
					  if ('' == $comment->comment_type) {
						 echo gravatar($comment->comment_author_email,60, $template_path . ''.get_bloginfo('template_directory').'/images/gravatar2.png');
						if($user_profile_url){   echo '</a>';}
					  } elseif ( ('trackback' == $comment->comment_type) || ('pingback' == $comment->comment_type) ) {
					if($user_profile_url){ 	echo  '<a href="'.$user_profile_url.'">';}
						echo gravatar($comment->comment_author_url,60, $template_path . ''.get_bloginfo('template_directory').'/images/gravatar2.png');
						if($user_profile_url){  echo '</a>';}
					  }
					  echo "\" alt=\"\" class=\"avatar\" />";
				   }
    echo "</span>\n";
    echo '' ;

           echo '<div class="wide_comment_text"  >' ;
 			 echo  '<a href="'.$user_profile_url.'">'.$comment_author.'</a> '.__('avaliou').' <a href="'.$permalink.'">'.$post_title.'</a><br />';
			 
			$post_rating = $wpdb->get_var("select rating_rating from $rating_table_name where comment_id=\"$comment_id\"");
			echo '<p class="rating rating-recent-comments">'.draw_rating_star($post_rating)."</p>";
 			echo "<a class=\"comment_excerpt\" href=\"" . $permalink . "\" title=\"View the entire comment\">";
			echo $comment_excerpt;
			echo "</a>";
			echo "</div>";
			echo '</li>';
		}

	            }}elseif($comments && !$is_comments){return true;}else{return false;}

}}

if (!function_exists('excerpt')) {
function excerpt($limit=10) {
  $excerpt = explode(' ', get_the_excerpt(),$limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'...';
  } else {
    $excerpt = implode(" ",$excerpt);
  }	
  $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
  return $excerpt;
}}
 
if (!function_exists('content')) {
function content($limit) {
  $content = explode(' ', get_the_content(), $limit);
  if (count($content)>=$limit) {
    array_pop($content);
    $content = implode(" ",$content).'...';
  } else {
    $content = implode(" ",$content);
  }	
  $content = preg_replace('/\[.+\]/','', $content);
  $content = apply_filters('the_content', $content); 
  $content = str_replace(']]>', ']]&gt;', $content);
  return $content;
}}

if (!function_exists('is_user_can_add_event')) {
function is_user_can_add_event()
{
	global $current_user;
	//$current_user->ID
	return 1;	
}}
if (!function_exists('get_currency_sym')) {
function get_currency_sym()
{
	global $wpdb;
	if(get_option('currencysym'))
	{
		return stripslashes(get_option('currencysym'));
	}else
	{
		return '$';
	}
}}
if (!function_exists('get_currency_type')) {
function get_currency_type()
{
	global $wpdb;
	if(get_option('currency'))
	{
		return stripslashes(get_option('currency'));
	}else
	{
		return 'USD';
	}
	
}}
if (!function_exists('get_site_emailId')) {
function get_site_emailId()
{
	if(get_option('site_email'))
	{
		return get_option('site_email');
	}else
	{
		return get_option('admin_email');
	}
}}
if (!function_exists('get_site_emailName')) {
function get_site_emailName()
{
	if(get_option('site_email_name'))
	{
		return stripslashes(get_option('site_email_name'));
	}else
	{
		return stripslashes(get_option('blogname'));
	}
}}
if (!function_exists('is_allow_user_register')) {
function is_allow_user_register()
{
	return get_option('users_can_register');
}}

if (!function_exists('get_ssl_normal_url')) {
function get_ssl_normal_url($url,$pid='')
{
	if($pid)
	{
		return $url;
	}else
	{
		if(get_option('is_allow_ssl')=='0')
		{
		}else
		{
			$url = str_replace('http://','https://',$url);
		}
	}
	return $url;
}}
if (!function_exists('get_property_price_info')) {
function get_property_price_info($pro_type='')
{
	global $price_db_table_name,$wpdb;
	add_column_if_not_exist($price_db_table_name, 'sort_order');
	if($pro_type)
	{
		$subsql = " and pid=\"$pro_type\"";	
	}
	$pricesql = "select * from $price_db_table_name where status=1 $subsql ORDER BY sort_order,pid";
	$priceinfo = $wpdb->get_results($pricesql);
	$price_info = array();
	if($priceinfo)
	{
		foreach($priceinfo as $priceinfoObj)
		{
		$info = array();
		$info['pid'] = $priceinfoObj->pid;
		$info['title'] = $priceinfoObj->title;
		$info['price'] = $priceinfoObj->amount;
		$info['days'] = $priceinfoObj->days;
		$info['alive_days'] =$priceinfoObj->days;
		$info['cat'] =$priceinfoObj->cat;
		$info['is_featured'] =$priceinfoObj->is_featured;
		$info['title_desc'] =$priceinfoObj->title_desc;
		
		$info['sub_active'] =$priceinfoObj->sub_active;
		$info['sub_units'] =$priceinfoObj->sub_units;
		$info['sub_units_num'] =$priceinfoObj->sub_units_num;
		$price_info[] = $info;
		}
	}
	return $price_info;
}}
if (!function_exists('get_property_price_info_listing')) {
function get_property_price_info_listing($pid='', $pkg='')
{
	global $price_db_table_name,$wpdb;
	if($pkg==''){$pkg_id = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta where meta_key='package_pid' and post_id=$pid");}
	else{$pkg_id=$pkg;}
	$pricesql = "select * from $price_db_table_name where pid=$pkg_id";
	$priceinfo = $wpdb->get_results($pricesql);
	$price_info = array();
	if($priceinfo)
	{
		foreach($priceinfo as $priceinfoObj)
		{
		$info = array();
		$info['pid'] = $priceinfoObj->pid;
		$info['title'] = $priceinfoObj->title;
		$info['amount'] = $priceinfoObj->amount;
		$info['cat'] =$priceinfoObj->cat;
		$info['status'] = $priceinfoObj->status;
		$info['days'] = $priceinfoObj->days;		
		$info['is_featured'] =$priceinfoObj->is_featured;
		$info['property_feature_pkg'] =$priceinfoObj->property_feature_pkg;
		$info['timing_pkg'] =$priceinfoObj->timing_pkg;
		$info['contact_pkg'] =$priceinfoObj->contact_pkg	;
		$info['email_pkg'] =$priceinfoObj->email_pkg;
		$info['website_pkg'] =$priceinfoObj->website_pkg;
		$info['twitter_pkg'] =$priceinfoObj->twitter_pkg;
		$info['facebook_pkg'] =$priceinfoObj->facebook_pkg;
		$info['kw_tags_pkg'] =$priceinfoObj->kw_tags_pkg;
		$info['image_limit'] =$priceinfoObj->image_limit;
		$info['cat_limit'] =$priceinfoObj->cat_limit;
		$info['html_editor'] =$priceinfoObj->html_editor;
		$info['post_type'] =$priceinfoObj->post_type;
		$info['link_business_pkg'] =$priceinfoObj->link_business_pkg;
		$info['recurring_pkg'] =$priceinfoObj->recurring_pkg;
		$info['reg_desc_pkg'] =$priceinfoObj->reg_desc_pkg;
		$info['reg_fees_pkg'] =$priceinfoObj->reg_fees_pkg;
		$info['downgrade_pkg'] =$priceinfoObj->downgrade_pkg;
		$info['google_analytics'] =$priceinfoObj->google_analytics;
		$price_info[] = $info;
		}
	}
	return $info;
}}
if (!function_exists('get_property_downgrade_info')) {
function get_property_downgrade_info($pro_type='')
{
	global $price_db_table_name,$wpdb;
	if($pro_type)
	{
		$subsql = " and post_type=\"$pro_type\"";	
	}
	$pricesql = "select * from $price_db_table_name where status=1 $subsql";
	$priceinfo = $wpdb->get_results($pricesql);
	//$price_info = array();
	/*if($priceinfo)
	{
		foreach($priceinfo as $priceinfoObj)
		{

		$info = array();
		$info['pid'] = $priceinfoObj->pid;
		$info['title'] = $priceinfoObj->title;
		$info['post_type'] = $priceinfoObj->post_type;

		$price_info[] = $info;
		}
	}*/
	//return $price_info;
	return $priceinfo;
}}

if (!function_exists('twentyten_term_list')) {
function twentyten_term_list( $taxonomy, $glue = ', ', $text = '', $also_text = '' ) {
	global $wp_query, $post;
	$current_term = $wp_query->get_queried_object();
	$terms = wp_get_object_terms( $post->ID, $taxonomy );
	// If we're viewing a Taxonomy page..
	if ( isset( $current_term->taxonomy ) && $taxonomy == $current_term->taxonomy ) {
		// Remove the term from display.
		foreach ( (array) $terms as $key => $term ) {
			if ( $term->term_id == $current_term->term_id ) {
				unset( $terms[$key] );
				break;
			}
		}
		// Change to Also text as we've now removed something from the terms list.
		$text = $also_text;
	}
	$tlist = array();
	$rel = 'category' == $taxonomy ? 'rel="category"' : 'rel="tag"';
	foreach ( (array) $terms as $term ) {
		$tlist[] = '<a href="' . get_term_link( $term, $taxonomy ) . '" title="' . esc_attr( sprintf( __( 'View all posts in %s' ), $term->name ) ) . '" ' . $rel . '>' . $term->name . '</a>';
	}
	if ( ! empty( $tlist ) )
		return sprintf( $text, join( $glue, $tlist ) );
	return '';
}}
if (!function_exists('get_payment_optins')) {
function get_payment_optins($method)
{
	global $wpdb;
	$paymentsql = "select * from $wpdb->options where option_name like 'payment_method_$method'";
	$paymentinfo = $wpdb->get_results($paymentsql);
	if($paymentinfo)
	{
		foreach($paymentinfo as $paymentinfoObj)
		{
			$option_value = unserialize($paymentinfoObj->option_value);
			$paymentOpts = $option_value['payOpts'];
			$optReturnarr = array();
			for($i=0;$i<count($paymentOpts);$i++)
			{
				$optReturnarr[$paymentOpts[$i]['fieldname']] = $paymentOpts[$i]['value'];
			}
			//echo "<pre>";print_r($optReturnarr);
			return $optReturnarr;
		}
	}
}}

if (!function_exists('get_property_default_status')) {
function get_property_default_status()
{
	if(get_option('approve_status'))
	{
		return get_option('approve_status');
	}else
	{
		return 'publish';
	}
}}

if (!function_exists('get_user_nice_name')) {
function get_user_nice_name($fname,$lname='')
{
	global $wpdb;
	if($lname)
	{
		$uname = $fname.'-'.$lname;
	}else
	{
		$uname = $fname;
	}
	//$nicename = strtolower(str_replace(array("'",'"',"?",".","!","@","#","$","%","^","&","*","(",")","-","+","+"," "),array('-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-'),$uname));
	$nicename = strtolower(str_replace(array("'",'"',"?",".","!","@","#","$","%","^","&","*","(",")","-","+","+"," "),array('','','','-','','-','-','','','','','','','','','','-','-',''),$uname));
	$nicenamecount = $wpdb->get_var("select count(user_nicename) from $wpdb->users where user_nicename like \"$nicename\"");
	if($nicenamecount=='0')
	{
		return trim($nicename);
	}else
	{
		$lastuid = $wpdb->get_var("select max(ID) from $wpdb->users");
		return $nicename.'-'.$lastuid;
	}
}}


if (!function_exists('get_image_phy_destination_path')) {
function get_image_phy_destination_path()
{	
	$wp_upload_dir = wp_upload_dir();
	$path = $wp_upload_dir['path'];
	$url = $wp_upload_dir['url'];
	  $destination_path = $path."/";
      if (!file_exists($destination_path)){
      $imagepatharr = explode('/',str_replace(ABSPATH,'', $destination_path));
	   $year_path = ABSPATH;
		for($i=0;$i<count($imagepatharr);$i++)
		{
		  if($imagepatharr[$i])
		  {
			$year_path .= $imagepatharr[$i]."/";
			  if (!file_exists($year_path)){
				  mkdir($year_path, 0777);
			  }     
			}
		}
	}
	  return $destination_path;
}}

//This function would return paths of folder to which upload the image 
if (!function_exists('get_image_phy_destination_path_user')) {
function get_image_phy_destination_path_user()
{	
	global $upload_folder_path;
	$tmppath = $upload_folder_path;
	$destination_path = ABSPATH . $tmppath."users/";
      if (!file_exists($destination_path)){
      $imagepatharr = explode('/',$tmppath."users");
	   $year_path = ABSPATH;
		for($i=0;$i<count($imagepatharr);$i++)
		{
		  if($imagepatharr[$i])
		  {

			$year_path .= $imagepatharr[$i]."/";
			  if (!file_exists($year_path)){
				  mkdir($year_path, 0777);
			  }     
			}
		}
	}
	 return $destination_path;
	
}}

//
if (!function_exists('get_image_rel_destination_path_user')) {
function get_image_rel_destination_path_user()
{	
	global $upload_folder_path;
	$destination_path = site_url() ."/".$upload_folder_path."users/";
	  return $destination_path;
	
}}

if (!function_exists('get_image_rel_destination_path')) {
function get_image_rel_destination_path()
{
	$wp_upload_dir = wp_upload_dir();
	$path = $wp_upload_dir['path'];
	$url = $wp_upload_dir['url'];
	return $url.'/';
}}
if (!function_exists('get_image_tmp_phy_path')) {
function get_image_tmp_phy_path()
{	
	global $upload_folder_path;
	$tmppath = $upload_folder_path;
	return $destination_path = ABSPATH . $tmppath."tmp/";
}}

if (!function_exists('move_original_image_file')) {
function move_original_image_file($src,$dest)
{
	copy($src, $dest);
	unlink($src);
	$dest = explode('/',$dest);
	$img_name = $dest[count($dest)-1];
	$img_name_arr = explode('.',$img_name);

	$my_post = array();
	$my_post['post_title'] = $img_name_arr[0];
	$wp_upload_dir = wp_upload_dir();
	$subdir = $wp_upload_dir['subdir'];
	
	$my_post['guid'] = $subdir.'/'.$img_name;	return $my_post;
}}
if (!function_exists('get_image_size')) {
function get_image_size($src)
{
	$img = imagecreatefromjpeg($src);
	if (!$img) {
		echo "ERROR:could not create image handle ". $src;
		exit(0);
	}
	$width = imageSX($img);
	$height = imageSY($img);
	return array('width'=>$width,'height'=>$height);
	
}}
if (!function_exists('get_attached_file_meta_path')) {
function get_attached_file_meta_path($imagepath)
{
	$imagepath_arr = explode('/',$imagepath);
	$imagearr = array();
	for($i=0;$i<count($imagepath_arr);$i++)
	{
		$imagearr[] = $imagepath_arr[$i];
		if($imagepath_arr[$i] == 'uploads')
		{
			break;
		}
	}
	$imgpath_ini = implode('/',$imagearr);
	return str_replace($imgpath_ini.'/','',$imagepath);
}}
function image_resize_custom($src,$dest,$twidth,$theight)
{ 
	global $image_obj;
	// Get the image and create a thumbnail
	$img_arr = explode('.',$dest);
	$imgae_ext = strtolower($img_arr[count($img_arr)-1]);
	if($imgae_ext == 'jpg' || $imgae_ext == 'jpeg')
	{
		$img = imagecreatefromjpeg($src);
	}elseif($imgae_ext == 'gif')
	{
		$img = imagecreatefromgif($src);
	}
	elseif($imgae_ext == 'png')
	{
		$img = imagecreatefrompng($src);
	}
	
	if($img)
	{
		$width = imageSX($img);
		$height = imageSY($img);
	
		if (!$width || !$height) {
			echo "ERROR:Invalid width or height";
			exit(0);
		}
		
		if(($twidth<=0 || $theight<=0))
		{
			return false;
		}
		$image_obj->load($src);
		$image_obj->resize($twidth,$theight);
		$new_width = $image_obj->getWidth();
		$new_height = $image_obj->getHeight();
		$imgname_sub = '-'.$new_width.'X'. $new_height.'.'.$imgae_ext;
		$img_arr1 = explode('.',$dest);
		unset($img_arr1[count($img_arr1)-1]);
		$dest = implode('.',$img_arr1).$imgname_sub;
		$image_obj->save($dest);
		
		
		return array(
					'file' => basename( $dest ),
					'width' => $new_width,
					'height' => $new_height,
				);
	}else
	{
		return array();
	}
}

function get_author_info($aid)
{
	global $wpdb;
	$infosql = "select * from $wpdb->users where ID=$aid";
	$info = $wpdb->get_results($infosql);
	if($info)
	{
		return $info[0];
	}
}
// function set_property_status($pid,$status='publish')
function set_property_status($pid,$status) // Fix by Stiofan, hebtech.co.uk
{
	if($pid)
	{
		global $wpdb;
		//$wpdb->query("update $wpdb->posts set post_status=\"$status\" where ID=\"$pid\"");
		$my_post = array();
		//$my_post['post_status'] = 'publish';
		$my_post['post_status'] = $status; // Fix by Stiofan, hebtech.co.uk
		$my_post['ID'] = $pid;
		$last_postid = wp_update_post($my_post);
	}
}

function get_post_info($pid)
{
	global $wpdb;
	$productinfosql = "select * from $wpdb->posts where ID=$pid";
	$productinfo = $wpdb->get_results($productinfosql);
	if($productinfo)
	{
		foreach($productinfo[0] as $key=>$val)
		{
			$productArray[$key] = $val; 
		}
	}
	return $productArray;
}
function bdw_get_images_with_info($iPostID,$img_size='thumb') 
{
    $arrImages =& get_children('order=ASC&orderby=menu_order ID&post_type=attachment&post_mime_type=image&post_parent=' . $iPostID );
	
	$return_arr = array();
	if($arrImages) 
	{		
       foreach($arrImages as $key=>$val)
	   {
	   		$id = $val->ID;
			if($img_size == 'large')
			{
				$img_arr = wp_get_attachment_image_src($id,'full');	// THE FULL SIZE IMAGE INSTEAD
				$imgarr['id'] = $id;
				$imgarr['file'] = $img_arr[0];
				$return_arr[] = $imgarr;
			}
			elseif($img_size == 'medium')
			{
				$img_arr = wp_get_attachment_image_src($id, 'medium'); //THE medium SIZE IMAGE INSTEAD
				$imgarr['id'] = $id;
				$imgarr['file'] = $img_arr[0];
				$return_arr[] = $imgarr;
			}
			elseif($img_size == 'thumb')
			{
				$img_arr = wp_get_attachment_image_src($id, 'thumbnail'); // Get the thumbnail url for the attachment
				$imgarr['id'] = $id;
				$imgarr['file'] = $img_arr[0];
				$return_arr[] = $imgarr;
				
			}
	   }
	  return $return_arr;
	}
}
function get_property_cat_id_name($postid='')
{
	global $wpdb;
	$bedcatid = get_cat_id_from_name(get_option('ptthemes_bedroomcategory'));
	$bedcatarr = getCategoryList($bedcatid);
	if($bedcatarr)
	{
		foreach($bedcatarr as $key=>$val)
		{
			if($val['ID'])
			{
				$bed_catid_arr[] = $val['ID'];
				$bed_catname_arr[$val['ID']] = $val['name'];
			}
		}
	}	
	$typecatid = get_cat_id_from_name(get_option('ptthemes_property_typecategory'));
	$typecatarr = getCategoryList($typecatid);
	if($typecatarr)
	{
		foreach($typecatarr as $key=>$val)
		{
			if($val['ID'])
			{
				$type_catid_arr[] = $val['ID'];
				$type_catname_arr[$val['ID']] = $val['name'];
			}
		}
	}	
	$loccatid = get_cat_id_from_name(get_option('ptthemes_locationcategory'));
	$loccatarr = getCategoryList($loccatid);
	if($loccatarr)
	{
		foreach($loccatarr as $key=>$val)
		{
			if($val['ID'])
			{
				$loc_catid_arr[] = $val['ID'];
				$loc_catname_arr[$val['ID']] = $val['name'];
			}
		}
	}
	/*$pricecatid = get_cat_id_from_name(get_option('ptthemes_pricecategory'));
	$pricecatarr = getCategoryList($pricecatid);
	if($pricecatarr)
	{
		foreach($pricecatarr as $key=>$val)
		{
			if($val['ID'])
			{
				$price_catid_arr[] = $val['ID'];
				$price_catname_arr[$val['ID']] = $val['name'];
			}
		}
	}*/
	$pn_categories_obj = $wpdb->get_var("SELECT GROUP_CONCAT(distinct($wpdb->terms.term_id)) as cat_ID 
	                            FROM $wpdb->term_taxonomy,  $wpdb->terms,  $wpdb->term_relationships
                                WHERE $wpdb->term_taxonomy.term_id =  $wpdb->terms.term_id AND $wpdb->term_taxonomy.taxonomy = 'category'
								and $wpdb->term_relationships.term_taxonomy_id=$wpdb->term_taxonomy.term_taxonomy_id and $wpdb->term_relationships.object_id=\"$postid\"");
								
	$post_cats_arr = explode(',',$pn_categories_obj);
	if($post_cats_arr)
	{
		for($i=0;$i<count($post_cats_arr);$i++)
		{
			if($bed_catid_arr && in_array($post_cats_arr[$i],$bed_catid_arr))
			{
				$post_cat_info['bed'] = array('id'=>$post_cats_arr[$i],'name'=>$bed_catname_arr[$post_cats_arr[$i]]);
			}
			if($loc_catid_arr && in_array($post_cats_arr[$i],$loc_catid_arr))
			{
				$post_cat_info['location'] = array('id'=>$post_cats_arr[$i],'name'=>$loc_catname_arr[$post_cats_arr[$i]]);
			}
			/*if($price_catid_arr && in_array($post_cats_arr[$i],$price_catid_arr))
			{
				$post_cat_info['price'] = array('id'=>$post_cats_arr[$i],'name'=>$price_catname_arr[$post_cats_arr[$i]]);
			}*/	
		}
	}
	return $post_cat_info;
}
function get_cat_id_from_name($catname)
{
	global $wpdb;
	if($catname)
	{
	return $pn_categories_obj = $wpdb->get_var("SELECT $wpdb->terms.term_id as cat_ID 
	                            FROM $wpdb->term_taxonomy,  $wpdb->terms
                                WHERE $wpdb->term_taxonomy.term_id =  $wpdb->terms.term_id AND $wpdb->terms.name like \"$catname\"
                                AND $wpdb->term_taxonomy.taxonomy = 'category'");
	}
}
function getCategoryList( $parent = 0, $level = 0, $categories = 0, $page = 1, $per_page = 1000 ) 
{
	$count = 0;
	if ( empty($categories) ) 
	{
		$args = array('hide_empty' => 0,'orderby'=>'id');
			
		$categories = get_categories( $args );
		if ( empty($categories) )
			return false;
	}		
	$children = _get_term_hierarchy('category');
	return _cat_rows1( $parent, $level, $categories, $children, $page, $per_page, $count );
}
function _cat_rows1( $parent = 0, $level = 0, $categories, &$children, $page = 1, $per_page = 20, &$count )
{
	//global $category_array;
	$start = ($page - 1) * $per_page;
	$end = $start + $per_page;
	ob_start();

	foreach ( $categories as $key => $category ) 
	{
		if ( $count >= $end )
			break;

		$_GET['s']='';
		if ( $category->parent != $parent && empty($_GET['s']) )
			continue;

		// If the page starts in a subtree, print the parents.
		if ( $count == $start && $category->parent > 0 ) {
			$my_parents = array();
			$p = $category->parent;
			while ( $p ) {
				$my_parent = get_category( $p );
				$my_parents[] = $my_parent;
				if ( $my_parent->parent == 0 )
					break;
				$p = $my_parent->parent;
			}

			$num_parents = count($my_parents);
			while( $my_parent = array_pop($my_parents) ) {
				$category_array[] = _cat_rows1( $my_parent, $level - $num_parents );
				$num_parents--;
			}
		}

		if ($count >= $start)
		{
			$categoryinfo = array();
			$category = get_category( $category, '', '' );
			$default_cat_id = (int) get_option( 'default_category' );
			$pad = str_repeat( '&#8212; ', max(0, $level) );
			$name = ( $name_override ? $name_override : $pad . ' ' . $category->name );
			$categoryinfo['ID'] = $category->term_id;
			$categoryinfo['name'] = $name;
			$category_array[] = $categoryinfo;
		}

		unset( $categories[ $key ] );
		$count++;
		if ( isset($children[$category->term_id]) )
			_cat_rows1( $category->term_id, $level + 1, $categories, $children, $page, $per_page, $count );
	}
	$output = ob_get_contents();
	ob_end_clean();
	return $category_array;
}

function get_blog_sub_cats_str($type='array')
{
	$catid_arr = get_option('ptthemes_blogcategory');
	$blogcatids = '';
	$subcatids_arr = array();
	for($i=0;$i<count($catid_arr);$i++)
	{
		if($catid_arr[$i])
		{
			$subcatids_arr = array_merge($subcatids_arr,array($catid_arr[$i]),get_term_children( $catid_arr[$i],'category'));
		}
	}
	if($subcatids_arr && $type=='string')
	{
		$blogcatids = implode(',',$subcatids_arr);
		return $blogcatids;	
	}else
	{
		return $subcatids_arr;
	}			
}

if (function_exists('add_theme_support')) {
	add_theme_support('post-thumbnails');
	set_post_thumbnail_size(588, 250, true); // Normal post thumbnails
	add_image_size('loopThumb', 588, 125, true);
}
function get_price_info_select()
{
	global $price_db_table_name,$wpdb;
	$pricesql = "select * from $price_db_table_name";
	$priceinfo = $wpdb->get_results($pricesql);
return $priceinfo;
}
// Start app price info
function get_app_price_info($title='',$package_pid, $uri,$post_type='listing')
{
	global $price_db_table_name,$wpdb;
	add_column_if_not_exist($price_db_table_name, 'sort_order');
	$pricesql = "select * from $price_db_table_name where status=1 and post_type='$post_type' ORDER BY sort_order,pid";
	$priceinfo = $wpdb->get_results($pricesql);
	if($title==''){$title=$package_pid;}
	if($priceinfo)
	{
		$counter=1;
     echo '<div class="box-white">';
		foreach($priceinfo as $priceinfoObj)
		{
$alive = '';
if($priceinfoObj->days==0){ $alive = ' - '.__('Unlimited Days');}
if($priceinfoObj->days > 0){ $alive = ' - '.$priceinfoObj->days.' '.__('Days');}
if($priceinfoObj->sub_active){ 
	$sub_units_var = $priceinfoObj->sub_units;
	$sub_units_num_var = $priceinfoObj->sub_units_num;
	if($sub_units_var=='D'){$alive_days = $sub_units_num_var; }
	if($sub_units_var=='W'){$alive_days = $sub_units_num_var * 7; }
	if($sub_units_var=='M'){$alive_days = $sub_units_num_var * 30; }
	if($sub_units_var=='Y'){$alive_days = $sub_units_num_var * 365; }
	$alive = ' - '.$alive_days.' '.__('Days').' '.__('(Subscription)');
}
			?>
            
            <p><input type="radio" value="<?php echo $priceinfoObj->pid;?>" <?php if($title==$priceinfoObj->pid ){ echo 'checked="checked"';}?> name="price_select" id="price_select<?php echo $counter ?>"  onclick="window.location.href='<?php echo home_url();?>/?<?php echo $uri; ?>&amp;pkg=<?php echo $priceinfoObj->pid;?>'+user_val" />
            <?php echo stripslashes($priceinfoObj->title).' - '.get_option('currencysym').$priceinfoObj->amount.$alive;?>
			<span class="arrow-left <?php if($title==$priceinfoObj->pid ){ echo 'arrow-down';}?>" id="dd<?php echo $priceinfoObj->pid;?>"></span></p>
			<p class="ddown dd<?php echo $priceinfoObj->pid;?>" <?php if($title==$priceinfoObj->pid ){ echo 'style="display:block;"';}?>><?php echo stripslashes($priceinfoObj->title_desc);?></p>

        
        <?php $counter++;
		}
		
		echo '</div>';
	}
}
// End app function
function get_price_info($title='',$package_pid, $uri)
{
	global $price_db_table_name,$wpdb;
	add_column_if_not_exist($price_db_table_name, 'sort_order');
	$pricesql = "select * from $price_db_table_name where status=1 and post_type='listing' ORDER BY sort_order,pid";
	$priceinfo = $wpdb->get_results($pricesql);
	if($title==''){$title=$package_pid;}
	if($priceinfo)
	{
		$counter=1;
		foreach($priceinfo as $priceinfoObj)
		{
			if(stripslashes($priceinfoObj->title_desc))
			{
			?>
            <div class="package"><input type="radio" value="<?php echo $priceinfoObj->pid;?>" <?php if($title==$priceinfoObj->pid ){ echo 'checked="checked"';}?> name="price_select" id="price_select<?php echo $counter ?>"  onclick="window.location.href='<?php echo home_url();?>/?<?php echo $uri; ?>&amp;pkg=<?php echo $priceinfoObj->pid;?>'+user_val" />&nbsp;<?php echo stripslashes($priceinfoObj->title_desc);?></div>
        <?php
			}else
			{
		?>
         <div class="package"><input type="radio" value="<?php echo $priceinfoObj->pid;?>" <?php if($title==$priceinfoObj->pid ){ echo 'checked="checked"';}?> name="price_select" id="price_select<?php echo $counter ?>" onclick="window.location.href='<?php echo home_url();?>/?<?php echo $uri; ?>&amp;pkg=<?php echo $priceinfoObj->pid;?>'+user_val" />&nbsp;<?php printf(__(PUBLISH_DAYS_TEXT),$priceinfoObj->title,$priceinfoObj->days,str_replace(' ','_',$priceinfoObj->title),$priceinfoObj->amount,get_currency_type());?></div>
        <?php		
			}
		?>
        <?php $counter++;
		}
	}
}
function get_price_info_event($title='',$package_pid, $uri)
{
	global $price_db_table_name,$wpdb;
	$pricesql = "select * from $price_db_table_name where status=1 and post_type='event' ORDER BY sort_order,pid";
	$priceinfo = $wpdb->get_results($pricesql);
	if($title==''){$title=$package_pid;}
	if($priceinfo)
	{
		$counter=1;
		foreach($priceinfo as $priceinfoObj)
		{
			if(stripslashes($priceinfoObj->title_desc))
			{
			?>
            <div class="package"><input type="radio" value="<?php echo $priceinfoObj->pid;?>" <?php if($title==$priceinfoObj->pid ){ echo 'checked="checked"';}?> name="price_select" id="price_select<?php echo $counter ?>"  onclick="window.location.href='<?php echo home_url();?>/?<?php echo $uri; ?>&amp;pkg=<?php echo $priceinfoObj->pid;?>'+user_val" />&nbsp;<?php echo stripslashes($priceinfoObj->title_desc);?></div>
        <?php
			}else
			{
		?>
         <div class="package"><input type="radio" value="<?php echo $priceinfoObj->pid;?>" <?php if($title==$priceinfoObj->pid ){ echo 'checked="checked"';}?> name="price_select" id="price_select<?php echo $counter ?>" onclick="window.location.href='<?php echo home_url();?>/?<?php echo $uri; ?>&amp;pkg=<?php echo $priceinfoObj->pid;?>'+user_val" />&nbsp;<?php printf(__(PUBLISH_DAYS_TEXT),$priceinfoObj->title,$priceinfoObj->days,str_replace(' ','_',$priceinfoObj->title),$priceinfoObj->amount,get_currency_type());?></div>
        <?php		
			}
		?>
        <?php $counter++;
		}
	}
}
function get_payable_amount_with_coupon($total_amt,$coupon_code)
{
	$discount_amt = get_discount_amount($coupon_code,$total_amt);
	if($discount_amt>0)
	{
		return round($total_amt-$discount_amt, 2);
	}else
	{
		return round($total_amt, 2);
	}
}
function is_valid_coupon($coupon)
{
	global $wpdb;
	$couponsql = "select option_value from $wpdb->options where option_name='discount_coupons'";
	$couponinfo = $wpdb->get_results($couponsql);
	if($couponinfo)
	{
		foreach($couponinfo as $couponinfoObj)
		{
			$option_value = unserialize($couponinfoObj->option_value);
			foreach($option_value as $key=>$value)
			{
				if($value['couponcode'] == $coupon)
				{
					return true;
				}
			}
		}
	}
	return false;
}
function get_discount_amount($coupon,$amount)
{
	global $wpdb;
	if($coupon!='' && $amount>0)
	{
		$couponsql = "select option_value from $wpdb->options where option_name='discount_coupons'";
		$couponinfo = $wpdb->get_results($couponsql);
		if($couponinfo)
		{
			foreach($couponinfo as $couponinfoObj)
			{
				$option_value = unserialize($couponinfoObj->option_value);
				foreach($option_value as $key=>$value)
				{
					if($value['couponcode'] == $coupon)
					{
						if($value['dis_per']=='per')
						{
							$discount_amt = ($amount*$value['dis_amt'])/100;
						}else
						if($value['dis_per']=='amt')
						{
							$discount_amt = $value['dis_amt'];
						}
					}
				}
			}
			return $discount_amt;
		}
	}
	return '0';			
}

function get_time_difference( $start, $pid )
{
	$alive_days = get_post_meta($pid,'alive_days',true);
	$uts['start']      =    strtotime( $start );
	$uts['end']        =    mktime(0,0,0,date('m',strtotime($start)),date('d',strtotime($start))+$alive_days,date('Y',strtotime($start)));

	$post_days = gregoriantojd(date('m'), date('d'), date('Y')) - gregoriantojd(date('m',strtotime($start)), date('d',strtotime($start)), date('Y',strtotime($start)));
	$days = $alive_days-$post_days;

	if($days>0)
	{
		return $days;	
	}
    return( false );
}

function get_image_cutting_edge($args=array())
{
global $thumb_url;
	if(isset($args['image_cut']))
	{
		$cut_post =$args['image_cut'];
	}else
	{
		$cut_post = get_option('ptthemes_image_x_cut');
	}
	if($cut_post)
	{		
		if($cut_post=='top')
		{
			$thumb_url .= "&amp;a=t";	
		}elseif($cut_post=='bottom')
		{
			$thumb_url .= "&amp;a=b";	
		}elseif($cut_post=='left')
		{
			$thumb_url .= "&amp;a=l";
		}elseif($cut_post=='right')
		{
			$thumb_url .= "&amp;a=r";
		}elseif($cut_post=='top right')
		{
			$thumb_url .= "&amp;a=tr";
		}elseif($cut_post=='top left')
		{
			$thumb_url .= "&amp;a=tl";
		}elseif($cut_post=='bottom right')
		{
			$thumb_url .= "&amp;a=br";
		}elseif($cut_post=='bottom left')
		{
			$thumb_url .= "&amp;a=bl";
		}
	}
	return $thumb_url;
}


//This function would add propery to favorite listing and store the value in wp_usermeta table user_favorite field
function add_to_favorite($post_id)
{
	global $current_user;
	$user_meta_data = array();
	$user_meta_data = get_usermeta($current_user->data->ID,'user_favourite_post');
	$user_meta_data[]=$post_id;
	update_usermeta($current_user->data->ID, 'user_favourite_post', $user_meta_data);
	echo '<a href="javascript:void(0);" class="addtofav" onclick="javascript:addToFavourite(\''.$post_id.'\',\'remove\');">'.__('Remove from Favorites').'</a>';
	
}
//This function would remove the favorited property earlier
function remove_from_favorite($post_id)
{
	global $current_user;
	$user_meta_data = array();
	$user_meta_data = get_usermeta($current_user->data->ID,'user_favourite_post');
	if(in_array($post_id,$user_meta_data))
	{
		$user_new_data = array();
		foreach($user_meta_data as $key => $value)
		{
			if($post_id == $value)
			{
				$value= '';
			}else{
				$user_new_data[] = $value;
			}
		}	
		$user_meta_data	= $user_new_data;
	}
	update_usermeta($current_user->data->ID, 'user_favourite_post', $user_meta_data); 	
	echo '<a href="javascript:void(0);"  class="addtofav" onclick="javascript:addToFavourite(\''.$post_id.'\',\'add\');">'.ADD_FAVOURITE_TEXT.'</a>';
}

//This function would disply the html content for add to favorite or remove from favorite 
function favourite_html($user_id,$post_id)
{
	global $current_user;
	$user_meta_data = get_usermeta($current_user->data->ID,'user_favourite_post');
	if($user_meta_data && in_array($post_id,$user_meta_data))
	{

		?>
	<span id="favorite_property_<?php echo $post_id;?>" class="fav"  > <a href="javascript:void(0);" class="addtofav" onclick="javascript:addToFavourite(<?php echo $post_id;?>,'remove');"><?php echo REMOVE_FAVOURITE_TEXT;?></a>   </span>    
		<?php
	}else{
	?>
	<span id="favorite_property_<?php echo $post_id;?>" class="fav"><a href="javascript:void(0);" class="addtofav"  onclick="javascript:addToFavourite(<?php echo $post_id;?>,'add');"><?php echo ADD_FAVOURITE_TEXT;?></a></span>
	<?php } 
}

function get_formated_date($date)
{
	return mysql2date(get_option('date_format'), $date);
}
function get_formated_time($time)
{
	return mysql2date(get_option('time_format'), $time, $translate=true);
}
#########################Functions below added by stiofan #####################
function get_img_p($img)
{
	if($img=='center')$img_p = 'c';
elseif($img=='top')$img_p = 't';
elseif($img=='bottom')$img_p = 'b';
elseif($img=='left')$img_p = 'l';
elseif($img=='right')$img_p = 'r';
elseif($img=='top right')$img_p = 'tr';
elseif($img=='top left')$img_p = 'tl';
elseif($img=='bottom right')$img_p = 'br';
elseif($img=='bottom left')$img_p = 'bl';
	return '&amp;a='.$img_p;
}
###############################
function get_img_zc($img)
{ $img_zc = '0';
	if($img=='zoom')$img_zc = '1';
elseif($img=='crop')$img_zc = '0';
elseif($img=='resize')$img_zc = '2';
elseif($img=='resize-no-border')$img_zc = '3';

	return '&amp;zc='.$img_zc;
}
function my_search_form( $form ) {
	$form = '<form method="get" id="searchform" action="' . home_url( '/' ) . '" >
	<div><label class="screen-reader-text" for="s">' . __('Search for:') . '</label>
	<input type="text" value="' . get_search_query() . '" name="s" id="s" />
	<input type="submit" id="searchsubmit" value="'. esc_attr__('Search') .'" />
	</div>
	</form>';
	
    return $form;
}
add_filter( 'get_search_form', 'my_search_form' );
################################################
###### PREV /  NEXT LINKS ON DETAILS PAGE ######
################################################
function GT_get_adjacent_post($in_same_cat = false, $excluded_categories = '', $previous = true) {
	global $post, $wpdb;
	if ( empty( $post ) )
		return null;
	$current_post_date = $post->post_date;
	$tax = $post->post_type;
	$post_city_id = get_post_meta($post->ID, 'post_city_id', true);
	if($tax=='post' || $tax=='page'){$post_tax='';}else{$post_tax=$tax;}
	$join = '';
	$posts_in_ex_cats_sql = '';
	if ( $in_same_cat || !empty($excluded_categories) ) {
		
		$city_id = $_SESSION['multi_city'];
		if($city_id){
		$join = " join $wpdb->postmeta pm on pm.post_id=p.ID INNER JOIN $wpdb->term_relationships AS tr ON p.ID = tr.object_id INNER JOIN $wpdb->term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id";
		}else{
		$join = " INNER JOIN $wpdb->term_relationships AS tr ON p.ID = tr.object_id INNER JOIN $wpdb->term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id";
		}
		if ( $in_same_cat ) {
			$cat_array = wp_get_object_terms($post->ID, $post_tax.'category', array('fields' => 'ids'));
			if($city_id){
			$join .= " AND pm.meta_key='post_city_id' and pm.meta_value=\"$post_city_id\" AND tt.taxonomy = '".$post_tax."category' AND tt.term_id IN (" . implode(',', $cat_array) . ")";
			}else{
			$join .= " AND tt.taxonomy = '".$post_tax."category' AND tt.term_id IN (" . implode(',', $cat_array) . ")";				
			}
		}
		$posts_in_ex_cats_sql = "AND tt.taxonomy = '".$post_tax."category'";
		if ( !empty($excluded_categories) ) {
			$excluded_categories = array_map('intval', explode(' and ', $excluded_categories));
			if ( !empty($cat_array) ) {
				$excluded_categories = array_diff($excluded_categories, $cat_array);
				$posts_in_ex_cats_sql = '';
			}
			if ( !empty($excluded_categories) ) {
				$posts_in_ex_cats_sql = " AND tt.taxonomy = '".$post_tax."category' AND tt.term_id NOT IN (" . implode($excluded_categories, ',') . ')';
			}
		}
	}
	$adjacent = $previous ? 'previous' : 'next';
	$op = $previous ? '<' : '>';
	$order = $previous ? 'DESC' : 'ASC';
	$join  = apply_filters( "get_{$adjacent}_post_join", $join, $in_same_cat, $excluded_categories );
	$where = apply_filters( "get_{$adjacent}_post_where", $wpdb->prepare("WHERE p.post_date $op %s AND p.post_type = %s AND p.post_status = 'publish' $posts_in_ex_cats_sql", $current_post_date, $post->post_type), $in_same_cat, $excluded_categories );
	$sort  = apply_filters( "get_{$adjacent}_post_sort", "ORDER BY p.post_date $order LIMIT 1" );
	$query = "SELECT p.* FROM $wpdb->posts AS p $join $where $sort";
	$query_key = 'adjacent_post_' . md5($query);
	$result = wp_cache_get($query_key, 'counts');
	if ( false !== $result )
		return $result;
	$result = $wpdb->get_row("SELECT p.* FROM $wpdb->posts AS p $join $where $sort");
	if ( null === $result )
		$result = '';
	wp_cache_set($query_key, $result, 'counts');
	return $result;
}
function GT_adjacent_post_link($format, $link, $in_same_cat = false, $excluded_categories = '', $previous = true) {
	if ( $previous && is_attachment() )
		$post = & get_post($GLOBALS['post']->post_parent);
	else
		$post = GT_get_adjacent_post($in_same_cat, $excluded_categories, $previous);
	if ( !$post )
		return;
	$title = $post->post_title;
	if ( empty($post->post_title) )
		$title = $previous ? __('Previous Post') : __('Next Post');
	$title = apply_filters('the_title', $title, $post->ID);
	$date = mysql2date(get_option('date_format'), $post->post_date);
	$rel = $previous ? 'prev' : 'next';
	$string = '<a href="'.get_permalink($post).'" rel="'.$rel.'">';
	$link = str_replace('%title', $title, $link);
	$link = str_replace('%date', $date, $link);
	$link = $string . $link . '</a>';
	$format = str_replace('%link', $link, $format);
	$adjacent = $previous ? 'previous' : 'next';
	echo apply_filters( "{$adjacent}_post_link", $format, $link );
}
function GT_previous_post_link($format='&laquo; %link', $link='%title', $in_same_cat = false, $excluded_categories = '') {
	GT_adjacent_post_link($format, $link, $in_same_cat, $excluded_categories, true);
}
function GT_next_post_link($format='%link &raquo;', $link='%title', $in_same_cat = false, $excluded_categories = '') {
	GT_adjacent_post_link($format, $link, $in_same_cat, $excluded_categories, false);
}
################################################
###### END PREV /  NEXT LINKS ON DETAILS PAGE ##
################################################
################################################
##### START ADVANCED SORT/FILTER LISTING PAGE ##
################################################
function get_category_sort_terms_dd($cat_id,$category_link){
	global $wpdb,$custom_post_meta_db_table_name;
	if($cat_id){
	$post_meta_info = $wpdb->get_results("select * from $custom_post_meta_db_table_name where cat_sort REGEXP '(^|,)$cat_id(,|$)'");
	//print_r($post_meta_info);
	foreach($post_meta_info as $sort_term){
		?>
<option value="<?php if(strstr($category_link,'?')){ echo $cat_url = $category_link."&amp;sort=term&amp;term=".$sort_term->htmlvar_name;}else{ echo $cat_url = $category_link."?sort=term&amp;term=".$sort_term->htmlvar_name;}?>" <?php if($_REQUEST['term']==$sort_term->htmlvar_name){ echo 'selected="selected"';}?>><?php echo $sort_term->site_title;?></option>         		
	<?php }
	}}
function get_category_sort_terms($cat_id,$category_link){
	global $wpdb,$custom_post_meta_db_table_name;
	if($cat_id){
	$post_meta_info = $wpdb->get_results("select * from $custom_post_meta_db_table_name where cat_sort REGEXP '(^|,)$cat_id(,|$)'");
	//print_r($post_meta_info);
	foreach($post_meta_info as $sort_term){
		?>
    
		<li class="<?php if($_REQUEST['term']==$sort_term->htmlvar_name){ echo 'current';}?> rating"> <a href="<?php if(strstr($category_link,'?')){ echo $cat_url = $category_link."&amp;sort=term&amp;term=".$sort_term->htmlvar_name;}else{ echo $cat_url = $category_link."?sort=term&amp;term=".$sort_term->htmlvar_name;}?>">  <?php echo $sort_term->site_title;?> </a></li>
		
	<?php }
	}}
	
function get_category_filter_terms($cat_id,$category_link){
	global $wpdb,$custom_post_meta_db_table_name;
	if($cat_id){		
		$cur_URL =  'http://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		if(strstr($cur_URL,'?')){$category_link =$cur_URL; }
	$post_meta_info = $wpdb->get_results("select * from $custom_post_meta_db_table_name where cat_filter REGEXP '(^|,)$cat_id(,|$)' order by sort_order asc,admin_title asc");
	//print_r($post_meta_info);
	//print_r($_POST);
	
	if($post_meta_info){ ?><form id="filter_boxes" action="<?php echo $category_link; ?>" method="post"><?php
	foreach($post_meta_info as $sort_term){
		?>
        <input name="filters[]"  type="checkbox" <?php if(in_array($sort_term->htmlvar_name, $_POST['filters'])) {echo 'checked="checked"';}?> value="<?php echo $sort_term->htmlvar_name;?>"><?php echo $sort_term->site_title;?>
 
	<?php }?>
	<input name="submit" type="submit" id="adv_filter" value="<?php _e('filter');?>" />
        </form><?php
	
	}}}
	
################################################
####### END ADVANCED SORT/FILTER LISTING PAGE ##
################################################

?>