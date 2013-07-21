<?php

function get_category_home()
{
	global $wpdb;
	$map_cat_arr = get_current_city_category();
	if(trim($map_cat_arr))
	{
		$map_cat_ids = $map_cat_arr;
		$catsql = "select c.*,tx.parent from $wpdb->terms c join $wpdb->term_taxonomy tx on tx.term_id=c.term_id  where c.term_id in ($map_cat_ids) and tx.taxonomy in ('placecategory','eventcategory') and count>0  order by tx.parent,c.name ";	
		//$catsql = "select c.* from $wpdb->terms c  where c.term_id in ($map_cat_ids) order by c.name";	
	}else
	{
		$catsql = "select c.* from $wpdb->terms c,$wpdb->term_taxonomy tt  where tt.term_id=c.term_id and tt.taxonomy in ('placecategory','eventcategory') and count>0 and c.term_id not in ($blog_cats) order by c.name";	
	}
	$catinfo = $wpdb->get_results($catsql);
	$cat_content_info = array();
	$cat_name_info = array();
	foreach ($catinfo as $catinfo_obj)
	{
		$term_id = $catinfo_obj->term_id;
		$name = $catinfo_obj->name;
		$term_icon = $catinfo_obj->term_icon;
		$parent = $catinfo_obj->parent;
		if(!$term_icon)
		{
			$term_icon = get_bloginfo('template_directory').'/library/map/icons/pin.png';
		}
		
		
			
			
				$srcharr = array("'","/","-",'"','\\');
				$replarr = array("&prime;","&frasl;","&ndash;","&ldquo;",'');
				    $retstr ="";
						
						$content_data[] = $retstr;
					$arrsrch = array("'",'"','/',',',".",' ');
					$arrrep = array('','','','','','');
					$catname = strtolower(str_replace($arrsrch,$arrrep,$name));
					$cat_content_info[]= "'$catname':[".implode(',',$content_data)."]";
					$cat_name_info[] = array($name,$catname,$term_icon,$parent,$term_id);
				
						
				
	}
	if($cat_content_info)
	{					

		return array($cat_name_info,implode(',',$cat_content_info));
	}
}

