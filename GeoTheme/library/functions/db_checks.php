<?php
#########################################################
### CHECK BLOGS POSTS FOR CITY ID #######################
#########################################################
function tool_blog_chk(){
global $wpdb,$table_prefix;
$blog_lost = $wpdb->get_results("SELECT ID FROM $wpdb->posts WHERE post_type='post' AND post_status='publish' AND ID NOT IN(SELECT $wpdb->posts.ID FROM $wpdb->posts join $wpdb->postmeta on $wpdb->postmeta.post_id=$wpdb->posts.ID WHERE $wpdb->posts.post_type='post' AND $wpdb->posts.post_status='publish' AND $wpdb->postmeta.meta_key='post_city_id') GROUP BY ID");
$i=0;
foreach($blog_lost as $lost){
$i++;	
}
?>
<div class="updated fade below-h2" id="message" style="background-color:<?php if($i){echo '#FFA6A6';}else{echo '#95FF95';}?>;" >
 <p><?php if($i){echo $i; _e(' blog posts without a city ID'); ?> <button onClick='window.location.href="<?php echo site_url().'/wp-admin/admin.php?page=gt_tools&tool=blog_convert'?>"' title="Run" class="button-secondary action" >FIX</button><?php }else{ _e('Blog posts all have a city ID');}?></p>
 </div>
 <br />
 <?php
}
#########################################################
### CONVERT BLOGS POSTS FOR CITY ID #######################
#########################################################
function tool_blog_convert(){
global $wpdb,$table_prefix;
$blog_lost = $wpdb->get_results("SELECT ID FROM $wpdb->posts WHERE post_type='post' AND post_status='publish' AND ID NOT IN(SELECT $wpdb->posts.ID FROM $wpdb->posts join $wpdb->postmeta on $wpdb->postmeta.post_id=$wpdb->posts.ID WHERE $wpdb->posts.post_type='post' AND $wpdb->posts.post_status='publish' AND $wpdb->postmeta.meta_key='post_city_id') GROUP BY ID");
$i=0;
foreach($blog_lost as $lost){
	update_post_meta($lost->ID, 'post_city_id', 0);
$i++;	
}
?>
<div class="updated fade below-h2" id="message" style="background-color: rgb(255, 251, 204);" >
 <p><?php if($i){echo $i; _e(' blog posts converted.');}else{ _e('No blog posts converted.');}?></p>
 </div>
 <br />
 <?php
}
#########################################################
### CHECK CITY DATABASE #################################
#########################################################
function chk_city_db(){
global $wpdb,$multicity_db_table_name;
$loc_arr = $wpdb->get_results("SELECT * FROM $multicity_db_table_name");
$i=0;
$err='';
$use_default = get_option('ptthemes_map_set_default');
foreach($loc_arr as $loc){
if($loc->city_id==''){$err .= __('<p>Cities with no ID</p>');}
if($loc->cityname==''){$err .= '<p>City id: '.$loc->city_id.' has no name</p>';}
if($loc->lat==''){$err .= '<p>City id: '.$loc->city_id.' has no lat</p>';}
if($loc->lng==''){$err .= '<p>City id: '.$loc->city_id.' has no lng</p>';}
if($loc->scall_factor==''){$err .= '<p>City id: '.$loc->city_id.' has no scall_factor</p>';}
if($loc->is_zoom_home==''){$err .= '<p>City id: '.$loc->city_id.' has no zoom factor</p>';}
if($loc->city_slug==''){$err .= '<p>City id: '.$loc->city_id.' has no slug name</p>';}

if($use_default){
	if($loc->is_default=='1'){
		if($loc->categories==''){$err .= '<p>City id: '.$loc->city_id.' has no categories selected.</p>';}
		}
}
else{if($loc->categories==''){$err .= '<p>City id: '.$loc->city_id.' has no categories selected.</p>';}}

$i++;	
}
?>
<div class="updated fade below-h2" id="message" style="background-color:<?php if($err){echo '#FFA6A6';}else{echo '#95FF95';}?>;" >
 <p><?php echo $i; _e(' Cities checked');?></p>
<?php echo $err; ?>
 </div>
 <br />
 <?php
}

