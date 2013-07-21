<?php
########### DO SOME DB UPDATE SHIZLE JUST INCASE #############
global $wpdb,$multiregion_db_table_name,$multicity_db_table_name,$multihood_db_table_name,$multicountry_db_table_name;
add_column_if_not_exist($multicity_db_table_name, 'city_slug');
add_column_if_not_exist($multicity_db_table_name, 'cat_ex');
add_column_if_not_exist($multicity_db_table_name, 'home_desc', 'TEXT NOT NULL');
add_column_if_not_exist($multicity_db_table_name, 'meta_desc', 'TEXT NOT NULL');

add_column_if_not_exist($multicountry_db_table_name, 'cat_ex');
add_column_if_not_exist($multicountry_db_table_name, 'home_desc', 'TEXT NOT NULL');
add_column_if_not_exist($multicountry_db_table_name, 'meta_desc', 'TEXT NOT NULL');

add_column_if_not_exist($multihood_db_table_name, 'cat_ex');
add_column_if_not_exist($multihood_db_table_name, 'home_desc', 'TEXT NOT NULL');
add_column_if_not_exist($multihood_db_table_name, 'meta_desc', 'TEXT NOT NULL');

add_column_if_not_exist($multiregion_db_table_name, 'cat_ex');
add_column_if_not_exist($multiregion_db_table_name, 'home_desc', 'TEXT NOT NULL');
add_column_if_not_exist($multiregion_db_table_name, 'meta_desc', 'TEXT NOT NULL');
########### DO SOME DB UPDATE SHIZLE JUST INCASE #############



global $wpdb,$current_user,$upload_folder_path,$multicountry_db_table_name,$multiregion_db_table_name,$multicity_db_table_name,$multihood_db_table_name;

$wpdb->query("ALTER TABLE $multicity_db_table_name MODIFY COLUMN city_slug varchar(255) AFTER cityname"); // Fix for older setups...

