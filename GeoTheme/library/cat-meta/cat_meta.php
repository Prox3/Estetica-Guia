<?php
/*
Plugin Name: Demo Tax meta class
Plugin URI: http://en.bainternet.info
Description: Tax meta class usage demo
Version: 1.2
Author: Bainternet, Ohad Raz
Author URI: http://en.bainternet.info
*/

//include the main class file
require_once("Tax-meta-class.php");
if (is_admin()){
	/* 
	 * prefix of meta keys, optional
	 * use underscore (_) at the beginning to make keys hidden, for example $prefix = '_ba_';
	 *  you also can make prefix empty to disable it
	 * 
	 */
	//$prefix = 'ba_';
	$prefix = 'ct_';
	/* 
	 * configure your meta box
	 */
	$config = array(
		'id' => 'demo_meta_box',					// meta box id, unique per meta box
		'title' => 'Demo Meta Box',					// meta box title
		'pages' => array('placecategory','eventcategory'),				// taxonomy name, accept categories, post_tag and custom taxonomies
		'context' => 'normal',						// where the meta box appear: normal (default), advanced, side; optional
		'fields' => array(),						// list of meta fields (can be added by field arrays)
		'local_images' => false,					// Use local or hosted images (meta box images for add/remove)
		'use_with_theme' => true					//change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
	);
	
	
	/*
	 * Initiate your meta box
	 */
	$my_meta =  new Tax_Meta_Class($config);
	$my_meta->addWysiwyg($prefix.'cat_top_desc',array('name'=> 'Category Top Description ','desc' => 'This will appear at the top of the category lsiting. Use %location_name% to show the current locations name.'));
	$my_meta->addImage($prefix.'cat_default_img',array('name'=> 'Default Listing Image ','desc' => 'Choose a default "no image"'));
	$my_meta->addImage($prefix.'cat_icon',array('name'=> 'Category Icon '));
	$my_meta->addSelect($prefix.'cat_sort',array(''=>'Default','random'=>'Random','az'=>'Alphabetical','new'=>'Newest','rating'=>'Rating','review'=>'Reviews'),array('name'=> 'Sort By ','desc' => 'Select the default sort option.', 'std'=> array('selectkey2')));
	
	// Show options for placecategories only
	if($_REQUEST['taxonomy']=='placecategory'){
	// Exclude sort options
	$my_meta->addCheckbox($prefix.'cat_exclude_rating',array('name'=> '<b>Exclude</b> Rating sort option'));
	$my_meta->addCheckbox($prefix.'cat_exclude_reviews',array('name'=> '<b>Exclude</b> Reviews sort option'));
	
	// Include sort options
	$my_meta->addCheckbox($prefix.'cat_include_random',array('name'=> 'Include Random sort option'));
	$my_meta->addCheckbox($prefix.'cat_include_newest',array('name'=> 'Include Newest sort option'));
	$my_meta->addCheckbox($prefix.'cat_include_az',array('name'=> 'Include Alphabetical sort option'));
	//$my_meta->addCheckbox($prefix.'cat_include_',array('name'=> 'Include  sort option'));
	
	}


		//$my_meta->addDate($prefix.'date_field_id',array('name'=> 'My Date '));
		//	$my_meta->addTime($prefix.'time_field_id',array('name'=> 'My Time '));


	/*
	 * Add fields to your meta box
	 */
	/*
	//text field
	$my_meta->addText($prefix.'text_field_id',array('name'=> 'My Text '));
	//textarea field
	$my_meta->addTextarea($prefix.'textarea_field_id',array('name'=> 'My Textarea '));
	//checkbox field
	$my_meta->addCheckbox($prefix.'checkbox_field_id',array('name'=> 'My Checkbox '));
	//select field
	$my_meta->addSelect($prefix.'select_field_id',array('selectkey1'=>'Select Value1','selectkey2'=>'Select Value2'),array('name'=> 'My select ', 'std'=> array('selectkey2')));
	//radio field
	$my_meta->addRadio($prefix.'radio_field_id',array('radiokey1'=>'Radio Value1','radiokey2'=>'Radio Value2'),array('name'=> 'My Radio Filed', 'std'=> array('radionkey2')));
	//date field
	$my_meta->addDate($prefix.'date_field_id',array('name'=> 'My Date '));
	//Time field
	$my_meta->addTime($prefix.'time_field_id',array('name'=> 'My Time '));
	//Color field
	$my_meta->addColor($prefix.'color_field_id',array('name'=> 'My Color '));
	//Image field
	$my_meta->addImage($prefix.'image_field_id',array('name'=> 'My Image '));
	//file upload field
	$my_meta->addFile($prefix.'file_field_id',array('name'=> 'My File '));
	//wysiwyg field
	$my_meta->addWysiwyg($prefix.'wysiwyg_field_id',array('name'=> 'My wysiwyg Editor '));
	//taxonomy field
	$my_meta->addTaxonomy($prefix.'taxonomy_field_id',array('taxonomy' => 'category'),array('name'=> 'My Taxonomy '));
	//posts field
	$my_meta->addPosts($prefix.'posts_field_id',array('post_type' => 'post'),array('name'=> 'My Posts '));
	*/
	/*
	 * To Create a reapeater Block first create an array of fields
	 * use the same functions as above but add true as a last param
	 
	
	$repeater_fields[] = $my_meta->addText($prefix.'re_text_field_id',array('name'=> 'My Text '),true);
	$repeater_fields[] = $my_meta->addTextarea($prefix.'re_textarea_field_id',array('name'=> 'My Textarea '),true);
	$repeater_fields[] = $my_meta->addCheckbox($prefix.'re_checkbox_field_id',array('name'=> 'My Checkbox '),true);
	$repeater_fields[] = $my_meta->addImage($prefix.'image_field_id',array('name'=> 'My Image '),true);
	*/
	/*
	 * Then just add the fields to the repeater block
	 */
	//repeater block
	//$my_meta->addRepeaterBlock($prefix.'re_',array('inline' => true, 'name' => 'This is a Repeater Block','fields' => $repeater_fields));
	/*
	 * Don't Forget to Close up the meta box decleration
	 */
	//Finish Meta Box Decleration
	$my_meta->Finish();
}


