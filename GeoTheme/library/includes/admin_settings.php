<?php
global $wpdb;
if($_POST)
{
	$option_value['currency'] = $_POST['currency'];
	$option_value['currencysym'] = $_POST['currencysym']; 
	$option_value['site_email'] = $_POST['site_email'];
	$option_value['site_email_name'] = $_POST['site_email_name']; 
	//$option_value['is_user_addevent'] = $_POST['is_user_addevent'];	
	$option_value['list_type_title1'] = $_POST['list_type_title1'];
	$option_value['list_type_price1'] = $_POST['list_type_price1'];
	$option_value['list_type_days1'] = $_POST['list_type_days1'];
	$option_value['list_type_days_type1'] = $_POST['list_type_days_type1'];
	$option_value['list_type_feature1'] = $_POST['list_type_feature1'];
	$option_value['list_type_title2'] = $_POST['list_type_title2'];
	$option_value['list_type_price2'] = $_POST['list_type_price2'];
	$option_value['list_type_days2'] = $_POST['list_type_days2'];
	$option_value['list_type_days_type2'] = $_POST['list_type_days_type2'];
	$option_value['list_type_feature2'] = $_POST['list_type_feature2'];	
	//$option_value['approve_status'] = $_POST['approve_status'];	
	$option_value['is_allow_user_add'] = $_POST['is_allow_user_add'];
	$option_value['is_allow_ssl'] = $_POST['is_allow_ssl'];
	$option_value['is_allow_user'] = $_POST['is_allow_user'];
	$option_value['claim_listing'] = $_POST['claim_listing'];
	$option_value['auto_claim'] = $_POST['auto_claim'];
	$option_value['show_owner_verified'] = $_POST['show_owner_verified'];
	$option_value['claim_event'] = $_POST['claim_event'];
	$option_value['author_link'] = $_POST['author_link'];
	$option_value['ga_id'] = $_POST['ga_id'];
	$option_value['ga_stats'] = $_POST['ga_stats'];
	$option_value['ga_user'] = $_POST['ga_user'];
	if($_POST['ga_pass']!='hidden'){$option_value['ga_pass'] = $_POST['ga_pass'];}
	$option_value['search_dist'] = $_POST['search_dist'];
	$option_value['search_dist_1'] = $_POST['search_dist_1'];
	$option_value['search_dist_2'] = $_POST['search_dist_2'];
	$option_value['advanced_near_search'] = $_POST['advanced_near_search'];
	$option_value['search_near_add'] = $_POST['search_near_add'];
	$option_value['user_near'] = $_POST['user_near'];
	$option_value['user_near_search'] = $_POST['user_near_search'];
	if(!$_POST['place_cat_pre']){$_POST['place_cat_pre']='placecategory';}
	$option_value['place_cat_pre'] = trim($_POST['place_cat_pre']);
	if(!$_POST['event_cat_pre']){$_POST['event_cat_pre']='eventcategory';}
	$option_value['event_cat_pre'] = trim($_POST['event_cat_pre']);
	$option_value['place_link'] = trim($_POST['place_link']);
	$option_value['gt_update'] = $_POST['gt_update'];
	$option_value['gt_security'] = $_POST['gt_security'];
	$option_value['gt_docs'] = $_POST['gt_docs'];
	$option_value['cat_link_locations'] = $_POST['cat_link_locations'];
	$option_value['gt_show_app_page'] = $_POST['gt_show_app_page'];
	$message = "Updated Succesfully.";
	foreach($option_value as $key=>$val)
	{
		if($key){
		update_option($key,$val);	
		}
	}
}
if(get_option('currency')=='')
{
	$paymethodinfo = array(
						"currency"		=> 'USD',
						"currencysym"	=> '$',
						"site_email"	=> get_option('admin_email'),
						"site_email_name"=>	get_option('blogname'),
						//"is_user_addevent"		=>	"1",
						"list_type_title1"	=>	"Free",
						"list_type_price1"	=>	"0.00",
						"list_type_days1"	=>	"30",
						"list_type_feature1"	=>	"0",						
						"list_type_days_type1"	=>	"days",
						"list_type_title2"	=>	"Featured",
						"list_type_price2"	=>	"30.00",
						"list_type_days2"	=>	"90",
						"list_type_days_type2"	=>	"days",
						"list_type_feature2"	=>	"1",
						//"approve_status"	=>	"publish",
						"is_allow_ssl"		=>	"0",
						"is_allow_user"		=>	"0",
						"claim_listing"		=>	"0",
						"auto_claim"		=>	"0",
						"show_owner_verified"		=>	"0",
						"claim_event"		=>	"0",
						"author_link"		=>	"0",
						"ga_id"		=>	"", 
						"ga_stats"		=>	"0", 
						"user_near"		=>	"0", 
						"user_near_search"	=>	"1", 
						"place_link"		=>	"/city/%place%", 
						"gt_update"		=>	"1", 
						"gt_security"		=>	"1", 
						"gt_docs"		=>	"1",
						"cat_link_locations"		=>	"0",
						"gt_show_app_page"		=>	"0",
						"advanced_near_search"	=>	"1",
						);
	foreach($paymethodinfo as $key=>$val)
	{
		if($key){
		update_option($key,$val);	
		}
	}
}

