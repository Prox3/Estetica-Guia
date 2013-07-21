<?php
	$day = $_REQUEST["sday"];
	$monthNames = Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
	
	if (!isset($_REQUEST["mnth"])) $_REQUEST["mnth"] = date("n");
	if (!isset($_REQUEST["yr"])) $_REQUEST["yr"] = date("Y");
	
	$cMonth = $_REQUEST["mnth"];
	$cYear = $_REQUEST["yr"];
	
	$prev_year = $cYear;
	$next_year = $cYear;
	$prev_month = $cMonth-1;
	$next_month = $cMonth+1;
	
	if ($prev_month == 0 ) {
		$prev_month = 12;
		$prev_year = $cYear - 1;
	}
	if ($next_month == 13 ) {
		$next_month = 1;
		$next_year = $cYear + 1;
	}
	$mainlink = $_SERVER['REQUEST_URI'];
	if(strstr($_SERVER['REQUEST_URI'],'?mnth') && strstr($_SERVER['REQUEST_URI'],'&yr'))
	{
		$replacestr = "?mnth=".$_REQUEST['mnth'].'&yr='.$_REQUEST['yr'];
		$mainlink = str_replace($replacestr,'',$mainlink);
	}elseif(strstr($_SERVER['REQUEST_URI'],'&mnth') && strstr($_SERVER['REQUEST_URI'],'&yr'))
	{
		$replacestr = "&mnth=".$_REQUEST['mnth'].'&yr='.$_REQUEST['yr'];
		$mainlink = str_replace($replacestr,'',$mainlink);
	}
	if(strstr($_SERVER['REQUEST_URI'],'?') && !strstr($_SERVER['REQUEST_URI'],'?mnth'))
	{
		$pre_link = $mainlink."&mnth=". $prev_month . "&yr=" . $prev_year;
		$next_link = $mainlink."&mnth=". $next_month . "&yr=" . $next_year;
	}else
	{
		$pre_link = $mainlink."?mnth=". $prev_month . "&yr=" . $prev_year;	
		$next_link = $mainlink."?mnth=". $next_month . "&yr=" . $next_year;
	}

	
	?> 
    
    
     <span id="cal_title"><strong><?php echo $monthNames[$cMonth-1].' '.$cYear; ?></strong></span>
 
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
    <td  ></td>
	<td align="right"  ></td>
	</tr>
	</table>
	</td>
	</tr>
	<tr>
	<td align="center">
	<table width="100%" border="0" cellpadding="2" cellspacing="2"  class="calendar_widget">
	
	<tr>
	<?php if($day!='1'){ ?><td align="center" class="days" ><strong>S</strong></td><?php } ?>
	<td align="center" class="days" ><strong>M</strong></td>
	<td align="center" class="days" ><strong>T</strong></td>
	<td align="center" class="days" ><strong>W</strong></td>
	<td align="center" class="days" ><strong>T</strong></td>
	<td align="center" class="days" ><strong>F</strong></td>
	<td align="center" class="days" ><strong>S</strong></td>
    <?php if($day=='1'){ ?><td align="center" class="days" ><strong>S</strong></td><?php } ?>
	</tr> 
	<?php
	$timestamp = mktime(0,0,0,$cMonth,1,$cYear);
	$maxday = date("t",$timestamp);
	$thismonth = getdate ($timestamp);
	$startday = $thismonth['wday'];
	if($day=='1'){if($startday==0){$startday = $startday+6;}else{$startday = $startday-1;}}
	//if($day=='1'){$startday = $startday-1;}
	//echo $startday.'###';
	if($_GET['m'])
	{
		$m = $_GET['m'];	
		$py=substr($m,0,4);
		$pm=substr($m,4,2);
		$pd=substr($m,6,2);
		$monthstdate = "$cYear-$cMonth-01";
		$monthenddate = "$cYear-$cMonth-$maxday";
	}
	global $wpdb;
		$city_id =  mysql_real_escape_string ($_SESSION['multi_city']);

	for ($i=0; $i<($maxday+$startday); $i++) {
		if(($i % 7) == 0 ) echo "<tr>\n";
		if($i < $startday){
			echo "<td></td>\n";
		}
		else 
		{
			$cal_date = $i - $startday + 1;
			$calday = $cal_date;
			if(strlen($cal_date)==1)
			{
				$calday="0".$cal_date;
			}
			$cMonth1 = $cMonth;
			if(strlen($cMonth)==1)
			{
				$cMonth1="0".$cMonth;
			}
			$urlddate = "$cYear$cMonth1$calday";
			$thelink = home_url()."/?s=cal_event&m=$urlddate";
			$the_cal_date = $cal_date;
			if(strlen($the_cal_date)==1){$the_cal_date = '0'.$the_cal_date;}
			$todaydate = "$cYear-$cMonth1-$the_cal_date";
			if(!$city_id){
			//$event_of_month_sql = "select p.* from $wpdb->posts p where p.post_type='event' and p.post_status='publish' and p.ID in (select pm.post_id from $wpdb->postmeta pm where pm.meta_key like 'st_date' and pm.meta_value <= \"$todaydate\" and pm.post_id in ((select pm.post_id from $wpdb->postmeta pm where pm.meta_key like 'end_date' and pm.meta_value>=\"$todaydate\")))";
			$event_of_month_sql = "select p.* from $wpdb->posts p join (select pm.post_id from $wpdb->postmeta pm where pm.meta_key like 'st_date' and pm.meta_value <= \"$todaydate\" and pm.post_id in ((select pm.post_id from $wpdb->postmeta pm where pm.meta_key like 'end_date' and pm.meta_value>=\"$todaydate\"))) dd on dd.post_id=p.ID where p.post_type='event' and p.post_status='publish' ";}else{			
			$event_of_month_sql = "select p.* from $wpdb->posts p join (select pm.post_id from $wpdb->postmeta pm where pm.meta_key like 'st_date' and pm.meta_value <= \"$todaydate\" and pm.post_id in ((select pm.post_id from $wpdb->postmeta pm where pm.meta_key like 'end_date' and pm.meta_value>=\"$todaydate\"))) dd on dd.post_id=p.ID join $wpdb->postmeta pm on pm.post_id=p.ID where p.post_type='event' and p.post_status='publish' and pm.meta_key='post_city_id' and pm.meta_value in($city_id) ";
			}
			
			
			
			//echo $event_of_month_sql;
			$event_post_info_perday = $wpdb->get_results($event_of_month_sql);
			$post_info = '';
				if($event_post_info_perday)
				{ $ii=0;
					foreach($event_post_info_perday as $event_post_info_obj)
					{ if($ii!=0){$sep = ' || 
';}else{$sep = '';}
						$post_info .= $sep.$event_post_info_obj->post_title;
						$ii++;
					}
				}
				echo "<td align='center' valign='middle' height='20px'>";
				if($event_post_info_perday)
				{
					echo "<a class=\"event_highlight\" href=\"$thelink\" title=\"$post_info\">". ($cal_date) . "</a>";
				}else
				{
						echo "<span class=\"no_event\" >". ($cal_date) . "</span>";
				}
				echo "</td>\n";
		}
		if(($i % 7) == 6 ) echo "</tr>\n";
	}
	?>
	</table>
	</td>
	</tr>
	</table>
  
<?php ?>