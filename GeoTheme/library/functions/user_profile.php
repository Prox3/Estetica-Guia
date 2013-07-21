<?php
$countries_list = "AF->Afghanistan,AX->Åland Islands,AL->Albania,DZ->Algeria,AS->American Samoa,AD->Andorra,AO->Angola,AI->Anguilla,AQ->Antarctica,AG->Antigua and Barbuda,AR->Argentina,AM->Armenia,AW->Aruba,AU->Australia,AT->Austria,AZ->Azerbaijan,BS->Bahamas,BH->Bahrain,BD->Bangladesh,BB->Barbados,BY->Belarus,BE->Belgium,BZ->Belize,BJ->Benin,BM->Bermuda,BT->Bhutan,BO->Bolivia,BA->Bosnia and Herzegovina,BW->Botswana,BV->Bouvet Island,BR->Brazil,IO->British Indian Ocean Territory,BN->Brunei Darussalam,BG->Bulgaria,BF->Burkina Faso,BI->Burundi,KH->Cambodia,CM->Cameroon,CA->Canada,CV->Cape Verde,KY->Cayman Islands,CF->Central African Republic,TD->Chad,CL->Chile,CN->China,CX->Christmas Island,CC->Cocos (Keeling) Islands,CO->Colombia,KM->Comoros,CG->Congo,CD->Congo,CK->Cook Islands,CR->Costa Rica,CI->Cote D'ivoire,HR->Croatia,CU->Cuba,CY->Cyprus,CZ->Czech Republic,DK->Denmark,DJ->Djibouti,DM->Dominica,DO->Dominican Republic,EC->Ecuador,EG->Egypt,SV->El Salvador,GQ->Equatorial Guinea,ER->Eritrea,EE->Estonia,ET->Ethiopia,FK->Falkland Islands (Malvinas),FO->Faroe Islands,FJ->Fiji,FI->Finland,FR->France,GF->French Guiana,PF->French Polynesia,TF->French Southern Territories,GA->Gabon,GM->Gambia,GE->Georgia,DE->Germany,GH->Ghana,GI->Gibraltar,GR->Greece,GL->Greenland,GD->Grenada,GP->Guadeloupe,GU->Guam,GT->Guatemala,GG->Guernsey,GN->Guinea,GW->Guinea-bissau,GY->Guyana,HT->Haiti,HM->Heard Island and Mcdonald Islands,VA->Holy See (Vatican City State),HN->Honduras,HK->Hong Kong,HU->Hungary,IS->Iceland,IN->India,ID->Indonesia,IR->Iran,IQ->Iraq,IE->Ireland,IM->Isle of Man,IL->Israel,IT->Italy,JM->Jamaica,JP->Japan,JE->Jersey,JO->Jordan,KZ->Kazakhstan,KE->Kenya,KI->Kiribati,KP->North Korea,KR->South Korea,KW->Kuwait,KG->Kyrgyzstan,LA->Lao,LV->Latvia,LB->Lebanon,LS->Lesotho,LR->Liberia,LY->Libyan Arab Jamahiriya,LI->Liechtenstein,LT->Lithuania,LU->Luxembourg,MO->Macao,MK->Macedonia,MG->Madagascar,MW->Malawi,MY->Malaysia,MV->Maldives,ML->Mali,MT->Malta,MH->Marshall Islands,MQ->Martinique,MR->Mauritania,MU->Mauritius,YT->Mayotte,MX->Mexico,FM->Micronesia,MD->Moldova,MC->Monaco,MN->Mongolia,ME->Montenegro,MS->Montserrat,MA->Morocco,MZ->Mozambique,MM->Myanmar,NA->Namibia,NR->Nauru,NP->Nepal,NL->Netherlands,AN->Netherlands Antilles,NC->New Caledonia,NZ->New Zealand,NI->Nicaragua,NE->Niger,NG->Nigeria,NU->Niue,NF->Norfolk Island,MP->Northern Mariana Islands,NO->Norway,OM->Oman,PK->Pakistan,PW->Palau,PS->Palestinian Territory,PA->Panama,PG->Papua New Guinea,PY->Paraguay,PE->Peru,PH->Philippines,PN->Pitcairn,PL->Poland,PT->Portugal,PR->Puerto Rico,QA->Qatar,RE->Reunion,RO->Romania,RU->Russian Federation,RW->Rwanda,SH->Saint Helena,KN->Saint Kitts and Nevis,LC->Saint Lucia,PM->Saint Pierre and Miquelon,VC->Saint Vincent and The Grenadines,WS->Samoa,SM->San Marino,ST->Sao Tome and Principe,SA->Saudi Arabia,SCO->Scotland,SN->Senegal,RS->Serbia,SC->Seychelles,SL->Sierra Leone,SG->Singapore,SK->Slovakia,SI->Slovenia,SB->Solomon Islands,SO->Somalia,ZA->South Africa,GS->South Georgia and The South Sandwich Islands,ES->Spain,LK->Sri Lanka,SD->Sudan,SR->Suriname,SJ->Svalbard and Jan Mayen,SZ->Swaziland,SE->Sweden,CH->Switzerland,SY->Syrian Arab Republic,TW->Taiwan,TJ->Tajikistan,TZ->Tanzania,TH->Thailand,TL->Timor-leste,TG->Togo,TK->Tokelau,TO->Tonga,TT->Trinidad and Tobago,TN->Tunisia,TR->Turkey,TM->Turkmenistan,TC->Turks and Caicos Islands,TV->Tuvalu,UG->Uganda,UA->Ukraine,AE->United Arab Emirates,GB->United Kingdom,US->United States,UM->United States Minor Outlying Islands,UY->Uruguay,UZ->Uzbekistan,VU->Vanuatu,VE->Venezuela,VN->Viet Nam,VG->Virgin Islands British,VI->Virgin Islands U.S.,WA->Wales,WF->Wallis and Futuna,EH->Western Sahara,YE->Yemen,ZM->Zambia,ZW->Zimbabwe";
if(!get_option('user_countries')){update_option( 'user_countries', $countries_list );}
											   
											   
add_action( 'show_user_profile', 'extra_user_profile_fields' );
add_action( 'edit_user_profile', 'extra_user_profile_fields' );
 
