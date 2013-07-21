<?php
################################# RSS IMAGES  #########################################

$rss_img_ch = get_option('rss_img_ch_op');

$rss2_img_ch = get_option('rss2_img_ch_op');



//if ($rss_img_ch == 1)   add_action('rss_item', 'wp_rss_include'); echo apply_filters('the_excerpt_rss', $output);
if ($rss_img_ch == 1)  add_filter('the_excerpt_rss', 'wp_rss_include');

//if ($rss2_img_ch == 1)  add_action('rss2_item', 'wp_rss_include');
if ($rss2_img_ch == 1)  add_filter('rss2_item', 'wp_rss_include');



add_action('admin_menu', 'wp_rss_img_menu');





function wp_rss_include ( $output ){



	$image_size = get_option('rss_image_size_op');

	if (isset($image_size)) $image_url = rss_image_url($image_size);

	

	else  $image_url = rss_image_url('medium');

	

	if (!empty($image_url)) {

	    

		try {

		

			$uploads = wp_upload_dir();

			$url = parse_url($image_url);

			$path = $uploads['basedir'] . preg_replace( '/.*uploads(.*)/', '${1}', $url['path'] );

			

			if ( file_exists( $path ) )

			{

			  $filesize = filesize( $path );

			  

			} 

						

		} catch (Exception $e){

		

			$ary_header = get_headers($image_url, 1);

					   

			$filesize = $ary_header['Content-Length'];			

			

		} 

if($image_size == 'thumbnail'){		$image_url = get_bloginfo('template_url').'/thumb.php?src='.$image_url.'&w=150&zc=0&a=tr&q=90&bid=1';}
elseif($image_size == 'full'){		$image_url = $image_url;}
elseif($image_size == 'medium'){		$image_url = get_bloginfo('template_url').'/thumb.php?src='.$image_url.'&w=580&zc=0&a=tr&q=90&bid=1';}

		//$image_url = get_bloginfo('template_url').'/thumb.php?src='.$image_url.'&w=580&h=480&zc=0&a=tr&q=90&bid=1';
		//$output = '<enclosure url="' . $image_url . '" length="' . $filesize . '" type="image/jpg" />'.$output;
		$output = '<p><img src="' . $image_url . '"  /></p><p>'.$output.'</p>';
		
	    return $output;

		

	}else{  return $output;}

	

}





function rss_image_url($default_size = 'medium') {	

	global $post;

/*	if( function_exists ('has_post_thumbnail') && has_post_thumbnail($post->ID)) {

	    $thumbnail_id = get_post_thumbnail_id( $post->ID );

		if(!empty($thumbnail_id))

		$img = wp_get_attachment_image_src( $thumbnail_id, $default_size );	

	} elseif(get_children( array(

										'post_parent' => $post->ID, 

										'post_type' => 'attachment', 

										'post_mime_type' => 'image',

										'orderby' => 'menu_order', 

										'order' => 'ASC', 

										'numberposts' => 1) )) {

	$attachments = get_children( array(

										'post_parent' => $post->ID, 

										'post_type' => 'attachment', 

										'post_mime_type' => 'image',

										'orderby' => 'menu_order', 

										'order' => 'ASC', 

										'numberposts' => 1) );

	if($attachments == true) :

		foreach($attachments as $id => $attachment) :

			$img = wp_get_attachment_image_src($id, $default_size);			

		endforeach;		

	endif;

	} else {
		
		$img = bdw_get_images($post->ID,'large');

	   return $img[0]; 
		
	}*/
		$img = bdw_get_images($post->ID,'large');

	return $img[0];

}







function wp_rss_img_menu() {

    //add_options_page('WP RSS Images', 'WP RSS Images', 'administrator', 'wp-rss-image', 'wp_rss_image_setting');	
	add_submenu_page('product_menu.php', __("RSS Images"), __("RSS Images"), 8, 'wp-rss-image', 'wp_rss_image_setting');


}







function wp_rss_image_setting() {

     $image_size = get_option('rss_image_size_op');

	 

	 $rss_img_ch = get_option('rss_img_ch_op');

	 $rss2_img_ch = get_option('rss2_img_ch_op');	 

	     

    if(isset($_POST['Submit'])){

	

		$image_size = $_POST["image_size"];

		$rss_img_ch = $_POST["rss_img_ch"];

		$rss2_img_ch = $_POST["rss2_img_ch"];

		

        update_option( 'rss_image_size_op', $_POST["image_size"] );	

		update_option( 'rss_img_ch_op', $_POST["rss_img_ch"] );	

		update_option( 'rss2_img_ch_op', $_POST["rss2_img_ch"] );		

?>

         <div class="updated"><p><strong><?php _e('Options saved.', 'mt_trans_domain' ); ?></strong></p></div>

         

         

<?php  } ?>



<div class="wrap">   



<form method="post" name="options" target="_self">



<h2><?php _e("WP RSS Images Setting") ?></h2>

<h3><?php _e("Select the size of the images") ?></h3>

<p><?php _e("Select your setting for your rss feed images.") ?></p>

<table width="100%" cellpadding="10" class="form-table">



  <tr valign="top">

  	<td width="200" align="right">

  	  <input type="radio" name="image_size" id="radio" value="thumbnail" <?php if ($image_size == 'thumbnail') echo "checked=\"checked\"";?>/>

  	</td>

  	<td align="left" scope="row"><?php _e("Thumbnail (width = 150px)") ?></td>

  </tr>

  <tr valign="top">

  	<td width="200" align="right">

	 <input name="image_size" type="radio" id="radio" value="medium" <?php if (($image_size == 'medium')||($image_size == '')) echo "checked=\"checked\"";?> />

     </td> 

  	<td align="left" scope="row"><?php _e("Medium Size (width = 580px)") ?></td>

  </tr>

  <tr valign="top">

  	<td width="200" align="right">

	 <input type="radio" name="image_size" id="radio" value="full" <?php if ($image_size == 'full') echo "checked=\"checked\"";?>/>

     </td> 

  	<td align="left" scope="row"><?php _e("Full Size (not recommended)") ?></td>

  </tr>

</table>



<h3> <?php _e("Apply to: ") ?></h3>

<table width="100%" cellpadding="10" class="form-table">  

  <tr valign="top">

  	<td width="200" align="right"><input name="rss_img_ch" type="checkbox" value="1" 

	<?php if ($rss_img_ch == 1) echo "checked" ?> /></td>

  	<td align="left" scope="row"><?php _e("RSS") ?>   <a href="<?php echo get_bloginfo('rss_url'); ?> " title="<?php bloginfo('name'); ?> - rss" target="_blank"><?php echo get_bloginfo('rss_url'); ?> </a> </td>

  </tr>

  <tr valign="top">

  	<td width="200" align="right"><input name="rss2_img_ch" type="checkbox" value="1" 

	<?php if ($rss2_img_ch == 1)  echo "checked" ?> /></td>

  	<td align="left" scope="row"><?php _e("RSS 2") ?>    <a href="<?php echo get_bloginfo('rss2_url'); ?> " title="<?php bloginfo('name'); ?> - rss2" target="_blank"><?php echo get_bloginfo('rss2_url'); ?> </a> </td>

  </tr>    

</table>

<p class="submit">

<input type="submit" name="Submit" value="<?php _e("Update") ?>" />

</p>



</form>

</div>



<?php } 
################################# END RSS IMAGES  #########################################
?>