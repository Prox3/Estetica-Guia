<?php


function recurring_event() {
/////////////////RECURRING EVENT CODING START/////////////////
global $table_prefix, $wpdb;
$rc_table_name = $table_prefix . "recurring_event_session";
$current_date = date('Y-m-d');

	$postid_str = $wpdb->get_results("select p.* from $wpdb->posts p where p.post_type='event' and p.post_status='publish' and datediff(\"$current_date\",date_format((select meta_value from $wpdb->postmeta where post_id=p.ID and meta_key='end_date'  ),'%Y-%m-%d')) > 0 and p.ID in(select post_id from $wpdb->postmeta where meta_key='recurring' and meta_value<>'')");
	
	echo "select p.* from $wpdb->posts p where p.post_type='event' and p.post_status='publish' and datediff(\"$current_date\",date_format((select meta_value from $wpdb->postmeta where post_id=p.ID and meta_key='end_date'  ),'%Y-%m-%d')) > 0 and p.ID in(select post_id from $wpdb->postmeta where meta_key='recurring' and meta_value<>'')";
	
			foreach($postid_str as $postid_str_obj){
				$ID = $postid_str_obj->ID;
				$recurring = $wpdb->get_results("select meta_value from $wpdb->postmeta where meta_key='recurring' and post_id=\"$ID\"");// Get the recurring time

				if($recurring['0']->meta_value == 'week'){
					$wpdb->query("update $wpdb->postmeta set meta_value=DATE_ADD( meta_value, INTERVAL 1 WEEK ) where meta_key='end_date' and post_id=\"$ID\"");
					$wpdb->query("update $wpdb->postmeta set meta_value=DATE_ADD( meta_value, INTERVAL 1 WEEK ) where meta_key='st_date' and post_id=\"$ID\"");
										}
										
				if($recurring['0']->meta_value == 'two_week'){
					$wpdb->query("update $wpdb->postmeta set meta_value=DATE_ADD( meta_value, INTERVAL 2 WEEK ) where meta_key='end_date' and post_id=\"$ID\"");
					$wpdb->query("update $wpdb->postmeta set meta_value=DATE_ADD( meta_value, INTERVAL 2 WEEK ) where meta_key='st_date' and post_id=\"$ID\"");
										}
										
				if($recurring['0']->meta_value == 'month'){
					$wpdb->query("update $wpdb->postmeta set meta_value=DATE_ADD( meta_value, INTERVAL 1 MONTH ) where meta_key='end_date' and post_id=\"$ID\"");
					$wpdb->query("update $wpdb->postmeta set meta_value=DATE_ADD( meta_value, INTERVAL 1 MONTH ) where meta_key='st_date' and post_id=\"$ID\"");
										}	
										
				if($recurring['0']->meta_value == 'year'){
					$wpdb->query("update $wpdb->postmeta set meta_value=DATE_ADD( meta_value, INTERVAL 1 YEAR ) where meta_key='end_date' and post_id=\"$ID\"");
					$wpdb->query("update $wpdb->postmeta set meta_value=DATE_ADD( meta_value, INTERVAL 1 YEAR ) where meta_key='st_date' and post_id=\"$ID\"");
										}	
								
				}
			
		//$wpdb->query("insert into $rc_table_name (execute_date,is_run) values (\"$current_date\",'1')");
		$wpdb->query("update $rc_table_name set execute_date=\"$current_date\" ,is_run=1  where session_id=1");


	


} // End function



/*
// run the expiry check twice a day
if ( !wp_next_scheduled('my_task_hook') ) {
	wp_schedule_event( time(), 'twicedaily', 'my_task_hook' ); // hourly, daily and twicedaily
}
function recurring_event_cron() {
recurring_event();
}
add_action('my_task_hook', 'recurring_event_cron');

#######################################################################

#############################################################################
*/

add_action('recurring_event_check', 'run_event_check');

function event_cron() {
	if ( !wp_next_scheduled( 'recurring_event_check' ) ) {
		wp_schedule_event( time(), 'twicedaily', 'recurring_event_check');
	}
}
add_action('wp', 'event_cron');

function run_event_check() {
	recurring_event(); // do something every hour
}




?>