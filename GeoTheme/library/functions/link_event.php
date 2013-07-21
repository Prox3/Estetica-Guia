<?php

################################# LINK EVENT WITH BUSINESS  #########################################

// Hook into WordPress add_meta_boxes action

add_action( 'add_meta_boxes', 'add_Businesses_custom_metabox' );



/**

 * Add meta box function

 */

function add_Businesses_custom_metabox() {

    add_meta_box( 'custom-metabox', __( 'Businesses' ), 'Businesses_custom_metabox', 'event', 'side', 'high' );

}

/**

 * Display the metabox

 */
function Businesses_custom_metabox_app($cuvar,$user_id) {

    global $current_user, $wpdb, $post;

    //get curent user info (we need the ID)

    //get_currentuserinfo();

    //create nonce

    echo '<input type="hidden" name="Businesses_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

    //get saved meta

    $selected = get_post_meta( $post->ID, 'a_businesses', true );

    //create a query for all of the user businesses posts

    //$Businesses_query = new WP_Query();

	if ( $user_id==1 ) { 

################################################

			$post_type = "'place'";

			$blog_cats = get_blog_sub_cats_str('string');

			if($_SESSION['multi_city'])
			{
				$sql = "select p.* from $wpdb->posts p where p.post_type in ($post_type) and p.post_status in ('publish') and p.ID in (select tr.object_id from $wpdb->term_relationships tr join $wpdb->term_taxonomy t on t.term_taxonomy_id=tr.term_taxonomy_id where  t.taxonomy=\"placecategory\" )ORDER BY p.post_title ASC ";
				}else

			{

				$sql = "select p.* from $wpdb->posts p where p.post_type in ($post_type) and p.post_status in ('publish') and p.ID in (select tr.object_id from $wpdb->term_relationships tr join $wpdb->term_taxonomy t on t.term_taxonomy_id=tr.term_taxonomy_id where t.taxonomy=\"placecategory\" )ORDER BY p.post_title ASC ";

			}

			$Businesses_query = $wpdb->get_results($sql);

#######################################################################

	} 

	

	else{

################################################

			$post_type = "'place'";

			$blog_cats = get_blog_sub_cats_str('string');

			if($_SESSION['multi_city'])

			{

				$sql = "select p.* from $wpdb->posts p where p.post_type in ($post_type) and p.post_author='$user_id' and p.post_status in ('publish') and p.ID in (select tr.object_id from $wpdb->term_relationships tr join $wpdb->term_taxonomy t on t.term_taxonomy_id=tr.term_taxonomy_id where t.taxonomy=\"placecategory\" )ORDER BY p.post_title ASC ";
				}else

			{

				$sql = "select p.* from $wpdb->posts p where p.post_type in ($post_type) and p.post_author='$user_id' and p.post_status in ('publish') and p.ID in (select tr.object_id from $wpdb->term_relationships tr join $wpdb->term_taxonomy t on t.term_taxonomy_id=tr.term_taxonomy_id where  t.taxonomy=\"placecategory\" )ORDER BY p.post_title ASC ";

			}

			$Businesses_query = $wpdb->get_results($sql);

#######################################################################

    }

    if ($Businesses_query){

		echo '<li><div class="label">' . A_BUSS . '</div>';

			

        echo '<div class="field"><select name="a_businesses" id="a_businesses" style="margin-left:0px;display:block;" >

        <option value="">'.__('No Business').'</option>'; 

        

        //loop over all post and add them to the select dropdown

		foreach($Businesses_query as $postinfo_obj){

           // $Businesses_query->the_post();

            echo '<option value="'.$postinfo_obj->ID.'" ';

            if ( $postinfo_obj->ID == $cuvar || $postinfo_obj->ID == $selected){

                echo 'selected="selected"';

            }

            echo '>'.$postinfo_obj->post_title .'</option>';

        }

        echo '</select></div></li>';

		

		if($cuvar == ''){

			echo'<li> <div class="label-wide"><input type="button" value="'.__('Fill in Business Details').'" class="button blue" onclick="ob=this.form.a_businesses;window.open(location.href+\'&linkid=\'+ob.options[ob.selectedIndex].value,\'_top\')"></div></li>';}

			//echo '</div></li>';

    }

    //reset the query and the $post to its real value

    wp_reset_query();

   // $post = $real_post;

}


