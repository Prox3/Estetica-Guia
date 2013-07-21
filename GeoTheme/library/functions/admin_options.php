<?php
$options[] = array(	"type" => "maintabletop");

    /// General Settings
	
	    $options[] = array(	"name" => __("General Settings"),
						"type" => "heading");
						
		    $options[] = array(	"name" => __("Theme Skin"),
						        "toggle" => "true",
								"type" => "subheadingtop");
						
				$options[] = array(	"desc" => __("Please select the CSS skin of your blog from here.<br> <small><b>NOTE: This will override child theme styles. Set to NONE if having problems.</b></small>"),
					                "id" => $shortname."_alt_stylesheet",
					                "std" => "Select a CSS skin:",
					                "type" => "select",
					                "options" => $alt_stylesheets);
						
			$options[] = array(	"type" => "subheadingbottom");
			
			$options[] = array(	"name" => __("Customize your design and use custom stylesheet"),
						        "toggle" => "true",
								"type" => "subheadingtop");
						
				$options[] = array(	"label" => __("Use Custom Stylesheet"),
						            "desc" => __("If you want to make custom design changes use a child theme"),
						            "id" => $shortname."_customcss",
						            "std" => "false",
						            "type" => "checkbox");	
						
			$options[] = array(	"type" => "subheadingbottom");
			
			$options[] = array(	"name" => __("Favicon"),
						        "toggle" => "true",
								"type" => "subheadingtop");

				$options[] = array(	"desc" =>__("Paste the full URL for your favicon image here if you wish to show it in browsers. <a href='http://www.favicon.cc/'>Create one here</a>"),
						            "id" => $shortname."_favicon",
						            "std" => "",
						            "type" => "file");	
			
			$options[] = array(	"type" => "subheadingbottom");
			
			$options[] = array(	"name" => __("Your site Logo <br /> "),
						        "toggle" => "true",
								"type" => "subheadingtop");

                $options[] = array(	"name" => __("Choose Your Logo image"),
				                    "desc" => __("Paste the full URL to your logo image here or choose the one from Browse (Logo image size - 375px width )"),
						            "id" => $shortname."_logo_url",
						            "std" => "",
						            "type" => "file");

				$options[] = array(	"name" => __("Choose Blog Title over Logo"),
				                    "desc" => "This option will overwrite your logo selection above - You can <a href='". $generaloptionsurl . "'>change your settings here</a>",
						            "label" => __("Show Blog Title + Tagline."),
						            "id" => $shortname."_show_blog_title",
						            "std" => "true",
						            "type" => "checkbox");	

			$options[] = array(	"type" => "subheadingbottom");
			
 	
		$options[] = array(	"name" => __("Syndication / Feed URL <br> &nbsp;  &nbsp;  &nbsp;   (ex.http://feeds2.feedburner.com/geotheme)"),
						        "toggle" => "true",
								"type" => "subheadingtop");			
						
			$options[] = array( "desc" => __("If you are using a service like Feedburner to manage your RSS feed, enter full URL to your feed in the box. If you'd prefer to use the default WordPress feed, simply leave this box blank."),
			    		            "id" => $shortname."_feedburner_url",
			    		            "std" => "",
			    		            "type" => "text");	
			
			$options[] = array(	"type" => "subheadingbottom");
			
			$options[] = array(	"name" => __("Syndication / Feed ID  <br> &nbsp;  &nbsp;  &nbsp; (ex.geotheme)"),
						        "toggle" => "true",
								"type" => "subheadingtop");	
			
			
				$options[] = array( "desc" => __("If you are using a service like Feedburner to manage your RSS feed, enter Feed ID in this box. If you'd prefer to use the default WordPress feed, simply leave this box blank."),
			    		            "id" => $shortname."_feedburner_id",
			    		            "std" => "",
			    		            "type" => "text");	
						
			 $options[] = array(	"type" => "subheadingbottom");