//$cartsql = "select * from $wpdb->options where option_name like 'mysite_general_settings'";
//$cartinfo = $wpdb->get_results($cartsql);
if(1)
{	
	$currency = stripslashes(get_option('currency'));
	$currencysym = stripslashes(get_option('currencysym'));
	$site_email = stripslashes(get_option('site_email'));
	$site_email_name = stripslashes(get_option('site_email_name'));
	$area_unit = stripslashes(get_option('area_unit'));
	//$is_user_addevent = stripslashes(get_option('is_user_addevent'));
	
	$list_type_title1 = stripslashes(get_option('list_type_title1'));
	$list_type_price1 = stripslashes(get_option('list_type_price1'));
	$list_type_days1 = stripslashes(get_option('list_type_days1'));
	$list_type_days_type1 = stripslashes(get_option('list_type_days_type1'));
	$list_type_feature1 = stripslashes(get_option('list_type_feature1'));
	$list_type_title2 = stripslashes(get_option('list_type_title2'));
	$list_type_price2 = stripslashes(get_option('list_type_price2'));
	$list_type_days2 = stripslashes(get_option('list_type_days2'));
	$list_type_days_type2 = stripslashes(get_option('list_type_days_type2'));
	$list_type_feature2 = stripslashes(get_option('list_type_feature2'));
	$approve_status = stripslashes(get_option('approve_status'));
	$related_property = stripslashes(get_option('related_property'));
	$area_srch_setting = stripslashes(get_option('area_srch_setting'));
	$price_srch_setting = stripslashes(get_option('price_srch_setting'));
	$is_allow_user_add = stripslashes(get_option('is_allow_user_add'));
	$max_bathrooms = stripslashes(get_option('max_bathrooms'));
	$max_bedrooms = stripslashes(get_option('max_bedrooms'));
	$location_srch_setting = stripslashes(get_option('location_srch_setting'));
	$is_allow_ssl = stripslashes(get_option('is_allow_ssl'));
	$is_allow_user = stripslashes(get_option('is_allow_user'));
	$claim_listing = stripslashes(get_option('claim_listing'));
	$auto_claim = stripslashes(get_option('auto_claim'));
	$show_owner_verified = stripslashes(get_option('show_owner_verified'));
	$claim_event = stripslashes(get_option('claim_event'));
	$author_link = stripslashes(get_option('author_link'));
	$ga_id = stripslashes(get_option('ga_id'));
	$ga_stats = stripslashes(get_option('ga_stats'));
	$ga_user = stripslashes(get_option('ga_user'));
	$ga_pass = stripslashes(get_option('ga_pass'));
	$search_dist = stripslashes(get_option('search_dist'));
	$search_dist_1 = stripslashes(get_option('search_dist_1'));
	$search_dist_2 = stripslashes(get_option('search_dist_2'));
	$advanced_near_search = stripslashes(get_option('advanced_near_search'));
	$search_near_add = stripslashes(get_option('search_near_add'));
	$user_near = stripslashes(get_option('user_near'));
	$user_near_search = stripslashes(get_option('user_near_search'));
	$place_cat_pre = stripslashes(get_option('place_cat_pre'));
	$event_cat_pre = stripslashes(get_option('event_cat_pre'));
	$place_link = stripslashes(get_option('place_link'));
	$gt_update = stripslashes(get_option('gt_update'));
	$gt_security = stripslashes(get_option('gt_security'));
	$gt_docs = stripslashes(get_option('gt_docs'));
	$cat_link_locations = stripslashes(get_option('cat_link_locations'));
	$gt_show_app_page = stripslashes(get_option('gt_show_app_page'));
	 
}
?>