function Businesses_custom_metabox($cuvar) {

    global $current_user, $wpdb, $post;

    //get curent user info (we need the ID)

    get_currentuserinfo();

    //create nonce

    echo '<input type="hidden" name="Businesses_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

    //get saved meta

    $selected = get_post_meta( $post->ID, 'a_businesses', true );

    //create a query for all of the user businesses posts

    //$Businesses_query = new WP_Query();

	if ( current_user_can('manage_options') ) { 

################################################

			$post_type = "'place'";

			$blog_cats = get_blog_sub_cats_str('string');

			if($_SESSION['multi_city'])
			{
				$sql = "select p.* from $wpdb->posts p where p.post_type in ($post_type) and p.post_status in ('publish') and p.ID in (select tr.object_id from $wpdb->term_relationships tr join $wpdb->term_taxonomy t on t.term_taxonomy_id=tr.term_taxonomy_id where  t.taxonomy=\"placecategory\" )ORDER BY p.post_title ASC ";
				}else

			{

				$sql = "select p.* from $wpdb->posts p where p.post_type in ($post_type) and p.post_status in ('publish') and p.ID in (select tr.object_id from $wpdb->term_relationships tr join $wpdb->term_taxonomy t on t.term_taxonomy_id=tr.term_taxonomy_id where t.taxonomy=\"placecategory\" )ORDER BY p.post_title ASC ";

			}

			$Businesses_query = $wpdb->get_results($sql);

#######################################################################

	} 

	

	else{

################################################

			$post_type = "'place'";

			$blog_cats = get_blog_sub_cats_str('string');

			if($_SESSION['multi_city'])

			{

				$sql = "select p.* from $wpdb->posts p where p.post_type in ($post_type) and p.post_author='$current_user->ID' and p.post_status in ('publish') and p.ID in (select tr.object_id from $wpdb->term_relationships tr join $wpdb->term_taxonomy t on t.term_taxonomy_id=tr.term_taxonomy_id where t.taxonomy=\"placecategory\" )ORDER BY p.post_title ASC ";
				}else

			{

				$sql = "select p.* from $wpdb->posts p where p.post_type in ($post_type) and p.post_author='$current_user->ID' and p.post_status in ('publish') and p.ID in (select tr.object_id from $wpdb->term_relationships tr join $wpdb->term_taxonomy t on t.term_taxonomy_id=tr.term_taxonomy_id where  t.taxonomy=\"placecategory\" )ORDER BY p.post_title ASC ";

			}

			$Businesses_query = $wpdb->get_results($sql);

#######################################################################

    }

    if ($Businesses_query){

		echo '<div class="form_row clearfix">

             	<label>' . A_BUSS . '</label>';

			

        echo '<select name="a_businesses" id="a_businesses" style="margin-left:0px;display:block;" >

        <option value="">'.__('No Business').'</option>'; 

        

        //loop over all post and add them to the select dropdown

		foreach($Businesses_query as $postinfo_obj){

           // $Businesses_query->the_post();

            echo '<option value="'.$postinfo_obj->ID.'" ';

            if ( $postinfo_obj->ID == $cuvar || $postinfo_obj->ID == $selected){

                echo 'selected="selected"';

            }

            echo '>'.$postinfo_obj->post_title .'</option>';

        }

        echo '</select>';

		

		if($cuvar == ''){

			echo' <input type="button" value="'.__('Fill in Business Details').'" style="margin-left:0px;display:block;margin-top:3px;" class="b_submit" onclick="ob=this.form.a_businesses;window.open(location.href+\'&linkid=\'+ob.options[ob.selectedIndex].value,\'_top\')">';}

			echo '</div>';

    }

    //reset the query and the $post to its real value

    wp_reset_query();

   // $post = $real_post;

}

//hook to save the post meta

add_action( 'save_post', 'save_Businesses_custom_metabox' );

/**

 * Process the custom metabox fields

 */

function save_Businesses_custom_metabox( $post_id ) {

    global $post;

    // verify nonce

    if (!wp_verify_nonce($_POST['Businesses_meta_box_nonce'], basename(__FILE__))) {

        return $post_id;

    }

    // check autosave

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {

        return $post_id;

    }

    // check permissions

    if ('event' == $_POST['post_type']) {

        if (!current_user_can('edit_page', $post_id)) {

            return $post_id;

        }

    } elseif (!current_user_can('edit_post', $post_id)) {

        return $post_id;

    }



    if( $_POST ) {

        $old = get_post_meta($post_id, 'a_businesses', true);

        $new = $_POST['a_businesses'];

        if ($new && $new != $old){

            update_post_meta($post_id, 'a_businesses', $new);

        }

    }

}

function get_business_events(){

global $post, $wpdb;

$res = $wpdb->get_col("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'a_businesses' AND meta_value='$post->ID' ");

foreach($res as $res_fin){

echo "<li class='post-bus-list post-$res_fin'><a href=".get_permalink($res_fin).">".get_the_title($res_fin)."</a></li>";

}





}