function extra_user_profile_fields( $user ) { ?>
<h3><?php _e("Extra profile fields", "blank"); ?></h3>
 
<table class="form-table">


<tr>
<th><label for="user_pic_url"><?php _e("User Profile Pic"); ?></label></th>
<td>
<?php echo get_avatar(  $user->ID, 60, $template_path . ''.get_bloginfo('template_directory').'/images/gravatar.png' ); ?>
<div class="form_row clearfix"></div>
<input type="text" name="user_pic_url" id="user_pic_url" class="regular-text" value="<?php echo esc_attr(stripslashes(get_user_meta( $user->ID, 'user_pic_url', true ))); ?>" size="25"  />
<div class="form_row clearfix"></div>
<input type="file" name="user_pic_url_upload" id="user_pic_url_upload"  />
<input type="submit" value="<?php _e('Upload');?>" name="Upload"   />
<span id="user_fnameInfo"><?php if($pic_error){echo $pic_error;}?></span><br />
<span class="description"><?php _e("Upoad your profile pic"); ?></span>
</td>
</tr>


<tr>
<th><label for="address"><?php _e("Nationality"); ?></label></th>
<td>
<select name="country" id="country">
<option value=""><?php _e('Select Country');?></option>
  <?php $user_countries = get_option('user_countries');
  $user_countries_arr = explode(",", $user_countries);
  $user_country = get_user_meta( $user->ID, 'country', true );
  foreach($user_countries_arr as $country){
	  $co = explode("->", $country);
	  $selected ='';
	  if($user_country==$country){$selected ='selected="selected"';}
	  echo  '<option '.$selected.' value="'.$country.'">'.$co[1].'</option>';
}
  ?>
  </select><br />
<span class="description"><?php _e("Please select your nationality."); ?></span>
</td>
</tr>

<tr>
<th><label for="city"><?php _e("User City"); ?></label></th>
<td>
<input type="text" name="user_city" id="user_city" value="<?php echo esc_attr( get_the_author_meta( 'user_city', $user->ID ) ); ?>" class="regular-text" /><br />
<span class="description"><?php _e("Please enter your city."); ?></span>
</td>
</tr>

<tr>
<th><label for="facebook"><?php _e("Facebook"); ?></label></th>
<td>
<input type="text" name="facebook" id="facebook" value="<?php echo esc_attr( get_the_author_meta( 'facebook', $user->ID ) ); ?>" class="regular-text" /><br />
<span class="description"><?php _e("Please enter your Facebook URL."); ?></span>
</td>
</tr>

<tr>
<th><label for="twitter"><?php _e("twitter"); ?></label></th>
<td>
<input type="text" name="twitter" id="twitter" value="<?php echo esc_attr( get_the_author_meta( 'twitter', $user->ID ) ); ?>" class="regular-text" /><br />
<span class="description"><?php _e("Please enter twitter URL."); ?></span>
</td>
</tr>

<tr>
<th><label for="gplus"><?php _e("Google+"); ?></label></th>
<td>
<input type="text" name="gplus" id="gplus" value="<?php echo esc_attr( get_the_author_meta( 'gplus', $user->ID ) ); ?>" class="regular-text" /><br />
<span class="description"><?php _e("Please enter Google+ URL."); ?></span>
</td>
</tr>

</table>
<?php }
 
