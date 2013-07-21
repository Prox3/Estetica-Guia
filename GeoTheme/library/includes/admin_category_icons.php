<?php
global $wpdb;
if($_POST['save_icons'])
{
	$catinfo = $wpdb->get_col("SELECT t.*  FROM $wpdb->terms AS t INNER JOIN $wpdb->term_taxonomy AS tt ON tt.term_id = t.term_id WHERE tt.taxonomy IN ('placecategory','eventcategory')");
	for($i=0;$i<count($catinfo);$i++)
	{
		$post_var = "term_icon_".$catinfo[$i];
		$term_id=$catinfo[$i];
		$cat_icon = $_POST["$post_var"];
		$wpdb->query("update $wpdb->terms set term_icon=\"$cat_icon\" where term_id=\"$term_id\"");
	}
	$message = __("Icon settings saved successfully");
}
?>

<?php if($_REQUEST['icon_convert']){
$catinfo = $wpdb->get_results("SELECT t.*  FROM $wpdb->terms AS t INNER JOIN $wpdb->term_taxonomy AS tt ON tt.term_id = t.term_id WHERE tt.taxonomy IN ('placecategory','eventcategory')");
	foreach($catinfo as $cat)
	{
		//print_r(get_tax_meta($cat->term_id,'ct_cat_icon'));
			if($cat->term_icon){
			
			update_tax_meta($cat->term_id,'ct_cat_icon',array( 'id' => 'icon', 'src' => $cat->term_icon));

			
		}
		
	}	
	
$message = __("Icons converted");
}?>


<script>
function edit_cat(catid)
{
	if(document.getElementById('cat_edit_'+catid).style.display)
	{
		document.getElementById('cat_edit_'+catid).style.display = '';
	}else
	{
		document.getElementById('cat_edit_'+catid).style.display = 'none';	
	}
}
</script>
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
<h2 style="color:#F00"><?php _e('This page is Depreciated - please change category icons from the edit category page.')?></h2>
<h2 style="color:#F00"><a href="<?php echo site_url();?>/wp-admin/admin.php?page=category_icons&icon_convert=1"><?php _e('Convert Icons to new setup');?></a></h2>
<h2><?php _e('Manage Category Icons')?></h2>
<?php if($message){?>
<div class="updated fade below-h2" id="message" style="background-color: rgb(255, 251, 204);" >
  <p><?php _e($message);?> </p>
</div>
<?php }?>
<form action="<?php echo site_url();?>/wp-admin/admin.php?page=category_icons" method="post" name="payoptsetting_frm">
 <input type="hidden" name="save_icons" value="1">
  <table  style=" width:30%" cellpadding="5" class="widefat post sub_table" >
    <thead>
     <tr>
        <th width="45" align="center"><strong><?php _e('Category'); ?></strong></th>
        <th width="45" align="center"><strong><?php _e('Icon'); ?></strong></th>
        <th ><strong><?php _e('Action'); ?></strong></th>
        <th >&nbsp;</th>
      </tr>
<?php 
$catinfo = $wpdb->get_results("SELECT t.*  FROM $wpdb->terms AS t INNER JOIN $wpdb->term_taxonomy AS tt ON tt.term_id = t.term_id WHERE tt.taxonomy IN ('placecategory','eventcategory')");
foreach($catinfo as $catinfo_obj){
$term_id = $catinfo_obj->term_id;
$name = $catinfo_obj->name;
$term_icon = $catinfo_obj->term_icon;
?>
     
      <tr>
        <td width="120"><?php echo $name;?> </td>
        <td width="120"><img src="<?php echo $term_icon;?>" ></td>
        <td width="120"><a href="javascript:void(0);" onClick="edit_cat('<?php echo $term_id;?>');"><?php _e('Edit');?></a></td>
        <td><span style="display:none;" id="cat_edit_<?php echo $term_id;?>"><strong><?php _e('Icon Path:');?></strong><input size="80" type="text" value="<?php echo $term_icon;?>" name="term_icon_<?php echo $term_id;?>"></span></td>
      </tr>
<?php }?>
    </thead>
<tr><td colspan="2">&nbsp;</td><td colspan="1"><input type="submit" name="submit" value="<?php _e('Save Changes');?>"></td>
  </table>
</form>