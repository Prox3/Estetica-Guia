<?php 
header("Content-type: text/javascript");
/*
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time; */
?>
<?php
if($_REQUEST['ptype']=='get_markers' && $_REQUEST['stype']=='cat'){
	


function get_markers()
{	
	global $wpdb;
	$i=0;
	if($_REQUEST['cat_id'] != ''){	$map_cat_arr = mysql_real_escape_string($_REQUEST['cat_id']);}else{
	$map_cat_arr = get_current_city_category();}
	//echo $map_cat_arr;exit;
	if(trim($map_cat_arr))
	{
		$map_cat_ids = $map_cat_arr;
		$catsql = "select c.*,tx.parent, tx.taxonomy from $wpdb->terms c join $wpdb->term_taxonomy tx on tx.term_id=c.term_id  where c.term_id in ($map_cat_ids) and tx.taxonomy in ('placecategory','eventcategory') and count>0  order by tx.parent,c.name ";	
		//$catsql = "select c.* from $wpdb->terms c  where c.term_id in ($map_cat_ids) order by c.name";	
	}else
	{
		$catsql = "select c.*, tt.taxonomy from $wpdb->terms c,$wpdb->term_taxonomy tt  where tt.term_id=c.term_id and tt.taxonomy in ('placecategory','eventcategory') and count>0 and c.term_id order by c.name";	
	}
	//echo $catsql;
	$catinfo = $wpdb->get_results($catsql);
	$cat_content_info = array();
	$cat_name_info = array();
	foreach ($catinfo as $catinfo_obj)
	{ //print_r($catinfo_obj);
		$term_id = $catinfo_obj->term_id;
		$name = $catinfo_obj->name;
		$term_icon_url = get_tax_meta($term_id,'ct_cat_icon');
		$term_icon = $term_icon_url['src'];
		$parent = $catinfo_obj->parent;
		if(!$term_icon)
		{
			$term_icon = get_bloginfo('template_directory').'/library/map/icons/pin.png';
		}
		if($term_id)
		{		
##########################
$where ='';
if($catinfo_obj->taxonomy=='eventcategory'){
	if($_REQUEST['etype']=='upcoming' || !$_REQUEST['etype'] || $_REQUEST['etype']=='undefined' )
			{
				$today = date('Y-m-d');
				$where .= " AND (p.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='end_date' and $wpdb->postmeta.meta_value>='".$today."')) ";
			}elseif($_REQUEST['etype']=='past')
			{
				$today = date('Y-m-d');
				$where .= " AND (p.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='end_date' and $wpdb->postmeta.meta_value<='".$today."')) ";
			}
}
############################
			$content_data = array();
			$post_type = "'place','event'";
			$search = '';
			if($_REQUEST['search']){$search = 'and p.post_title like"%'.mysql_real_escape_string($_REQUEST['search']).'%"';}
			//$post_type = "'post'";
			if($_SESSION['multi_city'])
			{
				$multi_city_id =  get_multi_city_id();
				$meta_key =	get_multi_city_meta();
								$sql = "select p.* from $wpdb->posts p join $wpdb->postmeta pm on pm.post_id=p.ID where p.post_status in ('publish') and p.post_type in ($post_type) and (pm.meta_key=\"$meta_key\" and (pm.meta_value in ($multi_city_id))) $search and p.ID in (select tr.object_id from $wpdb->term_relationships tr join $wpdb->term_taxonomy t on t.term_taxonomy_id=tr.term_taxonomy_id where t.term_id=\"$term_id\" ) $where";

				}else
			{
				$sql = "select p.* from $wpdb->posts p where p.post_type in ($post_type) and p.post_status in ('publish') $search and p.ID in (select tr.object_id from $wpdb->term_relationships tr join $wpdb->term_taxonomy t on t.term_taxonomy_id=tr.term_taxonomy_id where t.term_id=\"$term_id\" ) $where";
			}
			$postinfo = $wpdb->get_results($sql);
			//echo $sql;
			$data_arr = array();
			if($postinfo)
			{
				$srcharr = array('"','\\');
				$replarr = array("&quot;",''); 
				
				foreach($postinfo as $postinfo_obj)
				{ 
					if(function_exists('icl_object_id') && icl_object_id($postinfo_obj->ID, $postinfo_obj->post_type, false)){
					 $postinfo_obj = get_post(icl_object_id($postinfo_obj->ID, $postinfo_obj->post_type, false));
					}
					$ID = $postinfo_obj->ID;
					$title = str_replace($srcharr,$replarr,$postinfo_obj->post_title); // fix by Stiofan
					//$title = str_replace($srcharr,$replarr,htmlentities($postinfo_obj->post_title, ENT_COMPAT, 'UTF-8')); // fix by Stiofan
					$lat = htmlentities(get_post_meta($ID,'geo_latitude',true));
					$lng = htmlentities(get_post_meta($ID,'geo_longitude',true));
					$timing ='';
					##########################
						if($_REQUEST['etype']=='upcoming' || $_REQUEST['etype']=='past')
								{ //echo date('Y-m-d', strtotime($date));
										$timing = ' - '.date('D M j, Y', strtotime(get_post_meta($ID,'st_date',true)));			
										$timing .= ' - '.get_post_meta($ID,'st_time',true);			
								}
					############################
					//$title = $postinfo_obj->post_title;
					//$lat = $postinfo_obj->LAT;
					//$lng = $postinfo_obj->LON;
					//$address = str_replace($srcharr,$replarr,htmlentities(get_post_meta($ID,'address',true), ENT_COMPAT, 'UTF-8')); // fix by Stiofan
					//$contact = str_replace($srcharr,$replarr,htmlentities(get_post_meta($ID,'contact',true), ENT_COMPAT, 'UTF-8'));
					//$timing = str_replace($srcharr,$replarr,(get_post_meta($ID,'timing',true)));
					/* REMOVED BY STIOFAN
						$title = str_replace($srcharr,$replarr,($postinfo_obj->post_title));
					$plink = get_permalink($postinfo_obj->ID);
					$lat = (get_post_meta($ID,'geo_latitude',true));
					$lng = (get_post_meta($ID,'geo_longitude',true));
					$address = str_replace($srcharr,$replarr,(get_post_meta($ID,'address',true)));
					$contact = str_replace($srcharr,$replarr,(get_post_meta($ID,'contact',true)));
					*/ 
					//$pimgarr = bdw_get_images($ID,'thumb',1);
					//global $thumb_url; /// get the mutiuser id
					//$pimg = get_bloginfo('template_directory').'/thumb.php?src='.$pimgarr[0].'&w=90&h=70&zc=1'.$thumb_url; #### reduce image size 
					if($lat && $lng)
					{
						

//[{"id":"1","lat_pos":"47.67299056242512","long_pos":"-116.76848108413083","formattedprice":"Call for price","totalcount":"2"},{"id":"2","lat_pos":"47.69737437298803","long_pos":"-116.79680521132809","formattedprice":"Call for price"}]


						$i++;
						$retstr ='{';
						$retstr .= '"id":"'.$ID.'",';
						$retstr .= '"formattedprice":"'.$title.''.$timing.'",';
						$retstr .= '"lat_pos": "'.$lat.'",';
						$retstr .= '"long_pos": "'.$lng.'",';
						$retstr .= '"icon":"'.$term_icon.'"';
						$retstr .= '}';
						
						
						
						
						/*
						$retstr ="{";
						$retstr .= "'id':'$ID',";
						$retstr .= "'name':'$title',";
						$retstr .= "'lat': '$lat',";
						$retstr .= "'lon': '$lng',";	
						$retstr .= "'totalcount':'2',";
						$retstr .= "'icons':'$term_icon'";
						$retstr .= "}";*/
						$content_data[] = $retstr;
					}
				}

				if($content_data)
				{
					$arrsrch = array("'",'"','/',',',".",' ');
					$arrrep = array('','','','','','');
					$catname = strtolower(str_replace($arrsrch,$arrrep,$name));
					//$cat_content_info[]= "'$catname':[".implode(',',$content_data)."]";
					$cat_content_info[]= implode(',',$content_data);
					//$cat_name_info[] = array($name,$catname,$term_icon,$parent,$term_id);
				}
			}			
		}		
	}
	if($cat_content_info)
	{// $cat_content_info= array_unique($cat_content_info);
		return '[{"totalcount":"'.$i.'",'.substr(implode(',',$cat_content_info),1).']';
	}else
	{
		return '[{"totalcount":"0"}]';
	}
}
$catarr = get_markers();
	echo $catarr;	
}
########################################## SIDEBAR LISTING MAP START ###########################################
else if($_REQUEST['ptype']=='get_markers' && $_REQUEST['stype']=='post'){
	
	function get_side_markers()
{	
	global $wpdb;
	$i=0;
	if($_REQUEST['cat_id'] != ''){	$map_cat_arr = mysql_real_escape_string($_REQUEST['cat_id']);}
	//else{$map_cat_arr = get_current_city_category();}
	//echo $map_cat_arr;exit;
	if(trim($map_cat_arr))
	{
		$map_cat_ids = $map_cat_arr;
		$catsql = "select c.*,tx.parent from $wpdb->terms c join $wpdb->term_taxonomy tx on tx.term_id=c.term_id  where c.term_id in ($map_cat_ids) and tx.taxonomy in ('placecategory','eventcategory') and count>0  order by tx.parent,c.name ";	
		//$catsql = "select c.* from $wpdb->terms c  where c.term_id in ($map_cat_ids) order by c.name";	
	}else
	{
		$catsql = "select c.* from $wpdb->terms c,$wpdb->term_taxonomy tt  where tt.term_id=c.term_id and tt.taxonomy in ('placecategory','eventcategory') and count>0 and c.term_id  order by c.name";	
	}
	$catinfo = $wpdb->get_results($catsql);
	$cat_content_info = array();
	$cat_name_info = array();
	foreach ($catinfo as $catinfo_obj)
	{
		$term_id = $catinfo_obj->term_id;
		$name = $catinfo_obj->name;
		$term_icon_url = get_tax_meta($term_id,'ct_cat_icon');
		$term_icon = $term_icon_url['src'];
		$parent = $catinfo_obj->parent;
		if(!$term_icon)
		{
			$term_icon = get_bloginfo('template_directory').'/library/map/icons/pin.png';
		}
		if($term_id)
		{		
##########################
$where ='';
	if($_REQUEST['etype']=='upcoming')
			{
				$today = date('Y-m-d');
				$where .= " AND (p.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='end_date' and $wpdb->postmeta.meta_value>='".$today."')) ";
			}elseif($_REQUEST['etype']=='past')
			{
				$today = date('Y-m-d');
				$where .= " AND (p.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='end_date' and $wpdb->postmeta.meta_value<='".$today."')) ";
			}
############################
			$content_data = array();
			$post_type = "'place','event'";
			$search = '';
			if($_REQUEST['search']){$search = 'and p.post_title like"%'.mysql_real_escape_string($_REQUEST['search']).'%"';}
			//$post_type = "'post'";
			$post_ids = mysql_real_escape_string($_REQUEST['post_id']);
			if($_SESSION['multi_city'])
			{
				$multi_city_id =  get_multi_city_id();
				$meta_key =	get_multi_city_meta();
								$sql = "select p.* from $wpdb->posts p join $wpdb->postmeta pm on pm.post_id=p.ID where p.post_status in ('publish') and p.ID in($post_ids) AND p.post_type in ($post_type) and (pm.meta_key=\"$meta_key\" and (pm.meta_value in ($multi_city_id))) $search and p.ID in (select tr.object_id from $wpdb->term_relationships tr join $wpdb->term_taxonomy t on t.term_taxonomy_id=tr.term_taxonomy_id where t.term_id=\"$term_id\" ) $where";

				}else
			{
				$sql = "select p.* from $wpdb->posts p where p.post_type in ($post_type) and p.post_status in ('publish') AND p.ID in($post_ids) $search and p.ID in (select tr.object_id from $wpdb->term_relationships tr join $wpdb->term_taxonomy t on t.term_taxonomy_id=tr.term_taxonomy_id where t.term_id=\"$term_id\" ) $where";
			}
			$postinfo = $wpdb->get_results($sql);
			//echo $sql;
			$data_arr = array();
			if($postinfo)
			{
				$srcharr = array('"','\\');
				$replarr = array("&quot;",''); 
				
				foreach($postinfo as $postinfo_obj)
				{ 
					if(function_exists('icl_object_id') && icl_object_id($postinfo_obj->ID, $postinfo_obj->post_type, false)){
					 $postinfo_obj = get_post(icl_object_id($postinfo_obj->ID, $postinfo_obj->post_type, false));
					}
					$ID = $postinfo_obj->ID;
					$title = str_replace($srcharr,$replarr,$postinfo_obj->post_title); // fix by Stiofan
					//$title = str_replace($srcharr,$replarr,htmlentities($postinfo_obj->post_title, ENT_COMPAT, 'UTF-8')); // fix by Stiofan
					$lat = htmlentities(get_post_meta($ID,'geo_latitude',true));
					$lng = htmlentities(get_post_meta($ID,'geo_longitude',true));
					$timing ='';
					##########################
						if($_REQUEST['etype']=='upcoming' || $_REQUEST['etype']=='past')
								{ //echo date('Y-m-d', strtotime($date));
										$timing = ' - '.date('D M j, Y', strtotime(get_post_meta($ID,'st_date',true)));			
										$timing .= ' - '.get_post_meta($ID,'st_time',true);			
								}
					############################
					//$title = $postinfo_obj->post_title;
					//$lat = $postinfo_obj->LAT;
					//$lng = $postinfo_obj->LON;
					//$address = str_replace($srcharr,$replarr,htmlentities(get_post_meta($ID,'address',true), ENT_COMPAT, 'UTF-8')); // fix by Stiofan
					//$contact = str_replace($srcharr,$replarr,htmlentities(get_post_meta($ID,'contact',true), ENT_COMPAT, 'UTF-8'));
					//$timing = str_replace($srcharr,$replarr,(get_post_meta($ID,'timing',true)));
					/* REMOVED BY STIOFAN
						$title = str_replace($srcharr,$replarr,($postinfo_obj->post_title));
					$plink = get_permalink($postinfo_obj->ID);
					$lat = (get_post_meta($ID,'geo_latitude',true));
					$lng = (get_post_meta($ID,'geo_longitude',true));
					$address = str_replace($srcharr,$replarr,(get_post_meta($ID,'address',true)));
					$contact = str_replace($srcharr,$replarr,(get_post_meta($ID,'contact',true)));
					*/ 
					//$pimgarr = bdw_get_images($ID,'thumb',1);
					//global $thumb_url; /// get the mutiuser id
					//$pimg = get_bloginfo('template_directory').'/thumb.php?src='.$pimgarr[0].'&w=90&h=70&zc=1'.$thumb_url; #### reduce image size 
					if($lat && $lng)
					{
						

//[{"id":"1","lat_pos":"47.67299056242512","long_pos":"-116.76848108413083","formattedprice":"Call for price","totalcount":"2"},{"id":"2","lat_pos":"47.69737437298803","long_pos":"-116.79680521132809","formattedprice":"Call for price"}]


						$i++;
						$retstr ='{';
						$retstr .= '"id":"'.$ID.'",';
						$retstr .= '"formattedprice":"'.$title.''.$timing.'",';
						$retstr .= '"lat_pos": "'.$lat.'",';
						$retstr .= '"long_pos": "'.$lng.'",';
						$retstr .= '"icon":"'.$term_icon.'"';
						$retstr .= '}';
						
						
						
						
						/*
						$retstr ="{";
						$retstr .= "'id':'$ID',";
						$retstr .= "'name':'$title',";
						$retstr .= "'lat': '$lat',";
						$retstr .= "'lon': '$lng',";	
						$retstr .= "'totalcount':'2',";
						$retstr .= "'icons':'$term_icon'";
						$retstr .= "}";*/
						$content_data[] = $retstr;
					}
				}
				if($content_data)
				{
					$arrsrch = array("'",'"','/',',',".",' ');
					$arrrep = array('','','','','','');
					$catname = strtolower(str_replace($arrsrch,$arrrep,$name));
					//$cat_content_info[]= "'$catname':[".implode(',',$content_data)."]";
					$cat_content_info[]= implode(',',$content_data);
					//$cat_name_info[] = array($name,$catname,$term_icon,$parent,$term_id);
				}
			}			
		}		
	}
	if($cat_content_info)
	{
		return '[{"totalcount":"'.$i.'",'.substr(implode(',',$cat_content_info),1).']';
	}else
	{
		return '[{"totalcount":"0"}]';
	}
}
$catarr = get_side_markers();
	echo $catarr;	


}
########################################## SIDEBAR LISITNG MAP END #############################################
########################################## SINGLE LISTING MAP START ###########################################
else if($_REQUEST['ptype']=='get_markers' && $_REQUEST['stype']=='cat_single'){
	
	
$ID = mysql_real_escape_string($_REQUEST['ID']);
$bubble = mysql_real_escape_string($_REQUEST['bubble']);




	global $post,$wp_query;
if($ID){
if(get_post_meta($ID,'address',true))
{
	$address = get_post_meta($ID,'address',true);
}else
{
	$address = get_post_meta($ID,'geo_address',true);
}
if($_REQUEST['pre_lat']){$address_latitude =$_REQUEST['pre_lat'];}else{$address_latitude = get_post_meta($ID,'geo_latitude',true);}
if($_REQUEST['pre_lon']){$address_longitude =$_REQUEST['pre_lon'];}else{$address_longitude = get_post_meta($ID,'geo_longitude',true);}
if($_REQUEST['pre_map_type']){$map_type =$_REQUEST['pre_map_type'];}else{$map_type = get_post_meta($ID,'map_view',true);}
if($_REQUEST['zoom']){$zoom = $_REQUEST['zoom'];}else{$zoom = 13;}
if($map_type=='G_NORMAL_MAP')
{
	$map_type='ROADMAP';
}elseif($map_type=='G_SATELLITE_MAP')
{
	$map_type='SATELLITE';
}elseif($map_type=='G_HYBRID_MAP')
{
	$map_type='TERRAIN';
}else{$map_type='ROADMAP';}
$scale = 14;
$cagInfo = wp_get_object_terms($ID,'placecategory',$args);
if(!$cagInfo){
	$cagInfo = wp_get_object_terms($ID,'eventcategory',$args);
}

$cat_id = $cagInfo[count($cagInfo)-1]->term_id;

$term_icon_url = get_tax_meta($cat_id,'ct_cat_icon');
		$cat_icon = $term_icon_url['src'];
		/*$cat_icon = get_post_cat_icon($ID,  'place');
		if(!$cat_icon){ 
		$cat_icon = get_post_cat_icon($ID,  'event');
		}*/
if($cat_icon=='')
{
	$cat_icon = get_bloginfo('template_directory').'/library/map/icons/pin.png';	
}
$prdimage =  bdw_get_images($ID,'thumb',1);

$srch_arr = array("'",'"','\\');
$rpl_arr = array('','','');
$contact = trim(str_replace($srch_arr,$rpl_arr,get_post_meta($ID,'contact',true)));
$post_title = trim(str_replace($srch_arr,$rpl_arr,get_the_title($ID)));
$address = trim(str_replace($srch_arr,$rpl_arr,$address));

$tooltip_message = '';
if($prdimage){$tooltip_message .= '<img src="'.$prdimage[0].'" width="90" height="70" style="float:left; margin:0 11px 22px 0;" alt="'.$post_title.'" />';}
$tooltip_message .= '<a href="'.get_permalink($ID).'" class=ptitle>'.$post_title.'</a>';
if($address){
$tooltip_message .= '<br/><span class=pcontact>'.$address.'</span>';
}
if($contact){
$tooltip_message .= '<br/><span class=pcontact>'.wordwrap($contact,40,'<br/>\n').'</span>';
}
if($_REQUEST['pre_lat']){$tooltip_message = 'Preview';}
if($address_longitude && $address_latitude)
{

		?>
        
        
 var rendererOptions = {
    draggable: true
  };
  var directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);;
  var directionsService = new google.maps.DirectionsService();
  var map;
 
  var latLng = new google.maps.LatLng(<?php echo $address_latitude;?>, <?php echo $address_longitude;?>);
 
  function initialize() {
 
    var myOptions = {
      zoom: <?php if ($zoom) {echo $zoom;}else{echo $scale;}?>,
      mapTypeId: google.maps.MapTypeId.<?php if($map_type){echo $map_type;}else{echo 'ROADMAP';}?>,
      center: latLng 
    };
    map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);
    directionsDisplay.setMap(map);
    directionsDisplay.setPanel(document.getElementById("directionsPanel"));
 
    var image = '<?php echo $cat_icon;?>';
	var myLatLng = new google.maps.LatLng(<?php echo $address_latitude;?>, <?php echo $address_longitude;?>);
	var Marker = new google.maps.Marker({
	  position: latLng,
	  map: map,
	  icon: image
	});
	
                   document.getElementById('loading_div').style.display="none";

		var content = '<?php echo $tooltip_message;?>';
	infowindow = new google.maps.InfoWindow({
	  content: content
	});
	
	////////////////////////////////// Fix by Stiofan hebtech.co.uk for bubble beign hidden on load/////////////////////
	<?php if($bubble==1){ echo'window.setTimeout(function() {  infowindow.open(map, Marker); }, 1800);';} ?>
	
	google.maps.event.addListener(Marker, 'click', function() {
      infowindow.open(map,Marker);
    });
////////////////////////////////// End Fix by Stiofan hebtech.co.uk for bubble beign hidden on load/////////////////
    
    //calcRoute();
	google.maps.event.addListener(directionsDisplay, 'directions_changed', function() {
      computeTotalDistance(directionsDisplay.directions);
    });
    
/////////////////////////////////////////////////////////////////////////////
        var maxMap = document.getElementById( 'triggermap' );
		google.maps.event.addDomListener(maxMap, 'click', showAlert);
		
		function showAlert() {
       // window.alert('DIV clicked');
		jQuery('#map-canvas').toggleClass('map-fullscreen');
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
  
 
  function calcRoute() {
 var dest = document.getElementById('fromAddress').value;
    var request = {
      origin: dest,
      destination: "<?php echo $address_latitude;?>, <?php echo $address_longitude;?>",
      travelMode: google.maps.DirectionsTravelMode.DRIVING
    };
    directionsService.route(request, function(response, status) {
      if (status == google.maps.DirectionsStatus.OK) {
        directionsDisplay.setDirections(response);
      }else {alert('Address not found for: '+ dest);}
    });
  }
 
  function computeTotalDistance(result) {
    var total = 0;
    var myroute = result.routes[0];
    for (i = 0; i < myroute.legs.length; i++) {
      total += myroute.legs[i].distance.value;
    }
    totalk = total / 1000
	totalk_round = Math.round(totalk * 100)/100
	totalm = total / 1609.344
	totalm_round = Math.round(totalm * 100)/100
    document.getElementById("directionsPanel").innerHTML = "<p>Total Distance: <span id='totalk'>" + totalk_round + " km</span></p><p>Total Distance: <span id='totalm'>" + totalm_round + " miles</span></p>";
  }   
  google.maps.event.addDomListener(window, 'load', initialize);

<?php
}}}
########################################## SINGLE LISITNG MAP END #############################################


