<?php
/// Multi City Options
$options[] = array(	"name" => __("Google Map Settings"),
						    "type" => "heading");

$options[] = array(	"name" => __("Map Settings"),
				"toggle" => "true",
				"type" => "subheadingtop");

$options[] = array(	"name" => __("Scrollwheel on main map"),
					"label" => __("Wish to Enable scrollwheel zoom on main map ?"),
					"desc" => __("Select the option if you wish to enable the map to be zoomed with the mouse scroll wheel."),
					"id" => $shortname."_map_scrollwheel",
					"std" => "",
					"type" => "checkbox");

$options[] = array(	"name" => __("Streetview on main map"),
					"label" => __("Wish to Enable streetview on main map ?"),
					"desc" => __("Select the option if you wish to enable streetview on the main map."),
					"id" => $shortname."_map_streetview",
					"std" => "",
					"type" => "checkbox");
$options[] = array(	"type" => "subheadingbottom");

$options[] = array(	"name" => __("Map Category Settings"),
				"toggle" => "true",
				"type" => "subheadingtop");

$options[] = array(	"name" => __("Category Selection"),
					"label" => __("Wish to use Default city settings for all?"),
					"desc" => __("Select this to use the default city category selection. (otherwise individual settings)"),
					"id" => $shortname."_map_set_default",
					"std" => "",
					"type" => "checkbox");

$options[] = array(	"name" => __("Category Tree"),
					"label" => __("Collapse child/sub categories ?"),
					"desc" => __("Select this option to collapse sub categories under it's parent category"),
					"id" => $shortname."_map_sub_colapse",
					"std" => "",
					"type" => "checkbox");
$options[] = array(	"type" => "subheadingbottom");

$options[] = array(	"name" => __("Location Settings"),
						    "type" => "heading");

$options[] = array(	"name" => __("Multi City Settings"),
				"toggle" => "true",
				"type" => "subheadingtop");

$options[] = array(	"name" => __("Multi City Options"),
					"label" => __("Wish to Enable Multi City ?"),
					"desc" => __("Select the option if you wish to enable multi city option. If it's not selected, default first city options will apply to complete site."),
					"id" => $shortname."_enable_multicity_flag",
					"std" => "",
					"type" => "checkbox");

$options[] = array(	"name" => __("Multi City EVERYWHERE Option"),
					"label" => __("Wish to Enable EVERYWHERE City ?"),
					"desc" => __("Select the option if you wish to enable the option to show all city's info."),
					"id" => $shortname."_enable_everycity_flag",
					"std" => "",
					"type" => "checkbox");

$options[] = array(	"type" => "subheadingbottom");
################################################################## REGION SETTINGS ################################################
$options[] = array(	"name" => __("Multi Region Settings"),
				"toggle" => "true",
				"type" => "subheadingtop");

$options[] = array(	"name" => __("Multi Region Options"),
					"label" => __("Wish to Enable Multi Region ?"),
					"desc" => __("Select the option if you wish to enable multi region option. (MULTICITY MUST BE ENABLED FOR THIS TO WORK)"),
					"id" => $shortname."_enable_multiregion_flag",
					"std" => "",
					"type" => "checkbox");

$options[] = array(	"type" => "subheadingbottom");
################################################################## REGION SETTINGS ################################################
$options[] = array(	"name" => __("Neighbourhood Settings"),
				"toggle" => "true",
				"type" => "subheadingtop");

$options[] = array(	"name" => __("Neighbourhood Options"),
					"label" => __("Wish to Enable Neighbourhoods ?"),
					"desc" => __("Select the option if you wish to enable Neighbourhood options. (MULTICITY MUST BE ENABLED FOR THIS TO WORK)"),
					"id" => $shortname."_enable_multihood_flag",
					"std" => "",
					"type" => "checkbox");

$options[] = array(	"type" => "subheadingbottom");
################################################################## COUNTRY SETTINGS ###################################################
$options[] = array(	"name" => __("Multi Country Settings"),
				"toggle" => "true",
				"type" => "subheadingtop");

$options[] = array(	"name" => __("Multi Country Options"),
					"label" => __("Wish to Enable Multi Country ?"),
					"desc" => __("Select the option if you wish to enable multi country option. (MULTICITY MUST BE ENABLED FOR THIS TO WORK)"),
					"id" => $shortname."_enable_multicountry_flag",
					"std" => "",
					"type" => "checkbox");

$options[] = array(	"type" => "subheadingbottom");
?>