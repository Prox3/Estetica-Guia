<?php
/*
File: address2.php
Description: This plugin file/child theme include file adds a second address line to the 
		GeoTheme theme. This can be used as a plugin, or it can be included in a
		child theme.
Version: 1.0 (05-10-2013)
*/
if ( !class_exists(mr_address2) ) {
    class mr_address2 {
    	/*
    	 * Utility function array_insert_after()
    	 *
    	 *	This function inserts a new element into an associative array after a given element.
    	 *
    	 *	args:
    	 *		$target_key	- the key the new element is to be inserted after
    	 *		$array		- the array you want to insert the new element into. This 
    	 *					function modifies the array inplace. 
    	 *		$new_key	- the new key to insert in the array
    	 *		$new_value	- the value for the new key to be inserted into the array.
    	 */
	function array_insert_after($target_key,array &$array, $new_key, $new_value) {
	    $new = array();
	    foreach ($array as $k=>$v) {
		$new[$k]=$v;
		if ($k==$target_key) {
		    $new[$new_key]=$new_value;
		}//if
	    }//foreach
	    $array=$new;
	}//function array_insert_after
	
	/*
	 * Admin modifier. 
	 *
	 *	This function is attached on the "admin_init" action hook. It checks for an entry in the
	 *	$pt_metaboxes array for 'address' and if it finds that entry, it inserts a new entry right
	 *	after that for 'address2'. This shows an 'Address (second line)' setting in the 'GeoTheme
	 *	Custom Settings panel on every administrative page that has the address in that panel.
	 */
	function add_address2_meta_admin() {
	    global $pt_metaboxes;
	    if ( isset($pt_metaboxes['address']) ) {
		$address2_metabox = array (
					'name'		=> 'address2',
					'default'	=> '',
					'label'		=> 'Address (second line)',
					'type'		=> 'text',
					'desc'		=> __('Additional address information. (<strong>note</strong>: This information is not used by the GeoCoder to locate this item on the map.)'),
				);
		self::array_insert_after('address',$pt_metaboxes,'address2',$address2_metabox);
	    }//if
	}//function add_address2_meta_admin()
	
	/*
	 * Page modifier.
	 *
	 *	This function checks if 'address2' is set in the meta information for the page being displayed. 
	 *	If an 'address 2' meta item is found, it is added onto the 'address' meta item after a <br /> tag.
	 *	This function is called from the 'mrGT2max_address' hook which was added to location and event
	 *	templates in the GeoThemes-to-the-max child theme.
	 */
	function append_address2_to_address($content) {
	    global $address, $address2, $preview, $post, $post_meta;
	    if ( $preview ) {
	        if ( $mr_address2=$address2 ) {
	            $content.='<br />'.$mr_address2;
		}
	    } else {
		if ( $mr_address2=get_post_meta($post->ID,'address2',true) ) {
		    $content.='<br />'.$mr_address2;
		}
	    }
	    $content=str_replace('::','<br />',$content);
$content='<!-- begin mr_address2::append_address2_to_address'.PHP_EOL.'	$content="'.$content.'"'.PHP_EOL.'get_post_meta($post->ID,\'address2\')="'.get_post_meta($post->ID,'address2',true).'"'.PHP_EOL.'$address="'.$address.'"'.PHP_EOL.'-->'.$content.'<!-- end mr_address2::append_address2_to_address -->';
	    $content='<div style="margin:0 2em;">'.$content.'</div>';
	    return $content;
	} // function append_address2_to_address()
    }//class mr_address2
}//if !class_exists
add_action ( 'admin_init', array('mr_address2','add_address2_meta_admin') );
add_filter ( 'mrGT2max_address', array('mr_address2','append_address2_to_address') );
?>