<?php
global $wpdb,$price_db_table_name;
add_column_if_not_exist($price_db_table_name, 'property_desc_pkg');
add_column_if_not_exist($price_db_table_name, 'property_feature_pkg');
add_column_if_not_exist($price_db_table_name, 'timing_pkg');
add_column_if_not_exist($price_db_table_name, 'contact_pkg');
add_column_if_not_exist($price_db_table_name, 'email_pkg');
add_column_if_not_exist($price_db_table_name, 'website_pkg');
add_column_if_not_exist($price_db_table_name, 'twitter_pkg');
add_column_if_not_exist($price_db_table_name, 'facebook_pkg');
add_column_if_not_exist($price_db_table_name, 'kw_tags_pkg');
add_column_if_not_exist($price_db_table_name, 'image_limit');
add_column_if_not_exist($price_db_table_name, 'cat_limit');
add_column_if_not_exist($price_db_table_name, 'html_editor');
add_column_if_not_exist($price_db_table_name, 'html_editor');
add_column_if_not_exist($price_db_table_name, 'post_type');
add_column_if_not_exist($price_db_table_name, 'link_business_pkg');
add_column_if_not_exist($price_db_table_name, 'recurring_pkg');
add_column_if_not_exist($price_db_table_name, 'reg_desc_pkg');
add_column_if_not_exist($price_db_table_name, 'reg_fees_pkg');
add_column_if_not_exist($price_db_table_name, 'downgrade_pkg');
add_column_if_not_exist($price_db_table_name, 'listing_desc_pkg');
add_column_if_not_exist($price_db_table_name, 'google_analytics');
add_column_if_not_exist($price_db_table_name, 'video_pkg');
add_column_if_not_exist($price_db_table_name, 'lat_lng');
add_column_if_not_exist($price_db_table_name, 'sort_order');

//Recurring payments
add_column_if_not_exist($price_db_table_name, 'sub_active');
add_column_if_not_exist($price_db_table_name, 'sub_units');
add_column_if_not_exist($price_db_table_name, 'sub_units_num');