// =============================== Google Map V3 Home page======================================
class googlemmap_homepage extends WP_Widget {
	function googlemmap_homepage() {
	//Constructor
		$widget_ops = array('classname' => 'widget Google Map in Home page', 'description' => __('Google Map in Home page. It will show you google map V3 for Home page with category checkbox selection.') );		
		$this->WP_Widget('googlemmapwidget_home', __('PT &rarr; Google Map V3 - Home page'), $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
	extract($args, EXTR_SKIP);
	$width = empty($instance['width']) ? '940px' : apply_filters('widget_width', $instance['width']);
	$heigh = empty($instance['heigh']) ? '425px' : apply_filters('widget_heigh', $instance['heigh']);
	$catarr = get_category_home();
	//print_r ($catarr);exit;
	$catname_arr = $catarr[0];
	$catinfo_arr = $catarr[1];
	?>


<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/library/js/map.js"></script>


	
	<script type="text/javascript"> 
            var ajaxSearch, openMarker;
 
		var langText = new Array(); 
		langText['tprop']='Results'; 
		langText['pid']='Property ID'; 
		langText['inputText']='<?php _e('Title or Keyword');?>'; 
		langText['noRecords']='<?php _e('Sorry, no records were found. Please try again.');?>'; 
		langText['previous']='Previous'; 
		langText['next']='Next'; 
		langText['of']='of';
		options = {
							'gtbaseurl': '<?php bloginfo('url'); ?>',						
							'latitude': '<?php echo get_current_city_lat();?>', 
							'longitude': '<?php echo get_current_city_lng();?>', 
							'zoom': <?php echo get_current_city_scale_factor();?>,							
							'scrollzoom': <?php if(get_option('ptthemes_map_scrollwheel')){echo 'true';}else{echo 'false';}?>, 
							'streetview': <?php if(get_option('ptthemes_map_streetview')){echo 'true';}else{echo 'false';}?>, 
							'maptype': 'ROADMAP',  
							'showPreview': '0', 
                            'maxZoom': 21, 
							
							'autozoom': '<?php echo get_current_city_map_scroll_flag();?>',
                            'token': '68f48005e256696074e1da9bf9f67f06' 
					}
			function ajaxPage(limitstart)
			{
				ajaxSearch();
			}
 
			function limitReset()
			{
				document.slider_search.limitstart.value = '';
			}		
					
			google.maps.event.addDomListener(window, 'load', home_map_go);
    </script>	
	

<div class="top_banner_section">
<div class="map_background">
<div class="top_banner_section_in clearfix" style="width: <?php echo $width;?>;max-width:<?php echo $width;?>;">
<div class="TopLeft"><span id="triggermap"></span></div>
<div class="TopRight"></div>
        <div id="map_canvas" style="width: <?php echo $width;?>; height:<?php echo $heigh;?>">
        
        <!-- new map start -->
        
  <div class="iprelative">     
    <div id="advmap_canvas" style="width: <?php echo $width;?>; height:<?php echo $heigh;?>"></div>     
    <div id="loading_div" style="width: <?php echo $width;?>; height:<?php echo $heigh;?>"></div> 
                <div id="advmap_counter"></div>        
    <div id="advmap_nofound"><?php echo MAP_NO_RESULTS; ?></div>     
   </div>   
   
<!-- new map end -->
        
        
        
        </div>
        <div class="BottomLeft"></div>
        <?php  $map_cat_ex = get_current_city_cat_ex();$map_cat_exarr =explode(",", $map_cat_ex); if($catname_arr){ ?>
        <div id="trigger" class="triggeroff"></div>

        <div class="map_category">

         <form id="ajaxform" name="slider_search" class="pe_advsearch_form" action="">     
          <input  onkeydown="if (event.keyCode == 13){limitReset();ajaxSearch()}" type="text" class="inputbox" id="search_string" name="search" value="<?php _e('Title or Keyword');?>" onclick="this.value=''" />

  
        <div class="toggle" style="display:none;">
        <ul id="sitemap" class="treeview">
        <?php 
		//print_r ($catname_arr);
		if(get_option('ptthemes_map_sub_colapse')){
		for($c=0;$c<count($catname_arr);$c++){
			
			$e=0;
			if($catname_arr[$c][3]=='0'){
			?>
        
        <li><label><input type="checkbox" value="<?php echo $catname_arr[$c][4];?>" <?php if(in_array($catname_arr[$c][4],$map_cat_exarr)){echo 'checked="checked"';} ?> id="<?php echo $catname_arr[$c][1];?>" name="ptype[]" onclick="limitReset();ajaxSearch()"/><img height="14" width="8" alt="" src="<?php echo get_cat_icon($catname_arr[$c][4]);?>"/> <?php _e($catname_arr[$c][0]); ?></label>
         
         <?php }
		 
			 for($d=0;$d<count($catname_arr);$d++){	
			 
			 if($catname_arr[$c][3]=='0' && $catname_arr[$c][4]==$catname_arr[$d][3]){
				if($e==0){echo '<ul>'; }$e++;
			  ?>
              
              
			 <li><label><input type="checkbox" value="<?php echo $catname_arr[$d][4];?>"  <?php if(in_array($catname_arr[$d][4],$map_cat_exarr)){echo 'checked="checked"';} ?> id="<?php echo $catname_arr[$d][1];?>" name="ptype[]" onclick="limitReset();ajaxSearch()"/><img height="14" width="8" alt="" src="<?php echo get_cat_icon($catname_arr[$d][4]);?>"/>--- <?php _e($catname_arr[$d][0]);?></label></li>
             
             
             
		<?php }else{}} if($e!=0){echo '</ul>';} if($catname_arr[$c][3]=='0'){echo '</li>';}?><?php
		 
		 }
		}else{
		 
		 for($c=0;$c<count($catname_arr);$c++){
			
			?>
        
        <li><label><input type="checkbox" value="<?php echo $catname_arr[$c][4];?>"  <?php if(in_array($catname_arr[$c][4],$map_cat_exarr)){echo 'checked="checked"';} ?> id="<?php echo $catname_arr[$c][1];?>" name="ptype[]" onclick="limitReset();ajaxSearch()"/><img height="14" width="12" alt="" src="<?php echo get_cat_icon($catname_arr[$c][4]);?>"/> <?php _e($catname_arr[$c][0]);?></label></li>
         
         <?php
		 
		 }}
		 
		 ?>
       
       </ul> </div>

  <input type="hidden" name="limitstart" value="" /> 

</form>

        <?php }?>
<div class="BottomRight"><?php if($catname_arr){ echo '</div>';}?>
</div></div></div></div>
	<?php
	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['width'] = strip_tags($new_instance['width']);
		$instance['heigh'] = ($new_instance['heigh']);

		return $instance;
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'width' => '', 'heigh' => '') );		
		$width = strip_tags($instance['width']);
		$heigh = strip_tags($instance['heigh']);
	?>
    <p>
      <label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('Map Width <small>(Default is : 940px)</small>');?>:
      <input class="widefat" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo attribute_escape($width); ?>" />
      </label>
    </p>
     <p>
      <label for="<?php echo $this->get_field_id('heigh'); ?>"><?php _e('Map Heigh <small>(Default is : 425px)</small>');?>:
      <input class="widefat" id="<?php echo $this->get_field_id('heigh'); ?>" name="<?php echo $this->get_field_name('heigh'); ?>" type="text" value="<?php echo attribute_escape($heigh); ?>" />
      </label>
    </p>
    <?php
	}}
register_widget('googlemmap_homepage');
?>