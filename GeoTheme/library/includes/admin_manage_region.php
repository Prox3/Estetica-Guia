<?php
global $wpdb,$multiregion_db_table_name;
if($_REQUEST['pagetype'] == 'delete' && $_REQUEST['id'] != '' && $_REQUEST['id'] != '0')
{
	$pid = $_REQUEST['id'];
	$wpdb->query("delete from $multiregion_db_table_name where region_id=\"$pid\"");
	$location = site_url()."/wp-admin/admin.php";
	echo '<form action="'.$location.'" method=get name="price_success">
	<input type=hidden name="page" value="region"><input type=hidden name="msg" value="delsuccess"></form>';
	echo '<script>document.price_success.submit();</script>';
	exit;
}
?>
<style>
h2 {
	color:#464646;
	font-family:Georgia, "Times New Roman", "Bitstream Charter", Times, serif;
	font-size:24px;
	font-size-adjust:none;
	font-stretch:normal;
	font-style:italic;
	font-variant:normal;
	font-weight:normal;
	line-height:35px;
	margin:0;
	padding:14px 15px 3px 0;
	text-shadow:0 1px 0 #FFFFFF;
}
</style>
<h2><?php _e('Manage Region'); ?></h2>
<?php if($_REQUEST['msg']=='success'){?>
<div class="updated fade below-h2" id="message" style="background-color: rgb(255, 251, 204);" >
  <p><?php _e('Region updated successfully.'); ?></p>
</div>
<?php }?>
<?php if($_REQUEST['msg']=='delsuccess'){?>
<div class="updated fade below-h2" id="message" style="background-color: rgb(255, 251, 204);" >
  <p><?php _e('Region deleted successfully.'); ?></p>
</div>
<?php }?>
<p><a href="<?php echo site_url().'/wp-admin/admin.php?page=region&pagetype=addedit'?>"><strong><?php _e('Add Region'); ?></strong></a> </p>

<table style=" width:70%" cellpadding="5" class="widefat post fixed" >
  <thead>
    <tr>
      <th width="50" align="left"><strong><?php _e('ID'); ?></strong></th>
      <th width="150" align="left"><strong><?php _e('Region'); ?></strong></th>
      <th width="150" align="left"><strong><?php _e('latitute '); ?></strong></th>
      <th width="150" align="left"><strong><?php _e('longitude'); ?></strong></th>
       <th width="85" align="left"><strong><?php _e('Scaling Factor'); ?></strong></th>
      <th width="85" align="left"><strong><?php _e('Zooming Home?'); ?></strong></th>
      <th width="50" align="left"><strong><?php _e('Default Region'); ?></strong></th>
       <th width="50" align="left"><strong><?php _e('Sort Order'); ?></strong></th>
     <th width="185" align="left"><strong><?php _e('Category IDs'); ?></strong></th>
       <th width="85" align="left"><strong><?php _e('Action'); ?></strong></th>
      <th align="left">&nbsp;</th>
    </tr>
<?php
$regionsql = "select * from $multiregion_db_table_name WHERE region_id!=0";
$cityinfo = $wpdb->get_results($regionsql);
if($cityinfo)
{
	foreach($cityinfo as $cityinfoObj)
	{
?>
    <tr>
      <td><?php echo $cityinfoObj->region_id;?></td>
      <td><?php echo $cityinfoObj->regionname;?></td>
      <td><?php echo $cityinfoObj->lat;?></td>
      <td><?php echo $cityinfoObj->lng;?></td>
       <td><?php echo $cityinfoObj->scall_factor ;?></td>
       <td><?php echo $cityinfoObj->is_zoom_home;?></td>
       <td><?php echo $cityinfoObj->is_default;?></td>
        <td><?php echo $cityinfoObj->sortorder;?></td>
      <td><?php echo $cityinfoObj->categories;?></td>
      <td><a href="<?php echo site_url().'/wp-admin/admin.php?page=region&pagetype=addedit&id='.$cityinfoObj->region_id;?>"><?php _e('Edit'); ?></a> | <a href="javascript:void(0);" onclick="return delete_rec('<?php echo $cityinfoObj->region_id;?>');"><?php _e('Delete'); ?></a></td>
      <td>&nbsp;</td>
    </tr>
    <?php
	}
}
?>
  </thead>
</table>
<br />
<?php _e('<strong>Note : </strong>You should set at least one city as Default. Default city information will be displayed on opening the site. If you want to set multicity functionaltiy, you should add more than one city and "post_city_id" as custom field of post to assign the listing to the city.');?>
<script language="javascript">
function delete_rec(priceid)
{
	if(confirm('<?php _e('Are you sure you want to delete this region?');?>'))
	{
		window.location.href="<?php echo site_url().'/wp-admin/admin.php?page=region&pagetype=delete&id='?>"+priceid;
		return true;
	}else
	{
		return false;
	}
}
</script>