$tmppath = $upload_folder_path."csv/";
if($_FILES['bulk_upload_csv'])
{
	if($_FILES['bulk_upload_csv']['name']!='' && $_FILES['bulk_upload_csv']['error']=='0')
	{
		$filename = $_FILES['bulk_upload_csv']['name'];
		$filenamearr = explode('.',$filename);
		$extensionarr = array('csv','CSV');
		
		if(in_array($filenamearr[count($filenamearr)-1],$extensionarr))
		{
			$tmppath = $upload_folder_path."csv/";
			$destination_path = ABSPATH . "$tmppath";
			if (!file_exists($destination_path))
			{
				mkdir($destination_path, 0777);				
			}
			$target_path = $destination_path . $filename;
			$csv_target_path = $target_path;
			if(move_uploaded_file($_FILES['bulk_upload_csv']['tmp_name'], $target_path)) 
			{
				$fd = fopen ($target_path, "rt");

				$rowcount = 0;
				$customKeyarray = array();
				while (!feof ($fd))
				{
					$buffer = fgetcsv($fd, 40960);
					if($rowcount == 0)
					{
						for($k=0;$k<count($buffer);$k++)
						{
							$customKeyarray[$k] = $buffer[$k];
						}
						if($customKeyarray[0]=='')
						{
							$url = site_url().'/wp-admin/admin.php';
							echo '<form action="'.$url.'" method="get" id="frm_bulk_upload" name="frm_bulk_upload">
							<input type="hidden" value="bulk" name="page"><input type="hidden" value="wrong" name="emsg">
							</form>
							<script>document.frm_bulk_upload.submit();</script>';exit;	
						}
					}else
					{
						$post_title = addslashes($buffer[0]);
						$post_desc = addslashes($buffer[1]);
						$post_cat = array();
						$catids_arr = array();
						$post_cat = trim($buffer[2]); // comma seperated category name
						if($post_cat)
						{
							$post_cat_arr = explode(',',$post_cat);
							for($c=0;$c<count($post_cat_arr);$c++)
							{
								$catid = trim($post_cat_arr[$c]);
								if($buffer[4]=='post'){
								if(get_cat_ID($catid))
								{
									$catids_arr[] = get_cat_ID($catid);
								}
								}// end if post
								elseif($buffer[4]=='place'){
								if(get_term_by( 'name', $catid, 'placecategory' ))
								{
									$cat = get_term_by( 'name', $catid, 'placecategory' );
									$catids_arr[] = $cat->slug;
								}
								}// end if place
								elseif($buffer[4]=='event'){
								if(get_term_by( 'name', $catid, 'eventcategory' ))
								{
									$cat = get_term_by( 'name', $catid, 'eventcategory' );
									$catids_arr[] = $cat->slug;
								}
								}// end if place
							}
						}
						if(!$catids_arr)
						{
							$catids_arr[] = 1;	
						}
						$post_tags = trim($buffer[3]); // comma seperated tags
						if($post_tags)
						{
							$tag_arr = array();
							$tag_arr = explode(',',$post_tags);	
						}
						if($post_title!='')
						{
							$my_post['post_title'] = $post_title;
							$my_post['post_content'] = $post_desc;
							$my_post['post_type'] = addslashes($buffer[4]);
							$my_post['post_author'] = $current_user->data->ID;
							$my_post['post_status'] = 'publish';
							$my_post['post_category'] = $catids_arr;
							$my_post['tags_input'] = $tag_arr;
							$last_postid = wp_insert_post( $my_post );
							
							if($my_post['post_type']=='place'){
							wp_set_object_terms($last_postid, $my_post['tags_input'], $taxonomy='place_tags');
							wp_set_object_terms($last_postid,$my_post['post_category'], $taxonomy='placecategory');
							}elseif($my_post['post_type']=='event'){
							wp_set_object_terms($last_postid, $my_post['tags_input'], $taxonomy='event_tags');
							wp_set_object_terms($last_postid,$my_post['post_category'], $taxonomy='eventcategory');
							}elseif($my_post['post_type']=='post'){
							wp_set_object_terms($last_postid, $my_post['tags_input'], $taxonomy='post_tags');
							wp_set_object_terms($last_postid,$my_post['post_category'], $taxonomy='category');
							}
							
							$menu_order = 0;
							$image_folder_name = 'place/';
							for($c=5;$c<count($customKeyarray);$c++)
							{
								update_post_meta($last_postid, $customKeyarray[$c], addslashes($buffer[$c]));
								if($customKeyarray[$c]=='IMAGE')
								{
									$image_name = $buffer[$c];
									if($image_name)
									{
										$menu_order = $c+1;
										$image_name_arr = explode('/',$image_name);
										$img_name = $image_name_arr[count($image_name_arr)-1];
										$img_name_arr = explode('.',$img_name);
										$post_img = array();
										$post_img['post_title'] = $img_name_arr[0];
										$post_img['post_status'] = 'attachment';
										$post_img['post_parent'] = $last_postid;
										$post_img['post_type'] = 'attachment';
										$post_img['post_mime_type'] = 'image/jpeg';
										$post_img['menu_order'] = $menu_order;
										$last_postimage_id = wp_insert_post( $post_img );
										update_post_meta($last_postimage_id, '_wp_attached_file', $image_folder_name.$image_name);					
										$post_attach_arr = array(
															"width"	=>	580,
															"height" =>	480,
															"hwstring_small"=> "height='150' width='150'",
															"file"	=> $image_folder_name.$image_name,
															);
										wp_update_attachment_metadata( $last_postimage_id, $post_attach_arr );
									}
								}
							}
						}
					}				
				$rowcount++;
				} 
				@unlink($csv_target_path);
				$url = site_url().'/wp-admin/admin.php';
				echo '<form action="'.$url.'" method="get" id="frm_bulk_upload" name="frm_bulk_upload">
				<input type="hidden" value="bulk" name="page"><input type="hidden" value="success" name="msg"><input type="hidden" value="'.$rowcount.'" name="rowcount">
				</form>
				<script>document.frm_bulk_upload.submit();</script>
				';exit;
			}
			else
			{
				$url = site_url().'/wp-admin/admin.php';
				echo '<form action="'.$url.'" method="get" id="frm_bulk_upload" name="frm_bulk_upload">
				<input type="hidden" value="bulk" name="page"><input type="hidden" value="tmpfile" name="emsg">
				</form>
				<script>document.frm_bulk_upload.submit();</script>
				';exit;
			}
		}else
		{
			$url = site_url().'/wp-admin/admin.php';
			echo '<form action="'.$url.'" method="get" id="frm_bulk_upload" name="frm_bulk_upload">
			<input type="hidden" value="bulk" name="page"><input type="hidden" value="csvonly" name="emsg">
			</form>
			<script>document.frm_bulk_upload.submit();</script>
			';exit;
			//wp_redirect(site_url().'/wp-admin/admin.php?page=bulk&emsg=csvonly');exit;	
		}
	}else
	{
		$url = site_url().'/wp-admin/admin.php';
		echo '<form action="'.$url.'" method="get" id="frm_bulk_upload" name="frm_bulk_upload">
		<input type="hidden" value="bulk" name="page"><input type="hidden" value="invalid_file" name="emsg">
		</form>
		<script>document.frm_bulk_upload.submit();</script>
		';exit;
		//wp_redirect(site_url().'/wp-admin/admin.php?page=bulk&emsg=invalid_file');exit;
	}
}
?>

<?php 
##################################################
############### RESULT MESSAGES ##################
##################################################
if($_REQUEST['emsg']=='city_csvonly'){?>
 <div class="updated fade below-h2" id="message" style="background-color: rgb(255, 251, 204);" >
 <p><?php _e('Please upload CSV file only.');?></p>
 </div>
 <br />
 <?php }?>
 <?php if($_REQUEST['emsg']=='city_invalid_file'){?>
 <div class="updated fade below-h2" id="message" style="background-color: rgb(255, 251, 204);" >
 <p><?php _e('Please select valid CSV file only for listing bulk upload.');?></p>
 </div>
 <br />
 <?php }?>
  <?php if($_REQUEST['emsg']=='city_tmpfile'){?>
 <div class="updated fade below-h2" id="message" style="background-color: rgb(255, 251, 204);" >
 <p><?php echo $target_path;  _e('Cannot move the bulk upload file to Temporary system folder <b>"'.$tmppath.'"</b>. Please check folder permission should be 0777.');?></p>
 </div>
 <br />
 <?php }?>
  <?php if($_REQUEST['emsg']=='city_wrong'){?>
 <div class="updated fade below-h2" id="message" style="background-color: rgb(255, 251, 204);" >
 <p><?php echo $target_path;  _e('File you are uploading is not valid. First colum should be "Post Title".');?></p>
 </div>
 <br />
 <?php }?>
