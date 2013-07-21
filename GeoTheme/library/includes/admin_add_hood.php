<?php
global $wpdb,$multiregion_db_table_name,$multicity_db_table_name,$multihood_db_table_name;
add_column_if_not_exist($multihood_db_table_name, 'cat_ex');
add_column_if_not_exist($multihood_db_table_name, 'home_desc', 'TEXT NOT NULL');
add_column_if_not_exist($multihood_db_table_name, 'meta_desc', 'TEXT NOT NULL');



if($_POST['cityact'] == 'addhood')
{
	$id  = $_POST['id'];
	$hoodname = $_POST['hoodname'];
	$hood_slug = $_POST['hood_slug'];
	$lat = $_POST['lat'];
	$lng = $_POST['lng'];
	$scall_factor = $_POST['scall_factor'];
	$cat  = $_POST['cat'];
	$cat_ex  = $_POST['cat_ex'];
	$cities  = $_POST['cities'];
	$default  = $_POST['default'];
	$sortorder = $_POST['sortorder'];
	$home_desc = $_POST['home_desc'];
	$meta_desc = $_POST['meta_desc'];
	if($cat)
	{
		$categories = implode(',',$cat);
	}
	if($cat_ex)
	{
		$cat_ex = implode(',',$cat_ex);
	}
	if($cities)
	{
		$cities = implode(',',$cities);
	}
	$is_zoom_home = $_POST['is_zoom_home'];
	
	if($default)
	{
		$wpdb->query("update $multiregion_db_table_name set is_default='0'");
	}
	if($id!='')
	{
		$wpdb->query("update $multihood_db_table_name set hoodname=\"$hoodname\",hood_slug=\"$hood_slug\", lat=\"$lat\", lng=\"$lng\", scall_factor=\"$scall_factor\",categories=\"$categories\",cat_ex=\"$cat_ex\",is_zoom_home=\"$is_zoom_home\",is_default=\"$default\",sortorder=\"$sortorder\",cities=\"$cities\",home_desc=\"$home_desc\",meta_desc=\"$meta_desc\" where hood_id=\"$id\"");
	}else
	{
		$wpdb->query("insert into $multihood_db_table_name (hoodname,hood_slug,lat,lng,scall_factor,categories,cat_ex,is_zoom_home,is_default,sortorder,cities,home_desc,meta_desc) values (\"$hoodname\",\"$hood_slug\",\"$lat\",\"$lng\",\"$scall_factor\",\"$categories\",\"$cat_ex\",\"$is_zoom_home\",\"$default\",\"$sortorder\",\"$cities\",\"$home_desc\",\"$meta_desc\")");
	}
	$location = site_url()."/wp-admin/admin.php";
	echo '<form action="'.$location.'" method=get name="city_success">
	<input type=hidden name="page" value="hood"><input type=hidden name="msg" value="success"></form>';
	echo '<script>document.city_success.submit();</script>';
	exit;
}
if($_REQUEST['id']!='')
{
	$pid = $_REQUEST['id'];
	$citysql = "select * from $multihood_db_table_name where hood_id=\"$pid\"";
	$cityinfo = $wpdb->get_results($citysql);
}
?>

<form action="<?php echo site_url()?>/wp-admin/admin.php?page=hood&pagetype=addedit&pid=<?php echo $_REQUEST['id'];?>" method="post" name="price_frm">
  <input type="hidden" name="cityact" value="addhood">
  <input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>">
  <style>