################################################# IMAGE SETTINGS PUT BACK BY STIOFAN #################################
			 
			 $options[] = array(	"name" => __("Image Setting (Tim thumb setting - Image Cutting Edge)"),
						        "toggle" => "true",
								"type" => "subheadingtop");	

$options[] = array(	"name" => __("Default Image Cutting Edge"),
					                "desc" => __("Set Default Image Cutting Edge Position."),
					                "id" => $shortname."_image_x_cut",
					                "std" => "center",
									"options" => array('center','top','bottom','left','right','top right','top left','bottom right','bottom left'),
					                "type" => "select");

$options[] = array(	"name" => __("Default Image Quality"),
					                "desc" => __("Set Default Image Quality % (default: 90)"),
					                "id" => $shortname."_image_q",
					                //"std" => "90", 
									"options" => array('100','95','90','85','80','75','70','60','50','40','30'),
					                "type" => "select");

$options[] = array(	"name" => __("Image zoom/crop"),
					                "desc" => __("Set Image to Zoom or Crop"),
					                "id" => $shortname."_image_zc",
					                "std" => "zoom",
									"options" => array('zoom','crop','resize','resize-no-border'),
					                "type" => "select");

				$options[] = array(	"type" => "subheadingbottom");
				
			


########################################################################################################################				
			 
		$options[] = array(	"type" => "maintablebreak");
		

    /// Navigation Settings												
				
		$options[] = array(	"name" => __("Navigation Settings"),
						    "type" => "heading");
										
				$options[] = array(	"name" => __("Top Strip Header Navigation Exclude Pages"),
								"toggle" => "true",
								"type" => "subheadingtop");
						
				$options[] = array(	"type" => "multihead");
						if(strstr($_SERVER['REQUEST_URI'],'/wp-admin/'))
{
				$options = pages_exclude($options);
}
			$options[] = array(	"type" => "subheadingbottom");
			
			
		$options[] = array(	"name" => __("Place Categories for Header Navigation"),
								"toggle" => "true",
								"type" => "subheadingtop");
					if(strstr($_SERVER['REQUEST_URI'],'/wp-admin/')){$cat_arr = get_category_array();}
					$cat_arr = array_merge(array(array('id'=>'','title'=>'No Category')),$cat_arr);
					$options[] = array(	"label" => "",
                	                "desc" => __("Select categories, press &lsquo;control button&rsquo; to select more than one"),
						            "id" => $shortname."_placecategory",
						            "std" => "",
						            "type" => "multiselect",
									"options"=> $cat_arr,
									);	

			$options[] = array(	"type" => "subheadingbottom");
			
			$options[] = array(	"name" => __("Event Categories for Header Navigation"),
								"toggle" => "true",
								"type" => "subheadingtop");
									if(strstr($_SERVER['REQUEST_URI'],'/wp-admin/')){
					$cat_arr = get_eventcategory_array();}
					$cat_arr = array_merge(array(array('id'=>'','title'=>'No Category')),$cat_arr);
					$options[] = array(	"label" => "",
                	                "desc" => __("Select event categories, press &lsquo;control button&rsquo; to select more than one"),
						            "id" => $shortname."_eventcategory",
						            "std" => "",
						            "type" => "multiselect",
									"options"=> $cat_arr,
									);	

			$options[] = array(	"type" => "subheadingbottom");
			
			
			 $options[] = array(	"name" => __("Footer Navigation"),
						        "toggle" => "true",
								"type" => "subheadingtop");
				
				if(strstr($_SERVER['REQUEST_URI'],'/wp-admin/')){
				$options[] = array(	"label" => "",
                	                "desc" => __("Select Pages, press &lsquo;control button&rsquo; to select more than one"),
						            "id" => $shortname."_footerpages",
						            "std" => "",
						            "type" => "multiselect",
									"options"=> get_pages_array(),
									);}
				
				$options[] = array(	"type" => "subheadingbottom");
			

			$options[] = array(	"name" => __("Allow user to list the Place"),
						        "toggle" => "true",
								"type" => "subheadingtop");
						
				$options[] = array(	"label" => __("Do you wish to allow the user to list their place?"),
						            "desc" => "",
						            "id" => "is_user_addevent",
						            "std" => "true",
						            "type" => "checkbox");	
						
			$options[] = array(	"type" => "subheadingbottom");
			
			$options[] = array(	"name" => __("Allow user to list the Event"),
						        "toggle" => "true",
								"type" => "subheadingtop");
						
				$options[] = array(	"label" => __("Do you wish to allow the user to list their Event?"),
						            "desc" => "",
						            "id" => "is_user_eventlist",
						            "std" => "true",
						            "type" => "checkbox");	
						
			$options[] = array(	"type" => "subheadingbottom");
			
			$options[] = array(	"name" => __("Breadcrumbs Navigation"),
						        "toggle" => "true",
								"type" => "subheadingtop");
						
				$options[] = array(	"label" => __("Show breadcrumbs navigation bar"),
						            "desc" => "i.e. Home > Blog > Title - <a href='". site_url() . "/wp-admin/options-general.php?page=breadcrumb_navxt'>Change options here</a>",
						            "id" => $shortname."_breadcrumbs",
						            "std" => "true",
						            "type" => "checkbox");
				$options[] = array(	"label" => __("Hide the Places and Events crumb?"),
						            "desc" => "i.e. Home > Places > Title",
						            "id" => $shortname."_breadcrumbs_hide",
						            "std" => "true",
						            "type" => "checkbox");
				
						
			$options[] = array(	"type" => "subheadingbottom");
				
				
		$options[] = array(	"type" => "maintablebreak");
		
 		
