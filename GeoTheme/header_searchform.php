<div class="searchform">
  <form method="get" id="searchform2" action="<?php bloginfo('home'); ?>/" onsubmit="if(geocodeAddress())alert('<?php _('Everything is ok');?>'); else { return false; }"> 
   <input type="hidden" name="t" value="1" />
    <span class="searchfor"><input type="text" value="<?php if(isset($_REQUEST['s']) && $_REQUEST['s']!='cal_event'){echo stripslashes($_REQUEST['s']);}else{echo SEARCH_FOR_TEXT;}?>" name="s" id="sr" class="s" onkeydown="if (event.keyCode == 13){set_srch()}" onfocus="if (this.value == '<?php echo SEARCH_FOR_TEXT; ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php echo SEARCH_FOR_TEXT; ?>';}" />
     <small class="text"><?php echo SEARCH_FOR_MSG;?> </small>
     </span>
  	 <span id="set_near_me" class="near" <?php if(get_option('user_near_search') && file_exists(get_stylesheet_directory()."/images/nearmebg.png")){echo "style='background: url(".get_bloginfo('stylesheet_directory')."/images/nearmebg.png) no-repeat left top;'";}?>><span id="set_near"></span><input name="sn" id="sn" type="text" class="s" value="<?php if(isset($_REQUEST['sn'])){echo stripslashes($_REQUEST['sn']);}else{echo NEAR_TEXT;}?>" onblur="if (this.value == '') {this.value = '<?php echo NEAR_TEXT;?>';}" onkeydown="if (event.keyCode == 13){set_srch()}"  onfocus="if (this.value == '<?php echo NEAR_TEXT;?>') {this.value = '';}"   /> 
      <small class="text"><?php echo SEARCH_NEAR_MSG;?></small>
     </span>
     <input name="Sgeo_lat" id="Sgeo_lat" type="hidden" value="" />
     <input name="Sgeo_lon" id="Sgeo_lon" type="hidden" value="" />
    <input type="button" class="search_btn" value="<?php echo SEARCH;?>" alt="<?php echo SEARCH;?>" onclick="set_srch();" />
  </form>
</div>
<script type="text/javascript" src="http://gmaps-samples-v3.googlecode.com/svn/trunk/geolocate/geometa.js"></script> 
<script type="text/javascript">
jQuery('#set_near').click(function() {
jQuery('#sn').val('<?php echo NEAR_ME;?>');
});
function set_srch()
{ 		    
	if(jQuery(".searchfor").css("display") == "none"){
	jQuery(".searchfor").slideDown(2000);
	jQuery("#set_near_me").slideDown(2000);
	return false;
	}

	if(document.getElementById('sr').value=='<?php echo SEARCH_FOR_TEXT; ?>')
	{
		document.getElementById('sr').value = ' ';	
	}
	if(document.getElementById('sn').value=='<?php echo NEAR_TEXT; ?>')
	{
		document.getElementById('sn').value = '';	
	}
	 geocodeAddress();
}
var latlng;
var Sgeocoder;
var address;
var Sgeocoder = new google.maps.Geocoder();
function updateSearchPosition(latLng) {
	document.getElementById('Sgeo_lat').value=latLng.lat();
	  document.getElementById('Sgeo_lon').value=latLng.lng();
  
  document.forms["searchform2"].submit(); // submit form after insering the lat long positions

 
}
function geocodeAddress() {
	  Sgeocoder = new google.maps.Geocoder(); // Call the geocode function
	  //alert('click1');
	  if(document.getElementById('sn').value=='')
	{
			  document.forms["searchform2"].submit(); // submit form after insering the lat long positions

	}else{
	
    var address = document.getElementById("sn").value;
	if(document.getElementById('sn').value=='<?php echo NEAR_ME;?>'){
	initialise2();}else{
    Sgeocoder.geocode( { 'address': address<?php gt_advanced_near_search();?> }, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
		updateSearchPosition(results[0].geometry.location);
	 } else {
        alert("<?php _e('Search was not successful for the following reason: ');?>" + status);
      }
    });}
	}
  }
</script>
<script type="text/javascript"> 
  function initialise2() {
    var latlng = new google.maps.LatLng(-25.363882,131.044922);
    var myOptions = {
      zoom: 4,
      mapTypeId: google.maps.MapTypeId.TERRAIN,
      disableDefaultUI: true
    }
	//alert(latLng);
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
        msg = "<?php _e('Unable to find your location');?>";
        break;
      case err.PERMISSION_DENINED:
        msg = "<?php _e('Permission denied in finding your location');?>";
        break;
      case err.POSITION_UNAVAILABLE:
        msg = "<?php _e('Your location is currently unknown');?>";
        break;
      case err.BREAK:
        msg = "<?php _e('Attempt to find location took too long');?>";
        break;
      default:
        msg = "<?php _e('Location detection not supported in browser');?>";
    }
    document.getElementById('info').innerHTML = msg;
  }
 
  function positionSuccess(position) {
    var coords = position.coords || position.coordinate || position;
	 //alert(coords.latitude + ', ' + coords.longitude );
	 document.getElementById('Sgeo_lat').value=coords.latitude;
	  document.getElementById('Sgeo_lon').value=coords.longitude;
	  
	    document.forms["searchform2"].submit(); // submit form after insering the lat long positions


   
  }
 
 
 
</script> 