if($_POST['priceact'] == 'addprice')
{
	$id = $_POST['id'];
	$title = $_POST['title'];
	$amount = $_POST['amount'];
	$days = $_POST['days'];
	$status = $_POST['status'];
	$cat = $_POST['cat'];
	$is_featured = $_POST['is_featured'];
	$title_desc = $_POST['title_desc'];
	$property_desc_pkg = $_POST['property_desc_pkg'];
	$property_feature_pkg = $_POST['property_feature_pkg'];
	$timing_pkg = $_POST['timing_pkg'];
	$contact_pkg = $_POST['contact_pkg'];
	$email_pkg = $_POST['email_pkg'];
	$website_pkg = $_POST['website_pkg'];
	$twitter_pkg = $_POST['twitter_pkg'];
	$facebook_pkg = $_POST['facebook_pkg'];
	$kw_tags_pkg = $_POST['kw_tags_pkg'];
	$image_limit = $_POST['image_limit'];
	$cat_limit = $_POST['cat_limit'];
	$html_editor = $_POST['html_editor'];
	$post_type = $_POST['posting_type'];
	$link_business_pkg = $_POST['link_business_pkg'];
	$recurring_pkg = $_POST['recurring_pkg'];
	$reg_desc_pkg = $_POST['reg_desc_pkg'];
	$reg_fees_pkg = $_POST['reg_fees_pkg'];
	$downgrade_pkg = $_POST['downgrade_pkg'];
	$listing_desc_pkg = $_POST['listing_desc_pkg'];
	$google_analytics = $_POST['google_analytics'];
	$video_pkg = $_POST['video_pkg'];
	$lat_lng = $_POST['lat_lng'];
	$sort_order = $_POST['sort_order'];
	if($sort_order==''){$sort_order = $id;}
	// Subscription fields 
	$sub_active = $_POST['sub_active'];
	$sub_units = $_POST['sub_units'];
	$sub_units_num = $_POST['sub_units_num'];
	if($cat)
	{
		$cat = implode(',',$cat);
	}
	if(!$title_desc)
	{
		$title_desc = $title.' : number of publish days are '.$days.' (<span id="'.str_replace(' ','_',$title).'">'.$amount.' '.get_currency_type().'</span>)';
	}
	$title_desc = addslashes($title_desc);
	if($is_featured)
	{
		//$wpdb->query("update $price_db_table_name set is_featured='0'");
	}
	if($id)
	{
		$wpdb->query("update $price_db_table_name set title=\"$title\", amount=\"$amount\", days=\"$days\", status=\"$status\",cat=\"$cat\",is_featured=\"$is_featured\",title_desc=\"$title_desc\", property_feature_pkg=\"$property_feature_pkg\",property_desc_pkg=\"$property_desc_pkg\", timing_pkg=\"$timing_pkg\", contact_pkg=\"$contact_pkg\", email_pkg=\"$email_pkg\", website_pkg=\"$website_pkg\", twitter_pkg=\"$twitter_pkg\", facebook_pkg=\"$facebook_pkg\", kw_tags_pkg=\"$kw_tags_pkg\", image_limit=\"$image_limit\", cat_limit=\"$cat_limit\", html_editor=\"$html_editor\", post_type=\"$post_type\", link_business_pkg=\"$link_business_pkg\", recurring_pkg=\"$recurring_pkg\", reg_desc_pkg=\"$reg_desc_pkg\", reg_fees_pkg=\"$reg_fees_pkg\", downgrade_pkg=\"$downgrade_pkg\",listing_desc_pkg=\"$listing_desc_pkg\",google_analytics=\"$google_analytics\",sub_active=\"$sub_active\",sub_units=\"$sub_units\",sub_units_num=\"$sub_units_num\",video_pkg=\"$video_pkg\",lat_lng=\"$lat_lng\",sort_order=\"$sort_order\"  where pid=\"$id\"");
	}else
	{
		$wpdb->query("insert into $price_db_table_name (title,amount,days,status,cat,is_featured,title_desc,property_feature_pkg,property_desc_pkg,timing_pkg,contact_pkg,email_pkg,website_pkg,twitter_pkg,facebook_pkg,kw_tags_pkg,html_editor,image_limit,cat_limit,post_type,link_business_pkg,recurring_pkg,reg_desc_pkg,reg_fees_pkg,downgrade_pkg,listing_desc_pkg,google_analytics,sub_active,sub_units,sub_units_num,video_pkg,lat_lng,sort_order) values (\"$title\",\"$amount\",\"$days\",\"$status\",\"$cat\",\"$is_featured\", \"$title_desc\", \"$property_feature_pkg\", \"$property_desc_pkg\", \"$timing_pkg\",  \"$contact_pkg\", \"$email_pkg\", \"$website_pkg\", \"$twitter_pkg\", \"$facebook_pkg\", \"$kw_tags_pkg\", \"$html_editor\", \"$image_limit\", \"$cat_limit\", \"$post_type\", \"$link_business_pkg\", \"$recurring_pkg\", \"$reg_desc_pkg\", \"$reg_fees_pkg\", \"$downgrade_pkg\", \"$listing_desc_pkg\", \"$google_analytics\", \"$sub_active\", \"$sub_units\", \"$sub_units_num\", \"$video_pkg\", \"$lat_lng\", \"$sort_order\")");
	}
	$location = site_url()."/wp-admin/admin.php";
	echo '<form action="'.$location.'" method=get name="price_success">
	<input type=hidden name="page" value="price"><input type=hidden name="msg" value="success"></form>';
	echo '<script>document.price_success.submit();</script>';
	exit;
}
if($_REQUEST['id']!='')
{
	$pid = $_REQUEST['id'];
	$pricesql = "select * from $price_db_table_name where pid=\"$pid\"";
	$priceinfo = $wpdb->get_results($pricesql);
}
?>

<form action="<?php echo site_url()?>/wp-admin/admin.php?page=price&pagetype=addedit&pid=<?php echo $_REQUEST['id'];?>" method="post" name="price_frm">
  <input type="hidden" name="priceact" value="addprice">
  <input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>">
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
  <h2>
    <?php