/// Detail Options
				
		$options[] = array(	"name" => __("Place Detail page Settings"),
						    "type" => "heading");
						
			$options[] = array(	"name" => __("\"Tweet\" button show or hide"),
						        "toggle" => "true",
								"type" => "subheadingtop");
						
				$options[] = array(	"label" => __("Wish to display \"Twitter Like\" button?"),
						            "desc" => "",
						            "id" => $shortname."_tweet_button",
						            "std" => "true",
						            "type" => "checkbox");	
						
			$options[] = array(	"type" => "subheadingbottom");
			
			
			 $options[] = array(	"name" => __("\"Facebook Like\" button show or hide"),
						        "toggle" => "true",
								"type" => "subheadingtop");
						
				$options[] = array(	"label" => __("Wish to display \"Facebook Like\" button?"),
						            "desc" => "",
						            "id" => $shortname."_facebook_button",
						            "std" => "true",
						            "type" => "checkbox");	
				$options[] = array(	"type" => "subheadingbottom");
				
				$options[] = array(	"name" => __("\"Google Plus\" button show or hide"),
						        "toggle" => "true",
								"type" => "subheadingtop");
						
				$options[] = array(	"label" => __("Wish to display \"Google Plus\" button?"),
						            "desc" => "",
						            "id" => $shortname."_google_button",
						            "std" => "true",
						            "type" => "checkbox");	
				$options[] = array(	"type" => "subheadingbottom");
				
				$options[] = array(	"name" => __("\"Add This\" username"),
						        "toggle" => "true",
								"type" => "subheadingtop");
						
				$options[] = array(	"label" => __("Please enter your \"Add This\" username"),
						            "desc" => "",
						            "id" => $shortname."_addthis_username",
						            "std" => "",
						            "type" => "text");	
				$options[] = array(	"type" => "subheadingbottom");
				
				$options[] = array(	"name" => __("Photo gallery slider settings"),
						       	 "toggle" => "true",
									"type" => "subheadingtop");
						
				$options[] = array(	"label" => __("Wish to set Photo gallery to auto slide?"),
						            "desc" => "",
						            "id" => $shortname."_photo_gallery",
						            "std" => "true",
						            "type" => "checkbox");
			
			$options[] = array(	"type" => "subheadingbottom");
			
			$options[] = array(	"name" => __("Wish to Display Send Inquiry & Email to friend"),
						       	 "toggle" => "true",
									"type" => "subheadingtop");
						
				$options[] = array(	"label" => __("Wish to Display Send Inquiry & Email to friend links on detail page?"),
						            "desc" => __("Wish to Display Send Inquiry & Email to friend links on detail page?"),
						            "id" => $shortname."_email_on_detailpage",
						            "std" => "Yes",
						            "type" => "select",
									"options" => array('Yes','No'),);
			
			$options[] = array(	"type" => "subheadingbottom");
			
			$options[] = array(	"name" => __("Wish to Display Contact"),
						       	 "toggle" => "true",
									"type" => "subheadingtop");
						
				$options[] = array(	"label" => __("Wish to Display Contact on detail page?"),
						            "desc" => "",
						            "id" => $shortname."_contact_on_detailpage",
						            "std" => "Yes",
						            "type" => "select",
									"options" => array('Yes','No'),);
			
			$options[] = array(	"type" => "subheadingbottom");
			
			$options[] = array(	"name" => __("Wish to Display Related Listings"),
						       	 "toggle" => "true",
									"type" => "subheadingtop");
						
				$options[] = array(	"label" => __("Wish to Display Related Listings on detail page?"),
						            "desc" => "",
						            "id" => $shortname."_related_on_detailpage",
						            "std" => "Yes",
						            "type" => "select",
									"options" => array('Yes','No'),);
				
			$options[] = array(	"type" => "subheadingbottom");
			
			$options[] = array(	"name" => __("Enable Moderation?"),
						       	 "toggle" => "true",
									"type" => "subheadingtop");
			
				$options[] = array(	"label" => __("Enable Moderation?"),
						            "desc" => "",
						            "id" => $shortname."_moderation",
						            "std" => "Yes",
						            "type" => "select",
									"options" => array('Yes','No'),);
			
			$options[] = array(	"type" => "subheadingbottom");
			
		$options[] = array(	"type" => "maintablebreak");
		