<?php
if($_REQUEST['msg']=='city_success'){
$new_row = $_REQUEST['new_row'];
$update_row = $_REQUEST['update_row'];
$success_msg = '';
$success_msg .=  "<div id=message class=updated><p>".__('CSV uploaded successfully.')."</p>";
$rowcount = $rowcount-2;
$success_msg .= "<p><b>".__('Total of '.$new_row.' records inserted.')."</b></p>";
$success_msg .= "<p><b>".__('Total of '.$update_row.' records updated.')."</b></p>";
echo $success_msg .= "</div><br>";
}
##################################################
############### RESULT MESSAGES ##################
##################################################
?>


<form action="<?php echo site_url()?>/wp-admin/admin.php?page=bulk" method="post" name="bukl_upload_frm" enctype="multipart/form-data">
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
  <h2><?php _e('Place/Event Bulk Upload');?></h2>
  <p><?php echo __('Have a ').get_option('blogname').__(' site somewhere else that you wish to import here? Simply  download'); echo '<a href="'. home_url().'/?ptype=csvdl">'.__('sample CSV file').'</a>'; echo __(' and import your data accordingly.</p><p>It is advisable to create the same category in this Blog first and then use "Place/Event Category" title accurate in CSV file.</p>');?>
 <?php if($_REQUEST['emsg']=='csvonly'){?>
 <div class="updated fade below-h2" id="message" style="background-color: rgb(255, 251, 204);" >
 <p><?php _e('Please upload CSV file only.');?></p>
 </div>
 <br />
 <?php }?>
 <?php if($_REQUEST['emsg']=='invalid_file'){?>
 <div class="updated fade below-h2" id="message" style="background-color: rgb(255, 251, 204);" >
 <p><?php _e('Please select valid CSV file only for listing bulk upload.');?></p>
 </div>
 <br />
 <?php }?>
  <?php if($_REQUEST['emsg']=='tmpfile'){?>
 <div class="updated fade below-h2" id="message" style="background-color: rgb(255, 251, 204);" >
 <p><?php echo $target_path;  _e('Cannot move the bulk upload file to Temporary system folder <b>"'.$tmppath.'"</b>. Please check folder permission should be 0777.');?></p>
 </div>
 <br />
 <?php }?>
  <?php if($_REQUEST['emsg']=='wrong'){?>
 <div class="updated fade below-h2" id="message" style="background-color: rgb(255, 251, 204);" >
 <p><?php echo $target_path;  _e('File you are uploading is not valid. First colum should be "Post Title".');?></p>
 </div>
 <br />
 <?php }?>
<?php
if($_REQUEST['msg']=='success'){
$rowcount = $_REQUEST['rowcount'];
$success_msg = '';
$success_msg .=  "<div id=message class=updated><p>".__('CSV uploaded successfully.')."</p>";
$rowcount = $rowcount-2;
$success_msg .= "<p><b>".__('Total of '.$rowcount.' records inserted.')."</b></p>";
echo $success_msg .= "<p>Please create 'place' folder in <b>'/".$upload_folder_path."'</b> and trasfer all images.</b></p></div><br>";
}
?>
  <table style=" width:40%" cellpadding="3" cellspacing="3" class="widefat post fixed" >
    <tr>
      <td width="24%"><?php _e('Select CSV file to upload');?></td>
      <td width="70%">:
        <input type="file" name="bulk_upload_csv" id="bulk_upload_csv"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    <td><input type="submit" name="submit" value="<?php _e('Submit');?>" onClick="return check_frm();" class="button-secondary action" >    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>    
    </tr>
    <tr><td></td>
      <td><?php _e('You can download');?> <a href="<?php echo home_url()?>/?ptype=csvdl"><?php _e('sample CSV file');?></a></td>
          
    </tr>
  </table>
</form>
<script>
function check_frm()
{
	if(document.getElementById('bulk_upload_csv').value == '')
	{
		alert("<?php _e('Please select csv file to upload');?>");
		return false;
	}
	return true;
}
</script>

<?php
##############################################################################################
################################## CITY BULK UPLOAD ##########################################
##############################################################################################
global $wpdb,$current_user,$upload_folder_path;
$tmppath = $upload_folder_path."csv/";