##############################################################
############## LETS ADD CUSTOM COLUMN HERE ###################
##############################################################
add_filter('manage_edit-placecategory_columns', 'addCat_column', 10, 2);
add_filter('manage_edit-eventcategory_columns', 'addCat_column', 10, 2);

function addCat_column($columns)
{
 // only edit the columns on the current taxonomy
 if ( !isset($_GET['taxonomy']) && ($_GET['taxonomy'] != 'placecategory' || $_GET['taxonomy'] != 'eventcategory') )
 return $columns; 
 
 if ( $posts = $columns['description'] ){ unset($columns['description']); }
  
    $columns['cat_icon'] = 'Icon';
    $columns['cat_default_img'] = 'Default Image';
    $columns['cat_ID_num'] = 'Cat ID';
    return $columns;
}
#############################################################
function manage_category_custom_fields($deprecated,$column_name,$term_id)
{
 if ($column_name == 'cat_ID_num') {
echo $term_id;
 }
 if ($column_name == 'cat_icon') {
	 $term_icon_url = get_tax_meta($term_id,'ct_cat_icon');
echo '<img src="'.$term_icon_url['src'].'" />';
 } 
if ($column_name == 'cat_default_img') {
	 $cat_default_img = get_tax_meta($term_id,'ct_cat_default_img');
echo '<img src="'.$cat_default_img['src'].'" style="max-height:60px;max-width:60px;"/>';

 }
}
add_action('manage_placecategory_custom_column','manage_category_custom_fields',10,3);
add_action('manage_eventcategory_custom_column','manage_category_custom_fields',10,3);



?>