<?php
global $wpdb,$price_db_table_name;
if($_REQUEST['run'] == 'dbcheck')
{
	
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
  <h2><?php _e('GeoTheme Diagnostics & Tools');?></h2>
 <?php if($_REQUEST['run']=='test'){?>
 <div class="updated fade below-h2" id="message" style="background-color: rgb(255, 251, 204);" >
 <p><?php _e('Test run');?></p>
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
// TOOL FUNCTIONS
if($_REQUEST['tool']=='blog_convert'){ echo tool_blog_convert();} 
if($_REQUEST['tool']=='price_fix'){ echo fix_price_db();} 
if($_REQUEST['tool']=='fix_images'){ echo fix_images();} 
if($_REQUEST['tool']=='fix_featured'){ echo fix_double_featured();} 
?>
  
<?php 
// DIAGNOSTIC FUNCTIONS
if($_REQUEST['chk']=='locations'){ echo chk_city_db();echo chk_country_db();echo chk_region_db();echo chk_hood_db();} 
?>
  


  <table style=" width:60%" cellpadding="3" cellspacing="3" class="widefat post fixed" >



    
    
    <tr>
      <td width="10%">&nbsp;</td>
      <td><h2><?php _e('Diagnostics');?></h2></td>   
    </tr>
    
    <tr>
      <td width="10%"><button onClick='window.location.href="<?php echo site_url().'/wp-admin/admin.php?page=gt_tools&chk=locations'?>"' title="Run" class="button-secondary action" >Run</button></td>
      <td >:<?php _e('Check the Location database structure.');?></td>
    </tr>
    

     
    <tr>
      <td width="10%">&nbsp;</td>
      <td><h2><?php _e('Tools');?></h2></td>   
    </tr>
    
    <tr>
      <td width="10%"><button onClick='window.location.href="<?php echo site_url().'/wp-admin/admin.php?page=gt_tools&tool=blog_convert'?>"' title="Run" class="button-secondary action" >Run</button></td>
      <td >:<?php _e('Convert all Blog posts with no city ID to have city ID of "0" and appear everywhere.');?></td>
    </tr>
    
    <tr>
      <td width="10%"><button onClick='delete_price()' title="Run" class="button-secondary action" >Run</button></td>
      <td >:<?php _e('Drop and re-add the Price table (all prices will be deleted)');?></td>
    </tr>
    
    <tr>
      <td width="10%"><button onClick='window.location.href="<?php echo site_url().'/wp-admin/admin.php?page=gt_tools&tool=fix_images'?>"' title="Run" class="button-secondary action" >Run</button></td>
      <td >:<?php _e('Fix images not showing in the media library.');?></td>
    </tr>
    
    <tr>
      <td width="10%"><button onClick='window.location.href="<?php echo site_url().'/wp-admin/admin.php?page=paymentoptions&pay_fix=run'?>"' title="Run" class="button-secondary action" >Run</button></td>
      <td >:<?php _e('Drop and re-add the payment options (payment option settings will be lost)');?></td>
    </tr>
    
     <tr>
      <td width="10%"><button onClick='window.location.href="<?php echo site_url().'/wp-admin/admin.php?page=gt_tools&tool=fix_featured'?>"' title="Run" class="button-secondary action" >Run</button></td>
      <td >:<?php _e('Fix double featured post meta');?></td>
    </tr>
    

    
    
    <tr>
      <td>&nbsp;</td>
      <td> </td>   
    </tr>
    
  
  </table>

<script language="javascript">
function delete_price(priceid)
{
	if(confirm('<?php _e('Are you sure want to delete the price table?');?>'))
	{
		window.location.href="<?php echo site_url().'/wp-admin/admin.php?page=gt_tools&tool=price_fix'?>";
		return true;
	}else
	{
		return false;
	}
}
</script>