<form action="<?php echo site_url();?>/wp-admin/admin.php?page=product_menu.php" method="post">
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
  <h2><?php _e('General Settings');?></h2>
  <?php if($message){?>
  <div class="updated fade below-h2" id="message" style="background-color: rgb(255, 251, 204);" >
    <p><?php _e($message);?> </p>
    <p><strong>Your page will update in 3 seconds to refresh your permalinks</strong></p>
    <?php if($_POST['place_link']){echo '<meta http-equiv="Refresh" content="3">';} ?>
  </div>
  <?php }?>
  <table style=" width:50%;"  cellpadding="5" class="widefat post fixed" >
    <thead>
      <tr>
        <td width="40%"><?php _e('Sender (Name that will be shown as email sender when users receive emails from this site)');?></td>
        <td width="71%"><input type="text" name="site_email_name" value="<?php echo $site_email_name;?>" /></td>
      </tr>
      <tr>
        <td><?php _e('Email Address (emails to users will be sent via this mail ID)');?></td>
        <td><input type="text" name="site_email" value="<?php echo $site_email;?>" /></td>
      </tr>
      <tr>
        <td><?php _e('Default Currency (Ex.: USD)');?></td>
        <td><input type="text" name="currency" value="<?php echo $currency;?>" /></td>
      </tr>
      <tr>
        <td><?php _e('Default Currency Symbol (Ex.: $)');?></td>
        <td><input type="text" name="currencysym" value="<?php echo $currencysym;?>" /></td>
      </tr>
	   <tr>
        <td><?php _e('Use HTTPS when clicking on Submit');?></td>
        <td><input type="radio" name="is_allow_ssl" <?php if($is_allow_ssl=='1'){ echo 'checked="checked"';}?>  value="1" /> <?php _e('Yes');?>  <input type="radio" name="is_allow_ssl" <?php if($is_allow_ssl=='0'){ echo 'checked="checked"';}?> value="0" /> <?php _e('No');?></td>
      </tr>
<!-- ########################################## Edit by stiofan hebtech.co.uk ##################################### -->
      <tr>
        <td><?php _e('Allow user to see wp-admin area');?></td>
        <td><input type="radio" name="is_allow_user" <?php if($is_allow_user=='1'){ echo 'checked="checked"';}?>  value="1" /> <?php _e('Yes');?>  <input type="radio" name="is_allow_user" <?php if($is_allow_user=='0'){ echo 'checked="checked"';}?> value="0" /> <?php _e('No');?></td>
      </tr>
<!-- ########################################## End Edit by stiofan hebtech.co.uk ##################################### -->
<!-- ########################################## Edit by stiofan hebtech.co.uk ##################################### -->
      <tr>
        <td><?php _e('Enable claim listing?');?></td>
        <td><input type="radio" name="claim_listing" <?php if($claim_listing=='1'){ echo 'checked="checked"';}?>  value="1" /> <?php _e('Yes');?>  <input type="radio" name="claim_listing" <?php if($claim_listing=='0'){ echo 'checked="checked"';}?> value="0" /> <?php _e('No');?></td>
      </tr>