if($_FILES['city_bulk_upload_csv'])
{

	if($_FILES['city_bulk_upload_csv']['name']!='' && $_FILES['city_bulk_upload_csv']['error']=='0')
	{
		$filename = $_FILES['city_bulk_upload_csv']['name'];
		$filenamearr = explode('.',$filename);
		$extensionarr = array('csv','CSV');
		
		if(in_array($filenamearr[count($filenamearr)-1],$extensionarr))
		{
			$tmppath = $upload_folder_path."csv/";
			$destination_path = ABSPATH . "$tmppath";
			if (!file_exists($destination_path))
			{
				mkdir($destination_path, 0777);				
			}
			$target_path = $destination_path . $filename;
			$csv_target_path = $target_path;
			if(move_uploaded_file($_FILES['city_bulk_upload_csv']['tmp_name'], $target_path)) 
			{
				$fd = fopen ($target_path, "rt");

				$rowcount = 0;
				$new_row = 0;
				$update_row = 0;
				$customKeyarray = array();
				while (!feof ($fd))
				{
					$buffer = fgetcsv($fd, 40960);
					if($rowcount == 0)
					{
						for($k=0;$k<count($buffer);$k++)
						{
							$customKeyarray[$k] = $buffer[$k];
						}
						if($customKeyarray[0]=='')
						{
							$url = site_url().'/wp-admin/admin.php?page=bulk'; 
							echo '<form action="'.$url.'" method="get" id="frm_bulk_upload" name="frm_bulk_upload">
							<input type="hidden" value="bulk" name="page"><input type="hidden" value="city_wrong" name="emsg">
							</form>
							<script>document.city_frm_bulk_upload.submit();</script>';exit;	
						}
					}else
					{
						$id = addslashes($buffer[0]);
						$name = addslashes($buffer[1]);
						$slug = addslashes($buffer[2]);
						$lat = addslashes($buffer[3]);
						$lng = addslashes($buffer[4]);
						$scall_factor = addslashes($buffer[5]);
						$sortorder = addslashes($buffer[6]);
						$is_zoom_home = addslashes($buffer[7]);
						$categories = addslashes($buffer[8]);
						$is_default = addslashes($buffer[9]);
						$cat_ex = addslashes($buffer[10]);
						$home_desc = addslashes($buffer[11]);
						$meta_desc = addslashes($buffer[12]);
											
						
						if($id!='' && $name)
						{
						
						$wpdb->query("update $multicity_db_table_name set cityname=\"$name\", lat=\"$lat\", lng=\"$lng\", scall_factor=\"$scall_factor\",categories=\"$categories\",cat_ex=\"$cat_ex\",is_zoom_home=\"$is_zoom_home\",is_default=\"$default\",sortorder=\"$sortorder\",city_slug=\"$slug\",home_desc=\"$home_desc\",meta_desc=\"$meta_desc\" where city_id=\"$id\"");
						$update_row++;
				
						}elseif($name){
							$wpdb->query("insert into $multicity_db_table_name (cityname,lat,lng,scall_factor,categories,cat_ex,is_zoom_home,is_default,sortorder,city_slug,home_desc,meta_desc) values (\"$name\",\"$lat\",\"$lng\",\"$scall_factor\",\"$categories\",\"$cat_ex\",\"$is_zoom_home\",\"$default\",\"$sortorder\",\"$slug\",\"$home_desc\",\"$meta_desc\")");
							
						$new_row++;
						
						}
					}				
				$rowcount++;
				}
				@unlink($csv_target_path);
				$url = site_url().'/wp-admin/admin.php?page=bulk';
				echo '<form action="'.$url.'" method="get" id="city_frm_bulk_upload" name="city_frm_bulk_upload">
				<input type="hidden" value="bulk" name="page">
				<input type="hidden" value="city_success" name="msg">
				<input type="hidden" value="'.$new_row.'" name="new_row">
				<input type="hidden" value="'.$update_row.'" name="update_row">
				</form>
				<script>document.city_frm_bulk_upload.submit();</script>
				';exit;
			}
			else
			{
				$url = site_url().'/wp-admin/admin.php?page=bulk';
				echo '<form action="'.$url.'" method="get" id="city_frm_bulk_upload" name="city_frm_bulk_upload">
				<input type="hidden" value="bulk" name="page">
				<input type="hidden" value="city_tmpfile" name="emsg">
				</form>
				<script>document.city_frm_bulk_upload.submit();</script>
				';exit;
			}
		}else
		{
			$url = site_url().'/wp-admin/admin.php?page=bulk';
			echo '<form action="'.$url.'" method="get" id="city_frm_bulk_upload" name="city_frm_bulk_upload">
			<input type="hidden" value="bulk" name="page"><input type="hidden" value="city_csvonly" name="emsg">
			</form>
			<script>document.city_frm_bulk_upload.submit();</script>
			';exit;
			//wp_redirect(site_url().'/wp-admin/admin.php?page=bulk&emsg=csvonly');exit;	
		}
	}else
	{
		$url = site_url().'/wp-admin/admin.php?page=bulk';
		echo '<form action="'.$url.'" method="get" id="city_frm_bulk_upload" name="city_frm_bulk_upload">
		<input type="hidden" value="bulk" name="page"><input type="hidden" value="city_invalid_file" name="emsg">
		</form>
		<script>document.city_frm_bulk_upload.submit();</script>
		';exit;
		//wp_redirect(site_url().'/wp-admin/admin.php?page=bulk&emsg=invalid_file');exit;
	}
}



		
		
?>

<form action="<?php echo site_url()?>/wp-admin/admin.php?page=bulk" method="post" name="city_bukl_upload_frm" enctype="multipart/form-data">
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
  <h2><?php _e('City Bulk Import/Export');?></h2>
 

  <table style=" width:40%" cellpadding="3" cellspacing="3" class="widefat post fixed" >
    <tr>
      <td width="24%"><?php _e('Select CSV file to upload');?></td>
      <td width="70%">:
        <input type="file" name="city_bulk_upload_csv" id="city_bulk_upload_csv"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    <td><input type="submit" name="submit" value="<?php _e('Submit');?>" onClick="return check_city_frm();" class="button-secondary action" >    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>    
    </tr>
    
    <tr><td></td>
      <td><?php _e('You can export your cities');?> <a href="<?php echo home_url()?>/?export=city"><span class="button-secondary action"><?php _e('Download');?></span></a></td>
   </tr>
  </table>