/// Event Listing Options
				
$options[] = array(	"name" => __("Add Listing page Settings"),
					"type" => "heading");
				
	$options[] = array(	"name" => __("Category display settings"),
						"toggle" => "true",
						"type" => "subheadingtop");
				
	$options[] = array(	"label" => __("Category display settings"),
						"desc" => "",
						"id" => $shortname."_category_dislay",
						"std" => "",
						"type" => "select",
						"options" => array('checkbox','radio','select'),
						);	
	$options[] = array(	"type" => "subheadingbottom");
	
	$options[] = array(	"name" => __("Captcha settings"),
						"toggle" => "true",
						"type" => "subheadingtop");
				
	$options[] = array(	"label" => __("Wish to enable Captcha"),
						"desc" => "",
						"id" => $shortname."_captcha_dislay",
						"std" => "Yes",
						"type" => "select",
						"options" => array('Yes','No'),
						);
	$options[] = array(	"type" => "subheadingbottom");
	
	$options[] = array(	"name" => __("Antispam Settings"),
						"toggle" => "true",
						"type" => "subheadingtop");
	
	$options[] = array(	"label" => __("Enable GeoTheme AntiSpam"),
						"desc" => __("This will enable better antispam protection from bots."),
						"id" => $shortname."_antispam_dislay",
						"std" => "Yes",
						"type" => "select",
						"options" => array('Yes','No'),
						);
	$options[] = array(	"type" => "subheadingbottom");
	
	$options[] = array(	"name" => __("Add New Listing Status"),
						"toggle" => "true",
						"type" => "subheadingtop");
				
	$options[] = array(	"label" => __("Select New Listing default Status"),
						"desc" => "",
						"id" => "approve_status",
						"std" => "publish",
						"type" => "select",
						"options" => array('publish','draft'),
						);	
	$options[] = array(	"type" => "subheadingbottom");