<!-- ########################################## End Edit by stiofan hebtech.co.uk ##################################### -->
<!-- ########################################## Edit by stiofan hebtech.co.uk ##################################### -->
      <tr>
        <td><?php _e('Auto approve claim listing?(email verification)');?></td>
        <td><input type="radio" name="auto_claim" <?php if($auto_claim=='1'){ echo 'checked="checked"';}?>  value="1" /> <?php _e('Yes');?>  <input type="radio" name="auto_claim" <?php if($auto_claim=='0'){ echo 'checked="checked"';}?> value="0" /> <?php _e('No');?></td>
      </tr>
<!-- ########################################## End Edit by stiofan hebtech.co.uk ##################################### -->
<!-- ########################################## Edit by stiofan hebtech.co.uk ##################################### -->
      <tr>
        <td><?php _e('Show owner verified text on listings?');?></td>
        <td><input type="radio" name="show_owner_verified" <?php if($show_owner_verified=='1'){ echo 'checked="checked"';}?>  value="1" /> <?php _e('Yes');?>  <input type="radio" name="show_owner_verified" <?php if($show_owner_verified=='0'){ echo 'checked="checked"';}?> value="0" /> <?php _e('No');?></td>
      </tr>
<!-- ########################################## End Edit by stiofan hebtech.co.uk ##################################### -->
<!-- ########################################## Edit by stiofan hebtech.co.uk ##################################### -->
      <tr>
        <td><?php _e('Show claim listing info on events?');?></td>
        <td><input type="radio" name="claim_event" <?php if($claim_event=='1'){ echo 'checked="checked"';}?>  value="1" /> <?php _e('Yes');?>  <input type="radio" name="claim_event" <?php if($claim_event=='0'){ echo 'checked="checked"';}?> value="0" /> <?php _e('No');?></td>
      </tr>
<!-- ########################################## End Edit by stiofan hebtech.co.uk ##################################### -->
<!-- ########################################## Edit by stiofan hebtech.co.uk ##################################### -->
      <tr>
        <td><?php _e('Show link to author page on listings?');?></td>
        <td><input type="radio" name="author_link" <?php if($author_link=='1'){ echo 'checked="checked"';}?>  value="1" /> <?php _e('Yes');?>  <input type="radio" name="author_link" <?php if($author_link=='0'){ echo 'checked="checked"';}?> value="0" /> <?php _e('No');?></td>
      </tr>
<!-- ########################################## End Edit by stiofan hebtech.co.uk ##################################### -->
<!-- ########################################## Edit by stiofan hebtech.co.uk ##################################### -->
      <tr>
        <td><?php _e('Enable Geo-locate user to nearest city?');?></td>
        <td><input type="radio" name="user_near" <?php if($user_near=='1'){ echo 'checked="checked"';}?>  value="1" /> <?php _e('Yes');?>  <input type="radio" name="user_near" <?php if($user_near=='0'){ echo 'checked="checked"';}?> value="0" /> <?php _e('No');?></td>
      </tr>
<!-- ########################################## End Edit by stiofan hebtech.co.uk ##################################### -->
<!-- ########################################## Edit by stiofan hebtech.co.uk ##################################### -->
      <tr>
        <td><?php _e('Enable Geo-locate user on search?');?></td>
        <td><input type="radio" name="user_near_search" <?php if($user_near_search=='1'){ echo 'checked="checked"';}?>  value="1" /> <?php _e('Yes');?>  <input type="radio" name="user_near_search" <?php if($user_near_search=='0'){ echo 'checked="checked"';}?> value="0" /> <?php _e('No');?></td>
      </tr>
<!-- ########################################## End Edit by stiofan hebtech.co.uk ##################################### -->
<tr>
        <td><b><?php _e('Google Analytic Settings');?></b></td>
        <td>&nbsp;</td>
        </tr>
<!-- ########################################## Edit by stiofan hebtech.co.uk ##################################### -->
      <tr>
        <td><?php _e('Google Analytics "Profile ID(ie: ga:12345678)?');?> <a href="http://www.geotheme.com/support-forum/geotheme-support-forum-group1/documentation-forum5/general-settings-thread16/" target="_blank"><?php _e('help'); ?></a></td>
        <td><input type="text" name="ga_id" value="<?php echo $ga_id;?>" /></td>
      </tr>