// ########################################################################################
else if($_REQUEST['m_id'] && $_REQUEST['stype']=='s'){
global $wpdb;
	if($_REQUEST['m_id'] != ''){$pid = mysql_real_escape_string($_REQUEST['m_id']);}else{echo 'no marker data found';exit;}

				$sql = "select p.* from $wpdb->posts p where p.ID=$pid and p.post_status in ('publish')";
			
			$postinfo = $wpdb->get_results($sql);
			
			$data_arr = array();
			
			$img_zc = get_img_zc(get_option('ptthemes_image_zc'));### added image zoom or crop option
			
			if($postinfo)
			{
				$srcharr = array("'","/","-",'"','\\');
				$replarr = array("&prime;","&frasl;","&ndash;","&ldquo;",'');
				foreach($postinfo as $postinfo_obj)
				{	
					/*
					if(function_exists('icl_object_id') && icl_object_id($postinfo_obj->ID, $postinfo_obj->post_type, false)){
					 global $sitepress;
					$default_lan = $sitepress->get_default_language();
					 $rating_stars = get_post_rating_star(icl_object_id($postinfo_obj->ID, $postinfo_obj->post_type, false, $default_lan));
					 }else{
					$rating_stars = get_post_rating_star($postinfo_obj->ID); 
					 }*/
					$ID = $postinfo_obj->ID;
					
					$rating_stars = get_post_rating_star($postinfo_obj->ID);
					
					$title = str_replace($srcharr,$replarr,htmlentities($postinfo_obj->post_title, ENT_COMPAT, 'UTF-8')); // fix by Stiofan
					$plink = get_permalink($postinfo_obj->ID);
					$lat = htmlentities(get_post_meta($ID,'geo_latitude',true));
					$lng = htmlentities(get_post_meta($ID,'geo_longitude',true));
					$address = str_replace($srcharr,$replarr,htmlentities(get_post_meta($ID,'address',true), ENT_COMPAT, 'UTF-8')); // fix by Stiofan
					$contact = str_replace($srcharr,$replarr,htmlentities(get_post_meta($ID,'contact',true), ENT_COMPAT, 'UTF-8'));
					$timing = str_replace($srcharr,$replarr,(get_post_meta($ID,'timing',true)));
					/* REMOVED BY STIOFAN
						$title = str_replace($srcharr,$replarr,($postinfo_obj->post_title));
					$plink = get_permalink($postinfo_obj->ID);
					$lat = (get_post_meta($ID,'geo_latitude',true));
					$lng = (get_post_meta($ID,'geo_longitude',true));
					$address = str_replace($srcharr,$replarr,(get_post_meta($ID,'address',true)));
					$contact = str_replace($srcharr,$replarr,(get_post_meta($ID,'contact',true)));
					*/ 
					$pimgarr = bdw_get_images($ID,'medium',1);
					global $thumb_url; /// get the mutiuser id
					if($_REQUEST['small']){
					$pimg = $pimgarr[0]; #### reduce image size 
					}else{
					$pimg = $pimgarr[0]; #### reduce image size 
					}
					if($lat && $lng)
					{
						if($_REQUEST['small']){
						$retstr ='<div class="bubble" style="width:245px;">';
            			$retstr .= '<h4><a href="'.$plink.'">'.$title.'</a></h4>';
						if($pimgarr){$retstr .= '<div class="bubble_image" style="position: relative;height:70px;width:90px;">';
						$retstr .= '<a href="'.$plink.'"><img src="'.$pimg.'"  style="height:100%;display:block;margin:0 auto;" /></a></div>';
						$retstr .= '</div>';}
						$retstr .='<span class="rating">'.$rating_stars.'</span>';						
						$retstr .= '<div class="bubble_desc" style="width:140px;">';
						$retstr .= '<span class=ptiming>'.$address.'</span>';
						$retstr .= '<br/><span class=pcontact>'.$timing.'</span>';
						$retstr .= '<br/><span class=pcontact>'.$contact.'</span>';
						$retstr .= '</div>';             					
						$retstr .= '</div>';
						}else{
						
						$retstr ='<div class="bubble">';
            			$retstr .= '<h4><a href="'.$plink.'">'.$title.'</a></h4>';
						if($pimgarr){$retstr .= '<div class="bubble_image" style="position: relative;">';
						$retstr .= '<a href="'.$plink.'"><img src="'.$pimg.'"   style="height:100%;display:block;margin:0 auto;" /></a></div>';
						$retstr .= '</div>';}
						$retstr .='<span class="rating">'.$rating_stars.'</span>';						
						$retstr .= '<div class="bubble_desc">';
						$retstr .= '<span class=ptiming>'.$address.'</span>';
						$retstr .= '<br/><span class=pcontact>'.$timing.'</span>';
						$retstr .= '<br/><span class=pcontact>'.$contact.'</span>';
						$retstr .= '</div>';             					
						$retstr .= '</div>';
						}
						echo $retstr;
					}
				}
				}
}
	
?>
<?php /*
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
echo 'Page generated in '.$total_time.' seconds.'."\n"; */
?>