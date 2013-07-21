<?php
if(!function_exists('get_location_map_app_javascripts'))
{
	function get_location_map_app_javascripts()
	{
	?>
<script type="text/javascript">
/* <![CDATA[ */
var map;
var marker;
var latlng;
var geocoder;
var address;
<?php
if($_SESSION['multi_city'])
{
?>
var CITY_MAP_CENTER_LAT = '<?php echo get_current_city_lat();?>';
var CITY_MAP_CENTER_LNG = '<?php echo get_current_city_lng();?>';
var CITY_MAP_ZOOMING_FACT=<?php echo get_current_city_scale_factor();?>;
<?php
}else
{
?>
var CITY_MAP_CENTER_LAT = '<?php echo get_current_city_lat();?>';
var CITY_MAP_CENTER_LNG = '<?php echo get_current_city_lng();?>';
var CITY_MAP_ZOOMING_FACT=<?php echo get_current_city_scale_factor();?>;
<?php }?>
<?php
global $geo_latitude,$geo_longitude;
if(esc_attr(stripslashes($geo_latitude)) && esc_attr(stripslashes($geo_longitude)))
{
?>
var CITY_MAP_CENTER_LAT = '<?php echo $geo_latitude;?>';
var CITY_MAP_CENTER_LNG = '<?php echo $geo_longitude;?>';
<?php
}
?>
if(CITY_MAP_CENTER_LAT=='')
{
	var CITY_MAP_CENTER_LAT = 34;	
}
if(CITY_MAP_CENTER_LNG=='')
{
	var CITY_MAP_CENTER_LNG = 0;	
}


var geocoder = new google.maps.Geocoder();
 
function geocodePosition(pos) {
  geocoder.geocode({
    latLng: pos
  }, function(responses) {
    if (responses && responses.length > 0) {
      updateMarkerAddress(responses[0].formatted_address);
    } else {
      updateMarkerAddress('Cannot determine address at this location.');
    }
  });
}
 
function updateMarkerStatus(str) {
  document.getElementById('markerStatus').innerHTML = str;
}
 
function updateMarkerPosition(latLng) {
	document.getElementById('geo_latitude').value=latLng.lat();
	  document.getElementById('geo_longitude').value=latLng.lng();
  /* document.getElementById('info').innerHTML = [
    latLng.lat(),
    latLng.lng()
  ].join(', '); */
}
 
function updateMarkerAddress(str) {
	if (jQuery("#address").val() == '' ||jQuery("#address").val() == oldstr ){
  document.getElementById('address').value = str;
  
  if(str){oldstr = str;}
  }
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
    geocodePosition(marker.getPosition());
  });
  google.maps.event.addListener(map, 'dragend', function() {
   // updateMarkerStatus('Drag ended');

    geocodePosition(marker.getPosition());
	centerMarker();
	updateMarkerPosition(marker.getPosition());

  });
  
  
  ///////////////////////////// FUNCTION TO SET MAP MARKER IF CITY CHANGED ////////////////////////////////////////////////
  var cityMove = document.getElementById( 'post_city_id' );
		google.maps.event.addDomListener(cityMove, 'change', cityCenterMap);
		
		function cityCenterMap(){
			if(jQuery("#address").val()==''){
			var cityID = jQuery("#post_city_id").val();
			jQuery.get("<?php echo get_bloginfo('url').'?ajax=latlng&city_id='; ?>"+cityID, function (data) {			
			var LT = data.split(",");
			var latLng2 = new google.maps.LatLng(LT[0],LT[1]);
			marker.setPosition(latLng2);
			centerMap();																				
			});
			}
			
		}  
  /////////////////////////////////////////////////////////////////////////////
  
    ///////////////////////////// FUNCTION TO SET MAP MARKER IF REGION CHANGED ////////////////////////////////////////////////
  var hoodMove = document.getElementById( 'post_hood_id' );
		google.maps.event.addDomListener(hoodMove, 'change', hoodCenterMap);
		
		function hoodCenterMap(){
			if(jQuery("#address").val()==''){
			var hoodID = jQuery("#post_hood_id").val();
			jQuery.get("<?php echo get_bloginfo('url').'?ajax=latlng&hood_id='; ?>"+hoodID, function (data) {			
			var LT = data.split(",");
			var latLng2 = new google.maps.LatLng(LT[0],LT[1]);
			marker.setPosition(latLng2);
			centerMap();																				
			});
			}
			
		}  
  /////////////////////////////////////////////////////////////////////////////
        var maxMap = document.getElementById( 'triggermap' );
		google.maps.event.addDomListener(maxMap, 'click', showAlert);
		
		function showAlert() {
       // window.alert('DIV clicked');
		jQuery('#map_canvas').toggleClass('map-fullscreen');
		jQuery('.map_category').toggleClass('map_category_fullscreen');
		jQuery('#trigger').toggleClass('map_category_fullscreen');
		jQuery('body').toggleClass('body_fullscreen');
		jQuery('#loading_div').toggleClass('loading_div_fullscreen');
		jQuery('#advmap_nofound').toggleClass('nofound_fullscreen');
		jQuery('#triggermap').toggleClass('triggermap_fullscreen');
		jQuery('.TopLeft').toggleClass('TopLeft_fullscreen');

		//var darwin = new google.maps.LatLng(-12.461334, 130.841904);
 			 //map.setCenter(darwin);
			 window.setTimeout(function() { 
var center = map.getCenter(); 
google.maps.event.trigger(map, 'resize'); 
map.setCenter(center); 
        }, 100);
      }
////////////////////////////////////////////////////////////////////////////////
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
	<?php
	}
}
get_location_map_app_javascripts();
?>
<script type="text/javascript">
// Onload handler to fire off the app.
google.maps.event.addDomListener(window, 'load', initialize);
</script>


    
<div id="map_canvas" style="height:300px;position:relative; width:280px;"></div>