<!-- ########################################## End Edit by stiofan hebtech.co.uk ##################################### -->
<!-- ########################################## Edit by stiofan hebtech.co.uk ##################################### -->
      <tr>
        <td><?php _e('Show business owner Google Analytics stats?');?></td>
        <td><input type="radio" name="ga_stats" <?php if($ga_stats=='1'){ echo 'checked="checked"';}?>  value="1" /> <?php _e('Yes');?>  <input type="radio" name="ga_stats" <?php if($ga_stats=='0'){ echo 'checked="checked"';}?> value="0" /> <?php _e('No');?></td>
      </tr>
<!-- ########################################## End Edit by stiofan hebtech.co.uk ##################################### -->
<!-- ########################################## Edit by stiofan hebtech.co.uk ##################################### -->
      <tr>
        <td><?php _e('Google Analytics Username for Api?');?></td>
                <td><input type="text" name="ga_user" value="<?php echo $ga_user;?>" /></td>

      </tr>
<!-- ########################################## End Edit by stiofan hebtech.co.uk ##################################### -->
<!-- ########################################## Edit by stiofan hebtech.co.uk ##################################### -->
      <tr>
        <td><?php _e('Google Analytics Password for Api?');?></td>
                <td><input type="password" name="ga_pass" value="hidden" /></td>
      </tr>
<!-- ########################################## End Edit by stiofan hebtech.co.uk ##################################### -->
<!-- ########################################## Edit by stiofan hebtech.co.uk ##################################### -->
      <tr>
        <td><b><?php _e('Search Settings');?></b></td>
        <td>&nbsp;</td>
        </tr>
        
       
         <tr>
        <td><?php _e('Limit square distance area to X miles(helps improve search speed for lots of listings)');?></td>
        <td><input type="text" name="search_dist" value="<?php echo $search_dist;?>" /><?php _e('enter whole number only ex. 40  (Tokyo is largest city in the world @40 sq miles)LEAVE BLANK FOR NO DISTANCE LIMIT');?></td>
      </tr>
      
      <tr>
        <td><?php _e('Show search distances in miles or km');?></td>
        <td><input type="radio" name="search_dist_1" <?php if($search_dist_1=='miles'){ echo 'checked="checked"';}?>  value="miles" /> <?php _e('miles');?>  <input type="radio" name="search_dist_1" <?php if($search_dist_1=='km'){ echo 'checked="checked"';}?> value="km" /> <?php _e('km');?></td>
      </tr>
      
       <tr>
        <td><?php _e('If distance is less than 0.01 show distance in meters or feet');?></td>
        <td><input type="radio" name="search_dist_2" <?php if($search_dist_2=='meters'){ echo 'checked="checked"';}?>  value="meters" /> <?php _e('meters');?>  <input type="radio" name="search_dist_2" <?php if($search_dist_2=='feet'){ echo 'checked="checked"';}?> value="feet" /> <?php _e('feet');?></td>
      </tr>
      
      <tr>
        <td><?php _e('Add location name to geolocation search?');?></td>
        <td><input type="radio" name="advanced_near_search" <?php if($advanced_near_search=='1' || $advanced_near_search==''){ echo 'checked="checked"';}?>  value="1" /> <?php _e('Yes');?>  <input type="radio" name="advanced_near_search" <?php if($advanced_near_search=='0'){ echo 'checked="checked"';}?> value="0" /> <?php _e('No');?></td>
      </tr>
      
      <tr>
        <td><?php _e('Add a location name to "NEAR" geolocation searches: ex: "UK"');?></td>
        <td><input type="text" name="search_near_add" value="<?php echo $search_near_add;?>" /><?php _e('You can use this to limit searches to a country or region or make them more specific.');?> </td>
      </tr>