</form>
<script>
function check_city_frm()
{
	if(document.getElementById('city_bulk_upload_csv').value == '')
	{
		alert("<?php _e('Please select csv file to upload');?>");
		return false;
	}
	return true;
}
</script>

<?php
##############################################################################################
################################## COUNTRY BULK UPLOAD #######################################
##############################################################################################
global $wpdb,$current_user,$upload_folder_path;
$tmppath = $upload_folder_path."csv/";

if($_FILES['country_bulk_upload_csv'])
{

	if($_FILES['country_bulk_upload_csv']['name']!='' && $_FILES['country_bulk_upload_csv']['error']=='0')
	{
		$filename = $_FILES['country_bulk_upload_csv']['name'];
		$filenamearr = explode('.',$filename);
		$extensionarr = array('csv','CSV');
		
		if(in_array($filenamearr[count($filenamearr)-1],$extensionarr))
		{
			$tmppath = $upload_folder_path."csv/";
			$destination_path = ABSPATH . "$tmppath";
			if (!file_exists($destination_path))
			{
				mkdir($destination_path, 0777);				
			}
			$target_path = $destination_path . $filename;
			$csv_target_path = $target_path;
			if(move_uploaded_file($_FILES['country_bulk_upload_csv']['tmp_name'], $target_path)) 
			{
				$fd = fopen ($target_path, "rt");

				$rowcount = 0;
				$new_row = 0;
				$update_row = 0;
				$customKeyarray = array();
				while (!feof ($fd))
				{
					$buffer = fgetcsv($fd, 40960);
					if($rowcount == 0)
					{
						for($k=0;$k<count($buffer);$k++)
						{
							$customKeyarray[$k] = $buffer[$k];
						}
						if($customKeyarray[0]=='')
						{
							$url = site_url().'/wp-admin/admin.php?page=bulk'; 
							echo '<form action="'.$url.'" method="get" id="frm_bulk_upload" name="frm_bulk_upload">
							<input type="hidden" value="bulk" name="page"><input type="hidden" value="city_wrong" name="emsg">
							</form>
							<script>document.city_frm_bulk_upload.submit();</script>';exit;	
						}
					}else
					{
						$id = addslashes($buffer[0]);
						$name = addslashes($buffer[1]);
						$slug = addslashes($buffer[2]);
						$lat = addslashes($buffer[3]);
						$lng = addslashes($buffer[4]);
						$scall_factor = addslashes($buffer[5]);
						$sortorder = addslashes($buffer[6]);
						$is_zoom_home = addslashes($buffer[7]);
						$categories = addslashes($buffer[8]);
						$cities = addslashes($buffer[9]);
						$regions = addslashes($buffer[10]);
						$is_default = addslashes($buffer[11]);
						$cat_ex = addslashes($buffer[12]);
						$home_desc = addslashes($buffer[13]);
						$meta_desc = addslashes($buffer[14]);			
						
						if($id!='' && $name)
						{
						
						$wpdb->query("update $multicountry_db_table_name set countryname=\"$name\", lat=\"$lat\", lng=\"$lng\", scall_factor=\"$scall_factor\",categories=\"$categories\",cat_ex=\"$cat_ex\",is_zoom_home=\"$is_zoom_home\",is_default=\"$default\",sortorder=\"$sortorder\",country_slug=\"$slug\",cities=\"$cities\",regions=\"$regions\",home_desc=\"$home_desc\",meta_desc=\"$meta_desc\" where country_id=\"$id\"");
						$update_row++;
				
						}elseif($name){
							$wpdb->query("insert into $multicountry_db_table_name (countryname,lat,lng,scall_factor,categories,cat_ex,is_zoom_home,is_default,sortorder,country_slug,cities,regions,home_desc,meta_desc) values (\"$name\",\"$lat\",\"$lng\",\"$scall_factor\",\"$categories\",\"$cat_ex\",\"$is_zoom_home\",\"$default\",\"$sortorder\",\"$slug\",\"$cities\",\"$regions\",\"$home_desc\",\"$meta_desc\")");
						$new_row++;
						
						}
					}				
				$rowcount++;
				}
				@unlink($csv_target_path);
				$url = site_url().'/wp-admin/admin.php?page=bulk';
				echo '<form action="'.$url.'" method="get" id="country_frm_bulk_upload" name="country_frm_bulk_upload">
				<input type="hidden" value="bulk" name="page">
				<input type="hidden" value="city_success" name="msg">
				<input type="hidden" value="'.$new_row.'" name="new_row">
				<input type="hidden" value="'.$update_row.'" name="update_row">
				</form>
				<script>document.country_frm_bulk_upload.submit();</script>
				';exit;
			}
			else
			{
				$url = site_url().'/wp-admin/admin.php?page=bulk';
				echo '<form action="'.$url.'" method="get" id="country_frm_bulk_upload" name="country_frm_bulk_upload">
				<input type="hidden" value="bulk" name="page">
				<input type="hidden" value="city_tmpfile" name="emsg">
				</form>
				<script>document.country_frm_bulk_upload.submit();</script>
				';exit;
			}
		}else
		{
			$url = site_url().'/wp-admin/admin.php?page=bulk';
			echo '<form action="'.$url.'" method="get" id="country_frm_bulk_upload" name="country_frm_bulk_upload">
			<input type="hidden" value="bulk" name="page"><input type="hidden" value="city_csvonly" name="emsg">
			</form>
			<script>document.country_frm_bulk_upload.submit();</script>
			';exit;
			//wp_redirect(site_url().'/wp-admin/admin.php?page=bulk&emsg=csvonly');exit;	
		}
	}else
	{
		$url = site_url().'/wp-admin/admin.php?page=bulk';
		echo '<form action="'.$url.'" method="get" id="country_frm_bulk_upload" name="country_frm_bulk_upload">
		<input type="hidden" value="bulk" name="page"><input type="hidden" value="city_invalid_file" name="emsg">
		</form>
		<script>document.country_frm_bulk_upload.submit();</script>
		';exit;
		//wp_redirect(site_url().'/wp-admin/admin.php?page=bulk&emsg=invalid_file');exit;
	}
}



		
		