function get_all_spec(){

  global $post, $wpdb;

  	$recent = new WP_Query("meta_key=proprty_feature"); while($recent->have_posts()) : $recent->the_post();



    if(get_post_meta($post->ID, 'proprty_feature', true)){

    $str_to_out .= "<li class='post-bus-list post-$post->ID'><a href=".get_permalink($post->ID).">".get_the_title($post->ID)." </a>".get_post_meta($post->ID, 'proprty_feature', true)."</li>";

    }



		endwhile;

return $str_to_out;

}



function get_business_events_new(){

    global $post, $wpdb;

      $date = date('Y-m-d');

      $sql = "SELECT post_id, meta_value FROM $wpdb->postmeta WHERE meta_key = 'end_date' and meta_value >='$date' and post_id IN (SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'a_businesses' AND meta_value='$post->ID') ORDER BY meta_value DESC LIMIT  5";

        $res = $wpdb->get_results($sql);

      if($res){

        foreach($res as $res_fin){

        $date_old = get_post_meta($res_fin->post_id, 'st_date', true);
		   $time = get_post_meta($res_fin->post_id, 'st_time', true);
		   $date_full = $date_old.','.$time;
           $st_date = date_i18n("F d, Y g:i A", strtotime($date_full));



      $dat_ar = explode('-', $date_old);

      if (strlen($dat_ar[1]) == 1 ){

      $dat_ar[1] = '0'.$dat_ar[1];		

      }

      

      if (strlen($dat_ar[2]) == 1 ){

      $dat_ar[2] = '0'.$dat_ar[2];		

      }

      //get_post_meta($res_fin->post_id, 'st_time', true);

 

      

      $new_date = $dat_ar[1].'/'.$dat_ar[2].'/'.$dat_ar[0].' '.get_post_meta($res_fin->post_id, 'st_time', true);

      $old_date = date($new_date);              // works

      $new_date = date('F d, Y g:i A', strtotime($old_date));

	    

	$page_pub = get_page( $res_fin->post_id );

  if ($page_pub->post_status == 'publish'){

        $str_to_out .= "<li class='post-bus-list post-$res_fin->post_id'><a href=".get_permalink($res_fin->post_id).">".get_the_title($res_fin->post_id)."</a> <p>".$st_date."</p></li>";}

        } 

     }

     if(isset($str_to_out)){return  $str_to_out;}else{return '';}

 } 



function get_business_events_old(){

    global $post, $wpdb;

     $date = date('Y-m-d');

     $sql = "SELECT post_id, meta_value FROM $wpdb->postmeta WHERE meta_key = 'end_date' and meta_value <'$date' and post_id IN (SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'a_businesses' AND meta_value='$post->ID') ORDER BY meta_value DESC LIMIT  5";

    // var_dump($sql);

        $res = $wpdb->get_results($sql);

    //  var_dump($res);   

        foreach($res as $res_fin){

           $date_old = get_post_meta($res_fin->post_id, 'st_date', true);
		   $time = get_post_meta($res_fin->post_id, 'st_time', true);
		   $date_full = $date_old.','.$time;
           $st_date = date_i18n("F d, Y g:i A", strtotime($date_full));



      $dat_ar = explode('-', $date_old);

      if (strlen($dat_ar[1]) == 1 ){

      $dat_ar[1] = '0'.$dat_ar[1];		

      }

      

      if (strlen($dat_ar[2]) == 1 ){

      $dat_ar[2] = '0'.$dat_ar[2];		

      }

      $new_date = $dat_ar[1].'/'.$dat_ar[2].'/'.$dat_ar[0].' '.get_post_meta($res_fin->post_id, 'st_time', true);

      $old_date = date($new_date);              // works

      $new_date = date('F d, Y g:i A', strtotime($old_date));

      

      $page_pub = get_page( $res_fin->post_id );

  if ($page_pub->post_status == 'publish'){

        $str_to_out .= "<ul><li class='post-bus-list post-$res_fin->post_id'><a href='".get_permalink($res_fin->post_id)."'>".get_the_title($res_fin->post_id)."</a><p>".$st_date."</p></li></ul>";}

        } 

     if(isset($str_to_out)){return  $str_to_out;}else{return '';}

 }  



function get_event_place(){
    global $post, $wpdb;
	$venue_ID = get_post_meta($post->ID, 'a_businesses', true);
	if($venue_ID){
	$venue_add = get_post_meta($venue_ID, 'address', true);
	return "<ul><li class='post-bus-list post-$venue_ID'><a href='".get_permalink($venue_ID)."'>".get_the_title($venue_ID)."</a><p>".$venue_add."</p></li></ul>";
	}

}

################################# END LINK EVENT WITH BUSINESS  #########################################

?>