<?php
global $wpdb,$moderation_db_table_name;
if($_REQUEST['pagetype'] == 'delete' && $_REQUEST['id'] != '')
{
	$pid = $_REQUEST['id'];
	$wpdb->query("delete from $moderation_db_table_name where pid=\"$pid\"");
	$location = site_url()."/wp-admin/admin.php?page=moderation";
	echo '<form action="'.$location.'" method=get name="claim_success">
	<input type=hidden name="page" value="moderation"><input type=hidden name="msg" value="delsuccess"></form>';
	echo '<script>document.claim_success.submit();</script>';
	exit;
}
if($_REQUEST['pagetype'] == 'approve' && $_REQUEST['id'] != '')
{
	$pid = $_REQUEST['id'];	
	$wpdb->query("update $moderation_db_table_name set status='2' where pid=\"$pid\"");

	$location = site_url()."/wp-admin/admin.php?page=moderation";
	echo '<form action="'.$location.'" method=get name="claim_success">
	<input type=hidden name="page" value="moderation"><input type=hidden name="msg" value="approve"></form>';
	echo '<script>document.claim_success.submit();</script>';
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
<h2><?php _e('Manage Moderation Claims'); ?></h2>
<?php if($_REQUEST['msg']=='approve'){?>
<div class="updated fade below-h2" id="message" style="background-color: rgb(255, 251, 204);" >
  <p><?php _e('Moderation claim marked as closed.'); ?></p>
</div>
<?php }?>
<?php if($_REQUEST['msg']=='delsuccess'){?>
<div class="updated fade below-h2" id="message" style="background-color: rgb(255, 251, 204);" >
  <p><?php _e('Moderation claim deleted successfully.'); ?></p>
</div>
<?php }?>
<table style=" width:70%" cellpadding="5" class="widefat post fixed" >
  <thead>
    <tr>
      <th width="150" align="left"><strong><?php _e('Listing Title'); ?></strong></th>
      <th width="150" align="left"><strong><?php _e('User Who Reported'); ?></strong></th>
      <th width="150" align="left"><strong><?php _e('User IP'); ?></strong></th>
      <th width="150" align="left"><strong><?php _e('Reason'); ?></strong></th>
       <th width="85" align="left"><strong><?php _e('Status'); ?></strong></th>
      <th width="85" align="left"><strong><?php _e('Details'); ?></strong></th>
      <th width="85" align="left"><strong><?php _e('Quick Actions'); ?></strong></th>
      <th align="left">&nbsp;</th>
    </tr>
<?php
$claimsql = "select * from $moderation_db_table_name  ORDER BY status ASC, claim_date DESC";
$claiminfo = $wpdb->get_results($claimsql);
if($claiminfo)
{
	foreach($claiminfo as $claiminfoObj)
	{
		//Get username
		$user_info = get_userdata($claiminfoObj->user_id);
?>
    <tr <?php if($claiminfoObj->status==2)echo 'style="background-color:#99FFCC"'; else echo 'style="background-color:#FFAEAE"';  ?>>
      <td><?php echo "<a href='".home_url()."/?p=".$claiminfoObj->list_id."'>$claiminfoObj->list_title</a>";?></td>
      <td><?php echo "<a href='".get_admin_url()."user-edit.php?user_id=".$claiminfoObj->user_id."'>$user_info->user_login</a>"; ?></td>
      <td><?php echo $claiminfoObj->user_ip;?></td>
      <td><?php echo gt_moderation_reason($claiminfoObj->moderation_reason);?></td>
      <td><?php if($claiminfoObj->status=='') _e("Open"); elseif($claiminfoObj->status==2) _e("Closed"); elseif($claiminfoObj->status==1) _e("Pending Review");?></td>
      <td><a href="<?php echo site_url().'/wp-admin/admin.php?page=moderation&pagetype=addedit&id='.$claiminfoObj->pid;?>"><?php _e('Full Details'); ?></a> </td>
      <td>
      <?php if ($claiminfoObj->status==''){ ?>
      <a href="javascript:void(0);" onclick="return approve_rec('<?php echo $claiminfoObj->pid;?>');"><img src="<?php bloginfo('template_directory'); ?>/images/tick.png" alt="<?php _e('Mark Closed');?>" title="<?php _e('Mark Closed');?>"/></a>
      <a href="javascript:void(0);"  onclick="return delete_rec('<?php echo $claiminfoObj->pid;?>');"><img src="<?php bloginfo('template_directory'); ?>/images/delete.png" alt="<?php _e('Delete Moderation Claim');?>" title="<?php _e('Delete Moderation Claim');?>"/></a>
      <?php } ?>
      <?php if ($claiminfoObj->status=='2'){ ?>
      <a href="javascript:void(0);"  onclick="return delete_rec('<?php echo $claiminfoObj->pid;?>');"><img src="<?php bloginfo('template_directory'); ?>/images/delete.png" alt="<?php _e('Delete Moderation Claim');?>" title="<?php _e('Delete Moderation Claim');?>"/></a>
      <?php } ?>
      <?php if ($claiminfoObj->status=='1'){ ?>
      <a href="javascript:void(0);" onclick="return approve_rec('<?php echo $claiminfoObj->pid;?>');"><img src="<?php bloginfo('template_directory'); ?>/images/tick.png" alt="<?php _e('Mark Closed');?>" title="<?php _e('Mark Closed');?>"/></a>
      <a href="javascript:void(0);"  onclick="return delete_rec('<?php echo $claiminfoObj->pid;?>');"><img src="<?php bloginfo('template_directory'); ?>/images/delete.png" alt="<?php _e('Delete Moderation Claim');?>" title="<?php _e('Delete Moderation Claim');?>"/></a>
      <?php } ?>
      </td>
      <td>&nbsp;<!-- icons by http://www.iconarchive.com/artist/visualpharm.html --></td>
    </tr>
    <?php
	}
}
?>
  </thead>
</table>
<script language="javascript">
function delete_rec(claimid)
{
	if(confirm('<?php _e('Are you sure want to DELETE this moderation claim?');?>'))
	{
		window.location.href="<?php echo site_url().'/wp-admin/admin.php?page=moderation&pagetype=delete&id='?>"+claimid;
		return true;
	}else
	{
		return false;
	}
}
function approve_rec(claimid)
{
	if(confirm('<?php _e('Are you sure want to set this moderation claim to CLOSED?');?>'))
	{
		window.location.href="<?php echo site_url().'/wp-admin/admin.php?page=moderation&pagetype=approve&id='?>"+claimid;
		return true;
	}else
	{
		return false;
	}
}

</script>