?>

<form action="<?php echo site_url()?>/wp-admin/admin.php?page=bulk" method="post" name="country_bukl_upload_frm" enctype="multipart/form-data">
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
  <h2><?php _e('Country Bulk Import/Export');?></h2>
 
 
  <table style=" width:40%" cellpadding="3" cellspacing="3" class="widefat post fixed" >
    <tr>
      <td width="24%"><?php _e('Select CSV file to upload');?></td>
      <td width="70%">:
        <input type="file" name="country_bulk_upload_csv" id="country_bulk_upload_csv"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    <td><input type="submit" name="submit" value="<?php _e('Submit');?>" onClick="return check_country_frm();" class="button-secondary action" >    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>    
    </tr>
    
    <tr><td></td>
      <td><?php _e('You can export your Countries');?> <a href="<?php echo home_url()?>/?export=country"><span  class="button-secondary action"><?php _e('Download');?></span></a></td>
   </tr>
  </table>
</form>
<script>
function check_country_frm()
{
	if(document.getElementById('country_bulk_upload_csv').value == '')
	{
		alert("<?php _e('Please select csv file to upload');?>");
		return false;
	}
	return true;
}
</script>

<?php
##############################################################################################
################################## REGION BULK UPLOAD #######################################
##############################################################################################
global $wpdb,$current_user,$upload_folder_path;
$tmppath = $upload_folder_path."csv/";

if($_FILES['region_bulk_upload_csv'])
{

	if($_FILES['region_bulk_upload_csv']['name']!='' && $_FILES['region_bulk_upload_csv']['error']=='0')
	{
		$filename = $_FILES['region_bulk_upload_csv']['name'];
		$filenamearr = explode('.',$filename);
		$extensionarr = array('csv','CSV');
		
		if(in_array($filenamearr[count($filenamearr)-1],$extensionarr))
		{
			$tmppath = $upload_folder_path."csv/";
			$destination_path = ABSPATH . "$tmppath";
			if (!file_exists($destination_path))
			{
				mkdir($destination_path, 0777);				
			}
			$target_path = $destination_path . $filename;
			$csv_target_path = $target_path;
			if(move_uploaded_file($_FILES['region_bulk_upload_csv']['tmp_name'], $target_path)) 
			{
				$fd = fopen ($target_path, "rt");

				$rowcount = 0;
				$new_row = 0;
				$update_row = 0;
				$customKeyarray = array();
				while (!feof ($fd))
				{
					$buffer = fgetcsv($fd, 40960);
					if($rowcount == 0)
					{
						for($k=0;$k<count($buffer);$k++)
						{
							$customKeyarray[$k] = $buffer[$k];
						}
						if($customKeyarray[0]=='')
						{
							$url = site_url().'/wp-admin/admin.php?page=bulk'; 
							echo '<form action="'.$url.'" method="get" id="frm_bulk_upload" name="frm_bulk_upload">
							<input type="hidden" value="bulk" name="page"><input type="hidden" value="city_wrong" name="emsg">
							</form>
							<script>document.city_frm_bulk_upload.submit();</script>';exit;	
						}
					}else
					{
						$id = addslashes($buffer[0]);
						$name = addslashes($buffer[1]);
						$slug = addslashes($buffer[2]);
						$lat = addslashes($buffer[3]);
						$lng = addslashes($buffer[4]);
						$scall_factor = addslashes($buffer[5]);
						$sortorder = addslashes($buffer[6]);
						$is_zoom_home = addslashes($buffer[7]);
						$categories = addslashes($buffer[8]);
						$cities = addslashes($buffer[9]);
						$is_default = addslashes($buffer[10]);
						$cat_ex = addslashes($buffer[11]);
						$home_desc = addslashes($buffer[12]);
						$meta_desc = addslashes($buffer[13]);									
						
						if($id!='' && $name)
						{
						
						$wpdb->query("update $multiregion_db_table_name set regionname=\"$name\", lat=\"$lat\", lng=\"$lng\", scall_factor=\"$scall_factor\",categories=\"$categories\",cat_ex=\"$cat_ex\",is_zoom_home=\"$is_zoom_home\",is_default=\"$default\",sortorder=\"$sortorder\",region_slug=\"$slug\",cities=\"$cities\",home_desc=\"$home_desc\",meta_desc=\"$meta_desc\" where region_id=\"$id\"");
						$update_row++;
				
						}elseif($name){
							$wpdb->query("insert into $multiregion_db_table_name (regionname,lat,lng,scall_factor,categories,cat_ex,is_zoom_home,is_default,sortorder,region_slug,cities,home_desc,meta_desc) values (\"$name\",\"$lat\",\"$lng\",\"$scall_factor\",\"$categories\",\"$cat_ex\",\"$is_zoom_home\",\"$default\",\"$sortorder\",\"$slug\",\"$cities\",\"$home_desc\",\"$meta_desc\")");
						$new_row++;
						
						}
					}				
				$rowcount++;
				}
				@unlink($csv_target_path);
				$url = site_url().'/wp-admin/admin.php?page=bulk';
				echo '<form action="'.$url.'" method="get" id="region_frm_bulk_upload" name="region_frm_bulk_upload">
				<input type="hidden" value="bulk" name="page">
				<input type="hidden" value="city_success" name="msg">
				<input type="hidden" value="'.$new_row.'" name="new_row">
				<input type="hidden" value="'.$update_row.'" name="update_row">
				</form>
				<script>document.region_frm_bulk_upload.submit();</script>
				';exit;
			}
			else
			{
				$url = site_url().'/wp-admin/admin.php?page=bulk';
				echo '<form action="'.$url.'" method="get" id="region_frm_bulk_upload" name="region_frm_bulk_upload">
				<input type="hidden" value="bulk" name="page">
				<input type="hidden" value="city_tmpfile" name="emsg">
				</form>
				<script>document.region_frm_bulk_upload.submit();</script>
				';exit;
			}
		}else
		{
			$url = site_url().'/wp-admin/admin.php?page=bulk';
			echo '<form action="'.$url.'" method="get" id="region_frm_bulk_upload" name="region_frm_bulk_upload">
			<input type="hidden" value="bulk" name="page"><input type="hidden" value="city_csvonly" name="emsg">
			</form>
			<script>document.region_frm_bulk_upload.submit();</script>
			';exit;
			//wp_redirect(site_url().'/wp-admin/admin.php?page=bulk&emsg=csvonly');exit;	
		}
	}else
	{
		$url = site_url().'/wp-admin/admin.php?page=bulk';
		echo '<form action="'.$url.'" method="get" id="region_frm_bulk_upload" name="region_frm_bulk_upload">
		<input type="hidden" value="bulk" name="page"><input type="hidden" value="city_invalid_file" name="emsg">
		</form>
		<script>document.region_frm_bulk_upload.submit();</script>
		';exit;
		//wp_redirect(site_url().'/wp-admin/admin.php?page=bulk&emsg=invalid_file');exit;
	}
}



		
		