$options[] = array(	"name" => __("Enable &quot;Accept Terms and Conditions&quot;"),
						"toggle" => "true",
						"type" => "subheadingtop");
				
	$options[] = array(	"label" => __("Enable &quot;Accept Terms and Conditions&quot;"),
						"desc" => "",
						"id" => "accept_term_condition",
						"std" => "publish",
						"type" => "checkbox",
						);	
	
	$options[] = array(	"label" => __("Term and Condition Syntex"),
						"desc" => "",
						"id" => "term_condition_content",
						"std" => 'Please accept <a href="" target"_blank">terms and conditions</a>',
						"type" => "textarea",
						);
	$options[] = array(	"type" => "subheadingbottom");
	
$options[] = array(	"type" => "maintablebreak");
$options[] = array(	"name" => __("Blog  Settings"),
					"type" => "heading");
$options[] = array(	"name" => __("Select Blog Categories"),
								"toggle" => "true",
								"type" => "subheadingtop");
	if(strstr($_SERVER['REQUEST_URI'],'/wp-admin/')){$cat_arr = get_blogcategory_array();}
	$cat_arr = array_merge(array(array('id'=>'','title'=>'No Category')),$cat_arr);
		$options[] = array(	"label" => "",
						"desc" => __("Select blog categories, press &lsquo;control button&rsquo; to select more than one"),
						"id" => $shortname."_blogcategory",
						"std" => "",
						"type" => "multiselect",
						"options"=> $cat_arr,
						);	

$options[] = array(	"type" => "subheadingbottom");

$options[] = array(	"name" => __("Content Display"),
					"toggle" => "true",
					"type" => "subheadingtop");
			
	$options[] = array(	"label" => __("Display Full Post Content"),
						"desc" => __("Instead of default Post excerpts display Full Post Content in Blog Section"),
						"id" => $shortname."_postcontent_full",
						"std" => "false",
						"type" => "checkbox");	
			
$options[] = array(	"type" => "subheadingbottom");

$options[] = array(	"type" => "maintablebreak");

$options[] = array(	"type" => "maintablebottom");
		
$options[] = array(	"type" => "maintabletop");

$options[] = array(	"type" => "maintablebottom");
		
$options[] = array(	"type" => "maintabletop");
/// Map Options
				
		if(file_exists(TEMPLATEPATH . '/library/functions/admin_options_multi_city.php'))
		{
			include_once(TEMPLATEPATH . "/library/functions/admin_options_multi_city.php");
		}
			
		$options[] = array(	"type" => "maintablebreak");
/// Listing Options
				
		$options[] = array(	"name" => __("Category page Settings"),
						    "type" => "heading");
						
			$options[] = array(	"name" => __("Category Page listing format, either grid or normal listing"),
						        "toggle" => "true",
								"type" => "subheadingtop");
			
			$options[] = array(	"name" => "",
					                "desc" => __("Post listing format will appear in either grid or listing as you set here."),
					                "id" => $shortname."_cat_listing",
					                "std" => "normal listing",
					                "type" => "select",
					                "options" => array('normal listing','grid'));
			
			$options[] = array(	"name" => __("Number of posts per page"),
								"desc" => __("Enter Number of posts per page you want to display on category page."),
								"id" => "posts_per_page",
								"std" => "5",
								"type" => "text");
			
			$options[] = array(	"type" => "subheadingbottom");
			
			$options[] = array(	"name" => __("Category Page Sort Order Settings"),
						        "toggle" => "true",
								"type" => "subheadingtop");
			
			$options[] = array(	"label" => __("Make Category Sort Order a Dropdown field."),
						            "id" => $shortname."_cat_sort_dd",
						            "std" => "true",
						            "type" => "checkbox");
			
			$options[] = array(	"type" => "subheadingbottom");
			
		$options[] = array(	"type" => "maintablebreak");
		

$options[] = array(	"type" => "maintablebreak");