h2 { color:#464646;font-family:Georgia,"Times New Roman","Bitstream Charter",Times,serif;
font-size:24px;
font-size-adjust:none;
font-stretch:normal;
font-style:italic;
font-variant:normal;
font-weight:normal;
line-height:35px;
margin:0;
padding:14px 15px 3px 0;
text-shadow:0 1px 0 #FFFFFF;  }
</style>
  <h2>
    <?php
if($_REQUEST['id']!='')
{
	_e('Edit Neighbourhood');
}else
{
	_e('Add Neighbourhood');
}
?>
  </h2>
  <table width="75%" cellpadding="3" cellspacing="3" class="widefat post fixed" >
    <tr>
      <td width="14%"><?php _e('Neighbourhood Name');?></td>
      <td width="86%">:
        <input type="text" name="hoodname" id="hoodname" value="<?php echo $cityinfo[0]->hoodname;?>"><input type="button" class="b_submit" value="Set Address on Map" onclick="codeAddress()" style="float:none;"/></td>
    </tr>
     <tr>
      <td width="14%"><?php _e('Neighbourhood Slug');?></td>
      <td width="86%">:
        <input type="text" name="hood_slug" id="hood_slug" value="<?php echo $cityinfo[0]->hood_slug;?>"></td>
    </tr>
     <tr>
      <td><?php _e('Map');?></td>
      <td><script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script> 

<script type="text/javascript">
/* <![CDATA[ */
var map;
var marker;
var latlng;
var geocoder;
var address;
var CITY_MAP_CENTER_LAT ='<?php if($cityinfo[0]->lat) {echo $cityinfo[0]->lat;}else {echo '0.0';}?>';
var CITY_MAP_CENTER_LNG = '<?php if($cityinfo[0]->lng) {echo $cityinfo[0]->lng;}else {echo '0.0';}?>';
var CITY_MAP_ZOOMING_FACT=<?php if($cityinfo[0]->scall_factor) {echo $cityinfo[0]->scall_factor;}else {echo '2';}?>;
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
//var CITY_MAP_ZOOMING_FACT = 1;
}else if(CITY_MAP_ZOOMING_FACT!='')
{
//var CITY_MAP_ZOOMING_FACT = 3;	
}
var geocoder = new google.maps.Geocoder();
function updateMarkerStatus(str) {
document.getElementById('markerStatus').innerHTML = str;
}
function updateMarkerPosition(latLng) {
document.getElementById('lat').value=latLng.lat();
document.getElementById('lng').value=latLng.lng();
}
function updateMapZoom(zoom) {
	//alert(zoom);
document.getElementById('scall_factor').value=zoom;
}
function initialize() {
geocoder = new google.maps.Geocoder();
var latLng = new google.maps.LatLng(CITY_MAP_CENTER_LAT,CITY_MAP_CENTER_LNG);
var myOptions = {
zoom: CITY_MAP_ZOOMING_FACT,
center: latLng,
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
	
    var address = document.getElementById("hoodname").value;
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


<div id="map_canvas" style=" height:300px; width:435px;"  class="form_row clearfix"></div>

      </td>
    </tr>
    <tr>
      <td><?php _e('Map Central latitute');?></td>
      <td>: 
        <input type="text" name="lat" id="lat" value="<?php echo $cityinfo[0]->lat;?>">
       </td>
    </tr>
    <tr>
      <td><?php _e('Map Central longitude');?></td>
      <td>:
         <input type="text" name="lng" id="lng" value="<?php echo $cityinfo[0]->lng;?>">
      </td>
    </tr>
     <tr>
      <td><?php _e('Map Scaling Factor');?></td>
      <td>:
      <select name="scall_factor" id="scall_factor">
      <?php for($i=1;$i<20;$i++){?>
      <option value="<?php echo $i;?>" <?php if($i==$cityinfo[0]->scall_factor){ echo 'selected="selected"';}?>><?php echo $i;?></option>
	  <?php }?>
      </select>
      </td>
    </tr>
     <tr>
      <td><?php _e('Map Auto Zooming?');?></td>
      <td>:
      <select name="is_zoom_home">
      <option value="Yes" <?php if($cityinfo[0]->is_zoom_home=='Yes'){ echo 'selected="selected"';}?>><?php _e('Yes');?></option>
      <option value="No" <?php if($cityinfo[0]->is_zoom_home=='No'){ echo 'selected="selected"';}?>><?php _e('No');?></option>
      </select>
      </td>
    </tr>
    <tr>
      <td><?php _e('Sort Order');?></td>
      <td>:
      <?php
      $sortorder = $cityinfo[0]->sortorder;
	  if(!$sortorder)
	  {
		  $sortorder = $wpdb->get_var("select max(sortorder)+1 from $multiregion_db_table_name"); 
	  }
	  ?>
      <input type="text" name="sortorder" value="<?php echo $sortorder;?>"  />
      </td>
    </tr>
     <tr>
      <td><?php _e('Set as default Neighbourhood');?></td>
      <td>:
      <input type="checkbox" name="default" value="1" <?php if($cityinfo[0]->is_default){echo 'checked="checked"';}?>  />
      </td>
    </tr>
    <?php if(!get_option('ptthemes_map_set_default')){?>
         <script type="text/javascript">  
  jQuery().ready(function() {  
   jQuery('#select1').click(function() { 
								var myHtml ='';
								jQuery('#select2').html(myHtml);
    return !jQuery('#select1 option:selected').clone().appendTo('#select2');  
   });  
     
  });  
 </script>
     <tr>
      <td><?php _e('Select Category');?></td>
      <td>:
      <?php
	   if($cityinfo[0]->categories)
	   {
			$catarr = explode(',',$cityinfo[0]->categories);   
	   }
	  ?>
      <select name="cat[]" multiple="multiple" id="select1" style="height: 100px;" >
      <option value=""><?php _e('Select Category');?></option>
       <?php $cat_info = get_category_array();
	   if($cityinfo[0]->cat)
	   {
			$catarr = explode(',',$cityinfo[0]->categories);   
	   }
	  for($i=0;$i<count($cat_info);$i++){?>
      <option value="<?php echo $cat_info[$i]['id'];?>" <?php if($catarr && in_array($cat_info[$i]['id'],$catarr)){ echo 'selected="selected"';}?> ><?php echo $cat_info[$i]['title'];?>
      <?php }?>
      </option>
      </select>
      
      <?php _e('Select Ticked Categories ->');?>
      <select name="cat_ex[]" multiple="multiple" id="select2" style="height: 100px;" >
       <?php $cat_info = get_category_array();
	   
	   if($cityinfo[0]->cat_ex)
	   {
			$cat_exarr = explode(',',$cityinfo[0]->cat_ex);   
	   }
	  for($i=0;$i<count($cat_info);$i++){
		  if(in_array($cat_info[$i]['id'],$catarr)){   ?>
      <option value="<?php echo $cat_info[$i]['id'];?>" <?php if($cat_exarr && in_array($cat_info[$i]['id'],$cat_exarr)){ echo 'selected="selected"';}?> ><?php echo $cat_info[$i]['title'];?>
      <?php }}?>
      </option>
      </select>
      </td>
    </tr>
    <?php }?>
     <tr>
      <td><?php _e('Select Cities');?></td>
      <td>:
      <?php
	   if($cityinfo[0]->cities)
	   {
			$catarr = explode(',',$cityinfo[0]->cities);   
	   }
	  ?>
      <select name="cities[]" multiple="multiple" style="height: 100px;" >
       <?php $city_info = $wpdb->get_results("select * from $multicity_db_table_name where city_id!=0 order by sortorder asc", ARRAY_A);
	   //print_r($city_info);
	   if($cityinfo[0]->cities)
	   {
			$cityarr = explode(',',$cityinfo[0]->cities);   
	   }
	  for($i=0;$i<count($city_info);$i++){?>
      <option value="<?php echo $city_info[$i]['city_id'];?>" <?php if($cityarr && in_array($city_info[$i]['city_id'],$cityarr)){ echo 'selected="selected"';}?> ><?php echo $city_info[$i]['cityname'];?>
      <?php }?>
      </option>
      </select>
      </td>
    </tr>
    
    <tr>
      <td><?php _e('Home Description');?></td>
      <td>:
      <div style='width:620px'>
      <?php 
			global $wp_version;
			$meta = stripslashes($cityinfo[0]->home_desc);

		if ( version_compare( $wp_version, '3.2.1' ) < 1 ) {
			echo "<textarea class='at-wysiwyg theEditor medium-text' name='home_desc' id='home_desc' cols='60' rows='5' >$meta</textarea>";
		}else{
			// Use new wp_editor() since WP 3.3
			wp_editor( stripslashes(html_entity_decode($meta)), 'home_desc', array( 'editor_class' => 'at-wysiwyg' ) );
		}?>
        </div>
      </td>
    </tr>
    
    
     <tr>
      <td><?php _e('Meta Description');?></td>
      <td>:
<textarea  name='meta_desc' id='meta_desc' cols='60' rows='5'  style='width:620px'><?php echo $cityinfo[0]->meta_desc;?></textarea>
      </td>
    </tr>
    
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="submit" value="<?php _e('Submit');?>" onclick="return check_frm();" class="button-secondary action" >
        &nbsp;
        <input type="button" name="cancel" value="<?php _e('Cancel');?>" onClick="window.location.href='<?php echo site_url()?>/wp-admin/admin.php?page=hood'" class="button-secondary action" ></td>
    </tr>
  </table>
</form>
<script>
function check_frm()
{
	if(document.getElementById('hoodname').value=='')
	{
		alert("<?php _e('Please enter Neighbourhood Name');?>");
		return false;
	}
	if(document.getElementById('hood_slug').value=='')
	{
		alert("<?php _e('Please enter Neighbourhood Slug');?>");
		return false;
	}
	return true;
}
</script>