#########################################################
### CHECK COUNTRY DATABASE ##############################
#########################################################
function chk_country_db(){
global $wpdb,$multicountry_db_table_name;
$loc_arr = $wpdb->get_results("SELECT * FROM $multicountry_db_table_name");
$i=0;
$err='';
foreach($loc_arr as $loc){
if($loc->country_id==''){$err .= __('<p>Countries with no ID</p>');}
if($loc->countryname==''){$err .= '<p>Country id: '.$loc->country_id.' has no name</p>';}
if($loc->lat==''){$err .= '<p>Country id: '.$loc->country_id.' has no lat</p>';}
if($loc->lng==''){$err .= '<p>Country id: '.$loc->country_id.' has no lng</p>';}
if($loc->scall_factor==''){$err .= '<p>Country id: '.$loc->country_id.' has no scall_factor</p>';}
if($loc->is_zoom_home==''){$err .= '<p>Country id: '.$loc->country_id.' has no zoom factor</p>';}
if($loc->country_slug==''){$err .= '<p>Country id: '.$loc->country_id.' has no slug name</p>';}
$i++;	
}
?>
<div class="updated fade below-h2" id="message" style="background-color:<?php if($err){echo '#FFA6A6';}else{echo '#95FF95';}?>;" >
 <p><?php echo $i; _e(' Countries checked');?></p>
<?php echo $err; ?>
 </div>
 <br />
 <?php
}

#########################################################
### CHECK REGION DATABASE ###############################
#########################################################
function chk_region_db(){
global $wpdb,$multiregion_db_table_name;
$loc_arr = $wpdb->get_results("SELECT * FROM $multiregion_db_table_name");
$i=0;
$err='';
foreach($loc_arr as $loc){
if($loc->region_id==''){$err .= __('<p>Regions with no ID</p>');}
if($loc->regionname==''){$err .= '<p>Region id: '.$loc->region_id.' has no name</p>';}
if($loc->lat==''){$err .= '<p>Region id: '.$loc->region_id.' has no lat</p>';}
if($loc->lng==''){$err .= '<p>Region id: '.$loc->region_id.' has no lng</p>';}
if($loc->scall_factor==''){$err .= '<p>Region id: '.$loc->region_id.' has no scall_factor</p>';}
if($loc->is_zoom_home==''){$err .= '<p>Region id: '.$loc->region_id.' has no zoom factor</p>';}
if($loc->region_slug==''){$err .= '<p>Region id: '.$loc->region_id.' has no slug name</p>';}
$i++;	
}
?>
<div class="updated fade below-h2" id="message" style="background-color:<?php if($err){echo '#FFA6A6';}else{echo '#95FF95';}?>;" >
 <p><?php echo $i; _e(' Regions checked');?></p>
<?php echo $err; ?>
 </div>
 <br />
 <?php
}

#########################################################
### CHECK HOODS DATABASE ################################
#########################################################
function chk_hood_db(){
global $wpdb,$multihood_db_table_name;
$loc_arr = $wpdb->get_results("SELECT * FROM $multihood_db_table_name");
$i=0;
$err='';
foreach($loc_arr as $loc){
if($loc->hood_id==''){$err .= __('<p>Neighbourhoods with no ID</p>');}
if($loc->hoodname==''){$err .= '<p>Neighbourhood id: '.$loc->hood_id.' has no name</p>';}
if($loc->lat==''){$err .= '<p>Neighbourhood id: '.$loc->hood_id.' has no lat</p>';}
if($loc->lng==''){$err .= '<p>Neighbourhood id: '.$loc->hood_id.' has no lng</p>';}
if($loc->scall_factor==''){$err .= '<p>Neighbourhood id: '.$loc->hood_id.' has no scall_factor</p>';}
if($loc->is_zoom_home==''){$err .= '<p>Neighbourhood id: '.$loc->hood_id.' has no zoom factor</p>';}
if($loc->hood_slug==''){$err .= '<p>Neighbourhood id: '.$loc->hood_id.' has no slug name</p>';}
$i++;	
}
?>
<div class="updated fade below-h2" id="message" style="background-color:<?php if($err){echo '#FFA6A6';}else{echo '#95FF95';}?>;" >
 <p><?php echo $i; _e(' Neighbourhoods checked');?></p>
<?php echo $err; ?>
 </div>
 <br />
 <?php
}


#########################################################
### FIX PRICE DATABASE ################################
#########################################################
function fix_price_db(){
global $wpdb,$price_db_table_name;
$wpdb->get_results("DROP TABLE $price_db_table_name");
geotheme_activation_setup();
?>
<div class="updated fade below-h2" id="message" style="background-color:<?php echo '#95FF95';?>;" >
 <p><?php  _e(' Price table fixed'); echo $price_db_table_name;?></p>
 </div>
 <br />
 <?php
}