?>

<form action="<?php echo site_url()?>/wp-admin/admin.php?page=bulk" method="post" name="region_bukl_upload_frm" enctype="multipart/form-data">
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
  <h2><?php _e('Region Bulk Import/Export');?></h2>
 
 
  <table style=" width:40%" cellpadding="3" cellspacing="3" class="widefat post fixed" >
    <tr>
      <td width="24%"><?php _e('Select CSV file to upload');?></td>
      <td width="70%">:
        <input type="file" name="region_bulk_upload_csv" id="region_bulk_upload_csv"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    <td><input type="submit" name="submit" value="<?php _e('Submit');?>" onClick="return check_region_frm();" class="button-secondary action" >    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>    
    </tr>
    
    <tr><td></td>
      <td><?php _e('You can export your Regions');?> <a href="<?php echo home_url()?>/?export=region"><span  class="button-secondary action"><?php _e('Download');?></span></a></td>
   </tr>
  </table>
</form>
<script>
function check_region_frm()
{
	if(document.getElementById('region_bulk_upload_csv').value == '')
	{
		alert("<?php _e('Please select csv file to upload');?>");
		return false;
	}
	return true;
}
</script>


<?php
##############################################################################################
################################## HOOD BULK UPLOAD #######################################
##############################################################################################
global $wpdb,$current_user,$upload_folder_path;
$tmppath = $upload_folder_path."csv/";