add_action( 'personal_options_update', 'save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_user_profile_fields' );
 
function save_extra_user_profile_fields( $user_id ) {
 
if ( !current_user_can( 'edit_user', $user_id ) ) { return false; }
 
update_user_meta( $user_id, 'country', $_POST['country'] );
update_user_meta( $user_id, 'user_city', $_POST['user_city'] );
update_user_meta( $user_id, 'facebook', $_POST['facebook'] );
update_user_meta( $user_id, 'twitter', $_POST['twitter'] );
update_user_meta( $user_id, 'gplus', $_POST['gplus'] );

################ START PROFILE PIC UPLOAD	
if($_FILES) 
{
						$destination_path = ABSPATH.'/wp-content/uploads/profile_pics/';
						if (!file_exists(ABSPATH.'/wp-content/uploads/profile_pics/')){
						  mkdir(ABSPATH.'/wp-content/uploads/profile_pics/', 0777);
						} 
						$image_var = 'user_pic_url_upload';
						if ((($_FILES[$image_var]["type"] == "image/gif")
						|| ($_FILES[$image_var]["type"] == "image/png")
						|| ($_FILES[$image_var]["type"] == "image/jpeg")
						|| ($_FILES[$image_var]["type"] == "image/jpeg")
						|| ($_FILES[$image_var]["type"] == "image/pjpeg"))
						&& ($_FILES[$image_var]["size"] < 2097152 && $_FILES[$image_var]['name'] && $_FILES[$image_var]['size']>0))
						{
							
							$name = createRandomString().str_replace(',','_',$_FILES[$image_var]['name']);
							$tmp_name = $_FILES[$image_var]['tmp_name'];
							$target_path = $destination_path . $name;
							if(move_uploaded_file($tmp_name, $target_path)) 
							{
								### remove old pic start ###
								$old_pic_url = get_user_meta( $user_id, 'user_pic_url', true );
								$old_pic_path = str_replace(site_url(), "", $old_pic_url);
								@unlink(ABSPATH.$old_pic_path);
								### remove old pic end ###
								$imagepath1 = site_url() ."/wp-content/uploads/profile_pics/".$name;
								update_user_meta($user_id, 'user_pic_url', mysql_real_escape_string($imagepath1));
								//echo $imagepath1;exit;
							}
						}else{$pic_error = __('Only jpg, gif and png files less than 2MB allowed.');}
					}					
################ END PROFILE PIC UPLOAD
}
function user_form_for_file2(){
	echo ' enctype="multipart/form-data"';
}
add_action( 'user_edit_form_tag', 'user_form_for_file2' );


########################################################################################################

add_action('manage_users_columns','geotheme_manage_users_columns');
function geotheme_manage_users_columns($column_headers) {
    //unset($column_headers['posts']);
    $column_headers['custom_places'] = 'Places';
    $column_headers['custom_events'] = 'Events';
    $column_headers['custom_invoices'] = 'Transactions';
    return $column_headers;
}

add_action('manage_users_custom_column','geotheme_manage_users_custom_column',10,3);

function geotheme_manage_users_custom_column($custom_column,$column_name,$user_id) {
    $custom_column = array();
	if ($column_name=='custom_places') {
        $counts = geotheme_get_author_place_counts('place');
        //$custom_column = array();
        if (isset($counts[$user_id]) && is_array($counts[$user_id]))
            foreach($counts[$user_id] as $count) {
                $link = admin_url() . "edit.php?post_type=" . $count['type']. "&author=".$user_id;
                // admin_url() . "edit.php?author=" . $user->ID;
                $custom_column[] = "\t<tr><a href={$link}>{$count['count']}</a></tr>";
            }
        $custom_column = implode("\n",$custom_column);
        if (empty($custom_column))
            $custom_column = "0";
        $custom_column = "<table>\n{$custom_column}\n</table>";
		 return $custom_column;
    }
	if ($column_name=='custom_events') {
        $counts = geotheme_get_author_event_counts('event');
        //$custom_column = array();
        if (isset($counts[$user_id]) && is_array($counts[$user_id]))
            foreach($counts[$user_id] as $count) {
                $link = admin_url() . "edit.php?post_type=" . $count['type']. "&author=".$user_id;
                // admin_url() . "edit.php?author=" . $user->ID;
                $custom_column[] = "\t<tr><a href={$link}>{$count['count']}</a></tr>";
            }
        $custom_column = implode("\n",$custom_column);
        if (empty($custom_column))
            $custom_column = "0";
        $custom_column = "<table>\n{$custom_column}\n</table>";
		 return $custom_column;
    }
	
	if ($column_name=='custom_invoices') {
        $counts = geotheme_get_author_invoices_counts('invoice');
        //$custom_column = array();
        if (isset($counts[$user_id]) && is_array($counts[$user_id]))
            foreach($counts[$user_id] as $count) {
                $link = admin_url() . "edit.php?post_type=" . $count['type']. "&author=".$user_id;
                // admin_url() . "edit.php?author=" . $user->ID;
                $custom_column[] = "\t<tr><a href={$link}>{$count['count']}</a></tr>";
            }
        $custom_column = implode("\n",$custom_column);
        if (empty($custom_column))
            $custom_column = "0";
        $custom_column = "<table>\n{$custom_column}\n</table>";
		 return $custom_column;
    }
   
}

