<?php
global $wpdb,$price_db_table_name;
add_column_if_not_exist($price_db_table_name, 'sort_order');
if($_REQUEST['pagetype'] == 'delete' && $_REQUEST['id'] != '')
{
	$pid = $_REQUEST['id'];
	$wpdb->query("delete from $price_db_table_name where pid=\"$pid\"");
	$location = site_url()."/wp-admin/admin.php";
	echo '<form action="'.$location.'" method=get name="price_success">
	<input type=hidden name="page" value="price"><input type=hidden name="msg" value="delsuccess"></form>';
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
<h2><?php _e('Manage Price'); ?></h2>
<?php if($_REQUEST['msg']=='success'){?>
<div class="updated fade below-h2" id="message" style="background-color: rgb(255, 251, 204);" >
  <p><?php _e('Price updated successfully.'); ?></p>
</div>
<?php }?>
<?php if($_REQUEST['msg']=='delsuccess'){?>
<div class="updated fade below-h2" id="message" style="background-color: rgb(255, 251, 204);" >
  <p><?php _e('Price deleted successfully.'); ?></p>
</div>
<?php }?>
<p><a href="<?php echo site_url().'/wp-admin/admin.php?page=price&pagetype=addedit'?>"><strong><?php _e('Add Price'); ?></strong></a> </p>
<table style=" width:70%" cellpadding="5" class="widefat post fixed" >
  <thead>
    <tr>
      <th width="85" align="left"><strong><?php _e('Package ID'); ?></strong></th>
      <th width="150" align="left"><strong><?php _e('Title'); ?></strong></th>
      <th width="100" align="left"><strong><?php _e('Post Type'); ?></strong></th>
      <th width="100" align="left"><strong><?php _e('Price'); ?> (<?php echo get_option('currencysym');?>)</strong></th>
      <th width="150" align="left"><strong><?php _e('Number Of Days'); ?></strong></th>
      <th width="60" align="left"><strong><?php _e('Status'); ?></strong></th>
       <th width="85" align="left"><strong><?php _e('Is Featured'); ?></strong></th>
       <th width="85" align="left"><strong><?php _e('Sort Order'); ?></strong></th>
      <th width="85" align="left"><strong><?php _e('Edit'); ?></strong></th>
      <th width="85" align="left"><strong><?php _e('Delete'); ?></strong></th>
      <th align="left">&nbsp;</th>
    </tr>
<?php
$pricesql = "select * from $price_db_table_name ORDER BY sort_order, pid";
$priceinfo = $wpdb->get_results($pricesql);
if($priceinfo)
{
	foreach($priceinfo as $priceinfoObj)
	{
?>
    <tr>
      <td><?php echo $priceinfoObj->pid;?></td>
      <td><?php echo $priceinfoObj->title;?></td>
      <td><?php echo $priceinfoObj->post_type;?></td>
      <td><?php echo $priceinfoObj->amount;?></td>
      <td><?php echo $priceinfoObj->days;?></td>
      <td><?php if($priceinfoObj->status==1) _e("Active"); else _e("Inactive");?></td>
       <td><?php if($priceinfoObj->is_featured==1) _e("Yes");?></td>
       <td><?php echo $priceinfoObj->sort_order;?></td>
      <td><a href="<?php echo site_url().'/wp-admin/admin.php?page=price&pagetype=addedit&id='.$priceinfoObj->pid;?>"><?php _e('Edit'); ?></a> </td>
      <td><a href="javascript:void(0);" onclick="return delete_rec('<?php echo $priceinfoObj->pid;?>');"><?php _e('Delete'); ?></a></td>
      <td>&nbsp;</td>
    </tr>
    <?php
	}
}
?>
  </thead>
</table>
<script language="javascript">
function delete_rec(priceid)
{
	if(confirm('<?php _e('Are you sure want to delete price?');?>'))
	{
		window.location.href="<?php echo site_url().'/wp-admin/admin.php?page=price&pagetype=delete&id='?>"+priceid;
		return true;
	}else
	{
		return false;
	}
}
</script>