if($_FILES['hood_bulk_upload_csv'])
{

	if($_FILES['hood_bulk_upload_csv']['name']!='' && $_FILES['hood_bulk_upload_csv']['error']=='0')
	{
		$filename = $_FILES['hood_bulk_upload_csv']['name'];
		$filenamearr = explode('.',$filename);
		$extensionarr = array('csv','CSV');
		
		if(in_array($filenamearr[count($filenamearr)-1],$extensionarr))
		{
			$tmppath = $upload_folder_path."csv/";
			$destination_path = ABSPATH . "$tmppath";
			if (!file_exists($destination_path))
			{
				mkdir($destination_path, 0777);				
			}
			$target_path = $destination_path . $filename;
			$csv_target_path = $target_path;
			if(move_uploaded_file($_FILES['hood_bulk_upload_csv']['tmp_name'], $target_path)) 
			{
				$fd = fopen ($target_path, "rt");

				$rowcount = 0;
				$new_row = 0;
				$update_row = 0;
				$customKeyarray = array();
				while (!feof ($fd))
				{
					$buffer = fgetcsv($fd, 40960);
					if($rowcount == 0)
					{
						for($k=0;$k<count($buffer);$k++)
						{
							$customKeyarray[$k] = $buffer[$k];
						}
						if($customKeyarray[0]=='')
						{
							$url = site_url().'/wp-admin/admin.php?page=bulk'; 
							echo '<form action="'.$url.'" method="get" id="frm_bulk_upload" name="frm_bulk_upload">
							<input type="hidden" value="bulk" name="page"><input type="hidden" value="city_wrong" name="emsg">
							</form>
							<script>document.city_frm_bulk_upload.submit();</script>';exit;	
						}
					}else
					{
						$id = addslashes($buffer[0]);
						$name = addslashes($buffer[1]);
						$slug = addslashes($buffer[2]);
						$lat = addslashes($buffer[3]);
						$lng = addslashes($buffer[4]);
						$scall_factor = addslashes($buffer[5]);
						$sortorder = addslashes($buffer[6]);
						$is_zoom_home = addslashes($buffer[7]);
						$categories = addslashes($buffer[8]);
						$cities = addslashes($buffer[9]);
						$is_default = addslashes($buffer[10]);
						$cat_ex = addslashes($buffer[11]);
						$home_desc = addslashes($buffer[12]);
						$meta_desc = addslashes($buffer[13]);
									
						
						if($id!='' && $name)
						{
						
						$wpdb->query("update $multihood_db_table_name set hoodname=\"$name\", lat=\"$lat\", lng=\"$lng\", scall_factor=\"$scall_factor\",categories=\"$categories\",cat_ex=\"$cat_ex\",is_zoom_home=\"$is_zoom_home\",is_default=\"$default\",sortorder=\"$sortorder\",hood_slug=\"$slug\",cities=\"$cities\",home_desc=\"$home_desc\",meta_desc=\"$meta_desc\" where hood_id=\"$id\"");
						$update_row++;
				
						}elseif($name){
							$wpdb->query("insert into $multihood_db_table_name (hoodname,lat,lng,scall_factor,categories,cat_ex,is_zoom_home,is_default,sortorder,hood_slug,cities,home_desc,meta_desc) values (\"$name\",\"$lat\",\"$lng\",\"$scall_factor\",\"$categories\",\"$cat_ex\",\"$is_zoom_home\",\"$default\",\"$sortorder\",\"$slug\",\"$cities\",\"$home_desc\",\"$meta_desc\")");
						$new_row++;
						
						}
					}				
				$rowcount++;
				}
				@unlink($csv_target_path);
				$url = site_url().'/wp-admin/admin.php?page=bulk';
				echo '<form action="'.$url.'" method="get" id="hood_frm_bulk_upload" name="hood_frm_bulk_upload">
				<input type="hidden" value="bulk" name="page">
				<input type="hidden" value="city_success" name="msg">
				<input type="hidden" value="'.$new_row.'" name="new_row">
				<input type="hidden" value="'.$update_row.'" name="update_row">
				</form>
				<script>document.hood_frm_bulk_upload.submit();</script>
				';exit;
			}
			else
			{
				$url = site_url().'/wp-admin/admin.php?page=bulk';
				echo '<form action="'.$url.'" method="get" id="hood_frm_bulk_upload" name="hood_frm_bulk_upload">
				<input type="hidden" value="bulk" name="page">
				<input type="hidden" value="city_tmpfile" name="emsg">
				</form>
				<script>document.hood_frm_bulk_upload.submit();</script>
				';exit;
			}
		}else
		{
			$url = site_url().'/wp-admin/admin.php?page=bulk';
			echo '<form action="'.$url.'" method="get" id="hood_frm_bulk_upload" name="hood_frm_bulk_upload">
			<input type="hidden" value="bulk" name="page"><input type="hidden" value="city_csvonly" name="emsg">
			</form>
			<script>document.hood_frm_bulk_upload.submit();</script>
			';exit;
			//wp_redirect(site_url().'/wp-admin/admin.php?page=bulk&emsg=csvonly');exit;	
		}
	}else
	{
		$url = site_url().'/wp-admin/admin.php?page=bulk';
		echo '<form action="'.$url.'" method="get" id="hood_frm_bulk_upload" name="hood_frm_bulk_upload">
		<input type="hidden" value="bulk" name="page"><input type="hidden" value="city_invalid_file" name="emsg">
		</form>
		<script>document.hood_frm_bulk_upload.submit();</script>
		';exit;
		//wp_redirect(site_url().'/wp-admin/admin.php?page=bulk&emsg=invalid_file');exit;
	}
}



		

?>

<form action="<?php echo site_url()?>/wp-admin/admin.php?page=bulk" method="post" name="hood_bukl_upload_frm" enctype="multipart/form-data">
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
  <h2><?php _e('Neighborhood Bulk Import/Export');?></h2>
 
 
  <table style=" width:40%" cellpadding="3" cellspacing="3" class="widefat post fixed" >
    <tr>
      <td width="24%"><?php _e('Select CSV file to upload');?></td>
      <td width="70%">:
        <input type="file" name="hood_bulk_upload_csv" id="hood_bulk_upload_csv"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    <td><input type="submit" name="submit" value="<?php _e('Submit');?>" onClick="return check_hood_frm();" class="button-secondary action" >    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>    
    </tr>
    
    <tr><td></td>
      <td><?php _e('You can export your Neighborhoods');?> <a href="<?php echo home_url()?>/?export=hoods"><span id="hood_export"  class="button-secondary action"><?php _e('Download');?></span></a></td>
   </tr>
  </table>
</form>
<script>
function check_hood_frm()
{
	if(document.getElementById('hood_bulk_upload_csv').value == '')
	{
		alert("<?php _e('Please select csv file to upload');?>");
		return false;
	}
	return true;
}
</script>