/// Place Listing Options
				
		$options[] = array(	"name" => __("Place Listing Settings"),
						    "type" => "heading");
						
			$options[] = array(	"name" => __("New Listings Settings"),
						        "toggle" => "true",
								"type" => "subheadingtop");
			
			$options[] = array(	"name" => __("Number of days new"),
								"desc" => __("Enter Number of days a listing will appear new.(enter 0 to disable feature)"),
								"id" => $shortname."_new_days",
								"std" => "30",
								"type" => "text");
			
			$options[] = array(	"type" => "subheadingbottom");

			
			$options[] = array(	"name" => __("Listing Expiration Settings"),
						        "toggle" => "true",
								"type" => "subheadingtop");
			
			$options[] = array(	"label" => __("Enable expiry process? (untick to disable) If you disable this option, none of the place listings will expire in future."),
						            "id" => $shortname."_listing_expiry_disable",
						            "std" => "true",
						            "type" => "checkbox");
			
			$options[] = array(	"name" => "",
					                "desc" => __("Select the listing status after the place listing expires."),
					                "id" => $shortname."_listing_ex_status",
					                "std" => "draft",
					                "type" => "select",
					                "options" => array('draft','publish','trash'));
			
			
			$options[] = array(	"type" => "subheadingbottom");
			
			$options[] = array(	"name" => __("Listing Email Notification"),
						        "toggle" => "true",
								"type" => "subheadingtop");
			
			$options[] = array(	"label" => __("Enable pre expiry notification to author? (untick to disable) If you disable the option, pre expiry email notification will stop."),
						            "id" => $shortname."_listing_preexpiry_notice_disable",
						            "std" => "true",
						            "type" => "checkbox");
			
			$options[] = array(	"name" => "",
					                "desc" => __("Enter number of days before pre expiry notification Email will be sent."),
					                "id" => $shortname."_listing_preexpiry_notice_days",
					                "std" => "1",
					                "type" => "select",
					                "options" => array('0','1','2','3','4','5','6','7','8','9','10'));
			
			
			$options[] = array(	"type" => "subheadingbottom");
			
		$options[] = array(	"type" => "maintablebreak");
		
		/// Ratting Options
				
		$options[] = array(	"name" => __("Rating Settings"),
						    "type" => "heading");
						
			$options[] = array(	"name" => __("Disable Rating"),
						        "toggle" => "true",
								"type" => "subheadingtop");
			
			$options[] = array(	"label" => __("Wish to disable Rating?"),
						            "id" => $shortname."_disable_rating",
						            "std" => "",
						            "type" => "checkbox");
			
			$options[] = array(	"type" => "subheadingbottom");
			
			$options[] = array(	"name" => __("Disable Rating limit"),
						        "toggle" => "true",
								"type" => "subheadingtop");
			
			$options[] = array(	"label" => __("Wish to disable Rating limit?"),
							   	"desc" => __("Want to set no limitation for insert rating?"),
						            "id" => $shortname."_disable_rating_limit",
						            "std" => "",
						            "type" => "checkbox");
			
			$options[] = array(	"type" => "subheadingbottom");
			
		$options[] = array(	"type" => "maintablebreak");
		
		/// Date & timing Options
				
		$options[] = array(	"name" => __("Date & time Settings"),
						    "type" => "heading");
						
			$options[] = array(	"name" => __("Date Format"),
						        "toggle" => "true",
								"type" => "subheadingtop");
			
			$options[] = array(	"label" => __("Set Date Format"),
						            "id" => "date_format",
						           "std" => "F j, Y",
						            "type" => "text");
			
			$options[] = array(	"type" => "subheadingbottom");
			
			$options[] = array(	"name" => __("Time Format"),
						        "toggle" => "true",
								"type" => "subheadingtop");
			
			$options[] = array(	"label" => __("Set Time Format"),
							   	"id" => "time_format",
						         "std" => "g:i a",
						         "type" => "text");
			
			$options[] = array(	"type" => "subheadingbottom");
			
		$options[] = array(	"type" => "maintablebreak");
		
	/// SEO Options
	
	$options[] = array(	"name" => __("Header / footer Stats and Scripts"),
						    "type" => "heading");
										
			$options[] = array(	"name" => __("Header Scripts"),
						        "toggle" => "true",
								"type" => "subheadingtop");	
						
				$options[] = array(	"name" => __("Header Scripts"),
					                "desc" => __("If you need to add scripts to your header (like <a href='http://haveamint.com/'>Mint</a> tracking code), do so here."),
					                "id" => $shortname."_scripts_header",
					                "std" => "",
					                "type" => "textarea");
			
			$options[] = array(	"type" => "subheadingbottom");
			
			$options[] = array(	"name" => __("Footer Scripts"),
						        "toggle" => "true",
								"type" => "subheadingtop");	
						
				$options[] = array(	"name" => __("Footer Scripts"),
					                "desc" => __("If you need to add scripts to your footer (like <a href='http://www.google.com/analytics/'>Google Analytics</a> tracking code), do so here."),
					                "id" => $shortname."_google_analytics",
					                "std" => "",
					                "type" => "textarea");
			
			$options[] = array(	"type" => "subheadingbottom");
			
			$options[] = array(	"name" => __("Footer Copyright"),
						        "toggle" => "true",
								"type" => "subheadingtop");	
						
				$options[] = array(	"name" => __("Footer Copyright"),
					                "desc" => __("Change the GeoTheme Copyright text"),
					                "id" => $shortname."_copyright",
					                "std" => "",
					                "type" => "textarea");
			
			$options[] = array(	"type" => "subheadingbottom");
			
						
		$options[] = array(	"type" => "maintablebreak");
				
		$options[] = array(	"name" => __("SEO Options"),
						    "type" => "heading");
						
			$options[] = array(	"name" => __("Home Page <code>&lt;meta&gt;</code> tags"),
						        "toggle" => "true",
								"type" => "subheadingtop");

				$options[] = array(	"name" => __("Meta Description"),
					                "desc" => __("You should use meta descriptions to provide search engines with additional information about topics that appear on your site. This only applies to your home page."),
					                "id" => $shortname."_meta_description",
					                "std" => "",
					                "type" => "textarea");

				$options[] = array(	"name" => __("Meta Keywords (comma separated)"),
					                "desc" => __("Meta keywords are rarely used nowadays but you can still provide search engines with additional information about topics that appear on your site. This only applies to your home page."),
						            "id" => $shortname."_meta_keywords",
						            "std" => "",
						            "type" => "text");
									
				$options[] = array(	"name" => __("Meta Author"),
					                "desc" => __("You should write your <em>full name</em> here but only do so if this blog is writen only by one author. This only applies to your home page."),
						            "id" => $shortname."_meta_author",
						            "std" => "",
						            "type" => "text");
						
			$options[] = array(	"type" => "subheadingbottom");
			
			$options[] = array(	"name" => __("Add <code>&lt;noindex&gt;</code> tags"),
						        "toggle" => "true",
								"type" => "subheadingtop");

				$options[] = array(	"label" => __("Add <code>&lt;noindex&gt;</code> to category archives."),
						            "id" => $shortname."_noindex_category",
						            "std" => "true",
						            "type" => "checkbox");
									
				$options[] = array(	"label" => __("Add <code>&lt;noindex&gt;</code> to tag archives."),
						            "id" => $shortname."_noindex_tag",
						            "std" => "true",
						            "type" => "checkbox");
				
				$options[] = array(	"label" => __("Add <code>&lt;noindex&gt;</code> to author archives."),
						            "id" => $shortname."_noindex_author",
						            "std" => "true",
						            "type" => "checkbox");
									
			    $options[] = array(	"label" => __("Add <code>&lt;noindex&gt;</code> to Search Results."),
						            "id" => $shortname."_noindex_search",
						            "std" => "true",
						            "type" => "checkbox");
				
				$options[] = array(	"label" => __("Add <code>&lt;noindex&gt;</code> to daily archives."),
						            "id" => $shortname."_noindex_daily",
						            "std" => "true",
						            "type" => "checkbox");
				
				$options[] = array(	"label" => __("Add <code>&lt;noindex&gt;</code> to monthly archives."),
						            "id" => $shortname."_noindex_monthly",
						            "std" => "true",
						            "type" => "checkbox");
				
				$options[] = array(	"label" => __("Add <code>&lt;noindex&gt;</code> to yearly archives."),
						            "id" => $shortname."_noindex_yearly",
						            "std" => "true",
						            "type" => "checkbox");
				
						
			$options[] = array(	"type" => "subheadingbottom");
			
			
		$options[] = array(	"type" => "maintablebreak");
		
			
	//////Translations		

	    $options[] = array(	"name" => __("Translations"),
						    "type" => "heading");
						
			$options[] = array(	"name" => __("Map Language settings"),
			                    "toggle" => "true",
						        "type" => "subheadingtop");
				
				$options[] = array(	"desc" => __("Enter your V3 country code, <a href='https://spreadsheets.google.com/pub?key=p9pdwsai2hDMsLkXsoM05KQ&gid=1' target='_blank'>See List</a> (leave blank for autodetect user)  "),
			    		            "id" => $shortname."_map_local",
			    		            "std" => "",
			    		            "type" => "text");
				
				$options[] = array(	"type" => "subheadingbottom");

			

