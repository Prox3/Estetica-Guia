<?php
global $wpdb,$price_db_table_name;
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
 
<?php 
// DIAGNOSTIC FUNCTIONS
if($_REQUEST['chk']=='all'){

######## CHECK PERMALINKS ARE SAVED #############	
echo '<h4>'.__('Permalinks saved checks').'</h4>';
echo gt_chk_permalinks();

######## CHECK UPLOAD FOLDER IS WRITABLE #############	
echo '<h4>'.__('Upload folder is writable checks').'</h4>';
echo gt_chk_upload();

######## CHECK FOR DOUBLE POST META #############	
echo '<h4>'.__('Double featured meta check (breaks search)').'</h4>';
echo gt_chk_double_meta();

######## THEME IN CORRECT FOLDER CHECK #############	
echo '<h4>'.__('Theme in correct folder checks').'</h4>';
echo gt_chk_folder();

######## NOTIFICATIONS SAVE CHECK #############	
echo '<h4>'.__('Notifications save checks').'</h4>';
echo gt_chk_notifications();

######## SESSION SAVE CHECK #############	
echo '<h4>'.__('Session save checks').'</h4>';
echo gt_chk_sessions();

######## BLOG POST LOCATION CHECK #############	
echo '<h4>'.__('Blog post location checks').'</h4>';
echo tool_blog_chk();

######## LOCATION DB CHECKS #############	
echo '<h4>'.__('Location database checks').'</h4>';
echo chk_city_db();
echo chk_country_db();
echo chk_region_db();
echo chk_hood_db();

######## PRICE DB CHECKS #############	
echo '<h4>'.__('Price database checks').'</h4>';
echo chk_price_db();

######## PLACE AND EVENT CITY AND PACKAGE CHECKS #############	
echo '<h4>'.__('City and Price ID checks').'</h4>';
echo chk_price_ID();
echo chk_city_ID();

}else{$_SESSION['test_value']='testing';}

?>
  


  <table style=" width:60%" cellpadding="3" cellspacing="3" class="widefat post fixed" >

<tr>
      <td width="10%">&nbsp;</td>
      <td><h2><?php _e('Diagnostics');?></h2></td>   
    </tr>
    
    <tr>
      <td width="10%"><button onClick='window.location.href="<?php echo site_url().'/wp-admin/admin.php?page=diagnostics&chk=all'?>"' title="Run" class="button-secondary action" >Run</button></td>
      <td >:<?php _e('Run full scan.');?></td>
    </tr>
    
    
    <tr>
      <td>&nbsp;</td>
      <td> </td>   
    </tr>
    
  
  </table>

