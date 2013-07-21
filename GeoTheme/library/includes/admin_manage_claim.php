<?php
global $wpdb,$claim_db_table_name;
if($_REQUEST['pagetype'] == 'delete' && $_REQUEST['id'] != '')
{
	$pid = $_REQUEST['id'];
	$wpdb->query("delete from $claim_db_table_name where pid=\"$pid\"");
	$location = site_url()."/wp-admin/admin.php";
	echo '<form action="'.$location.'" method=get name="claim_success">
	<input type=hidden name="page" value="claimlistings"><input type=hidden name="msg" value="delsuccess"></form>';
	echo '<script>document.claim_success.submit();</script>';
	exit;
}
if($_REQUEST['pagetype'] == 'approve' && $_REQUEST['id'] != '')
{
	$pid = $_REQUEST['id'];	
	$approvesql = "select * from $claim_db_table_name where pid=\"$pid\"";
	$approveinfo = $wpdb->get_results($approvesql);
	
	$post_id = $approveinfo[0]->list_id;
	$author_id = $approveinfo[0]->user_id;
	
	$wpdb->query("update $wpdb->posts set post_author=\"$author_id\" where ID=\"$post_id\""); // set new author
	$wpdb->query("update $claim_db_table_name set status='1' where pid=\"$pid\""); // marke claim as approved
	$wpdb->query("update $wpdb->postmeta set meta_value='1' where post_id=\"$post_id\" AND meta_key='claimed'"); // make listing caimed
######################################## CLIENT EMAIL ######################################################
 				clientEmail($post_id,$author_id,'claim_approved'); // email to client
###################################### CLIENT EMAIL END ####################################################

	$location = site_url()."/wp-admin/admin.php";
	echo '<form action="'.$location.'" method=get name="claim_success">
	<input type=hidden name="page" value="claimlistings"><input type=hidden name="msg" value="approve"></form>';
	echo '<script>document.claim_success.submit();</script>';
	exit;
}
if($_REQUEST['pagetype'] == 'reject' && $_REQUEST['id'] != '')
{
	$pid = $_REQUEST['id'];
	$wpdb->query("update $claim_db_table_name set status='2' where pid=\"$pid\"");
	$approvesql = "select * from $claim_db_table_name where pid=\"$pid\"";
	$approveinfo = $wpdb->get_results($approvesql);
	
	$post_id = $approveinfo[0]->list_id;
	$author_id = $approveinfo[0]->user_id;
######################################## CLIENT EMAIL ######################################################
		 clientEmail($post_id,$author_id,'claim_rejected'); // email to client
###################################### CLIENT EMAIL END ####################################################
	$location = site_url()."/wp-admin/admin.php";
	echo '<form action="'.$location.'" method=get name="claim_success">
	<input type=hidden name="page" value="claimlistings"><input type=hidden name="msg" value="reject"></form>';
	echo '<script>document.claim_success.submit();</script>';
	exit;
}
if($_REQUEST['pagetype'] == 'undo' && $_REQUEST['id'] != '')
{
	$pid = $_REQUEST['id'];
	
	$approvesql = "select * from $claim_db_table_name where pid=\"$pid\"";
	$approveinfo = $wpdb->get_results($approvesql);
	
	$post_id = $approveinfo[0]->list_id;
	$author_id = $approveinfo[0]->org_authorid;
	
	$wpdb->query("update $wpdb->posts set post_author=\"$author_id\" where ID=\"$post_id\"");
	$wpdb->query("update $claim_db_table_name set status='2' where pid=\"$pid\"");
	$wpdb->query("update $wpdb->postmeta set meta_value='0' where post_id=\"$post_id\" AND meta_key='claimed'"); // make listing not claimed
	
	$location = site_url()."/wp-admin/admin.php";
	echo '<form action="'.$location.'" method=get name="claim_success">
	<input type=hidden name="page" value="claimlistings"><input type=hidden name="msg" value="reject"></form>';
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
<h2><?php _e('Manage Listing Claims'); ?></h2>
<?php if($_REQUEST['msg']=='success'){?>
<div class="updated fade below-h2" id="message" style="background-color: rgb(255, 251, 204);" >
  <p><?php _e('Comments added successfully.'); ?></p>
</div>
<?php }?>
<?php if($_REQUEST['msg']=='approve'){?>
<div class="updated fade below-h2" id="message" style="background-color: rgb(255, 251, 204);" >
  <p><?php _e('Claim approved successfully.'); ?></p>
</div>
<?php }?>
<?php if($_REQUEST['msg']=='reject'){?>
<div class="updated fade below-h2" id="message" style="background-color: rgb(255, 251, 204);" >
  <p><?php _e('Claim rejected successfully.'); ?></p>
</div>
<?php }?>
<?php if($_REQUEST['msg']=='delsuccess'){?>
<div class="updated fade below-h2" id="message" style="background-color: rgb(255, 251, 204);" >
  <p><?php _e('Claim deleted successfully.'); ?></p>
</div>
<?php }?>
<table style=" width:70%" cellpadding="5" class="widefat post fixed" >
  <thead>
    <tr>
      <th width="150" align="left"><strong><?php _e('Listing Title'); ?></strong></th>
      <th width="150" align="left"><strong><?php _e('User'); ?></strong></th>
      <th width="150" align="left"><strong><?php _e('Full Name'); ?></strong></th>
      <th width="150" align="left"><strong><?php _e('Position'); ?></strong></th>
       <th width="120" align="left"><strong><?php _e('Phone'); ?></strong></th>
       <th width="85" align="left"><strong><?php _e('Status'); ?></strong></th>
      <th width="85" align="left"><strong><?php _e('Details'); ?></strong></th>
      <th width="85" align="left"><strong><?php _e('Action'); ?></strong></th>
      <th align="left">&nbsp;</th>
    </tr>
<?php
$claimsql = "select * from $claim_db_table_name  ORDER BY status ASC";
$claiminfo = $wpdb->get_results($claimsql);
if($claiminfo)
{
	foreach($claiminfo as $claiminfoObj)
	{
?>
    <tr <?php if($claiminfoObj->status==1)echo 'style="background-color:#99FFCC"'; elseif ($claiminfoObj->status==2) echo 'style="background-color:#FFAEAE"';  ?>>
      <td><?php echo $claiminfoObj->list_title;?></td>
      <td><?php echo $claiminfoObj->user_name;?></td>
      <td><?php echo $claiminfoObj->user_fullname;?></td>
      <td><?php echo $claiminfoObj->user_position;?></td>
      <td><?php echo $claiminfoObj->user_number;?></td>
      <td><?php if($claiminfoObj->status==1) _e("Approved"); elseif($claiminfoObj->status==2) _e("Rejected"); else _e("No Decision");?></td>
      <td><a href="<?php echo site_url().'/wp-admin/admin.php?page=claimlistings&pagetype=addedit&id='.$claiminfoObj->pid;?>"><?php _e('Full Details'); ?></a> </td>
      <td>
      <?php if ($claiminfoObj->status==''){ ?>
      <a href="javascript:void(0);" onclick="return approve_rec('<?php echo $claiminfoObj->pid;?>');"><img src="<?php bloginfo('template_directory'); ?>/images/tick.png" alt="Approve" title="Approve"/></a>
      <a href="javascript:void(0);" onclick="return reject_rec('<?php echo $claiminfoObj->pid;?>');"><img src="<?php bloginfo('template_directory'); ?>/images/reject.png" alt="Reject" title="Reject"/></a>
      <a href="javascript:void(0);" onclick="return delete_rec('<?php echo $claiminfoObj->pid;?>');"><img src="<?php bloginfo('template_directory'); ?>/images/delete.png" alt="Delete" title="Delete"/></a>
      <?php } ?>
      <?php if ($claiminfoObj->status=='1'){ ?>
      <a href="javascript:void(0);" onclick="return undo_rec('<?php echo $claiminfoObj->pid;?>');"><img src="<?php bloginfo('template_directory'); ?>/images/undo.png" alt="Undo" title="Undo" /></a>
      <a href="javascript:void(0);" onclick="return delete_rec('<?php echo $claiminfoObj->pid;?>');"><img src="<?php bloginfo('template_directory'); ?>/images/delete.png" alt="Delete" title="Delete"/></a>
      <?php } ?>
      <?php if ($claiminfoObj->status=='2'){ ?>
      <a href="javascript:void(0);" onclick="return approve_rec('<?php echo $claiminfoObj->pid;?>');"><img src="<?php bloginfo('template_directory'); ?>/images/tick.png" alt="Approve" title="Approve" /></a>
      <a href="javascript:void(0);" onclick="return delete_rec('<?php echo $claiminfoObj->pid;?>');"><img src="<?php bloginfo('template_directory'); ?>/images/delete.png" alt="Delete" title="Delete" /></a>
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
	if(confirm('<?php _e('Are you sure want to DELETE this claim?');?>'))
	{
		window.location.href="<?php echo site_url().'/wp-admin/admin.php?page=claimlistings&pagetype=delete&id='?>"+claimid;
		return true;
	}else
	{
		return false;
	}
}
function approve_rec(claimid)
{
	if(confirm('<?php _e('Are you sure want to APPROVE this claim?');?>'))
	{
		window.location.href="<?php echo site_url().'/wp-admin/admin.php?page=claimlistings&pagetype=approve&id='?>"+claimid;
		return true;
	}else
	{
		return false;
	}
}
function reject_rec(claimid)
{
	if(confirm('<?php _e('Are you sure want to REJECT this claim?');?>'))
	{
		window.location.href="<?php echo site_url().'/wp-admin/admin.php?page=claimlistings&pagetype=reject&id='?>"+claimid;
		return true;
	}else
	{
		return false;
	}
}
function undo_rec(claimid)
{
	if(confirm('<?php _e('Are you sure want to UNDO this claim and restore original author?');?>'))
	{
		window.location.href="<?php echo site_url().'/wp-admin/admin.php?page=claimlistings&pagetype=undo&id='?>"+claimid;
		return true;
	}else
	{
		return false;
	}
}
</script>