if($_REQUEST['id']!='')
{
	_e('Edit Price');
}else
{
	_e('Add Price');
}
?>
  </h2>
  <table width="75%" cellpadding="3" cellspacing="3" class="widefat post fixed" >
    <tr>
      <td width="14%"><?php _e('Price Title');?></td>
      <td width="86%">:
        <input type="text" name="title" id="title" value="<?php echo $priceinfo[0]->title;?>"></td>
    </tr>
    
    <tr>
      <td><?php _e('Post Type');?></td>
      <td>:
      <select name="posting_type" >
      <option value="listing" <?php if($priceinfo[0]->post_type=='listing'){ echo 'selected="selected"';}?> ><?php _e("Listing");?></option>
      <option value="event" <?php if($priceinfo[0]->post_type=='event'){ echo 'selected="selected"';}?> ><?php _e("Event");?></option>
      </select>
      </td>
    </tr>
    
    <tr>
      <td><?php _e('Price Amount');?> (<?php echo get_option('currencysym');?>)</td>
      <td>:
        <input type="text" name="amount" value="<?php echo $priceinfo[0]->amount;?>">
       </td>
    </tr>
    <script language="javascript">

  jQuery(function() {				  
jQuery('#sub_active').click( function() {
jQuery('#sub_hide1').slideToggle("500");
jQuery('#sub_hide2').slideToggle("500");
jQuery('#sub_hide3').slideToggle("500");
jQuery('#days').val('0');
});
});
  
  
</script>
    <tr>
      <td><?php _e('Recurring Payment?');?></td>
      <td>:
         <input type="checkbox" name="sub_active" id="sub_active" value="1" <?php if($priceinfo[0]->sub_active){echo 'checked="checked"';}?>>
         <?php _e('(Only supported by PayPal)');?>
      </td>
    </tr>
    
    <tr id="sub_hide1" <?php if(!$priceinfo[0]->sub_active){echo 'style="display:none"';}?>>
      <td><?php _e('Units of Duration');?></td>
      <td>:
		<select name="sub_units" >
      <option value="D" <?php if($priceinfo[0]->sub_units=='D'){ echo 'selected="selected"';}?> ><?php _e("Days");?></option>
      <option value="W" <?php if($priceinfo[0]->sub_units=='W'){ echo 'selected="selected"';}?> ><?php _e("Weeks");?></option>
      <option value="M" <?php if($priceinfo[0]->sub_units=='M'){ echo 'selected="selected"';}?> ><?php _e("Months");?></option>
      <option value="Y" <?php if($priceinfo[0]->sub_units=='Y'){ echo 'selected="selected"';}?> ><?php _e("Years");?></option>
      </select>         
      </td>
    </tr>
    
     <tr id="sub_hide2" <?php if(!$priceinfo[0]->sub_active){echo 'style="display:none"';}?>>
      <td><?php _e('Every X Amount of Units');?></td>
      <td>:
		<select name="sub_units_num" >
       <?php  $i=0;
	   while($i<90){$i++;?>
		  <option value="<?php echo $i;?>" <?php if($priceinfo[0]->sub_units_num==$i){ echo 'selected="selected"';}?> ><?php echo $i;?></option>
 <?php }  ?>
  </select><?php _e('(Allowed Range: Days range 1-90 || Weeks range 1-52 || Months range 1-24 || Years range 1-5)');?>
      </td>
    </tr>
    
    <tr id="sub_hide3" <?php if($priceinfo[0]->sub_active){echo 'style="display:none"';}?>>
      <td><?php _e('Number of Days');?></td>
      <td>:
         <input type="text" name="days"  id="days" value="<?php echo $priceinfo[0]->days;?>">
         <?php _e('(set to 0 to never expire)');?>
      </td>
    </tr>
    
    
     <!-- <tr>
      <td><?php _e('Select Category');?></td>
      <td>:
      <select name="cat">
      <option value=""><?php _e('Select Category');?></option>
       <?php $cat_info = get_category_array();
	  for($i=0;$i<count($cat_info);$i++){?>
      <option value="<?php echo $cat_info[$i]['id'];?>" <?php if($cat_info[$i]['id']==$priceinfo[0]->cat){ echo 'selected="selected"';}?> ><?php echo $cat_info[$i]['title'];?>
      <?php }?>
      </option>
      </select>
      </td>
    </tr> -->
    <tr>
      <td><?php _e('Status');?></td>
      <td>:
      <select name="status" >
      <option value="1" <?php if($priceinfo[0]->status=='1'){ echo 'selected="selected"';}?> ><?php _e("Active");?></option>
      <option value="0" <?php if($priceinfo[0]->status=='0'){ echo 'selected="selected"';}?> ><?php _e("Inactive");?></option>
      </select>
      </td>
    </tr>
    <tr>
      <td><?php _e('Is Featured');?></td>
      <td>:
      <select name="is_featured" >
      <option value="0" <?php if($priceinfo[0]->is_featured=='0'){ echo 'selected="selected"';}?> ><?php _e("No");?></option>
      <option value="1" <?php if($priceinfo[0]->is_featured=='1'){ echo 'selected="selected"';}?> ><?php _e("Yes");?></option>
      </select>
      </td>
    </tr>
    
      <tr>
      <td><?php _e('Exclude Categories');?></td>
      <td>:
      <?php
	  if($priceinfo[0]->post_type==''){ _e('You can only exclude categories once saved.');}else{
	   if($priceinfo[0]->cat)
	   {
			$catarr = explode(',',$priceinfo[0]->cat);   
	   }
	  ?>
      <select name="cat[]" multiple="multiple" style="height: 100px;" >
      <option value="" <?php if(!$priceinfo[0]->cat){ echo 'selected="selected"';} ?> ><?php _e('SHOW ALL');?></option>
       <?php 
	   if($priceinfo[0]->post_type=='event'){$cat_info = get_eventcategory_array();}
	   else{$cat_info = get_category_array();}	   
	   if($priceinfo[0]->cat)
	   {
			$catarr = explode(',',$priceinfo[0]->cat);   
	   }
	  for($i=0;$i<count($cat_info);$i++){?>
      <option value="<?php echo $cat_info[$i]['id'];?>" <?php if($catarr && in_array($cat_info[$i]['id'],$catarr)){ echo 'selected="selected"';}?> ><?php echo $cat_info[$i]['title'];?>
      <?php }?>
      </option>
      </select><?php _e('Select multiple categories to exclude by holding down "Ctrl" key. (if removing a parent category, you should remove its child categories.');?><br />
      <b><?php _e('  (It is not recommended to exclude categories from live packages as users will not be able to remove that category from the frontend.)');?></b>
      <?php } ?>
      </td>
    </tr>
    
    
     <tr>
      <td><?php _e('Expire, Downgrade to');?></td>
      <td>:
      <select name="downgrade_pkg" >
      <option value="0" <?php if($priceinfo[0]->downgrade_pkg=='0'){ echo 'selected="selected"';}?> ><?php _e("Expire");?></option>
     <?php 
	  $get_price_info = get_property_downgrade_info($priceinfo[0]->post_type);
	 if($get_price_info)
	{
	foreach($get_price_info  as $priceinfoObj)
	{ ?>
        <option value="<?php echo $priceinfoObj->pid; ?>" <?php if($priceinfo[0]->downgrade_pkg==$priceinfoObj->pid){ echo 'selected="selected"';}?> ><?php echo $priceinfoObj->title.' - '.$priceinfoObj->post_type;?></option>
		<?php }	}?>
      </select>
      </td>
    </tr>
     <tr>
      <td><?php _e('Title to be display while Add Listing');?></td>
      <td>:
      <textarea name="title_desc" cols="40" rows="5" id="title_desc"><?php echo stripslashes($priceinfo[0]->title_desc);?></textarea>
      <br /><?php _e('Keep blank to reset default content.');?>
      </td>
    </tr>
    
    
    <tr>
      <td><b><?php _e('Features');?></b></td>
      <td><?php _e('(No = Grey out, Yes = Show, Hide = Don\'t display)');?></td>
    </tr> 
    
    <!-- <tr>
      <td><?php _e('Listing Description(textarea)');?></td>
      <td>:
      <select name="listing_desc_pkg" >
      <option value="0" <?php if($priceinfo[0]->listing_desc_pkg=='0'){ echo 'selected="selected"';}?> ><?php _e("No");?></option>
      <option value="1" <?php if($priceinfo[0]->listing_desc_pkg=='1'){ echo 'selected="selected"';}?> ><?php _e("Yes");?></option>
      <option value="2" <?php if($priceinfo[0]->listing_desc_pkg=='2'){ echo 'selected="selected"';}?> ><?php _e("Hide");?></option>
      </select>
      </td>
    </tr> -->
    
    <tr>
      <td><?php _e('Listing Description(textarea)');?></td>
      <td>:
      <select name="property_desc_pkg" >
      <option value="0" <?php if($priceinfo[0]->property_desc_pkg=='0'){ echo 'selected="selected"';}?> ><?php _e("No");?></option>
      <option value="1" <?php if($priceinfo[0]->property_desc_pkg=='1'){ echo 'selected="selected"';}?> ><?php _e("Yes");?></option>
      <option value="2" <?php if($priceinfo[0]->property_desc_pkg=='2'){ echo 'selected="selected"';}?> ><?php _e("Hide");?></option>
      </select>
      </td>
    </tr>
    
     <tr>
      <td><?php _e('Special Offers(textarea)');?></td>
      <td>:
      <select name="property_feature_pkg" >
      <option value="0" <?php if($priceinfo[0]->property_feature_pkg=='0'){ echo 'selected="selected"';}?> ><?php _e("No");?></option>
      <option value="1" <?php if($priceinfo[0]->property_feature_pkg=='1'){ echo 'selected="selected"';}?> ><?php _e("Yes");?></option>
      <option value="2" <?php if($priceinfo[0]->property_feature_pkg=='2'){ echo 'selected="selected"';}?> ><?php _e("Hide");?></option>
      </select>
      </td>
    </tr>
    
    <tr>
      <td><?php _e('Opening Times');?></td>
      <td>:
      <select name="timing_pkg" >
      <option value="0" <?php if($priceinfo[0]->timing_pkg=='0'){ echo 'selected="selected"';}?> ><?php _e("No");?></option>
      <option value="1" <?php if($priceinfo[0]->timing_pkg=='1'){ echo 'selected="selected"';}?> ><?php _e("Yes");?></option>
      <option value="2" <?php if($priceinfo[0]->timing_pkg=='2'){ echo 'selected="selected"';}?> ><?php _e("Hide");?></option>
      </select>
      </td>
    </tr>
    
     <tr>
      <td><?php _e('Phone Number');?></td>
      <td>:
      <select name="contact_pkg" >
      <option value="0" <?php if($priceinfo[0]->contact_pkg=='0'){ echo 'selected="selected"';}?> ><?php _e("No");?></option>
      <option value="1" <?php if($priceinfo[0]->contact_pkg=='1'){ echo 'selected="selected"';}?> ><?php _e("Yes");?></option>
      <option value="2" <?php if($priceinfo[0]->contact_pkg=='2'){ echo 'selected="selected"';}?> ><?php _e("Hide");?></option>
      </select>
      </td>
    </tr>
    
    <tr>
      <td><?php _e('Email');?></td>
      <td>:
      <select name="email_pkg" >
      <option value="0" <?php if($priceinfo[0]->email_pkg=='0'){ echo 'selected="selected"';}?> ><?php _e("No");?></option>
      <option value="1" <?php if($priceinfo[0]->email_pkg=='1'){ echo 'selected="selected"';}?> ><?php _e("Yes");?></option>
      <option value="2" <?php if($priceinfo[0]->email_pkg=='2'){ echo 'selected="selected"';}?> ><?php _e("Hide");?></option>
      </select>
       <?php _e('(This will disable the email address input and disable the send to friend and Send Inquiry forms on the detail page)');?>
      </td>
    </tr>
    
     <tr>
      <td><?php _e('Website');?></td>
      <td>:
      <select name="website_pkg" >
      <option value="0" <?php if($priceinfo[0]->website_pkg =='0'){ echo 'selected="selected"';}?> ><?php _e("No");?></option>
      <option value="1" <?php if($priceinfo[0]->website_pkg =='1'){ echo 'selected="selected"';}?> ><?php _e("Yes");?></option>
      <option value="2" <?php if($priceinfo[0]->website_pkg =='2'){ echo 'selected="selected"';}?> ><?php _e("Hide");?></option>
      </select>
      </td>
    </tr> 
    
     <tr>
      <td><?php _e('Twitter');?></td>
      <td>:
      <select name="twitter_pkg" >
      <option value="0" <?php if($priceinfo[0]->twitter_pkg=='0'){ echo 'selected="selected"';}?> ><?php _e("No");?></option>
      <option value="1" <?php if($priceinfo[0]->twitter_pkg=='1'){ echo 'selected="selected"';}?> ><?php _e("Yes");?></option>
      <option value="2" <?php if($priceinfo[0]->twitter_pkg=='2'){ echo 'selected="selected"';}?> ><?php _e("Hide");?></option>
      </select>
      </td>
    </tr>
    
    <tr>
      <td><?php _e('Facebook');?></td>
      <td>:
      <select name="facebook_pkg" >
      <option value="0" <?php if($priceinfo[0]->facebook_pkg=='0'){ echo 'selected="selected"';}?> ><?php _e("No");?></option>
      <option value="1" <?php if($priceinfo[0]->facebook_pkg=='1'){ echo 'selected="selected"';}?> ><?php _e("Yes");?></option>
      <option value="2" <?php if($priceinfo[0]->facebook_pkg=='2'){ echo 'selected="selected"';}?> ><?php _e("Hide");?></option>
      </select>
      </td>
    </tr>
    
     <tr>
      <td><?php _e('Tag Keywords');?></td>
      <td>:
      <select name="kw_tags_pkg" >
      <option value="0" <?php if($priceinfo[0]->kw_tags_pkg=='0'){ echo 'selected="selected"';}?> ><?php _e("No");?></option>
      <option value="1" <?php if($priceinfo[0]->kw_tags_pkg=='1'){ echo 'selected="selected"';}?> ><?php _e("Yes");?></option>
      <option value="2" <?php if($priceinfo[0]->kw_tags_pkg=='2'){ echo 'selected="selected"';}?> ><?php _e("Hide");?></option>
      </select>
      </td>
    </tr>
    <tr>
      <td><?php _e('HTML Editor');?></td>
      <td>:
      <select name="html_editor" >
      <option value="0" <?php if($priceinfo[0]->html_editor=='0'){ echo 'selected="selected"';}?> ><?php _e("No");?></option>
      <option value="1" <?php if($priceinfo[0]->html_editor=='1'){ echo 'selected="selected"';}?> ><?php _e("Yes");?></option>
      </select>
      </td>
    </tr>
    <tr>
      <td><?php _e('Google Analytics');?></td>
      <td>:
      <select name="google_analytics" >
      <option value="0" <?php if($priceinfo[0]->google_analytics=='0'){ echo 'selected="selected"';}?> ><?php _e("No");?></option>
      <option value="1" <?php if($priceinfo[0]->google_analytics=='1'){ echo 'selected="selected"';}?> ><?php _e("Yes");?></option>
      </select>
      <?php _e('(Show user there Google Analytics stats on there page?)');?>
      </td>
    </tr>
    
    <tr>
      <td><?php _e('Video Code');?></td>
      <td>:
      <select name="video_pkg" >
      <option value="0" <?php if($priceinfo[0]->video_pkg=='0'){ echo 'selected="selected"';}?> ><?php _e("No");?></option>
      <option value="1" <?php if($priceinfo[0]->video_pkg=='1'){ echo 'selected="selected"';}?> ><?php _e("Yes");?></option>
      <option value="2" <?php if($priceinfo[0]->video_pkg=='2'){ echo 'selected="selected"';}?> ><?php _e("Hide");?></option>
      </select>
      </td>
    </tr>
    
    <tr>
      <td><?php _e('Lat/Lng');?></td>
      <td>:
      <select name="lat_lng" >
      <option value="1" <?php if($priceinfo[0]->lat_lng=='1'){ echo 'selected="selected"';}?> ><?php _e("Yes");?></option>
      <option value="2" <?php if($priceinfo[0]->lat_lng=='2'){ echo 'selected="selected"';}?> ><?php _e("Hide");?></option>
      </select>
      </td>
    </tr>
    
    
    <tr>
      <td><?php _e('Image Limit');?></td>
      <td>:
         <input type="text" name="image_limit" value="<?php echo $priceinfo[0]->image_limit;?>">
         <?php _e('(Leave blank for unlimited)');?>
      </td>
    </tr>
    
    <tr>
      <td><?php _e('Category Limit');?></td>
      <td>:
         <input type="text" name="cat_limit" value="<?php echo $priceinfo[0]->cat_limit;?>">
         <?php _e('(Leave blank for unlimited)');?>
      </td>
    </tr>
    
      
    
    <tr>
      <td><?php _e('Link Business');?></td>
      <td>:
      <select name="link_business_pkg" >
      <option value="0" <?php if($priceinfo[0]->link_business_pkg=='0'){ echo 'selected="selected"';}?> ><?php _e("No");?></option>
      <option value="1" <?php if($priceinfo[0]->link_business_pkg=='1'){ echo 'selected="selected"';}?> ><?php _e("Yes");?></option>
      <option value="2" <?php if($priceinfo[0]->link_business_pkg=='2'){ echo 'selected="selected"';}?> ><?php _e("Hide");?></option>
      </select>
      </td>
    </tr>
    
    <tr>
      <td><b><?php _e('Event Features Only');?></b></td>
      <td>
      </td>
    </tr> 
    
     <tr>
      <td><?php _e('Recurring Event');?></td>
      <td>:
      <select name="recurring_pkg" >
      <option value="0" <?php if($priceinfo[0]->recurring_pkg=='0'){ echo 'selected="selected"';}?> ><?php _e("No");?></option>
      <option value="1" <?php if($priceinfo[0]->recurring_pkg=='1'){ echo 'selected="selected"';}?> ><?php _e("Yes");?></option>
      <option value="2" <?php if($priceinfo[0]->recurring_pkg=='2'){ echo 'selected="selected"';}?> ><?php _e("Hide");?></option>
      </select>
      </td>
    </tr>
    
    <tr>
      <td><?php _e('Registration Description');?></td>
      <td>:
      <select name="reg_desc_pkg" >
      <option value="0" <?php if($priceinfo[0]->reg_desc_pkg=='0'){ echo 'selected="selected"';}?> ><?php _e("No");?></option>
      <option value="1" <?php if($priceinfo[0]->reg_desc_pkg=='1'){ echo 'selected="selected"';}?> ><?php _e("Yes");?></option>
      <option value="2" <?php if($priceinfo[0]->reg_desc_pkg=='2'){ echo 'selected="selected"';}?> ><?php _e("Hide");?></option>
      </select>
      </td>
    </tr>
    
    <tr>
      <td><?php _e('Registration Fees');?></td>
      <td>:
      <select name="reg_fees_pkg" >
      <option value="0" <?php if($priceinfo[0]->reg_fees_pkg=='0'){ echo 'selected="selected"';}?> ><?php _e("No");?></option>
      <option value="1" <?php if($priceinfo[0]->reg_fees_pkg=='1'){ echo 'selected="selected"';}?> ><?php _e("Yes");?></option>
      <option value="2" <?php if($priceinfo[0]->reg_fees_pkg=='2'){ echo 'selected="selected"';}?> ><?php _e("Hide");?></option>
      </select>
      </td>
    </tr>
    
    <tr>
      <td><b><?php _e('Sort Order');?></b></td>
      <td></td>
    </tr>
    
     <tr>
      <td><?php _e('Sort Order');?></td>
      <td>:
         <input type="text" name="sort" value="<?php echo $priceinfo[0]->sort;?>">
         <?php _e('(Number only, lower numbers will appear first)');?>
      </td>
    </tr>
      
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="submit" value="<?php _e('Submit');?>" onclick="return check_frm();" class="button-secondary action" >
        &nbsp;
        <input type="button" name="cancel" value="<?php _e('Cancel');?>" onClick="window.location.href='<?php echo site_url()?>/wp-admin/admin.php?page=price'" class="button-secondary action" ></td>
    </tr>
  </table>
</form>
<script>
function check_frm()
{
	if(document.getElementById('title').value=='')
	{
		alert("<?php _e('Please enter Title');?>");
		return false;
	}
	return true;
}
</script>