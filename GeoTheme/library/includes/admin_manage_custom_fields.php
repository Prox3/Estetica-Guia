<?php
global $wpdb,$custom_post_meta_db_table_name;
if($_REQUEST['act']=='addedit')
{
	include_once(TEMPLATEPATH . '/library/includes/admin_manage_custom_fields_edit.php');
}else
{
	include_once(TEMPLATEPATH . '/library/includes/admin_manage_custom_fields_list.php');
}
?>