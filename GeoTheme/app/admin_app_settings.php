<?php
global $wpdb;
if($_POST)
{
$option_value['gt_app_skin'] = $_POST['gt_app_skin'];
$option_value['gt_app_tc'] = $_POST['gt_app_tc'];
$option_value['gt_app_about'] = $_POST['gt_app_about'];
$option_value['gt_app_per_page'] = $_POST['gt_app_per_page'];
$option_value['gt_app_loc_ord'] = $_POST['gt_app_loc_ord'];

	
	foreach($option_value as $key=>$val)
	{
		if($key){
		update_option($key,$val);	
		}
	}
$message = "Updated Succesfully.";

}
?>
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
  <h2><?php _e('GeoTheme iOS App Settings');?></h2>
 <?php if($message){?>
 <div class="updated fade below-h2" id="message" style="background-color: rgb(255, 251, 204);" >
 <p><?php _e('Settings Saved');?></p>
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

<form action="<?php echo site_url();?>/wp-admin/admin.php?page=app_settings" method="post">



  <table style=" width:60%" cellpadding="3" cellspacing="3" class="widefat post fixed" >
	<tr>
      <td width="10%">&nbsp;</td>
      <td><h2><?php _e('About Page');?></h2></td>   
    </tr>
    
    <tr>
      <td width="10%" colspan="2">
			<?php 
			global $wp_version;
			$meta = stripslashes(get_option('gt_app_about'));

		if ( version_compare( $wp_version, '3.2.1' ) < 1 ) {
			echo "<textarea class='at-wysiwyg theEditor large-text' name='gt_app_about' id='gt_app_about' cols='60' rows='10'>$meta</textarea>";
		}else{
			// Use new wp_editor() since WP 3.3
			wp_editor( stripslashes(html_entity_decode($meta)), 'gt_app_about', array( 'editor_class' => 'at-wysiwyg' ) );
		}
			
			
			?>

      </td>
    </tr>
    
    <tr>
      <td width="10%">&nbsp;</td>
      <td><h2><?php _e('Terms & Conditions');?></h2></td>   
    </tr>
    
    <tr>
      <td width="10%" colspan="2">
			<?php 
			$tc_meta = stripslashes(get_option('gt_app_tc'));

			echo "<textarea class='at-wysiwyg theEditor large-text' name='gt_app_tc' id='gt_app_tc' cols='60' rows='10'>$tc_meta</textarea>";
			
		?>

      </td>
    </tr>
    

     
    <tr>
      <td width="10%">&nbsp;</td>
      <td><h2><?php _e('Listing Settings');?></h2></td>   
    </tr>
    
    <tr>
      <td width="10%"><?php _e('Posts per page');?></td>
      <td >
	  <select id="gt_app_per_page" name="gt_app_per_page">
      <?php $i = 1;
while ($i <= 100) {?>
  <option  <?php if(get_option('gt_app_per_page')==$i){echo 'selected="selected"';}?>><?php echo $i;?></option>
<?php $i++; }?>
  
</select>
	  </td>
    </tr>
    
    
    
    
    
    
    
    <tr>
      <td width="10%">&nbsp;</td>
      <td><h2><?php _e('Style Settings');?></h2></td>   
    </tr>
    
    <tr>
      <td width="10%"><?php _e('Add listing page skin');?></td>
      <td >
	  <select id="gt_app_skin" name="gt_app_skin">
      
  <option  <?php if(get_option('gt_app_skin')=='light'){echo 'selected="selected"';}?> value="light"><?php _e('Light');?></option>
  <option  <?php if(get_option('gt_app_skin')=='dark'){echo 'selected="selected"';}?> value="dark"><?php _e('Dark');?></option>
  <option  <?php if(get_option('gt_app_skin')=='apple'){echo 'selected="selected"';}?> value="apple"><?php _e('Apple');?></option>
  
</select>
	</td>
    </tr>
    
    
    
    <tr>
      <td width="10%">&nbsp;</td>
      <td><h2><?php _e('Location Settings');?></h2></td>   
    </tr>
    
    <tr>
      <td width="10%"><?php _e('Select location order');?></td>
      <td >
	  <select id="gt_app_loc_ord" name="gt_app_loc_ord">
      
  <option  <?php if(get_option('gt_app_loc_ord')=='sort_order'){echo 'selected="selected"';}?> value="sort_order"><?php _e('Sort Order Number');?></option>
  <option  <?php if(get_option('gt_app_loc_ord')=='az'){echo 'selected="selected"';}?> value="az"><?php _e('A-Z');?></option>
  
</select>
	</td>
    </tr>
    

    
    
    <tr>
      <td>&nbsp;</td>
        <td><p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="Update"></p></td>
    </tr>
    
  
  </table>
</form>
<script language="javascript">
function delete_rec(priceid)
{
	if(confirm('<?php _e('Are you sure want to delet price?');?>'))
	{
		window.location.href="<?php echo site_url().''?>"+priceid;
		return true;
	}else
	{
		return false;
	}
}
</script>