#########################################################
### CHECK PRICE DATABASE ################################
#########################################################
function chk_price_db(){
global $wpdb,$price_db_table_name;
$err='';
if($wpdb->get_var("SHOW TABLES LIKE \"$price_db_table_name\"") != $price_db_table_name){$err .= __('<p>Price DB Table does not exist.</p>');}
$price_col = $wpdb->get_results("SHOW COLUMNS FROM $price_db_table_name LIKE 'lat_lng'");
if($price_col[0]->Field=='lat_lng'){}else{$err .= __('<p>Price DB Table looks to be corrupt or not compleat.</p>');}

?>
<div class="updated fade below-h2" id="message" style="background-color:<?php if($err){echo '#FFA6A6';}else{echo '#95FF95';}?>;" >
 <p><?php _e('Price DB checked');?></p>
<?php echo $err; if($err){_e('You may wish to run the tool to drop and re-add the price DB table.');}?>
 </div>
 <br />
 <?php
}


#########################################################
### FIX IMAGE ATTACHMENTS ###############################
#########################################################
function fix_images(){
global $wpdb,$price_db_table_name;
$wpdb->query("UPDATE $wpdb->posts SET post_status='inherit' WHERE post_status='attachment'");
?>
<div class="updated fade below-h2" id="message" style="background-color:<?php echo '#95FF95';?>;" >
 <p><?php  _e('Image attachments fixed');?></p>
 </div>
 <br />
 <?php
}


#########################################################
### CHECK SESSIONS CAN SAVE #############################
#########################################################
function gt_chk_sessions(){
// Set error reporting to display all errors and notices
$err='';
$result='';
// Check for the existence of a known session variable
if ( $_SESSION['test_value'] ) {
  $result .= 'Found a session';
} else {
	$err=true;
  $result .= 'No session exists - writing to test_value, refresh to check.';
  $_SESSION['test_value'] = true;
}
// Close and write session
$foldername = session_save_path();
if (is_writable($foldername)) {
    $result .= '<br>The Sessions folder is writable '.$foldername;
} else {
	$err=true;
    $result .= '<br>The Sessions folder is not writable: '.$foldername;
	//chmod($foldername, 0777);
}
?>
<div class="updated fade below-h2" id="message" style="background-color:<?php if($err){echo '#FFA6A6';}else{echo '#95FF95';}?>;" >
 <p><?php  _e('Sessions Checks');?></p>
 <p><?php  echo $result;?></p>
 
 </div>
 <br />
<?php
}

#########################################################
### CHECK NOTIFICATIONS AVE SAVED #######################
#########################################################
function gt_chk_notifications(){
global $wpdb;
if(get_option('post_payment_fail_admin_email_subject')){$err='';}else{$err = __('<p>Notifications page not saved, please go to the notificatiosn page and save it.</p>');}
?>
<div class="updated fade below-h2" id="message" style="background-color:<?php if($err){echo '#FFA6A6';}else{echo '#95FF95';}?>;" >
 <p><?php  if($err){ echo $err;}else{_e('Notifications saved ok');}?></p>
 </div>
 <br />
 <?php
}

#########################################################
### CHECK THEME IN CORRECT FOLDER #######################
#########################################################
function gt_chk_folder(){
global $wpdb, $ct_on;
$err ='';
if (file_exists(get_template_directory().'/style.css')){}else{$err .= __('<p>Main Theme is in an extra level of folder, please check via FTP and fix.</p>');}
if($ct_on){
if (file_exists(get_stylesheet_directory().'/style.css')){}else{$err .= __('<p>Child Theme is in an extra level of folder, please check via FTP and fix.</p>');}
}
?>
<div class="updated fade below-h2" id="message" style="background-color:<?php if($err){echo '#FFA6A6';}else{echo '#95FF95';}?>;" >
 <p><?php  if($err){ echo $err;}else{_e('Theme in correct folder.');}?></p>
 </div>
 <br />
 <?php
}

#########################################################
### CHECK FOR DOUBLE POST META ##########################
#########################################################
function gt_chk_double_meta(){
global $wpdb;
$double_arr = $wpdb->query("select * from $wpdb->postmeta where meta_id in (select * from (select meta_id from $wpdb->postmeta a where a.meta_key = 'is_featured' and meta_id not in ( select min(meta_id) from $wpdb->postmeta b where b.post_id = a.post_id and b.meta_key = 'is_featured')) as x)");
if($double_arr){$err = __('<p>Duplicate post meta detected, please run the double featured fix tool</p>');}else{$err='';}
?>
<div class="updated fade below-h2" id="message" style="background-color:<?php if($err){echo '#FFA6A6';}else{echo '#95FF95';}?>;" >
 <p><?php  if($err){ echo $err;}else{_e('No duplicates found');}?></p>
 </div>
 <br />
 <?php
}

