<?php
//wp_deregister_script( 'jquery' );
//wp_enqueue_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js');
wp_enqueue_script('jquery');
wp_enqueue_script('custom', get_bloginfo('template_directory') . '/library/js/custom.js',array('jquery'));



$map_lang='';
if(get_option('ptthemes_map_local')){$map_lang = '&amp;language='.get_option('ptthemes_map_local');} 
wp_enqueue_script('google_maps', 'http://maps.google.com/maps/api/js?sensor=false'.$map_lang,'',NULL);



// PLACE VALIDATION
if($_REQUEST['ptype']=='post_event' || $_REQUEST['ptype']=='post_listing'){
wp_enqueue_script('place_validation', get_bloginfo('template_directory') . '/library/js/place_validation.js','','',true);

// SCRIPT FOR UPLOAD
	wp_enqueue_script('plupload-all');

	//wp_register_script('gtplupload', get_bloginfo('template_directory') . '/library/js/gtupload.js', array('jquery'));
    //wp_enqueue_script('gtplupload');
 	wp_enqueue_script('jquery-ui-sortable');	 
	add_action("wp_head", "gt_plupload_admin_head");
// SCRIPT FOR UPLOAD END

$data = array( 'email_string' => __( 'Please Enter Email Address' ), 
'user_string' => __( 'Please Select if New or Existing User' ), 
'name_string' => __( 'Please Enter Your Name' ), 
'owner_string' => __( 'Please Declare if Owner/Associate' ), 
'title_val_string' => __( 'Please Enter Title' ), 
'desc_val_string' => __( 'Please Enter Description' ), 
'cat_val_string' => __( 'Please select Category' ));
wp_localize_script( 'place_validation', 'gt_local', $data );
}



/*
global $wpdb,$post;
$post_type_js = get_post_type();
if($post_type_js=='place' || $post_type_js=='event' || $_REQUEST['ptype']=='preview' || $_REQUEST['ptype']=='preview_event'){
wp_enqueue_script('post_custom', get_bloginfo('template_directory') . '/library/js/post.custom.js','','',true);
$data = array( 'email_string' => __( 'Please Enter Email Address' ), 
'user_string' => __( 'Please Select if New or Existing User' ), 
'name_string' => __( 'Please Enter Your Name' ), 
'owner_string' => __( 'Please Declare if Owner/Associate' ), 
'title_val_string' => __( 'Please Enter Title' ), 
'desc_val_string' => __( 'Please Enter Description' ),
'valid_email_string' => __( 'Please Enter valid Email Address' ),
'user_comments' => __( 'Please Enter Comments' ),
'user_subject' => __( 'Please Enter Subject' ),
'user_full_name' => __( 'Please Enter Your Full Name' ),
'user_contact_string' => __( 'Please Enter A Valid Contact Number' ),
'user_position_string' => __( 'Please Enter Your Position In The Business' ),
'cat_val_string' => __( 'Please select Category' ));
wp_localize_script( 'post_custom', 'gt_local', $data );
 }
 */
?>