############ EXTRA USER FIELDS
 $options[] = array(	"name" => __("User Fields"),
						    "type" => "heading");
						
			$options[] = array(	"name" => __("User Signup Settings"),
			                    "toggle" => "true",
						        "type" => "subheadingtop");
				
				$options[] = array(	"label" => __("Allow user to choose own password"),
						            "id" => $shortname."_show_user_pass",
						            "std" => "true",
						            "type" => "checkbox");
				
				$options[] = array(	"label" => __("Disable user auto login on signup"),
						            "id" => $shortname."_auto_login",
						            "std" => "true",
						            "type" => "checkbox");
				
			$options[] = array(	"type" => "subheadingbottom");
				
			$options[] = array(	"name" => __("User Field Settings"),
			                    "toggle" => "true",
						        "type" => "subheadingtop");
				
				$options[] = array(	"label" => __("Show User Profile Pic"),
						            "id" => $shortname."_show_user_pic_url",
						            "std" => "true",
						            "type" => "checkbox");
				
				$options[] = array(	"label" => __("Show Website"),
						            "id" => $shortname."_show_user_url",
						            "std" => "true",
						            "type" => "checkbox");
				
				$options[] = array(	"label" => __("Show AIM"),
						            "id" => $shortname."_show_aim",
						            "std" => "true",
						            "type" => "checkbox");
				
				$options[] = array(	"label" => __("Show Yahoo IM"),
						            "id" => $shortname."_show_yim",
						            "std" => "true",
						            "type" => "checkbox");
				
				$options[] = array(	"label" => __("Show Jabber / Google Talk"),
						            "id" => $shortname."_show_jabber",
						            "std" => "true",
						            "type" => "checkbox");
				
				$options[] = array(	"label" => __("Show Biographical Info"),
						            "id" => $shortname."_show_description",
						            "std" => "true",
						            "type" => "checkbox");
				
				$options[] = array(	"label" => __("Show Nationality"),
						            "id" => $shortname."_show_country",
						            "std" => "true",
						            "type" => "checkbox");
				
				$options[] = array(	"label" => __("Show User City"),
						            "id" => $shortname."_show_city",
						            "std" => "true",
						            "type" => "checkbox");				
				
				$options[] = array(	"label" => __("Show User Facebook"),
						            "id" => $shortname."_show_facebook",
						            "std" => "true",
						            "type" => "checkbox");
				
				$options[] = array(	"label" => __("Show User Twitter"),
						            "id" => $shortname."_show_twitter",
						            "std" => "true",
						            "type" => "checkbox");
				
				$options[] = array(	"label" => __("Show User Google+"),
						            "id" => $shortname."_show_gplus",
						            "std" => "true",
						            "type" => "checkbox");
				

				
				$options[] = array(	"type" => "subheadingbottom");
				
				

$options[] = array(	"type" => "maintablebreak");
						
$options[] = array(	"type" => "maintablebottom");

?>