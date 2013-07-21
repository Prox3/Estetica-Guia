<?php
// =============================== Google Map Single page======================================
class googlemmap_singlepage extends WP_Widget {
	function googlemmap_singlepage() {
	//Constructor
		$widget_ops = array('classname' => 'widget Google Map in Detail page Sidebar', 'description' => __('Google Map in Detail page Sidebar. It will show you google map V3 for detail page only.') );		
		$this->WP_Widget('googlemmapwidget_single', __('PT &rarr; Google Map V3 - Detail page'), $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		$width = empty($instance['width']) ? '294' : apply_filters('widget_width', $instance['width']);
		$heigh = empty($instance['heigh']) ? '370' : apply_filters('widget_heigh', $instance['heigh']);
		$zoom = empty($instance['zoom']) ? '' : apply_filters('widget_zoom', $instance['zoom']);
		$bubble = empty($instance['bubble']) ? '' : apply_filters('widget_bubble', $instance['bubble']);
		
		
		 ?>						
 	    
<?php
global $post,$wp_query, $preview;
$post = $wp_query->post;

if($_REQUEST['alook'] && get_post_meta($_REQUEST['pid'],"map_zoom",true)){$zoom=get_post_meta($_REQUEST['pid'],"map_zoom",true);}
elseif(get_post_meta($post->ID,"map_zoom",true)){$zoom=get_post_meta($post->ID,"map_zoom",true);}

?>
<?php if($_REQUEST['alook']){?>
<script type="text/javascript" src="<?php bloginfo('url'); ?>/?ptype=get_markers&amp;stype=cat_single&amp;ID=<?php echo mysql_real_escape_string($_REQUEST['pid']); ?>&amp;zoom=<?php echo $zoom; ?>&amp;bubble=<?php echo $bubble; if($preview){echo '&amp;pre_lat='.get_post_meta($_REQUEST['pid'], 'geo_latitude',true).'&amp;pre_lon='.get_post_meta($_REQUEST['pid'], 'geo_longitude',true).'&amp;pre_map_type='.get_post_meta($_REQUEST['pid'], 'map_view',true);}?>"></script>
<?php }else{?>
<script type="text/javascript" src="<?php bloginfo('url'); ?>/?ptype=get_markers&amp;stype=cat_single&amp;ID=<?php if($post->ID){echo $post->ID;}else{echo '1';} ?>&amp;zoom=<?php echo $zoom; ?>&amp;bubble=<?php echo $bubble; if($preview){echo '&amp;pre_lat='.$_POST['geo_latitude'].'&amp;pre_lon='.$_POST['geo_longitude'].'&amp;pre_map_type='.$_POST['map_view'];}?>"></script>
<?php }?>

<div class="top_banner_section" id="sticky_map">
<div class="map_background">
<div class="top_banner_section_in clearfix" style="width: <?php echo $width;?>px;">
<div class="TopLeft"><span id="triggermap"></span></div>
<div class="TopRight"></div>
<div id="map_canvas" style="width: <?php echo $width;?>px; height:<?php echo $heigh;?>px">
<!-- new map start -->
<div class="iprelative">     
<div id="map-canvas" style="width: <?php echo $width;?>px; height:<?php echo $heigh;?>px"></div>     
<div id="loading_div" style="width: <?php echo $width;?>px; height:<?php echo $heigh;?>px"></div> 
<div id="advmap_counter"></div>        
<div id="advmap_nofound"><?php echo MAP_NO_RESULTS; ?></div>     
</div>   
<!-- new map end -->
</div>
<div class="BottomLeft"></div>
<div class="BottomRight"></div>
<input type="text"  id="fromAddress" name="from" class="textfield"  value="<?php _e('Enter Your Location');?>"  onblur="if (this.value == '') {this.value = '<?php _e('Enter Your Location');?>';}" onfocus="if (this.value == '<?php _e('Enter Your Location');?>') {this.value = '';}" />
<input type="button" value="<?php _e('Get Directions');?>" class="b_getdirection" id="directions" onclick="calcRoute()" />
 <div id="directionsPanel" style="width: <?php echo ($width * 0.95);?>px"></div>
</div></div></div>


<?php
	

?>
	<?php
	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['width'] = ($new_instance['width']);
		$instance['heigh'] = ($new_instance['heigh']);
		$instance['zoom'] = ($new_instance['zoom']);
		$instance['bubble'] = ($new_instance['bubble']);

		return $instance;
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'width' => '', 'heigh' => '', 'zoom' => '', 'bubble' => '') );		
		$width = ($instance['width']);
		$heigh = ($instance['heigh']);
		$zoom = ($instance['zoom']);
		$bubble = ($instance['bubble']);
		?>
		 <p>
      <label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('Map Width <small>(Default is : 294px)</small>');?>:
      <input class="widefat" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo attribute_escape($width); ?>" />
      </label>
    </p>
     <p>
      <label for="<?php echo $this->get_field_id('heigh'); ?>"><?php _e('Map Heigh <small>(Default is : 370px)</small>');?>:
      <input class="widefat" id="<?php echo $this->get_field_id('heigh'); ?>" name="<?php echo $this->get_field_name('heigh'); ?>" type="text" value="<?php echo attribute_escape($heigh); ?>" />
      </label>
    </p>
		<p>
      <label for="<?php echo $this->get_field_id('zoom'); ?>"><?php _e('Map Zoom level(1-19) <small>(Default is : 13)</small>');?>:
      <input class="widefat" id="<?php echo $this->get_field_id('zoom'); ?>" name="<?php echo $this->get_field_name('zoom'); ?>" type="text" value="<?php echo attribute_escape($zoom); ?>" />
      </label>
    </p>
    <p>
  <label for="<?php echo $this->get_field_id('bubble'); ?>"><?php _e('Marker Bubble Open?');?>
 <select id="<?php echo $this->get_field_id('bubble'); ?>" name="<?php echo $this->get_field_name('bubble'); ?>">
  <option value="0" <?php if(attribute_escape($bubble)=='0'){ echo 'selected="selected"';} ?>><?php _e('No');?></option>
  <option value="1" <?php if(attribute_escape($bubble)=='1'){ echo 'selected="selected"';} ?>><?php _e('Yes');?></option>
  </select>
  </label>
</p> 
    <?php
	}}
register_widget('googlemmap_singlepage');
?>