#########################################################
### FIX DOUBLE POST META ################################
#########################################################
function fix_double_featured(){
global $wpdb,$price_db_table_name;
$wpdb->query("DELETE from $wpdb->postmeta where meta_id in (select * from (select meta_id from $wpdb->postmeta a where a.meta_key = 'is_featured' and meta_id not in ( select min(meta_id) from $wpdb->postmeta b where b.post_id = a.post_id and b.meta_key = 'is_featured')) as x)");
?>
<div class="updated fade below-h2" id="message" style="background-color:<?php echo '#95FF95';?>;" >
 <p><?php  _e('Double featured meta fixed');?></p>
 </div>
 <br />
 <?php
}


#########################################################
### CHECK PLACE AND EVENTS CHECK FOR CITY ID ############
#########################################################
function chk_city_ID(){
global $wpdb,$table_prefix;
$err='';
$blog_lost = $wpdb->get_results("SELECT ID, post_type FROM $wpdb->posts WHERE post_type IN ('place','event')  AND post_status='publish' AND ID NOT IN(SELECT $wpdb->posts.ID FROM $wpdb->posts join $wpdb->postmeta on $wpdb->postmeta.post_id=$wpdb->posts.ID WHERE $wpdb->posts.post_type IN ('place','event') AND $wpdb->posts.post_status='publish' AND $wpdb->postmeta.meta_key='post_city_id') GROUP BY ID");
$i=0;
foreach($blog_lost as $lost){
//print_r($lost);
$err .= '<p><a href="'.admin_url( "post.php?post=$lost->ID&action=edit").'">ID: '.$lost->ID.'</a></p>';
$i++;	
}
?>
<div class="updated fade below-h2" id="message" style="background-color:<?php if($i){echo '#FFA6A6';}else{echo '#95FF95';}?>;" >
 <p><?php if($i){echo $i; _e(' places or events without a city ID'); echo $err;}else{ _e('Places and Events all have a city ID');}?></p>
 </div>
 <br />
 <?php
}


#########################################################
### CHECK PLACE AND EVENTS CHECK FOR PRICE ID ###########
#########################################################
function chk_price_ID(){
global $wpdb,$table_prefix;
$err='';
$blog_lost = $wpdb->get_results("SELECT ID, post_type FROM $wpdb->posts WHERE post_type IN ('place','event')  AND post_status='publish' AND ID NOT IN(SELECT $wpdb->posts.ID FROM $wpdb->posts join $wpdb->postmeta on $wpdb->postmeta.post_id=$wpdb->posts.ID WHERE $wpdb->posts.post_type IN ('place','event') AND $wpdb->posts.post_status='publish' AND $wpdb->postmeta.meta_key='package_pid') GROUP BY ID");
$i=0;
foreach($blog_lost as $lost){
//print_r($lost);
$err .= '<p><a href="'.admin_url( "post.php?post=$lost->ID&action=edit").'">ID: '.$lost->ID.'</a></p>';
$i++;	
}
?>
<div class="updated fade below-h2" id="message" style="background-color:<?php if($i){echo '#FFA6A6';}else{echo '#95FF95';}?>;" >
 <p><?php if($i){echo $i; _e(' places or events without a price package ID'); echo $err;}else{ _e('Places and Events all have a price package ID');}?></p>
 </div>
 <br />
 <?php
}

#########################################################
### CHECK UPLOAD FOLDER IS WRITABLE #####################
#########################################################
function gt_chk_upload(){
	global $wpdb;
$err='';
$foldername = wp_upload_dir();
if (is_writable($foldername['path'])) {
    $result .= 'Upload folder is writable: '.$foldername['path'];
} else {
	$err=true;
    $result .= 'Upload folder is not writable: '.$foldername['path'];
}
?>
<div class="updated fade below-h2" id="message" style="background-color:<?php if($err){echo '#FFA6A6';}else{echo '#95FF95';}?>;" >
 <p><?php  echo $result;?></p>
 </div>
 <br />
<?php
}

#########################################################
### CHECK PERMALINKS ARE SAVED ##########################
#########################################################
function gt_chk_permalinks(){
	global $wpdb;
$err='';
$place_cat_pre = get_option('place_cat_pre');
$event_cat_pre = get_option('event_cat_pre');
$place_link = get_option('place_link');

if($place_link==''){  $result .= '<p>GeoTheme Permalinks not saved from general settings page.</p>'; $err=true;}
if($place_cat_pre==''){  $result .= '<p>GeoTheme Place category prefix not saved from general settings page</p>'; $err=true;}
if($event_cat_pre==''){  $result .= '<p>GeoTheme Event category prefix not saved from general settings page</p>'; $err=true;}

?>
<div class="updated fade below-h2" id="message" style="background-color:<?php if($err){echo '#FFA6A6';}else{echo '#95FF95';}?>;" >
 <?php  if($result){echo $result;}else{ echo '<p>GeoTheme Permalinks look ok</p>';}?>
 </div>
 <br />
<?php
}