<!-- ########################################## End Edit by stiofan hebtech.co.uk ##################################### -->
<tr>
        <td><b><?php _e('PermaLink Settings');?></b></td>
        <td>&nbsp;</td>
        </tr>
        
        <tr>
        <td><?php _e('Enable location name on category links?');?></td>
        <td><input type="radio" name="cat_link_locations" <?php if($cat_link_locations=='1'){ echo 'checked="checked"';}?>  value="1" /> <?php _e('Yes');?>  <input type="radio" name="cat_link_locations" <?php if($cat_link_locations=='0'){ echo 'checked="checked"';}?> value="0" /> <?php _e('No');?></td>
      </tr>
        
        <tr>
        <td><?php _e('Place category prefix');?></td>
        <td><input type="text" name="place_cat_pre" size="50" value="<?php echo $place_cat_pre;?>" /><br /><?php _e('You can change the default /placecategory/ before place categories. This can not be blank or place and not contain "/" ie <b>placecat</b>.');?></td>
      </tr>
      
       <tr>
        <td><?php _e('Event category prefix');?></td>
        <td><input type="text" name="event_cat_pre" size="50" value="<?php echo $event_cat_pre;?>" /><br /><?php _e('You can change the default /eventcategory/ before event categories. This can not be blank or event and not contain "/" ie <b>eventcat</b>.');?></td>
      </tr>
      
       <tr>
        <td><?php _e('Place permalink settings.');?></td>
        <td><input type="text" name="place_link" size="50" value="<?php echo $place_link;?>" /><br /><?php _e('Because it is a Custom Post Type you MUST have something static at the start, ie place or city. You can then use %city%,%placecategory%,%author%,%post_id% and %place% as the place name. Examples:  /city/%city%/%placecategory%/%place%   or /place/%place%');?></td>
      </tr>
      
 <tr>
        <td><b><?php _e('Update Settings');?></b></td>
        <td>&nbsp;</td>
        </tr>
        
       <tr>
        <td><?php _e('Show GeoTheme update notifications');?></td>
        <td><input type="radio" name="gt_update" <?php if($gt_update=='1'){ echo 'checked="checked"';}?>  value="1" /> <?php _e('Yes');?>  <input type="radio" name="gt_update" <?php if($gt_update=='0'){ echo 'checked="checked"';}?> value="0" /> <?php _e('No');?></td>
      </tr>
      
      <tr>
        <td><?php _e('Show GeoTheme security notifications');?></td>
        <td><input type="radio" name="gt_security" <?php if($gt_security=='1'){ echo 'checked="checked"';}?>  value="1" /> <?php _e('Yes');?>  <input type="radio" name="gt_security" <?php if($gt_security=='0'){ echo 'checked="checked"';}?> value="0" /> <?php _e('No');?></td>
      </tr>
      
       <tr>
        <td><b><?php _e('Documentation Settings');?></b></td>
        <td>&nbsp;</td>
        </tr> 
        
        <tr>
        <td><?php _e('Show GeoTheme Documentation Button?');?></td>
        <td><input type="radio" name="gt_docs" <?php if($gt_docs=='1'){ echo 'checked="checked"';}?>  value="1" /> <?php _e('Yes');?>  <input type="radio" name="gt_docs" <?php if($gt_docs=='0'){ echo 'checked="checked"';}?> value="0" /> <?php _e('No');?></td>
      </tr> 
      
      <tr>
        <td><b><?php _e('App Settings');?></b></td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td><?php _e('Show App Settings page');?></td>
        <td><input type="radio" name="gt_show_app_page" <?php if($gt_show_app_page=='1'){ echo 'checked="checked"';}?>  value="1" /> <?php _e('Yes');?>  <input type="radio" name="gt_show_app_page" <?php if($gt_show_app_page=='0'){ echo 'checked="checked"';}?> value="0" /> <?php _e('No');?></td>
      </tr>    
        
        
        
      <tr>
        <td></td>
        <td><h2><input type="submit" name="submit" value="<?php _e('Submit');?>" class="button-secondary action" /></h2></td>
      </tr>
    </thead>
  </table>
</form>

