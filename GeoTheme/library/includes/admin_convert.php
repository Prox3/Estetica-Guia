<script language='JavaScript'>
      checked = false;
      function checkedAll () {
        if (checked == false){checked = true}else{checked = false}
	for (var i = 0; i < document.getElementById('convert_frm').elements.length; i++) {
	  document.getElementById('convert_frm').elements[i].checked = checked;
	}
      }
    </script>
<?php
global $wpdb;
if($_REQUEST['post']){
	$cat_arr = array();
	$tag_arr = array();
$convert_arr = $_REQUEST['post'];
foreach ( $convert_arr as $convert_id ) {
	$cat_arr=array(); // reset the cat array
	$tag_arr=array(); // reset the tag array

	set_post_type($convert_id,'place'); // set the post type
	
	$terms = get_the_terms( $convert_id, 'category' );
	  foreach ( $terms as $term ) {
					$cat_arr[] = $term->slug;
				}
				
	$tags = wp_get_post_tags($convert_id);
	  foreach ( $tags as $tag ) {
					$tag_arr[] = $tag->name;
				}			
wp_set_object_terms($convert_id, $tag_arr, $taxonomy='place_tags'); // set the tags
wp_set_object_terms($convert_id, $cat_arr, $taxonomy='placecategory'); // set the categories
}
}
/*
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
 				clientEmail($pid,$author_id,'claim_approved'); // email to client
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
		 clientEmail($pid,$author_id,'claim_rejected'); // email to client
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
}*/
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
<h2><?php _e('Convert Listings '); ?></h2>
<?php if($_REQUEST['msg']=='success'){?>
<div class="updated fade below-h2" id="message" style="background-color: rgb(255, 251, 204);" >
  <p><?php _e('Post(s) Converted Successfully.'); ?></p>
</div>

<?php }else{?>
<div class="updated fade below-h2" id="message" style="background-color: rgb(255, 251, 204);" >
  <p><?php _e('To work best you should create the exact "PLACE" Categories first otherwise new categories will be made and will lose spacing in the names etc.'); ?></p>
</div>
<?php } ?>
<form action="<?php echo site_url()?>/wp-admin/admin.php?page=convertlistings&pid=<?php echo $_REQUEST['id'];?>" method="post" name="convert_frm" id="convert_frm">
<table style=" width:70%" cellpadding="5" class="widefat post fixed" >
  <thead>
    <tr>
      <th width="100" align="left"><input type="checkbox" name='checkall' onclick='checkedAll();'/> <strong><?php _e('Tick'); ?></strong></th>
      <th width="350" align="left"><strong><?php _e('Listing Title'); ?></strong></th>
      <th width="350" align="left"><strong><?php _e('Categories'); ?></strong></th>
      <th align="left">&nbsp;</th>
    </tr>
<?php
$claimsql = "SELECT * FROM $wpdb->posts WHERE post_status='publish' and post_type='post' ORDER BY ID ASC";
$claiminfo = $wpdb->get_results($claimsql);
if($claiminfo)
{
	foreach($claiminfo as $claiminfoObj)
	{
?>
    <tr >
      <td><input type="checkbox" name="post[]" value="<?php echo $claiminfoObj->ID;?>" /> <?php echo $claiminfoObj->ID;?></td>
      <td><?php echo $claiminfoObj->post_title;?></td>
      <td><?php $terms = get_the_terms( $claiminfoObj->ID, 'category' );
	  foreach ( $terms as $term ) {
					echo $term->name.',';
				}
		?></td>
      <td>&nbsp;<!-- icons by http://www.iconarchive.com/artist/visualpharm.html --></td>
    </tr>
    <?php
	}
}
?>
 <tr>
      <td>&nbsp;</td>
      <td><input type=hidden name="msg" value="success"><input type="submit" name="submit" value="<?php _e('Convert');?>" onclick="return check_frm();" class="button-secondary action" ></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>

    </tr>
    
  </thead>
</table>
</form>