function geotheme_get_author_place_counts($type) {
    static $counts;
    if (!isset($counts)) {
        global $wpdb;
        global $wp_post_types;
        $sql = "SELECT post_type, post_author,COUNT(*) AS post_count FROM $wpdb->posts WHERE 1=1 AND post_type='$type' AND post_type NOT IN ('revision','nav_menu_item')  AND post_status IN ('publish','pending', 'draft') GROUP BY post_type, post_author";
		//echo $sql;
        $posts = $wpdb->get_results($sql);
        foreach($posts as $post) {
            $post_type_object = $wp_post_types[$post_type = $post->post_type];
            if (!empty($post_type_object->label))
                $label = $post_type_object->label;
            else if (!empty($post_type_object->labels->name))
                $label = $post_type_object->labels->name;
            else
                $label = ucfirst(str_replace(array('-','_'),' ',$post_type));
            if (!isset($counts[$post_author = $post->post_author]))
                $counts[$post_author] = array();
            $counts[$post_author][] = array(
                'label' => $label,
                'count' => $post->post_count,
                'type' => $post->post_type,
                );
        }
    }
    return $counts;
}
function geotheme_get_author_event_counts($type) {
    static $counts;
    if (!isset($counts)) {
        global $wpdb;
        global $wp_post_types;
        $sql = "SELECT post_type, post_author,COUNT(*) AS post_count FROM $wpdb->posts WHERE 1=1 AND post_type='$type' AND post_type NOT IN ('revision','nav_menu_item')  AND post_status IN ('publish','pending', 'draft') GROUP BY post_type, post_author";
		//echo $sql;
        $posts = $wpdb->get_results($sql);
        foreach($posts as $post) {
            $post_type_object = $wp_post_types[$post_type = $post->post_type];
            if (!empty($post_type_object->label))
                $label = $post_type_object->label;
            else if (!empty($post_type_object->labels->name))
                $label = $post_type_object->labels->name;
            else
                $label = ucfirst(str_replace(array('-','_'),' ',$post_type));
            if (!isset($counts[$post_author = $post->post_author]))
                $counts[$post_author] = array();
            $counts[$post_author][] = array(
                'label' => $label,
                'count' => $post->post_count,
                'type' => $post->post_type,
                );
        }
    }
    return $counts;
}

function geotheme_get_author_invoices_counts($type) {
    static $counts;
    if (!isset($counts)) {
        global $wpdb;
        global $wp_post_types;
        $sql = "SELECT post_type, post_author,COUNT(*) AS post_count FROM $wpdb->posts WHERE 1=1 AND post_type='$type' AND post_type NOT IN ('revision','nav_menu_item')  AND post_status IN ('publish','pending', 'draft') GROUP BY post_type, post_author";
		//echo $sql;
        $posts = $wpdb->get_results($sql);
        foreach($posts as $post) {
            $post_type_object = $wp_post_types[$post_type = $post->post_type];
            if (!empty($post_type_object->label))
                $label = $post_type_object->label;
            else if (!empty($post_type_object->labels->name))
                $label = $post_type_object->labels->name;
            else
                $label = ucfirst(str_replace(array('-','_'),' ',$post_type));
            if (!isset($counts[$post_author = $post->post_author]))
                $counts[$post_author] = array();
            $counts[$post_author][] = array(
                'label' => $label,
                'count' => $post->post_count,
                'type' => $post->post_type,
                );
        }
    }
    return $counts;
}
?>